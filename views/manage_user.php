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
    <title>Manajemen User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body class="flex">
    <!-- Navbar Kiri -->
    <div class="w-64 h-screen bg-blue-900 text-white p-5 flex flex-col fixed top-0 left-0">
        <div class="flex items-center mb-9">
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
        <h1 class="text-2xl font-semibold mb-6">Manajemen Pengguna</h1>

        <!-- Tombol Tab untuk Pilih Tampilan -->
        <div class="mb-6">
            <button onclick="showTab('addUser')" class="bg-blue-600 text-white py-2 px-4 rounded-md mr-2 hover:bg-blue-700 <?php echo ($current_page == 'manage_user.php') && !isset($_GET['action']) ? 'bg-blue-700' : ''; ?>">Tambah User</button>
            <button onclick="showTab('listUser')" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 <?php echo isset($_GET['action']) && $_GET['action'] == 'listUser' ? 'bg-blue-700' : ''; ?>">Daftar User</button>
        </div>

        <!-- Tab Content - Tambah User -->
        <div id="addUser" class="tab-content active">
            <h3 class="text-xl mb-4">Tambah User Baru</h3>
            <div class="border p-4 mb-8">
                <!-- Memanggil form create_user.php -->
                <?php include('create_user.php'); ?>
            </div>
        </div>

        <!-- Tab Content - Daftar User -->
        <div id="listUser" class="tab-content">
            <h3 class="text-xl mb-4">Daftar User</h3>
            <div class="border p-4">
                <!-- Memanggil tabel list_user.php -->
                <?php include('list_user.php'); ?>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan tab yang dipilih
        function showTab(tabName) {
            // Menyembunyikan semua tab
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Menampilkan tab yang dipilih
            const selectedTab = document.getElementById(tabName);
            selectedTab.classList.add('active');
        }
    </script>
</body>
</html>
