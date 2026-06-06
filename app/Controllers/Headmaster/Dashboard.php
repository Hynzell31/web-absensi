<?php

namespace App\Controllers\Headmaster;

use App\Controllers\BaseController;
use App\Models\PresensiSiswaModel;
use App\Models\PresensiGuruModel;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use CodeIgniter\I18n\Time;

class Dashboard extends BaseController
{
    protected PresensiSiswaModel $presensiSiswaModel;
    protected PresensiGuruModel  $presensiGuruModel;
    protected SiswaModel         $siswaModel;
    protected GuruModel          $guruModel;
    protected KelasModel         $kelasModel;

    public function __construct()
    {
        $this->presensiSiswaModel = new PresensiSiswaModel();
        $this->presensiGuruModel  = new PresensiGuruModel();
        $this->siswaModel         = new SiswaModel();
        $this->guruModel          = new GuruModel();
        $this->kelasModel         = new KelasModel();
    }

    public function index()
    {
        helper('user');
        if (!is_kepsek() && !is_superadmin()) {
            return redirect()->to('admin');
        }

        $today = Time::today()->toDateString();

        // Statistik hari ini
        $totalSiswa      = count($this->siswaModel->findAll());
        $totalGuru       = count($this->guruModel->findAll());
        $totalKelas      = count($this->kelasModel->findAll());

        // Absen hari ini
        $absenSiswaHariIni = $this->presensiSiswaModel
            ->where('tanggal', $today)
            ->where('jam_masuk IS NOT NULL', null, false)
            ->countAllResults();

        $absenGuruHariIni = $this->presensiGuruModel
            ->where('tanggal', $today)
            ->where('jam_masuk IS NOT NULL', null, false)
            ->countAllResults();

        // Data absen siswa hari ini untuk tabel
        $dataSiswaHariIni = $this->presensiSiswaModel
            ->select('tb_presensi_siswa.*, tb_siswa.nama_siswa, tb_kelas.kelas, tb_kehadiran.kehadiran')
            ->join('tb_siswa', 'tb_siswa.id_siswa = tb_presensi_siswa.id_siswa', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas', 'left')
            ->join('tb_kehadiran', 'tb_kehadiran.id_kehadiran = tb_presensi_siswa.id_kehadiran', 'left')
            ->where('tb_presensi_siswa.tanggal', $today)
            ->orderBy('tb_presensi_siswa.jam_masuk', 'ASC')
            ->findAll(20);

        // Data absen guru hari ini
        $dataGuruHariIni = $this->presensiGuruModel
            ->select('tb_presensi_guru.*, tb_guru.nama_guru, tb_guru.kode_guru, tb_kehadiran.kehadiran')
            ->join('tb_guru', 'tb_guru.id_guru = tb_presensi_guru.id_guru', 'left')
            ->join('tb_kehadiran', 'tb_kehadiran.id_kehadiran = tb_presensi_guru.id_kehadiran', 'left')
            ->where('tb_presensi_guru.tanggal', $today)
            ->orderBy('tb_presensi_guru.jam_masuk', 'ASC')
            ->findAll(20);

        $data = [
            'title'              => 'Dashboard Kepala Sekolah',
            'ctx'                => 'headmaster',
            'today'              => $today,
            'totalSiswa'         => $totalSiswa,
            'totalGuru'          => $totalGuru,
            'totalKelas'         => $totalKelas,
            'absenSiswaHariIni'  => $absenSiswaHariIni,
            'absenGuruHariIni'   => $absenGuruHariIni,
            'dataSiswaHariIni'   => $dataSiswaHariIni,
            'dataGuruHariIni'    => $dataGuruHariIni,
        ];

        return view('headmaster/dashboard', $data);
    }

    public function laporanSiswa()
    {
        helper('user');
        if (!is_kepsek() && !is_superadmin()) {
            return redirect()->to('admin');
        }

        $tanggalMulai  = $this->request->getGet('dari') ?? date('Y-m-01');
        $tanggalSelesai = $this->request->getGet('sampai') ?? date('Y-m-d');
        $idKelas        = $this->request->getGet('id_kelas');

        $query = $this->presensiSiswaModel
            ->select('tb_presensi_siswa.*, tb_siswa.nama_siswa, tb_kelas.kelas, tb_kehadiran.kehadiran')
            ->join('tb_siswa', 'tb_siswa.id_siswa = tb_presensi_siswa.id_siswa', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas', 'left')
            ->join('tb_kehadiran', 'tb_kehadiran.id_kehadiran = tb_presensi_siswa.id_kehadiran', 'left')
            ->where('tb_presensi_siswa.tanggal >=', $tanggalMulai)
            ->where('tb_presensi_siswa.tanggal <=', $tanggalSelesai);

        if ($idKelas) {
            $query->where('tb_siswa.id_kelas', $idKelas);
        }

        $laporan = $query->orderBy('tb_presensi_siswa.tanggal', 'DESC')->findAll();

        $data = [
            'title'          => 'Laporan Absensi Siswa',
            'ctx'            => 'headmaster',
            'laporan'        => $laporan,
            'tanggalMulai'   => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'idKelas'        => $idKelas,
            'kelas'          => $this->kelasModel->findAll(),
        ];

        return view('headmaster/laporan_siswa', $data);
    }

    public function laporanGuru()
    {
        helper('user');
        if (!is_kepsek() && !is_superadmin()) {
            return redirect()->to('admin');
        }

        $tanggalMulai   = $this->request->getGet('dari') ?? date('Y-m-01');
        $tanggalSelesai = $this->request->getGet('sampai') ?? date('Y-m-d');

        $laporan = $this->presensiGuruModel
            ->select('tb_presensi_guru.*, tb_guru.nama_guru, tb_guru.kode_guru, tb_kehadiran.kehadiran')
            ->join('tb_guru', 'tb_guru.id_guru = tb_presensi_guru.id_guru', 'left')
            ->join('tb_kehadiran', 'tb_kehadiran.id_kehadiran = tb_presensi_guru.id_kehadiran', 'left')
            ->where('tb_presensi_guru.tanggal >=', $tanggalMulai)
            ->where('tb_presensi_guru.tanggal <=', $tanggalSelesai)
            ->orderBy('tb_presensi_guru.tanggal', 'DESC')
            ->findAll();

        $data = [
            'title'          => 'Laporan Absensi Guru',
            'ctx'            => 'headmaster',
            'laporan'        => $laporan,
            'tanggalMulai'   => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
        ];

        return view('headmaster/laporan_guru', $data);
    }
}
