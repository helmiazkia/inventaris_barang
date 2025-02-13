<?php
// Cek apakah session sudah dimulai sebelumnya
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Memulai session hanya jika belum dimulai
}

// Pastikan pengguna memiliki hak akses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include('../config/koneksi.php');
include('../controllers/userController.php');

$userController = new UserController();
$users = $userController->tampilUser();

echo "<h1>Manajemen Pengguna</h1>";
echo "<a href='tambah_user.php'>Tambah Pengguna</a><br><br>";
echo "<table border='1'>";
echo "<tr><th>Username</th><th>Role</th><th>Aksi</th></tr>";

foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($user['username']) . "</td>";
    echo "<td>" . htmlspecialchars($user['role']) . "</td>";
    echo "<td><a href='edit_user.php?id=" . $user['id'] . "'>Edit</a> | <a href='hapus_user.php?id=" . $user['id'] . "'>Hapus</a></td>";
    echo "</tr>";
}
echo "</table>";
?>
