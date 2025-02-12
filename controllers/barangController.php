<?php
include('../config/koneksi.php');

class BarangController {

    public function tampilBarang() {
        global $pdo;
        $stmt = $pdo->query("SELECT barang.*, kategori.nama_kategori, ruangan.nama_ruangan 
                             FROM barang 
                             JOIN kategori ON barang.kategori_id = kategori.id 
                             JOIN ruangan ON barang.ruangan_id = ruangan.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahBarang($nama_barang, $kode_barang, $barcode, $kategori_id, $ruangan_id, $jumlah) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO barang (nama_barang, kode_barang, barcode, kategori_id, ruangan_id, jumlah) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama_barang, $kode_barang, $barcode, $kategori_id, $ruangan_id, $jumlah]);
    }

    public function editBarang($id, $nama_barang, $kode_barang, $barcode, $kategori_id, $ruangan_id, $jumlah) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE barang SET nama_barang = ?, kode_barang = ?, barcode = ?, kategori_id = ?, 
                               ruangan_id = ?, jumlah = ? WHERE id = ?");
        $stmt->execute([$nama_barang, $kode_barang, $barcode, $kategori_id, $ruangan_id, $jumlah, $id]);
    }

    public function hapusBarang($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM barang WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
