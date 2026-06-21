<?php
require_once __DIR__ . '/../models/TransaksiModel.php';
require_once __DIR__ . '/../models/KampanyeModel.php';

class TransaksiController {
    private $model;
    private $kampanyeModel;

    public function __construct($pdo) {
        if (!isset($_SESSION['user_id'])) { header('Location: /donasi/auth'); exit; }
        $this->model = new TransaksiModel($pdo);
        $this->kampanyeModel = new KampanyeModel($pdo);
    }

    public function index() {
        if ($_SESSION['role'] !== 'admin') { header('Location: /donasi/kampanye'); exit; }
        $data = $this->model->getAll();
        include __DIR__ . '/../views/transaksi/index.php';
    }

    public function create() {
        if ($_SESSION['role'] !== 'admin') { header('Location: /donasi/kampanye'); exit; }
        $kampanye = $this->model->getAllKampanye();
        include __DIR__ . '/../views/transaksi/tambah.php';
    }

    public function bayar($id_kampanye) {
        if ($_SESSION['role'] !== 'donatur') { header('Location: /donasi/kampanye'); exit; }
        $kampanye = $this->kampanyeModel->getById($id_kampanye);
        $list_doa = $this->model->getDoaByKampanye($id_kampanye);
        if (!$kampanye) { header('Location: /donasi/kampanye'); exit; }
        include __DIR__ . '/../views/transaksi/bayar.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $is_anonim = isset($_POST['is_anonim']) ? 1 : 0;
            $pesan = trim($_POST['pesan'] ?? '');
            $nominal = $_POST['nominal'];
            $metode = $_POST['metode_pembayaran'] ?? 'Manual Transfer';

            $this->model->create($_POST['id_kampanye'], $_SESSION['user_id'], $nominal, $pesan, $is_anonim, $metode, date('Y-m-d'));
            
            if ($_SESSION['role'] === 'admin') {
                header('Location: /donasi/transaksi');
            } else {
                // Variabel ini wajib ada agar instruksi.php tidak error!
                $va_number = '8806' . rand(1000000000, 9999999999);
                include __DIR__ . '/../views/transaksi/instruksi.php';
            }
            exit;
        }
    }
}
?>