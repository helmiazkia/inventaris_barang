<?php
session_start();
include('../config/koneksi.php');
include('../controllers/barangController.php');

$barangController = new BarangController();
$barang = $barangController->tampilBarang();

echo "<h1>Daftar Barang</h1>";

echo "<table border='1'>";
echo "<tr><th>Nama Barang</th><th>Kode Barang</th><th>Kategori</th><th>Ruangan</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr>";
foreach ($barang as $item) {
    echo "<tr>";
    echo "<td>" . $item['nama_barang'] . "</td>";
    echo "<td>" . $item['kode_barang'] . "</td>";
    echo "<td>" . $item['nama_kategori'] . "</td>";
    echo "<td>" . $item['nama_ruangan'] . "</td>";
    echo "<td>" . $item['jumlah'] . "</td>";
    echo "<td>" . $item['status'] . "</td>";
    echo "<td><a href='edit_barang.php?id=" . $item['id'] . "'>Edit</a> | <a href='hapus_barang.php?id=" . $item['id'] . "'>Hapus</a></td>";
    echo "</tr>";
}
echo "</table>";
?>
