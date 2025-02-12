<?php
include('../config/koneksi.php');

class PeminjamanController {

    public function pinjamBarang($barang_id, $user_id, $tanggal_pinjam, $tanggal_kembali, $catatan) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO peminjaman (barang_id, user_id, tanggal_pinjam, tanggal_kembali, catatan) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$barang_id, $user_id, $tanggal_pinjam, $tanggal_kembali, $catatan]);
    }

    public function riwayatPeminjaman() {
        global $pdo;
        $stmt = $pdo->query("SELECT peminjaman.*, barang.nama_barang, users.username 
                             FROM peminjaman 
                             JOIN barang ON peminjaman.barang_id = barang.id 
                             JOIN users ON peminjaman.user_id = users.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatusPeminjaman($id, $status) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE peminjaman SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
}
?>
