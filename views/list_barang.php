<?php
include('../config/koneksi.php');

// Ambil data barang dari database
$sql = "SELECT barang.*, kategori.nama_kategori FROM barang
        JOIN kategori ON barang.kategori_id = kategori.id";
$result = $conn->query($sql);
?>

<div class="bg-white p-6 rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full max-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="px-4 py-2 border">Nama Barang</th>
                    <th class="px-4 py-2 border">Kode Barang</th>
                    <th class="px-4 py-2 border">Kategori</th>
                    <th class="px-4 py-2 border">Jumlah Total</th>
                    <th class="px-4 py-2 border">Kondisi Barang</th>
                    <th class="px-4 py-2 border">Total Harga</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-100 transition cursor-pointer" onclick="window.location='detail_barang.php?id=<?php echo (int)$row['id']; ?>'">
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['kode_barang']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                            <td class="px-4 py-2 border"><?php echo (int)$row['jumlah_total']; ?></td>
                            <td class="px-4 py-2 border">
                                <ul>
                                    <li>Baik: <?php echo (int)$row['jumlah_baik']; ?></li>
                                    <li>Rusak Ringan: <?php echo (int)$row['jumlah_rusak_ringan']; ?></li>
                                    <li>Rusak Berat: <?php echo (int)$row['jumlah_rusak_berat']; ?></li>
                                </ul>
                            </td>
                            <td class="px-4 py-2 border"><?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td class="px-4 py-2 border">
                                <a href="edit_barang.php?id=<?php echo (int)$row['id']; ?>" class="text-blue-600 hover:text-blue-800">Edit</a> |
                                <a href="delete_barang.php?id=<?php echo (int)$row['id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-4 py-2 border text-center">Tidak ada barang yang tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
