<?php
// Test file - hapus setelah selesai diagnosa
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>PHP Test OK</h2>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'unknown') . "</p>";
echo "<p>Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'unknown') . "</p>";
echo "<p>Script Filename: " . ($_SERVER['SCRIPT_FILENAME'] ?? 'unknown') . "</p>";

// Test app dir
$appDir = __DIR__ . '/app/Config/Paths.php';
echo "<p>app/Config/Paths.php exists: " . (file_exists($appDir) ? '<b style="color:green">YES</b>' : '<b style="color:red">NO - ' . $appDir . '</b>') . "</p>";

// Test vendor dir
$vendorDir = __DIR__ . '/vendor/autoload.php';
echo "<p>vendor/autoload.php exists: " . (file_exists($vendorDir) ? '<b style="color:green">YES</b>' : '<b style="color:red">NO - ' . $vendorDir . '</b>') . "</p>";

// Test writable dir
$writableDir = __DIR__ . '/writable';
echo "<p>writable/ exists: " . (is_dir($writableDir) ? '<b style="color:green">YES</b>' : '<b style="color:red">NO</b>') . "</p>";
echo "<p>writable/ is writable: " . (is_writable($writableDir) ? '<b style="color:green">YES</b>' : '<b style="color:red">NO</b>') . "</p>";

// Test .env
$envFile = __DIR__ . '/.env';
echo "<p>.env exists: " . (file_exists($envFile) ? '<b style="color:green">YES</b>' : '<b style="color:red">NO</b>') . "</p>";

// Try to load CI4
echo "<hr><h3>Trying to load CodeIgniter...</h3>";
try {
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    require FCPATH . 'app/Config/Paths.php';
    $paths = new Config\Paths();
    echo "<p>Paths loaded OK. System dir: " . $paths->systemDirectory . "</p>";
    echo "<p>System dir exists: " . (is_dir($paths->systemDirectory) ? '<b style="color:green">YES</b>' : '<b style="color:red">NO</b>') . "</p>";
} catch (\Throwable $e) {
    echo "<p style='color:red'>ERROR: " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine() . "</p>";
}
