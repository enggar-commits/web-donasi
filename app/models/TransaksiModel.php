<?php
class TransaksiModel {
    private $db;

    public function __construct($pdo) { 
        $this->db = $pdo; 
    }

    public function getAll() {
        $query = "SELECT t.*, k.judul_kampanye, u.nama AS pencatat 
                  FROM tb_transaksi t 
                  JOIN tb_kampanye k ON t.id_kampanye = k.id_kampanye
                  JOIN tb_users u ON t.id_user = u.id_user
                  ORDER BY t.id_transaksi DESC";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllKampanye() {
        return $this->db->query("SELECT id_kampanye, judul_kampanye FROM tb_kampanye WHERE status = 'aktif'")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($id_kampanye, $id_user, $nominal, $pesan, $is_anonim, $metode, $tanggal) {
        $stmt = $this->db->prepare("INSERT INTO tb_transaksi (id_kampanye, id_user, nominal, pesan, is_anonim, metode_pembayaran, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_kampanye, $id_user, $nominal, $pesan, $is_anonim, $metode, $tanggal]);
        
        $stmtUpdate = $this->db->prepare("UPDATE tb_kampanye SET dana_terkumpul = dana_terkumpul + ? WHERE id_kampanye = ?");
        return $stmtUpdate->execute([$nominal, $id_kampanye]);
    }

    public function getDoaByKampanye($id_kampanye) {
        $stmt = $this->db->prepare("SELECT t.pesan, t.is_anonim, u.nama FROM tb_transaksi t JOIN tb_users u ON t.id_user = u.id_user WHERE t.id_kampanye = ? AND t.pesan IS NOT NULL AND t.pesan != '' ORDER BY t.id_transaksi DESC");
        $stmt->execute([$id_kampanye]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>