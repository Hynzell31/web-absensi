<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use App\Libraries\enums\UserRole;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Root redirect
$routes->get('/', function () {
   helper('user');

   if (!user()) {
      return redirect()->to(base_url('login'));
   }

   if (is_siswa()) {
      return redirect()->to(base_url('student/dashboard'));
   }

   if (is_kepsek()) {
      return redirect()->to(base_url('headmaster'));
   }

   if (is_wali_kelas() || is_guru()) {
      return redirect()->to(base_url('teacher/dashboard'));
   }

   $role = user_role();
   if ($role === \App\Libraries\enums\UserRole::Scanner || $role === \App\Libraries\enums\UserRole::StafPetugas) {
      return redirect()->to(base_url('scan'));
   }

   return redirect()->to(base_url('admin'));
});

// ==========================================
// REGISTRASI MANDIRI (Publik)
// ==========================================
$routes->get('daftar/siswa', 'Auth\StudentRegister::index');
$routes->post('daftar/siswa/proses', 'Auth\StudentRegister::register');
$routes->get('daftar/guru', 'Auth\StudentRegister::guruRegister');
$routes->post('daftar/guru/proses', 'Auth\StudentRegister::guruRegisterPost');

// ==========================================
// SCAN (publik setelah login)
// ==========================================
$routes->group('scan', function (RouteCollection $routes) {
   $routes->get('', 'Scan::index');
   $routes->get('masuk', 'Scan::index/Masuk');
   $routes->get('pulang', 'Scan::index/Pulang');
   $routes->post('cek', 'Scan::cekKode');
});

// ==========================================
// STUDENT (siswa login)
// ==========================================
$routes->group('student', ['namespace' => 'App\Controllers\Student', 'filter' => 'login'], function (RouteCollection $routes) {
   $routes->get('/', 'Dashboard::index');
   $routes->get('dashboard', 'Dashboard::index');
   $routes->get('qr/download', 'Dashboard::downloadQR');
   $routes->get('profile', 'Dashboard::profile');
});

