<?php
class AuthModel {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM tb_users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [BARU] Mengecek apakah username sudah dipakai
    public function isUsernameExist($username) {
        $stmt = $this->db->prepare("SELECT id_user FROM tb_users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [BARU] Memasukkan data user baru sebagai 'donatur'
    public function registerUser($username, $password, $nama) {
        $stmt = $this->db->prepare("INSERT INTO tb_users (username, password, nama, role) VALUES (?, ?, ?, 'donatur')");
        return $stmt->execute([$username, $password, $nama]);
    }
}
?>