<?php
<<<<<<< HEAD
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
=======
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/koneksi.php');

// Cek apakah ID barang tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_barang.php?action=listBarang&error=ID barang tidak ditemukan!");
    exit();
}

$id_barang = $_GET['id'];

// Periksa apakah barang dengan ID tersebut ada di database
$check_sql = "SELECT * FROM barang WHERE id_barang = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $id_barang);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: manage_barang.php?action=listBarang&error=Barang tidak ditemukan!");
    exit();
}

// Hapus data barang
$sql = "DELETE FROM barang WHERE id_barang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_barang);

if ($stmt->execute()) {
    header("Location: manage_barang.php?action=listBarang&success=Barang berhasil dihapus!");
    exit();
} else {
    header("Location: manage_barang.php?action=listBarang&error=Gagal menghapus barang!");
    exit();
}
?>
>>>>>>> c8255e8881d21df6f3e3f4aef10bc38f96fb2bea