// ==========================================
// ADMIN
// ==========================================
$routes->group('admin', function (RouteCollection $routes) {
   // Dashboard
   $routes->get('', 'Admin\Dashboard::index');
   $routes->get('dashboard', 'Admin\Dashboard::index');
   $routes->post('dashboard/filter-data', 'Admin\Dashboard::filterData');
   $routes->get('dashboard/active-users', 'Admin\Dashboard::getActiveUsers');

   // Kelas (tanpa Jurusan)
   $routes->group('kelas', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->get('/', 'KelasController::index');
      $routes->get('tambah', 'KelasController::tambahKelas');
      $routes->post('tambahKelasPost', 'KelasController::tambahKelasPost');
      $routes->get('edit/(:any)', 'KelasController::editKelas/$1');
      $routes->post('editKelasPost', 'KelasController::editKelasPost');
      $routes->post('deleteKelasPost', 'KelasController::deleteKelasPost');
      $routes->post('list-data', 'KelasController::listData');
      $routes->get('bulk', 'KelasController::bulkPost');
      $routes->post('downloadCSVFilePost', 'KelasController::downloadCSVFilePost');
      $routes->post('generateCSVObjectPost', 'KelasController::generateCSVObjectPost');
      $routes->post('importCSVItemPost', 'KelasController::importCSVItemPost');
   });

   // Data Siswa
   $routes->get('siswa', 'Admin\DataSiswa::index');
   $routes->post('siswa', 'Admin\DataSiswa::ambilDataSiswa');
   $routes->get('siswa/create', 'Admin\DataSiswa::formTambahSiswa');
   $routes->post('siswa/create', 'Admin\DataSiswa::saveSiswa');
   $routes->get('siswa/edit/(:any)', 'Admin\DataSiswa::formEditSiswa/$1');
   $routes->post('siswa/edit', 'Admin\DataSiswa::updateSiswa');
   $routes->delete('siswa/delete/(:any)', 'Admin\DataSiswa::delete/$1');
   $routes->get('siswa/bulk', 'Admin\DataSiswa::bulkPostSiswa');

   $routes->group('siswa', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->post('downloadCSVFilePost', 'DataSiswa::downloadCSVFilePost');
      $routes->post('generateCSVObjectPost', 'DataSiswa::generateCSVObjectPost');
      $routes->post('importCSVItemPost', 'DataSiswa::importCSVItemPost');
      $routes->post('deleteSelectedSiswa', 'DataSiswa::deleteSelectedSiswa');
   });

   // Data Guru
   $routes->get('guru', 'Admin\DataGuru::index');
   $routes->post('guru', 'Admin\DataGuru::ambilDataGuru');
   $routes->get('guru/create', 'Admin\DataGuru::formTambahGuru');
   $routes->post('guru/create', 'Admin\DataGuru::saveGuru');
   $routes->get('guru/edit/(:any)', 'Admin\DataGuru::formEditGuru/$1');
   $routes->post('guru/edit', 'Admin\DataGuru::updateGuru');
   $routes->delete('guru/delete/(:any)', 'Admin\DataGuru::delete/$1');
   $routes->get('guru/bulk', 'Admin\DataGuru::bulkPost');

   $routes->group('guru', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->post('downloadCSVFilePost', 'DataGuru::downloadCSVFilePost');
      $routes->post('generateCSVObjectPost', 'DataGuru::generateCSVObjectPost');
      $routes->post('importCSVItemPost', 'DataGuru::importCSVItemPost');
   });

   // Absen Siswa
   $routes->get('absen-siswa', 'Admin\DataAbsenSiswa::index');
   $routes->post('absen-siswa', 'Admin\DataAbsenSiswa::ambilDataSiswa');
   $routes->post('absen-siswa/kehadiran', 'Admin\DataAbsenSiswa::ambilKehadiran');
   $routes->post('absen-siswa/edit', 'Admin\DataAbsenSiswa::ubahKehadiran');

   // Absen Guru
   $routes->get('absen-guru', 'Admin\DataAbsenGuru::index');
   $routes->post('absen-guru', 'Admin\DataAbsenGuru::ambilDataGuru');
   $routes->post('absen-guru/kehadiran', 'Admin\DataAbsenGuru::ambilKehadiran');
   $routes->post('absen-guru/edit', 'Admin\DataAbsenGuru::ubahKehadiran');

   // Generate QR
   $routes->get('generate', 'Admin\GenerateQR::index');
   $routes->post('generate/siswa-by-kelas', 'Admin\GenerateQR::getSiswaByKelas');
   $routes->post('generate/siswa', 'Admin\QRGenerator::generateQrSiswa');
   $routes->post('generate/guru', 'Admin\QRGenerator::generateQrGuru');

   // Download QR
   $routes->get('qr/siswa/download', 'Admin\QRGenerator::downloadAllQrSiswa');
   $routes->get('qr/siswa/(:any)/download', 'Admin\QRGenerator::downloadQrSiswa/$1');
   $routes->get('qr/guru/download', 'Admin\QRGenerator::downloadAllQrGuru');
   $routes->get('qr/guru/(:any)/download', 'Admin\QRGenerator::downloadQrGuru/$1');
   // Download QR Petugas
   $routes->get('qr/petugas/(:any)/download', 'Admin\QRGenerator::downloadQrPetugas/$1');

   // Laporan
   $routes->get('laporan', 'Admin\GenerateLaporan::index');
   $routes->post('laporan/siswa', 'Admin\GenerateLaporan::generateLaporanSiswa');
   $routes->post('laporan/guru', 'Admin\GenerateLaporan::generateLaporanGuru');

   // Petugas (superadmin)
   $routes->get('petugas', 'Admin\DataPetugas::index');
   $routes->post('petugas', 'Admin\DataPetugas::ambilDataPetugas');
   $routes->get('petugas/register', 'Admin\DataPetugas::registerPetugas');
   $routes->post('petugas/register', 'Admin\DataPetugas::registerPetugasPost');
   $routes->get('petugas/edit/(:any)', 'Admin\DataPetugas::formEditPetugas/$1');
   $routes->post('petugas/edit', 'Admin\DataPetugas::updatePetugas');
   $routes->delete('petugas/delete/(:any)', 'Admin\DataPetugas::delete/$1');
   $routes->get('petugas/activate/(:any)', 'Admin\DataPetugas::toggleActivation/$1');

   // Settings
   $routes->group('general-settings', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->get('/', 'GeneralSettings::index');
      $routes->post('update', 'GeneralSettings::generalSettingsPost');
   });

   // Backup & Restore
   $routes->group('backup', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->get('', 'Backup::index');
      $routes->get('db/backup', 'Backup::dbBackup');
      $routes->post('db/restore', 'Backup::dbRestore');
      $routes->get('photos/backup', 'Backup::photosBackup');
      $routes->post('photos/restore', 'Backup::photosRestore');
   });
});

// ==========================================
// HEADMASTER / KEPALA SEKOLAH
// ==========================================
$routes->group('headmaster', ['namespace' => 'App\Controllers\Headmaster', 'filter' => 'login'], function (RouteCollection $routes) {
   $routes->get('/', 'Dashboard::index');
   $routes->get('laporan-siswa', 'Dashboard::laporanSiswa');
   $routes->get('laporan-guru', 'Dashboard::laporanGuru');
});

// ==========================================
// TEACHER / WALI KELAS
// ==========================================
$routes->group('teacher', ['namespace' => 'App\Controllers\Teacher', 'filter' => 'login'], function (RouteCollection $routes) {
   $routes->get('/', 'Dashboard::index');
   $routes->get('dashboard', 'Dashboard::index');
   $routes->get('laporan', 'Reports::index');
   $routes->post('laporan/generate', 'Reports::generate');
   $routes->get('qr', 'QRCode::index');
   $routes->get('qr/download', 'QRCode::download');
   $routes->get('attendance', 'Dashboard::attendance');
   $routes->get('attendance/(:any)', 'Dashboard::attendance/$1');
   $routes->post('attendance/get-list', 'Dashboard::getAttendanceList');
   $routes->post('attendance/get-edit-modal', 'Dashboard::getEditModal');
   $routes->post('attendance/update-single', 'Dashboard::updateSingleAttendance');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
   require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
