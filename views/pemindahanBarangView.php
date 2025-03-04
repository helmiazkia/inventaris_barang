<?php
include('../controllers/pemindahanBarangController.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemindahan Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Topbar -->
    <?php include('topbar.php'); ?>

    <div class="lg:ml-64 p-8 pt-20 min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4"><?php echo isset($dataPemindahan) ? 'Edit' : 'Tambah'; ?> Pemindahan Barang</h2>

            <!-- Form Pemindahan Barang -->
            <form action="../controllers/pemindahanBarangController.php" method="POST">
                <?php if (isset($dataPemindahan)): ?>
                    <input type="hidden" name="id" value="<?php echo $dataPemindahan['id']; ?>">
                <?php endif; ?>

                <div class="mb-4">
                    <label for="kode_unik" class="block text-sm font-semibold">Kode Unik Barang</label>
                    <select name="kode_unik" id="kode_unik" class="w-full p-2 border rounded">
                        <?php if (isset($dataPemindahan)): ?>
                            <option value="<?php echo $dataPemindahan['kode_unik']; ?>" selected><?php echo $dataPemindahan['kode_unik']; ?></option>
                        <?php endif; ?>
                        <?php while ($barang = $barangResult->fetch_assoc()): ?>
                            <option value="<?php echo $barang['kode_unik']; ?>"><?php echo $barang['kode_unik']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="ruangan_asal_id" class="block text-sm font-semibold">Ruangan Asal</label>
                    <select name="ruangan_asal_id" id="ruangan_asal_id" class="w-full p-2 border rounded">
                        <?php if (isset($dataPemindahan)): ?>
                            <option value="<?php echo $dataPemindahan['ruangan_asal_id']; ?>" selected>
                                <?php echo $dataPemindahan['ruangan_asal_name']; ?>
                            </option>
                        <?php endif; ?>
                        <?php while ($ruangan = $ruanganResult->fetch_assoc()): ?>
                            <option value="<?php echo $ruangan['id']; ?>"><?php echo $ruangan['nama_ruangan']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="ruangan_tujuan_id" class="block text-sm font-semibold">Ruangan Tujuan</label>
                    <select name="ruangan_tujuan_id" id="ruangan_tujuan_id" class="w-full p-2 border rounded">
                        <?php if (isset($dataPemindahan)): ?>
                            <option value="<?php echo $dataPemindahan['ruangan_tujuan_id']; ?>" selected>
                                <?php echo $dataPemindahan['ruangan_tujuan_name']; ?>
                            </option>
                        <?php endif; ?>
                        <?php while ($ruangan = $ruanganResult->fetch_assoc()): ?>
                            <option value="<?php echo $ruangan['id']; ?>"><?php echo $ruangan['nama_ruangan']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="tanggal_pindah" class="block text-sm font-semibold">Tanggal Pindah</label>
                    <input type="date" name="tanggal_pindah" id="tanggal_pindah" value="<?php echo isset($dataPemindahan) ? $dataPemindahan['tanggal_pindah'] : date('Y-m-d'); ?>" class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label for="keterangan_pindah" class="block text-sm font-semibold">Keterangan Pindah</label>
                    <textarea name="keterangan_pindah" id="keterangan_pindah" class="w-full p-2 border rounded"><?php echo isset($dataPemindahan) ? $dataPemindahan['keterangan_pindah'] : ''; ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="dipindah_oleh" class="block text-sm font-semibold">Dipindah Oleh</label>
                    <input type="text" name="dipindah_oleh" id="dipindah_oleh"
                        value="<?php echo isset($dataPemindahan) ? $dataPemindahan['dipindah_oleh'] : (isset($_SESSION['nama_pegawai']) ? $_SESSION['nama_pegawai'] : ''); ?>"
                        class="w-full p-2 border rounded" readonly>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded"><?php echo isset($dataPemindahan) ? 'Update' : 'Simpan'; ?></button>
            </form>
        </div>

        <!-- Tabel Pemindahan Barang -->
        <div class="bg-white p-6 rounded-lg shadow mt-6">
            <h2 class="text-lg font-bold mb-4">Daftar Pemindahan Barang</h2>

            <table class="w-full min-w-max table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2 border">Kode Unik</th>
                        <th class="px-4 py-2 border">Ruangan Asal</th>
                        <th class="px-4 py-2 border">Ruangan Tujuan</th>
                        <th class="px-4 py-2 border">Tanggal Pindah</th>
                        <th class="px-4 py-2 border">Keterangan Pindah</th>
                        <th class="px-4 py-2 border">Dipindah Oleh</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultPemindahan->num_rows > 0): ?>
                        <?php while ($row = $resultPemindahan->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-100 transition">
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['kode_unik']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['ruangan_asal_name']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['ruangan_tujuan_name']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['tanggal_pindah']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['keterangan_pindah']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['dipindah_oleh']); ?></td>
                                <td class="px-4 py-2 border">
                                    <a href="?id=<?php echo $row['id']; ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-4 py-2 border text-center">Tidak ada data pemindahan barang</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>