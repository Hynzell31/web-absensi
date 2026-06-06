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
    die("No siswa");
}

$uniqueCode = $siswa['unique_code'];
echo "Testing scan for: " . $siswa['nama_siswa'] . "\n";

$date = \CodeIgniter\I18n\Time::today()->toDateString();
$time = \CodeIgniter\I18n\Time::now()->toTimeString();

$sudahAbsen = $presensiModel->cekAbsen($siswa['id_siswa'], $date);
if ($sudahAbsen) {
    echo "Sudah absen! ID: $sudahAbsen\n";
    // Delete it so we can test insert
    $presensiModel->delete($sudahAbsen);
    echo "Deleted previous absen.\n";
}

echo "Attempting absenMasuk...\n";
try {
    $presensiModel->absenMasuk($siswa['id_siswa'], $date, $time, $siswa['id_kelas']);
    echo "absenMasuk called.\n";
} catch (\Exception $e) {
    echo "Error calling absenMasuk: " . $e->getMessage() . "\n";
}

$sudahAbsen2 = $presensiModel->cekAbsen($siswa['id_siswa'], $date);
if ($sudahAbsen2) {
    echo "SUCCESS: Inserted with ID $sudahAbsen2\n";
    $p = $presensiModel->getPresensiById($sudahAbsen2);
    print_r($p);
} else {
    echo "FAILED: Did not insert into DB! Check validation or constraints.\n";
    print_r($presensiModel->errors());
}

