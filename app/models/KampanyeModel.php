<?php
class KampanyeModel {
    private $db;

    public function __construct($pdo) { $this->db = $pdo; }

    public function getAll() {
        $query = "SELECT k.*, u.nama AS pembuat 
                  FROM tb_kampanye k 
                  JOIN tb_users u ON k.id_user = u.id_user
                  ORDER BY k.id_kampanye DESC";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tb_kampanye WHERE id_kampanye = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($id_user, $judul, $gambar, $deskripsi, $target) {
        $stmt = $this->db->prepare("INSERT INTO tb_kampanye (id_user, judul_kampanye, gambar, deskripsi, target_dana) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$id_user, $judul, $gambar, $deskripsi, $target]);
    }

    public function update($id, $judul, $gambar, $deskripsi, $target, $status) {
        if ($gambar) {
            $stmt = $this->db->prepare("UPDATE tb_kampanye SET judul_kampanye = ?, gambar = ?, deskripsi = ?, target_dana = ?, status = ? WHERE id_kampanye = ?");
            return $stmt->execute([$judul, $gambar, $deskripsi, $target, $status, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE tb_kampanye SET judul_kampanye = ?, deskripsi = ?, target_dana = ?, status = ? WHERE id_kampanye = ?");
            return $stmt->execute([$judul, $deskripsi, $target, $status, $id]);
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tb_kampanye WHERE id_kampanye = ?");
        return $stmt->execute([$id]);
    }
}
?>