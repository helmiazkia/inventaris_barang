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
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex">
    <!-- Navbar Kiri (Fixed) -->
    <div class="w-64 h-screen bg-blue-900 text-white p-5 flex flex-col fixed top-0 left-0">
        <!-- Logo dan Teks -->
        <div class="flex items-center mb-9 ">
            <img src="../public/image.png" alt="Logo" class="w-12 h-12 mr-4">
            <span class="text-xs">Dinas Komunikasi Informatika dan Statistika<br> Kab.Brebes</span>
        </div>

        <!-- Menu Navbar -->
        <div class="flex flex-col space-y-4 mt-5">
            <a href="dashboard.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'dashboard.php') ? 'bg-blue-700' : ''; ?>">Dashboard</a>
            <a href="manage_user.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'manage_user.php') ? 'bg-blue-700' : ''; ?>">Manajemen User</a>
            <a href="logout.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'logout.php') ? 'bg-blue-700' : ''; ?>">Logout</a>
        </div>
    </div>

    <!-- Konten Halaman Utama -->
    <div class="flex-1 p-8 ml-64"> <!-- Added ml-64 to push content to the right -->
        <h1 class="text-2xl font-semibold mb-6">Selamat datang, <?php echo $_SESSION['username']; ?> (Admin)</h1>
        <p>Ini adalah dashboard admin. Anda dapat menambah, mengelola, dan menghapus pengguna dari sini.</p>

        <!-- Link CRUD User -->
        <h4 class="text-xl mt-8">Manajemen User</h4>
        <ul class="list-disc pl-5">
            <li><a href="create_user.php" class="text-blue-600 hover:underline">Tambah User Baru</a></li>
            <li><a href="list_user.php" class="text-blue-600 hover:underline">Lihat Daftar User</a></li>
        </ul>
    </div>
</body>

</html>
