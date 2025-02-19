<!-- navbar.php -->
<?php

$current_page = basename($_SERVER['PHP_SELF']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'User';

$page_titles = [
    'dashboard.php' => 'Dashboard',
    'manage_user.php' => 'Manajemen User',
    'logout.php' => 'Logout',
    'edit_user.php' => 'Edit data user',
    'manage_ruangan' => 'Manajemen Ruanngan'
];

$current_title = isset($page_titles[$current_page]) ? $page_titles[$current_page] : 'Beranda';
?>

<!-- Navbar Samping -->
<div class="w-64 h-screen bg-blue-900 text-white p-5 flex flex-col fixed top-0 left-0">
    <!-- Logo dan Teks -->
    <div class="flex items-center mb-9">
        <img src="../public/image.png" alt="Logo" class="w-12 h-12 mr-4">
        <span class="text-xs">Dinas Komunikasi Informatika dan Statistika<br> Kab. Brebes</span>
    </div>

    <!-- Menu Navbar -->
    <div class="flex flex-col space-y-4 mt-5 mb-auto">
        <a href="dashboard.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'dashboard.php') ? 'bg-blue-700' : ''; ?>">Dashboard</a>
        <a href="manage_user.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'manage_user.php') ? 'bg-blue-700' : ''; ?>">Manajemen User</a>
        <a href="manage_ruangan.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'manage_ruangan.php') ? 'bg-blue-700' : ''; ?>">Manajemen Ruangan</a>
    </div>

    <!-- Link Logout di bagian paling bawah dengan Bingkai -->
    <a href="logout.php" class="text-lg hover:bg-blue-700 hover:border-blue-700 hover:text-white p-2 rounded-md border border-transparent <?php echo ($current_page == 'logout.php') ? 'bg-blue-700 text-white border-blue-700' : 'border-white'; ?>">Logout</a>
</div>

<!-- Navbar Atas -->
<div class="ml-64 h-16 bg-white flex justify-between items-center px-6 shadow-md fixed top-0 left-0 right-0">
    <h1 class="text-xl font-semibold"><?php echo $current_title; ?></h1>
    <div class="flex items-center">
        <span class="text-lg font-medium text-gray-700"><?php echo $username; ?> (<?php echo ucfirst($role); ?>)</span>
    </div>
</div>
