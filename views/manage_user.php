<?php
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Tentukan halaman aktif
$action = isset($_GET['action']) ? $_GET['action'] : 'addUser';
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
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar (Fixed Sidebar) -->
    <body class="flex">
    <!-- Panggil Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Konten Halaman Utama -->
    <div class="ml-64 p-8 pt-16">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Manajemen Pengguna</h1>

        <!-- Tombol Tab -->
        <div class="flex space-x-4 mb-6">
            <button onclick="showTab('addUser')" class="flex items-center space-x-2 px-5 py-3 rounded-lg transition duration-300 
                <?php echo ($action == 'addUser') ? 'bg-blue-700 text-white shadow-lg' : 'bg-white border text-gray-700 hover:bg-gray-100'; ?>">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v6h6a1 1 0 110 2h-6v6a1 1 0 11-2 0v-6H3a1 1 0 110-2h6V3a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                <span>Tambah User</span>
            </button>
            <button onclick="showTab('listUser')" class="flex items-center space-x-2 px-5 py-3 rounded-lg transition duration-300 
                <?php echo ($action == 'listUser') ? 'bg-blue-700 text-white shadow-lg' : 'bg-white border text-gray-700 hover:bg-gray-100'; ?>">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M6 3a3 3 0 100 6 3 3 0 000-6zm0 8a5 5 0 100 10 5 5 0 000-10zm8-8a3 3 0 100 6 3 3 0 000-6zm0 8a5 5 0 100 10 5 5 0 000-10z"></path></svg>
                <span>Daftar User</span>
            </button>
        </div>

        <!-- Tab Content - Tambah User -->
        <div id="addUser" class="tab-content <?php echo ($action == 'addUser') ? 'active' : ''; ?>">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Tambah User Baru</h3>
                <?php include('create_user.php'); ?>
            </div>
        </div>

        <!-- Tab Content - Daftar User -->
        <div id="listUser" class="tab-content <?php echo ($action == 'listUser') ? 'active' : ''; ?>">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Daftar User</h3>
                <?php include('list_user.php'); ?>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            window.location.href = '?action=' + tabName;
        }
    </script>
</body>
</html>
