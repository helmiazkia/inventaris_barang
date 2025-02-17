<?php
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/koneksi.php');

// Ambil ID user yang ingin dihapus
$user_id = $_GET['id'];

// Hapus data user
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // Redirect dengan notifikasi success
    header("Location: manage_user.php?success=User berhasil dihapus!");
    exit();
} else {
    // Redirect dengan notifikasi error
    header("Location: manage_user.php?error=Gagal menghapus user!");
    exit();
}
