<?php
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Tentukan halaman aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex">
    <!-- Navbar Kiri -->
    <div class="w-64 h-screen bg-blue-900 text-white p-5 flex flex-col">
        <!-- Logo dan Teks -->
        <div class="flex items-center mb-9">
            <img src="../public/image.png" alt="Logo" class="w-12 h-12 mr-4">
            <span class="text-xs">Dinas Komunikasi Informatika dan Statistika<br> Kab.Brebes</span>
        </div>

        <!-- Menu Navbar -->
        <div class="flex flex-col space-y-4 mt-5">
            <a href="dashboard.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'dashboard.php') ? 'bg-blue-700' : ''; ?>">Dashboard</a>
            <a href="create_user.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'create_user.php') ? 'bg-blue-700' : ''; ?>">Tambah User</a>
            <a href="list_user.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'list_user.php') ? 'bg-blue-700' : ''; ?>">Daftar User</a>
            <a href="logout.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'logout.php') ? 'bg-blue-700' : ''; ?>">Logout</a>
        </div>
    </div>

    <!-- Konten Halaman Utama -->
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-semibold mb-6">Tambah User Baru</h1>

        <form method="POST" action="process_create_user.php">
            <!-- Form Tambah User -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" id="username" name="username" required class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium">Role</label>
                <select id="role" name="role" required class="w-full px-4 py-2 border rounded-md">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="jabatan" class="block text-sm font-medium">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="nip" class="block text-sm font-medium">NIP</label>
                <input type="text" id="nip" name="nip" required class="w-full px-4 py-2 border rounded-md">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">Tambah User</button>
        </form>
    </div>
</body>

</html>
