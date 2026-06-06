<?php
define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
$app = \CodeIgniter\Config\Services::codeigniter();
$app->initialize();

$siswaModel = new \App\Models\SiswaModel();
$presensiModel = new \App\Models\PresensiSiswaModel();

$siswa = $siswaModel->first();
if (!$siswa) {
    echo "No siswa found.\n";
    exit;
}

echo "Testing scan for siswa: " . $siswa['nama_siswa'] . " (ID: " . $siswa['id_siswa'] . ", Kelas: " . $siswa['id_kelas'] . ")\n";

$date = \CodeIgniter\I18n\Time::today()->toDateString();
$time = \CodeIgniter\I18n\Time::now()->toTimeString();

$sudahAbsen = $presensiModel->cekAbsen($siswa['id_siswa'], $date);
if ($sudahAbsen) {
    echo "Already absen today. ID: $sudahAbsen\n";
    // delete it so we can test
    $presensiModel->delete($sudahAbsen);
    echo "Deleted previous absen.\n";
}

$presensiModel->absenMasuk($siswa['id_siswa'], $date, $time, $siswa['id_kelas']);

if ($presensiModel->errors()) {
    echo "Errors during insert:\n";
    print_r($presensiModel->errors());
} else {
    $inserted = $presensiModel->cekAbsen($siswa['id_siswa'], $date);
    if ($inserted) {
        echo "Success! Inserted presensi ID: $inserted\n";
    } else {
        echo "Failed to insert, but no model errors reported.\n";
    }
}
