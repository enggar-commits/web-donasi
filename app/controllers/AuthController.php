<?php
require_once __DIR__ . '/../models/AuthModel.php';

class AuthController {
    private $model;
    private $baseUrl; // Menyimpan base URL otomatis
    
    public function __construct($pdo) { 
        $this->model = new AuthModel($pdo); 
        // Deteksi environment otomatis: localhost (XAMPP) pakai /donasi, Railway (Cloud) kosongkan
        $this->baseUrl = ($_SERVER['HTTP_HOST'] == 'localhost') ? '/donasi' : '';
    }

    public function index() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . $this->baseUrl . '/kampanye');
            exit;
        }
        include __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        // Cek jika sudah login, lempar ke kampanye
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . $this->baseUrl . '/kampanye');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->model->getUserByUsername(trim($_POST['username']));
            if ($user && password_verify(trim($_POST['password']), $user['password'])) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                header('Location: ' . $this->baseUrl . '/kampanye');
                exit;
            } else {
                $error = "Username atau password salah!";
                // Biarkan eksekusi berlanjut ke bawah untuk merender view beserta variabel $error
            }
        }
        
        // TAMPILKAN VIEW (Bagian ini yang sebelumnya hilang untuk request GET / URL)
        include __DIR__ . '/../views/auth/login.php';
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . $this->baseUrl . '/kampanye');
            exit;
        }
        include __DIR__ . '/../views/auth/register.php';
    }

    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama']);
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // Pengecekan Username
            if ($this->model->isUsernameExist($username)) {
                $error = "Username sudah dipakai, silakan gunakan yang lain!";
                include __DIR__ . '/../views/auth/register.php';
                return;
            }

            // Enkripsi password dan simpan ke database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->model->registerUser($username, $hashedPassword, $nama);

            // AUTO-LOGIN: Ambil data user yang baru saja dibuat
            $newUser = $this->model->getUserByUsername($username);

            // Daftarkan ke Session
            $_SESSION['user_id'] = $newUser['id_user'];
            $_SESSION['nama'] = $newUser['nama'];
            $_SESSION['role'] = $newUser['role'];

            // Arahkan langsung ke dashboard antarmuka web donasi menggunakan baseUrl dinamis
            header('Location: ' . $this->baseUrl . '/kampanye');
            exit;
        }
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . $this->baseUrl . '/auth');
        exit;
    }
}
?>