<footer class="bg-white text-gray-500 py-4 mt-8 border-t border-gray-300 transition-all duration-300" id="footer">
    <div class="container mx-auto text-center">
        <p class="text-sm">&copy; <?php echo date('Y'); ?> Sistem Manajemen Inventaris.</p>
        <p class="text-xs mt-2">Dibuat <span class="text-xs-500 font-semibold">oleh Mahasiswa PKL Dinkominfotik Brebes</span></p>
    </div>
</footer>

<script>
    function adjustFooter() {
        let sidebar = document.getElementById('sidebar');
        let footer = document.getElementById('footer');
        if (sidebar && window.innerWidth >= 768) {
            footer.classList.add('ml-64');
        } else {
            footer.classList.remove('ml-64');
        }
    }

    // Panggil fungsi saat halaman dimuat
    adjustFooter();

    // Pastikan footer menyesuaikan jika ukuran layar berubah
    window.addEventListener('resize', adjustFooter);
</script>
