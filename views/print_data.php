<?php
session_start();
include('../config/koneksi.php');
include('../controllers/peminjamanController.php');

$peminjamanController = new PeminjamanController();
$user_id = $_SESSION['user_id'];
$riwayat = $peminjamanController->riwayatPeminjaman();

echo "<h1>Riwayat Peminjaman (Print)</h1>";
echo "<table border='1'>";
echo "<tr><th>Nama Barang</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th><th>Catatan</th></tr>";
foreach ($riwayat as $item) {
    echo "<tr>";
    echo "<td>" . $item['nama_barang'] . "</td>";
    echo "<td>" . $item['tanggal_pinjam'] . "</td>";
    echo "<td>" . ($item['tanggal_kembali'] ? $item['tanggal_kembali'] : 'Belum Kembali') . "</td>";
    echo "<td>" . $item['status'] . "</td>";
    echo "<td>" . $item['catatan'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
<button onclick="window.print()">Print</button>
