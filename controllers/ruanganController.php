<?php
include('../config/koneksi.php');

class RuanganController {

    public function tampilRuangan() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM ruangan");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahRuangan($nama_ruangan) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO ruangan (nama_ruangan) VALUES (?)");
        $stmt->execute([$nama_ruangan]);
    }

    public function editRuangan($id, $nama_ruangan) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE ruangan SET nama_ruangan = ? WHERE id = ?");
        $stmt->execute([$nama_ruangan, $id]);
    }

    public function hapusRuangan($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM ruangan WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
