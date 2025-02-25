<?php
// Cek jika user sudah login dan memiliki role admin
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Include koneksi database
include('koneksi.php');

// Ambil id barang dari URL
$id_barang = $_GET['id'];

// Query untuk menghapus barang berdasarkan ID (menggunakan prepared statement)
$stmt = $conn->prepare("DELETE FROM barang WHERE id_barang = ?");
$stmt->bind_param("i", $id_barang); // 'i' untuk integer

if ($stmt->execute()) {
    echo "Barang berhasil dihapus!";
    // Redirect ke halaman daftar barang setelah berhasil menghapus
    header("Location: daftar_barang.php"); // Sesuaikan dengan halaman daftar barang
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
