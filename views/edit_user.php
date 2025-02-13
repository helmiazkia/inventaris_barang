<?php
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/koneksi.php');

// Ambil ID user yang ingin diedit
$user_id = $_GET['id'];

// Ambil data user dari database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Proses form submit untuk update user
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $jabatan = $_POST['jabatan'];
        $nip = $_POST['nip'];

        // Hash password baru jika ada perubahan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update data user
        $sql = "UPDATE users SET username = ?, password = ?, role = ?, jabatan = ?, nip = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $username, $hashed_password, $role, $jabatan, $nip, $user_id);

        if ($stmt->execute()) {
            $success_message = "User berhasil diperbarui!";
        } else {
            $error_message = "Gagal memperbarui user!";
        }
    }
} else {
    $error_message = "User tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>

    <?php if (isset($success_message)): ?>
        <p style="color:green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username:</label><br>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label for="role">Role:</label>
