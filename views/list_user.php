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
    <title>Daftar User</title>
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
        <h1 class="text-2xl font-semibold mb-6">Daftar User</h1>

        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Jabatan</th>
                    <th class="px-4 py-2">NIP</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tampilkan data user -->
                <tr>
                    <td class="border px-4 py-2">1</td>
                    <td class="border px-4 py-2">Admin</td>
                    <td class="border px-4 py-2">Admin</td>
                    <td class="border px-4 py-2">Manager</td>
                    <td class="border px-4 py-2">123456789</td>
                    <td class="border px-4 py-2">
                        <a href="edit_user.php?id=1" class="text-blue-600 hover:underline">Edit</a> | 
                        <a href="delete_user.php?id=1" class="text-red-600 hover:underline">Hapus</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
