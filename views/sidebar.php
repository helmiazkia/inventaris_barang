<?php
$current_page = basename($_SERVER['PHP_SELF']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'User';

$page_titles = [
    'dashboard.php' => 'Dashboard',
    'userView.php' => 'Manajemen User',
    'barangView.php' => 'Manajemen Barang',
    'logout.php' => 'Logout',
    'ruanganView.php' => 'Manajemen Ruangan',
    'edit_user.php' => 'Edit Data Pegawai',
    'edit_barang.php' => 'Edit Data Barang'

];

$current_title = isset($page_titles[$current_page]) ? $page_titles[$current_page] : 'Beranda';
?>

<!-- Sidebar -->
<div id="sidebar" class="w-64 h-screen bg-blue-900 text-white p-5 flex flex-col fixed top-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <!-- Logo dan Nama -->
    <div class="flex items-center mb-9 mt-3">
        <img src="../public/image.png" alt="Logo" class="w-12 h-12 mr-4">
        <span class="text-xs">Dinas Komunikasi Informatika dan Statistika<br> Kab. Brebes</span>
    </div>

    <!-- Menu Navbar -->
    <div class="flex flex-col space-y-4 mt-10 mb-auto">
        <a href="dashboard.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'dashboard.php') ? 'bg-blue-700' : ''; ?>">Dashboard</a>
        <a href="userView.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'userView.php') ? 'bg-blue-700' : ''; ?>">Manajemen User</a>
        <a href="ruanganView.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'ruanganView.php') ? 'bg-blue-700' : ''; ?>">Manajemen Ruangan</a>
        <a href="barangView.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'barangView.php') ? 'bg-blue-700' : ''; ?>">Manajemen Barang</a>
        <a href="pemindahanBarangView.php" class="text-lg hover:bg-blue-700 p-2 rounded-md <?php echo ($current_page == 'pemindahanBarangView.php') ? 'bg-blue-700' : ''; ?>">Pemindahan Barang</a>
        
    </div>

    <!-- Logout -->
    <a href="logout.php" class="text-lg hover:bg-blue-700 hover:border-blue-700 hover:text-white p-2 rounded-md border border-transparent <?php echo ($current_page == 'logout.php') ? 'bg-blue-700 text-white border-blue-700' : 'border-white'; ?>">Logout</a>
</div>

<!-- Overlay untuk mobile -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden lg:hidden z-40" onclick="toggleSidebar()"></div>
