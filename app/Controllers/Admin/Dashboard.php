<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\PetugasModel;
use App\Models\PresensiGuruModel;
use App\Models\PresensiSiswaModel;
use App\Models\UserActivityModel;
use CodeIgniter\I18n\Time;
use App\Libraries\enums\UserRole;

class Dashboard extends BaseController
{
   protected SiswaModel $siswaModel;
   protected GuruModel $guruModel;
   protected KelasModel $kelasModel;
   protected PresensiSiswaModel $presensiSiswaModel;
   protected PresensiGuruModel $presensiGuruModel;
   protected PetugasModel $petugasModel;
   protected UserActivityModel $activityModel;

   public function __construct()
   {
      $this->siswaModel         = new SiswaModel();
      $this->guruModel          = new GuruModel();
      $this->kelasModel         = new KelasModel();
      $this->presensiSiswaModel = new PresensiSiswaModel();
      $this->presensiGuruModel  = new PresensiGuruModel();
      $this->petugasModel       = new PetugasModel();
      $this->activityModel      = new UserActivityModel();
   }

   public function index()
   {
      if (is_wali_kelas()) {
         return redirect()->to('teacher/dashboard');
      }

      if (is_siswa()) {
         return redirect()->to('student/dashboard');
      }

      if (is_guru()) {
         return redirect()->to('teacher/dashboard');
      }

      if (user_role() === UserRole::Scanner) {
         return redirect()->to('scan');
      }

      $now = Time::now();

      $dateRange = [];
      for ($i = 6; $i >= 0; $i--) {
         if ($i == 0) {
            $formattedDate = "Hari ini";
         } else {
            $t             = $now->subDays($i);
            $formattedDate = "{$t->getDay()} " . substr($t->toFormattedDateString(), 0, 3);
         }
         array_push($dateRange, $formattedDate);
      }

      $today = $now->toDateString();

      // Get attendance trends
      $grafikKehadiranSiswa = $this->presensiSiswaModel->getAttendanceTrend();
      $grafikKehadiranGuru  = $this->presensiGuruModel->getAttendanceTrend();

      // Prepare kelas data with student count
      $kelasData = $this->kelasModel->getDataKelas();
      foreach ($kelasData as &$k) {
         $k['jumlah_siswa'] = $this->siswaModel->getSiswaCountByKelas($k['id_kelas']);
      }

      // Auto-mark inactive users as offline (idle > 5 menit)
      $this->activityModel->markInactiveOffline(5);

      // Get active users (online dalam 5 menit terakhir)
      $activeUsers = $this->activityModel->getActiveUsers(5);
      $countOnline = count($activeUsers);

      $data = [
         'title'   => 'Dashboard',
         'ctx'     => 'dashboard',

         'siswa'   => $this->siswaModel->getAllSiswaWithKelas(),
         'guru'    => $this->guruModel->getAllGuru(),

         'kelas'   => $kelasData,

         'dateRange' => $dateRange,
         'dateNow'   => $now->toLocalizedString('d MMMM Y'),

         'grafikKehadiranSiswa' => $grafikKehadiranSiswa,
         'grafikKehadiranGuru'  => $grafikKehadiranGuru,

         'jumlahKehadiranSiswa' => [
            'hadir' => count($this->presensiSiswaModel->getPresensiByKehadiran('1', $today)),
            'sakit' => count($this->presensiSiswaModel->getPresensiByKehadiran('2', $today)),
            'izin'  => count($this->presensiSiswaModel->getPresensiByKehadiran('3', $today)),
            'alfa'  => count($this->presensiSiswaModel->getPresensiByKehadiran('4', $today))
         ],

         'jumlahKehadiranGuru' => [
            'hadir' => count($this->presensiGuruModel->getPresensiByKehadiran('1', $today)),
            'sakit' => count($this->presensiGuruModel->getPresensiByKehadiran('2', $today)),
            'izin'  => count($this->presensiGuruModel->getPresensiByKehadiran('3', $today)),
            'alfa'  => count($this->presensiGuruModel->getPresensiByKehadiran('4', $today))
         ],

         'totalSiswa'  => $this->siswaModel->getSiswaCountByKelas(),
         'totalGuru'   => $this->guruModel->countAllResults(),

         'petugas'     => $this->petugasModel->getAllPetugas(),

         // Active users realtime
         'activeUsers' => $activeUsers,
         'countOnline' => $countOnline,
      ];

      return view('admin/dashboard', $data);
   }

   public function filterData()
   {
      $idKelas = $this->request->getPost('id_kelas');
      $now     = Time::now();
      $today   = $now->toDateString();

      $jumlahKehadiranSiswa = [
         'hadir' => count($this->presensiSiswaModel->getPresensiByKehadiran('1', $today, $idKelas)),
         'sakit' => count($this->presensiSiswaModel->getPresensiByKehadiran('2', $today, $idKelas)),
         'izin'  => count($this->presensiSiswaModel->getPresensiByKehadiran('3', $today, $idKelas)),
         'alfa'  => count($this->presensiSiswaModel->getPresensiByKehadiran('4', $today, $idKelas))
      ];

      $grafikKehadiranSiswa = $this->presensiSiswaModel->getAttendanceTrend(7, $idKelas ?: null);
      $jumlahSiswa          = $this->siswaModel->getSiswaCountByKelas($idKelas);

      $data = [
         'hadir'      => $jumlahKehadiranSiswa['hadir'],
         'sakit'      => $jumlahKehadiranSiswa['sakit'],
         'izin'       => $jumlahKehadiranSiswa['izin'],
         'alfa'       => $jumlahKehadiranSiswa['alfa'],
         'totalSiswa' => $jumlahSiswa,
      ];

      return json_encode([
         'result'      => 1,
         'htmlContent' => view('admin/_dashboard_siswa_stats', $data),
         'chartData'   => $grafikKehadiranSiswa,
         'totalSiswa'  => $jumlahSiswa
      ]);
   }

   /**
    * AJAX: Ambil data pengguna aktif terbaru (polling real-time)
    */
   public function getActiveUsers()
   {
      $this->activityModel->markInactiveOffline(5);
      $activeUsers = $this->activityModel->getActiveUsers(5);
      $countOnline = count($activeUsers);

      return $this->response->setJSON([
         'count'       => $countOnline,
         'users'       => $activeUsers,
         'htmlContent' => view('admin/_active_users_list', ['activeUsers' => $activeUsers, 'countOnline' => $countOnline]),
      ]);
   }
}
