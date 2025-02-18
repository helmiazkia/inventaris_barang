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

        // Cek apakah password diubah
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET username = ?, password = ?, role = ?, jabatan = ?, nip = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $username, $hashed_password, $role, $jabatan, $nip, $user_id);
        } else {
            $sql = "UPDATE users SET username = ?, role = ?, jabatan = ?, nip = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssii", $username, $role, $jabatan, $nip, $user_id);
        }

        if ($stmt->execute()) {
            // Jika user yang sedang login mengupdate akunnya sendiri
            if ($_SESSION['id'] == $user_id) {
                if (!empty($password)) {
                    // Logout jika password diubah
                    session_destroy();
                    header("Location: ../login.php");
                    exit();
                } else {
                    // Perbarui session agar perubahan langsung terlihat
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    $_SESSION['jabatan'] = $jabatan;
                    $_SESSION['nip'] = $nip;
                }
            }
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Panggil Navbar -->
    <?php include('navbar.php'); ?>

</body>

    <!-- Konten Halaman Edit -->
    <div class="ml-64 p-8 pt-16 mt-1">
        <h1 class="text-2xl font-semibold mb-6">Edit User</h1>

        <!-- Tampilkan pesan error/sukses -->
        <?php if (isset($success_message)): ?>
            <p class="text-green-500"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <p class="text-red-500"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium">Role</label>
                <select id="role" name="role" required class="w-full px-4 py-2 border rounded-md">
                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="jabatan" class="block text-sm font-medium">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" value="<?php echo htmlspecialchars($user['jabatan']); ?>" class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="nip" class="block text-sm font-medium">NIP</label>
                <input type="text" id="nip" name="nip" value="<?php echo htmlspecialchars($user['nip']); ?>" required class="w-full px-4 py-2 border rounded-md">
            </div>

            <button type="submit" name="edit_user" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">Perbarui User</button>
        </form>
    </div>
</body>
</html>
