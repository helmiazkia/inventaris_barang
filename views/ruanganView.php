<?php
include('../controllers/ruanganController.php');  // Masukkan controller agar bisa menangani logic
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Ruangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function showNotification(type, message) {
            alert(message);
        }

        <?php if (isset($_GET['success'])): ?>
            window.onload = function() {
                showNotification('success', '<?php echo $_GET['success']; ?>');
            }
        <?php elseif (isset($_GET['error'])): ?>
            window.onload = function() {
                showNotification('error', '<?php echo $_GET['error']; ?>');
            }
        <?php endif; ?>
    </script>
    <style>
        /* Menambahkan scroll horizontal pada tabel di tampilan mobile */
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* Supaya scroll lancar di perangkat mobile */
        }

        table {
            min-width: 600px; /* Pastikan tabel cukup lebar di perangkat kecil */
        }

        /* Responsif untuk tampilan mobile */
        @media (max-width: 768px) {
            table {
                min-width: 400px; /* Ukuran tabel menyesuaikan untuk tampilan lebih kecil */
            }

            .modal-content {
                width: 90%; /* Agar modal bisa tampil dengan baik di mobile */
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Topbar -->
    <?php include('topbar.php'); ?>

    <div class="lg:ml-64 p-8 pt-20 min-h-screen">

        <div class="bg-white p-6 rounded-lg shadow mb-6">

            <!-- Notifikasi -->
            <?php if (isset($_GET['success'])): ?>
                <p class="bg-green-100 text-green-700 p-2 rounded-md"><?php echo $_GET['success']; ?></p>
            <?php elseif (isset($_GET['error'])): ?>
                <p class="bg-red-100 text-red-700 p-2 rounded-md"><?php echo $_GET['error']; ?></p>
            <?php endif; ?>

            <!-- Form Tambah Ruangan -->
            <!-- Tombol Tambah Ruangan -->
            <div class="mb-6 text-left">
                <button onclick="openAddRoomModal()" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-md hover:bg-blue-700 transition">
                    Tambah Ruangan
                </button>
            </div>

            <!-- Daftar Ruangan -->
            <h2 class="text-lg font-bold mt-6 mb-2">Daftar Ruangan</h2>
            
            <!-- Kontainer untuk tabel yang bisa digulir -->
            <div class="table-container">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Ruangan</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $ruangan_result->fetch_assoc()): ?>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['id']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['nama_ruangan']; ?></td>
                                <td class="border border-gray-300 px-4 py-2 flex gap-2">
                                    <button onclick="editRoom(<?php echo $row['id']; ?>, '<?php echo $row['nama_ruangan']; ?>')"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </button>
                                    <a href="?delete=<?php echo $row['id']; ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Tambah Ruangan -->
            <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h3 class="text-lg font-bold mb-4">Tambah Ruangan</h3>
                    <form method="POST" action="../controllers/ruanganController.php">
                        <div class="mb-4">
                            <label for="nama_ruangan" class="block text-sm font-medium">Nama Ruangan</label>
                            <input type="text" id="nama_ruangan" name="nama_ruangan" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <button type="submit" name="add_room" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">
                            Tambah Ruangan
                        </button>
                        <button type="button" onclick="closeAddRoomModal()" class="w-full mt-2 bg-gray-500 text-white font-bold py-2 rounded-md hover:bg-gray-600 transition">
                            Batal
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Ruangan -->
            <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h3 class="text-xl font-bold mb-4">Edit Ruangan</h3>
                    <form method="POST" action="../controllers/ruanganController.php">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-4">
                            <label for="edit_nama_ruangan" class="block text-sm font-medium">Nama Ruangan</label>
                            <input type="text" id="edit_nama_ruangan" name="nama_ruangan" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <button type="submit" name="edit_room" class="w-full bg-green-600 text-white font-bold py-2 rounded-md hover:bg-green-700 transition">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeEditRoomModal()" class="w-full mt-2 bg-gray-500 text-white font-bold py-2 rounded-md hover:bg-gray-600 transition">
                            Batal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAddRoomModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddRoomModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function editRoom(id, name) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_ruangan').value = name;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditRoomModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
    <?php include('footer.php'); ?>
</body>

</html>
