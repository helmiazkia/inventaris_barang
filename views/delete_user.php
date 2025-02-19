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

// Cek apakah admin menghapus akun mereka sendiri
if ($_SESSION['id'] == $user_id) {
    // Hapus session dan logout
    session_destroy();
    header("Location: ../login.php?message=You have successfully deleted your account. Please log in again.");
    exit();
}

// Hapus data user
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // Redirect kembali ke daftar user dengan notifikasi success
    header("Location: manage_user.php?action=listUser&success=User berhasil dihapus!");
    exit();
} else {
    // Redirect kembali ke daftar user dengan notifikasi error
    header("Location: manage_user.php?action=listUser&error=Gagal menghapus user!");
    exit();
}
?>
