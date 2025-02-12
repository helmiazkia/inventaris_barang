<?php
session_start();
include('../config/koneksi.php');
include('../controllers/ruanganController.php');

$ruanganController = new RuanganController();
$ruangan = $ruanganController->tampilRuangan();

echo "<h1>Manajemen Ruangan</h1>";
echo "<a href='tambah_ruangan.php'>Tambah Ruangan</a><br><br>";
echo "<table border='1'>";
echo "<tr><th>Nama Ruangan</th><th>Aksi</th></tr>";
foreach ($ruangan as $item) {
    echo "<tr>";
    echo "<td>" . $item['nama_ruangan'] . "</td>";
    echo "<td><a href='edit_ruangan.php?id=" . $item['id'] . "'>Edit</a> | <a href='hapus_ruangan.php?id=" . $item['id'] . "'>Hapus</a></td>";
    echo "</tr>";
}
echo "</table>";
?>
