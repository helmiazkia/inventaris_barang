<?php
session_start();

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/koneksi.php'); // Pastikan ini mengarah ke file koneksi database yang benar

// Ambil jumlah pengguna
$sql = "SELECT COUNT(*) AS total_users FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_users = $row['total_users'];

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

<body class="bg-gray-100 flex flex-col min-h-screen">
    
    <!-- Panggil Navbar -->
    <?php include('sidebar.php'); ?>
    <?php include('topbar.php'); ?>
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar (Opsional) -->
        <aside class="w-full md:w-64 bg-gray-800 text-white p-6 md:h-screen hidden md:block">
            <h2 class="text-xl font-bold">Admin Panel</h2>
            <ul class="mt-4">
                <li class="py-2 px-4 rounded hover:bg-gray-700 <?php echo ($current_page == 'dashboard.php') ? 'bg-gray-700' : ''; ?>">
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li class="py-2 px-4 rounded hover:bg-gray-700 <?php echo ($current_page == 'manage_user.php') ? 'bg-gray-700' : ''; ?>">
                    <a href="manage_user.php?action=listUser">Manajemen Pengguna</a>
                </li>
            </ul>
        </aside>

        <!-- Konten Utama -->
        <main class="flex-1 p-6 pt-16 mt-10 md:ml-64">
            <div class="max-w-full md:max-w-md mx-auto md:mx-0">
                <!-- Kartu Jumlah Pengguna -->
                <div class="bg-yellow-300 p-6 rounded-lg shadow-md mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Jumlah Pengguna</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2"> <?php echo $total_users; ?> </p>
                    <p class="text-sm text-gray-600 mt-2">Total pengguna yang terdaftar di sistem.</p>
                    <!-- Tombol untuk menuju Daftar User -->
                    <div class="mt-4">
                        <a href="manage_user.php?action=listUser" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">Lihat Daftar User</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>