<?php
// index.php
session_start();
require_once __DIR__ . '/config/database.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_folder = '/donasi'; 
$path = substr($path, strlen($base_folder));
$pathParts = array_values(array_filter(explode('/', trim($path, '/'))));

$page = $pathParts[0] ?? 'home';
$param = $pathParts[1] ?? null; 
$id = $pathParts[2] ?? null;

// Jika user mengakses root, arahkan ke auth jika belum login
if ($page === 'home') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /donasi/auth');
        exit;
    }
    // Sementara arahkan ke kampanye sebagai halaman utama admin
    header('Location: /donasi/kampanye');
    exit;
}

$allowedControllers = ['auth', 'kampanye', 'transaksi'];

if (!in_array($page, $allowedControllers)) {
    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
    exit;
}

$controllerFile = __DIR__ . "/app/controllers/" . ucfirst($page) . "Controller.php";
if (!file_exists($controllerFile)) {
    echo "<h1>404 - Controller Tidak Ditemukan</h1>";
    exit;
}

require_once $controllerFile;
$controllerClass = ucfirst($page) . 'Controller';
$controller = new $controllerClass($pdo);

// --- Routing Logika ---

// 1. Modul Auth
if ($page === 'auth') {
    if ($param === 'login' && method_exists($controller, 'login')) { $controller->login(); exit; }
    if ($param === 'logout' && method_exists($controller, 'logout')) { $controller->logout(); exit; }
    if ($param === 'register' && method_exists($controller, 'register')) { $controller->register(); exit; }
    if ($param === 'storeUser' && method_exists($controller, 'storeUser')) { $controller->storeUser(); exit; }
}

// 2. Modul CRUD & Transaksi Umum
if ($param === 'tambah' && method_exists($controller, 'create')) { $controller->create(); exit; }
if ($param === 'store' && method_exists($controller, 'store')) { $controller->store(); exit; }
if ($param === 'edit' && $id && method_exists($controller, 'edit')) { $controller->edit($id); exit; }
if ($param === 'update' && method_exists($controller, 'update')) { $controller->update(); exit; }
if ($param === 'hapus' && $id && method_exists($controller, 'delete')) { $controller->delete($id); exit; }

// 3. Modul Khusus Pembayaran Donatur
if ($param === 'bayar' && $id && method_exists($controller, 'bayar')) { $controller->bayar($id); exit; }

// Default Index
if (method_exists($controller, 'index')) {
    $controller->index();
    exit;
}