<?php
$host = "localhost"; // Sesuaikan dengan host Anda
$user = "root"; // Sesuaikan dengan username MySQL Anda
$pass = ""; // Sesuaikan dengan password MySQL Anda
$dbname = "inventaris_barang"; // Nama database Anda

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
