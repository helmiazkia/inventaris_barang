<?php
$host = 'localhost'; // alamat host
$dbname = 'inventaris_barang'; // nama database
$username = 'root'; // username database
$password = ''; // password database

// Membuat koneksi dengan PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
