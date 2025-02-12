<?php
session_start();
include('../config/koneksi.php');
include('../controllers/barangController.php');

$barangController = new BarangController();

$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$query = "SELECT barang.*, kategori.nama_kategori, ruangan.nama_ruangan 
          FROM barang 
          JOIN kategori ON barang.kategori_id = kategori.id 
          JOIN ruangan ON barang.ruangan_id = ruangan.id 
          WHERE barang.nama_barang LIKE :search OR barang.kode_barang LIKE :search OR ruangan.nama_ruangan LIKE :search";

$stmt = $pdo->prepare($query);
$stmt->execute(['search' => "%$search%"]);
$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>Daftar Barang</h1>";

echo "<form method='GET' action=''>";
echo "<input type='text' name='search' value='$search' placeholder='Cari barang...'>";
echo "<button type='submit'>Cari</button>";
echo "</form>";

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
