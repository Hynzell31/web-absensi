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
$siswa = $siswaModel->first();
if ($siswa) {
    echo $siswa['unique_code'];
}
