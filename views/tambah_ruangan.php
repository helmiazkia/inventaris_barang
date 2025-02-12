<?php
session_start();
include('../config/koneksi.php');
include('../controllers/ruanganController.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_ruangan = $_POST['nama_ruangan'];

    $ruanganController = new RuanganController();
    $ruanganController->tambahRuangan($nama_ruangan);
    echo "Ruangan berhasil ditambahkan!";
}
?>

<form method="POST" action="">
    <label for="nama_ruangan">Nama Ruangan:</label><br>
    <input type="text" id="nama_ruangan" name="nama_ruangan" required><br><br>
    <button type="submit">Tambah Ruangan</button>
</form>
