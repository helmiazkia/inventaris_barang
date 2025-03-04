<?php
include('../controllers/detailBarangController.php');  // Masukkan controller untuk menghandle logic

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Detail Barang</title>
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

            <!-- Form Tambah Detail Barang -->
            <!-- Tombol Tambah Detail Barang -->
            <div class="mb-6 text-left">
                <button onclick="openAddItemModal()" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-md hover:bg-blue-700 transition">
                    Tambah Detail Barang
                </button>
            </div>

            <!-- Daftar Detail Barang -->
            <h2 class="text-lg font-bold mt-6 mb-2">Daftar Detail Barang</h2>
            
            <!-- Kontainer untuk tabel yang bisa digulir -->
            <div class="table-container">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Barang</th>
                            <th class="border border-gray-300 px-4 py-2">Kode Barang</th>
                            <th class="border border-gray-300 px-4 py-2">Ruangan Asal</th>
                            <th class="border border-gray-300 px-4 py-2">Ruangan Sekarang</th>
                            <th class="border border-gray-300 px-4 py-2">Tanggal Pindah</th>
                            <th class="border border-gray-300 px-4 py-2">Keterangan</th>
                            <th class="border border-gray-300 px-4 py-2">Dipindah Oleh</th>
                            <th class="border border-gray-300 px-4 py-2">Harga Beli</th>
                            <th class="border border-gray-300 px-4 py-2">Kondisi</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['id']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['nama_barang']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['kode_barang']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['ruangan_asal']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['ruangan_sekarang']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['tanggal_pindah']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['keterangan']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['dipindah_oleh']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['harga_beli']; ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo $row['kondisi']; ?></td>
                                <td class="border border-gray-300 px-4 py-2 flex gap-2">
                                    <button onclick="editItem(<?php echo $row['id']; ?>, '<?php echo $row['nama_barang']; ?>', '<?php echo $row['kode_barang']; ?>', <?php echo $row['ruangan_asal_id']; ?>, <?php echo $row['ruangan_sekarang_id']; ?>, '<?php echo $row['tanggal_pindah']; ?>', '<?php echo $row['keterangan']; ?>', '<?php echo $row['dipindah_oleh']; ?>', <?php echo $row['harga_beli']; ?>, '<?php echo $row['kondisi']; ?>')"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </button>
                                    <a href="?action=deleteDetailBarang&id=<?php echo $row['id']; ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus detail barang ini?');"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Tambah Detail Barang -->
            <div id="addItemModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h3 class="text-lg font-bold mb-4">Tambah Detail Barang</h3>
                    <form method="POST" action="?action=addDetailBarang">
                        <div class="mb-4">
                            <label for="kode_barang" class="block text-sm font-medium">Kode Barang</label>
                            <input type="text" id="kode_barang" name="kode_barang" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="ruangan_asal_id" class="block text-sm font-medium">Ruangan Asal</label>
                            <select id="ruangan_asal_id" name="ruangan_asal_id" required class="w-full px-4 py-2 border rounded-md">
                                <?php
                                $ruangan_result = $conn->query("SELECT id, nama_ruangan FROM ruangan");
                                while ($ruangan = $ruangan_result->fetch_assoc()) {
                                    echo "<option value='{$ruangan['id']}'>{$ruangan['nama_ruangan']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="ruangan_sekarang_id" class="block text-sm font-medium">Ruangan Sekarang</label>
                            <select id="ruangan_sekarang_id" name="ruangan_sekarang_id" required class="w-full px-4 py-2 border rounded-md">
                                <?php
                                $ruangan_result = $conn->query("SELECT id, nama_ruangan FROM ruangan");
                                while ($ruangan = $ruangan_result->fetch_assoc()) {
                                    echo "<option value='{$ruangan['id']}'>{$ruangan['nama_ruangan']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_pindah" class="block text-sm font-medium">Tanggal Pindah</label>
                            <input type="date" id="tanggal_pindah" name="tanggal_pindah" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" required class="w-full px-4 py-2 border rounded-md"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="dipindah_oleh" class="block text-sm font-medium">Dipindah Oleh</label>
                            <input type="text" id="dipindah_oleh" name="dipindah_oleh" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="harga_beli" class="block text-sm font-medium">Harga Beli</label>
                            <input type="number" id="harga_beli" name="harga_beli" required class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="kondisi" class="block text-sm font-medium">Kondisi</label>
                            <select id="kondisi" name="kondisi" required class="w-full px-4 py-2 border rounded-md">
                                <option value="baik">Baik</option>
                                <option value="rusak ringan">Rusak Ringan</option>
                                <option value="rusak berat">Rusak Berat</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">
                            Tambah Detail Barang
                        </button>
                        <button type="button" onclick="closeAddItemModal()" class="w-full mt-2 bg-gray-500 text-white font-bold py-2 rounded-md hover:bg-gray-600 transition">
                            Batal
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <script>
        // Fungsi untuk membuka modal edit barang
        function editItem(id, nama_barang, kode_barang, ruangan_asal_id, ruangan_sekarang_id, tanggal_pindah, keterangan, dipindah_oleh, harga_beli, kondisi) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_barang').value = nama_barang;
            document.getElementById('edit_kode_barang').value = kode_barang;
            document.getElementById('edit_ruangan_asal_id').value = ruangan_asal_id;
            document.getElementById('edit_ruangan_sekarang_id').value = ruangan_sekarang_id;
            document.getElementById('edit_tanggal_pindah').value = tanggal_pindah;
            document.getElementById('edit_keterangan').value = keterangan;
            document.getElementById('edit_dipindah_oleh').value = dipindah_oleh;
            document.getElementById('edit_harga_beli').value = harga_beli;
            document.getElementById('edit_kondisi').value = kondisi;
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
