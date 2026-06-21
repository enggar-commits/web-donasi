<?php
require_once __DIR__ . '/../models/KampanyeModel.php';

class KampanyeController {
    private $model;

    public function __construct($pdo) {
        if (!isset($_SESSION['user_id'])) { header('Location: /donasi/auth'); exit; }
        $this->model = new KampanyeModel($pdo);
    }

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/kampanye/index.php';
    }

    private function checkAdmin() {
        if ($_SESSION['role'] !== 'admin') { header('Location: /donasi/kampanye'); exit; }
    }

    public function create() {
        $this->checkAdmin();
        include __DIR__ . '/../views/kampanye/tambah.php';
    }

    public function store() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gambar_name = null;
            // Penanganan upload file gambar (Intel x64 Localhost / XAMPP)
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar_name = time() . '.' . $ext;
                $upload_path = __DIR__ . '/../../uploads/' . $gambar_name;
                move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path);
            }

            $this->model->create($_SESSION['user_id'], $_POST['judul_kampanye'], $gambar_name, $_POST['deskripsi'], $_POST['target_dana']);
            header('Location: /donasi/kampanye');
            exit;
        }
    }

    public function edit($id) {
        $this->checkAdmin();
        $data = $this->model->getById($id);
        if (!$data) { header('Location: /donasi/kampanye'); exit; }
        include __DIR__ . '/../views/kampanye/edit.php';
    }

    public function update() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_kampanye'];
            $gambar_name = null;

            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar_name = time() . '.' . $ext;
                $upload_path = __DIR__ . '/../../uploads/' . $gambar_name;
                move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path);
            }

            $this->model->update($id, $_POST['judul_kampanye'], $gambar_name, $_POST['deskripsi'], $_POST['target_dana'], $_POST['status']);
            header('Location: /donasi/kampanye');
            exit;
        }
    }

    public function delete($id) {
        $this->checkAdmin();
        $this->model->delete($id);
        header('Location: /donasi/kampanye');
        exit;
    }
}
?>