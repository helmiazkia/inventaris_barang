<?php
if (!isset($current_title)) {
    $current_title = 'Beranda';
}
?>

<!-- Navbar Atas -->
<div class="lg:ml-64 h-16 bg-white flex justify-between items-center px-6 shadow-md fixed top-0 left-0 right-0">
    <!-- Tombol Toggle untuk Mobile -->
    <button id="menu-button" class="lg:hidden text-gray-700 focus:outline-none" onclick="toggleSidebar()">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>

    <h1 class="text-xl font-semibold"><?php echo $current_title; ?></h1>
    
    <div class="flex items-center">
        <span class="text-lg font-medium text-gray-700"><?php echo $username; ?> (<?php echo ucfirst($role); ?>)</span>
    </div>
</div>

<!-- Script untuk Toggle Sidebar -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }
</script>
