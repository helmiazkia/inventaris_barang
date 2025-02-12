<?php
session_start();
include('../config/koneksi.php');
include('../controllers/userController.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validasi username dan password
    if (empty($username) || empty($password)) {
        echo "Username dan password tidak boleh kosong.";
    } else {
        $userController = new UserController();
        $userController->tambahUser($username, $password, $role);
        echo "Pengguna berhasil ditambahkan!";
    }
}
?>

<form method="POST" action="">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <label for="role">Role:</label><br>
    <select name="role" id="role">
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select><br><br>
    <button type="submit">Tambah Pengguna</button>
</form>
