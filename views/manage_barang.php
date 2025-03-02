<?php
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/koneksi.php');

// Cek validitas action dari URL
$valid_actions = ['addBarang', 'listBarang'];
$action = isset($_GET['action']) && in_array($_GET['action'], $valid_actions) ? $_GET['action'] : 'addBarang';

// Ambil parameter sukses atau error untuk menampilkan notifikasi
$success_message = isset($_GET['success']) ? $_GET['success'] : null;
$error_message = isset($_GET['error']) ? $_GET['error'] : null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function showNotification(type, message) {
            alert(message);
        }

        <?php if ($success_message): ?>
            window.onload = function() {
                showNotification('success', '<?php echo $success_message; ?>');
            }
        <?php elseif ($error_message): ?>
            window.onload = function() {
                showNotification('error', '<?php echo $error_message; ?>');
            }
        <?php endif; ?>
    </script>
    <style>
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Barang</title>
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
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>
    <!-- Topbar -->
    <?php include('topbar.php'); ?>



    <!-- Konten -->
    <div class="lg:ml-64 p-6 pt-20 mt-3 transition-all duration-300 min-h-screen">
        <!-- Tombol Tab -->
        <div class="flex space-x-4 mb-6">
            <button onclick="showTab('addBarang')" class="px-6 py-3 rounded-lg transition duration-300 
                <?php echo ($action == 'addBarang') ? 'bg-blue-700 text-white shadow-lg' : 'bg-white border text-gray-700 hover:bg-gray-100'; ?>">
                <span>Tambah Barang</span>
            </button>
            <button onclick="showTab('listBarang')" class="px-6 py-3 rounded-lg transition duration-300 
                <?php echo ($action == 'listBarang') ? 'bg-blue-700 text-white shadow-lg' : 'bg-white border text-gray-700 hover:bg-gray-100'; ?>">
                <span>Daftar Barang</span>
            </button>
        </div>

        <!-- Tab Content - Tambah Barang -->
        <div id="addBarang" class="tab-content <?php echo ($action == 'addBarang') ? 'active' : ''; ?>">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-4">Tambah Barang Baru</h3>
                <?php include('create_barang.php'); ?>
            </div>
        </div>

        <!-- Tab Content - Daftar Barang -->
        <div id="listBarang" class="tab-content <?php echo ($action == 'listBarang') ? 'active' : ''; ?>">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-4">Daftar Barang</h3>
                <?php include('list_barang.php'); ?>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            window.location.href = '?action=' + tabName;
        }
    </script>
    <!-- Footer -->
    <?php include('footer.php'); ?>

</body>

</html>