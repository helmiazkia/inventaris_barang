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

<body class="flex flex-col bg-gray-100">

    <!-- Panggil Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Konten Halaman Utama -->
    <div class="ml-64 p-8 pt-16 mt-10">

        <!-- Kartu Jumlah Pengguna dengan warna kuning dan mepet kiri -->
        <div class="bg-yellow-300 p-4 rounded-lg shadow-md mb-6 max-w-xs">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Jumlah Pengguna</h3>
            <p class="text-2xl font-bold text-blue-600"><?php echo $total_users; ?></p>
            <p class="text-sm text-gray-500 mt-2">Total pengguna yang terdaftar di sistem.</p>
            <!-- Tombol untuk arahkan ke Daftar User -->
            <div class="mt-4">
                <a href="manage_user.php?action=listUser" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">Lihat Daftar User</a>
            </div>
        </div>

    </div>

    </div>

</body>

</html>