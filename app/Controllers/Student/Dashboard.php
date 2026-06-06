<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\PresensiSiswaModel;
use App\Models\KelasModel;
use App\Controllers\Admin\QRGenerator;
use CodeIgniter\I18n\Time;
use App\Libraries\enums\UserRole;

class Dashboard extends BaseController
{
    protected SiswaModel $siswaModel;
    protected PresensiSiswaModel $presensiModel;
    protected KelasModel $kelasModel;

    public function __construct()
    {
        $this->siswaModel   = new SiswaModel();
        $this->presensiModel = new PresensiSiswaModel();
        $this->kelasModel   = new KelasModel();
    }

    public function index()
    {
        $u = user();
        if (empty($u)) return redirect()->to('login');

        // Cari data siswa yang terhubung ke akun ini
        $siswa = $this->siswaModel->getSiswaByUserId($u->id);

        $today = Time::today()->toDateString();
        $presensiHariIni = null;
        $riwayat = [];
        $kelas   = null;

        if (!empty($siswa)) {
            $presensiHariIni = $this->presensiModel->getPresensiByIdSiswaTanggal($siswa['id_siswa'], $today);

            // Riwayat 30 hari terakhir
            $riwayat = $this->presensiModel
                ->select('tb_presensi_siswa.*, tb_kehadiran.kehadiran')
                ->join('tb_kehadiran', 'tb_kehadiran.id_kehadiran = tb_presensi_siswa.id_kehadiran')
                ->where('id_siswa', $siswa['id_siswa'])
                ->where('tanggal >=', date('Y-m-d', strtotime('-30 days')))
                ->orderBy('tanggal', 'DESC')
                ->findAll();

            $kelas = $this->kelasModel->getKelas($siswa['id_kelas']);
        }

        $data = [
            'title'           => 'Dashboard Siswa',
            'ctx'             => 'student',
            'siswa'           => $siswa,
            'kelas'           => $kelas,
            'presensiHariIni' => $presensiHariIni,
            'riwayat'         => $riwayat,
        ];

        return view('student/dashboard', $data);
    }

    public function downloadQR()
    {
        $u = user();
        if (empty($u)) return redirect()->to('login');

        $siswa = $this->siswaModel->getSiswaByUserId($u->id);
        if (empty($siswa)) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        try {
            $qrGen = new QRGenerator();

            $kelas = $this->kelasModel->getKelas($siswa['id_kelas']);
            $kelasSlug = $kelas ? url_title($kelas->kelas, lowercase: true) : 'siswa';

            $qrGen->setQrCodeFilePath(FCPATH . 'uploads/qr-siswa/' . $kelasSlug . '/');

            $filePath = $qrGen->generate(
                nama: $siswa['nama_siswa'],
                nomor: $siswa['id_siswa'],
                unique_code: $siswa['unique_code']
            );

            return $this->response->download($filePath, null, true);
        } catch (\Throwable $th) {
            return redirect()->back()->with('msg', $th->getMessage());
        }
    }

    public function profile()
    {
        $u = user();
        if (empty($u)) return redirect()->to('login');
        $siswa = $this->siswaModel->getSiswaByUserId($u->id);

        return view('student/profile', [
            'title'  => 'Profil Saya',
            'ctx'    => 'student',
            'siswa'  => $siswa,
            'user'   => $u,
        ]);
    }
}
