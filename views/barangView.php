<?php

include('../controllers/barangController.php');  // Masukkan controller untuk menghandle logic

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

        <?php if (isset($success_message)): ?>
            window.onload = function() {
                showNotification('success', '<?php echo $success_message; ?>');
            }
        <?php elseif (isset($error_message)): ?>
            window.onload = function() {
                showNotification('error', '<?php echo $error_message; ?>');
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
            <?php if (isset($success_message)): ?>
                <p class="bg-green-100 text-green-700 p-2 rounded-md"><?php echo $success_message; ?></p>
            <?php elseif (isset($error_message)): ?>
                <p class="bg-red-100 text-red-700 p-2 rounded-md"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- Form Tambah Barang -->
            <!-- Tombol Tambah Barang -->
            <div class="mb-6 text-left">
                <button onclick="openAddItemModal()" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-md hover:bg-blue-700 transition">
                    Tambah Barang
                </button>
            </div>

            <!-- Daftar Barang -->
            <h2 class="text-lg font-bold mt-6 mb-2">Daftar Barang</h2>
            
            <!-- Kontainer untuk tabel yang bisa digulir -->
            <div class="table-container">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Barang</th>
                            <th class="border border-gray-300 px-4 py-2">Kode Barang</th>
                            <th class="border border-gray-300 px-4 py-2">Kategori</th>
                            <th class="border border-gray-300 px-4 py-2">Jumlah Total</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['id']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['nama_barang']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['kode_barang']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['nama_kategori']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['jumlah_total']; ?></td>
                                <td class="border border-gray-300 px-4 py-2 flex gap-2">
                                    <button onclick="editItem(<?php echo $row['id']; ?>, '<?php echo $row['nama_barang']; ?>', '<?php echo $row['kode_barang']; ?>', <?php echo $row['kategori_id']; ?>, <?php echo $row['jumlah_total']; ?>)"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </button>
                                    <a href="?action=deleteBarang&id=<?php echo $row['id']; ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Tambah Barang -->
            <div id="addItemModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h3 class="text-lg font-bold mb-4">Tambah Barang</h3>
                    <form method="POST" action="?action=addBarang">
                        <div class="mb-4">
                            <label for="nama_barang" class="block text-sm font-medium">Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="kode_barang" class="block text-sm font-medium">Kode Barang</label>
                            <input type="text" id="kode_barang" name="kode_barang" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="kategori_id" class="block text-sm font-medium">Kategori Barang</label>
                            <select id="kategori_id" name="kategori_id" required class="w-full px-4 py-2 border rounded-md">
                                <?php
                                $kategori_result = $conn->query("SELECT id, nama_kategori FROM kategori");
                                while ($kategori = $kategori_result->fetch_assoc()) {
                                    echo "<option value='{$kategori['id']}'>{$kategori['nama_kategori']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="jumlah_total" class="block text-sm font-medium">Jumlah Total</label>
                            <input type="number" id="jumlah_total" name="jumlah_total" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">
                            Tambah Barang
                        </button>
                        <button type="button" onclick="closeAddItemModal()" class="w-full mt-2 bg-gray-500 text-white font-bold py-2 rounded-md hover:bg-gray-600 transition">
                            Batal
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Barang -->
            <div id="editItemModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h3 class="text-xl font-bold mb-4">Edit Barang</h3>
                    <form method="POST" action="?action=editBarang">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-4">
                            <label for="edit_nama_barang" class="block text-sm font-medium">Nama Barang</label>
                            <input type="text" id="edit_nama_barang" name="nama_barang" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="edit_kode_barang" class="block text-sm font-medium">Kode Barang</label>
                            <input type="text" id="edit_kode_barang" name="kode_barang" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="edit_kategori_id" class="block text-sm font-medium">Kategori Barang</label>
                            <select id="edit_kategori_id" name="kategori_id" required class="w-full px-4 py-2 border rounded-md">
                                <?php
                                $kategori_result = $conn->query("SELECT id, nama_kategori FROM kategori");
                                while ($kategori = $kategori_result->fetch_assoc()) {
                                    echo "<option value='{$kategori['id']}'>{$kategori['nama_kategori']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="edit_jumlah_total" class="block text-sm font-medium">Jumlah Total</label>
                            <input type="number" id="edit_jumlah_total" name="jumlah_total" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeEditItemModal()" class="w-full mt-2 bg-gray-500 text-white font-bold py-2 rounded-md hover:bg-gray-600 transition">
                            Batal
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <script>
        // Fungsi untuk membuka modal edit barang
        function editItem(id, nama_barang, kode_barang, kategori_id, jumlah_total) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_barang').value = nama_barang;
            document.getElementById('edit_kode_barang').value = kode_barang;
            document.getElementById('edit_kategori_id').value = kategori_id;
            document.getElementById('edit_jumlah_total').value = jumlah_total;
            document.getElementById('editItemModal').classList.remove('hidden');
        }

        // Fungsi untuk menutup modal edit barang
        function closeEditItemModal() {
            document.getElementById('editItemModal').classList.add('hidden');
        }

        // Fungsi untuk membuka modal tambah barang
        function openAddItemModal() {
            document.getElementById('addItemModal').classList.remove('hidden');
        }

        // Fungsi untuk menutup modal tambah barang
        function closeAddItemModal() {
            document.getElementById('addItemModal').classList.add('hidden');
        }
    </script>

</body>

</html>
