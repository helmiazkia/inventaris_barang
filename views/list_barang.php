<?php
include('../config/koneksi.php');

// Ambil data barang dari database
$sql = "SELECT barang.*, kategori.nama_kategori FROM barang
        JOIN kategori ON barang.kategori_id = kategori.id";
$result = $conn->query($sql);
?>

<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-xl font-semibold mb-4">Daftar Barang</h3>
    
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2 border">Nama Barang</th>
                <th class="px-4 py-2 border">Kode Barang</th>
                <th class="px-4 py-2 border">Kategori</th>
                <th class="px-4 py-2 border">Jumlah</th>
                <th class="px-4 py-2 border">Harga Beli</th>
                <th class="px-4 py-2 border">Kondisi</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Foto</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="px-4 py-2 border"><?php echo $row['nama_barang']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $row['kode_barang']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $row['nama_kategori']; ?></td>
                        <td class="px-4 py-2 border"><?php echo $row['jumlah']; ?></td>
                        <td class="px-4 py-2 border"><?php echo number_format($row['harga_beli'], 0, ',', '.'); ?></td>
                        <td class="px-4 py-2 border"><?php echo ucfirst($row['kondisi_barang']); ?></td>
                        <td class="px-4 py-2 border"><?php echo ucfirst($row['status']); ?></td>
                        <td class="px-4 py-2 border">
                            <img src="<?php echo $row['foto']; ?>" alt="Foto Barang" class="w-20 h-20 object-cover rounded-md">
                        </td>
                        <td class="px-4 py-2 border">
                            <a href="edit_barang.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-800">Edit</a> | 
                            <a href="hapus_barang.php?id=<?php echo $row['id']; ?>" class="text-red-600 hover:text-red-800">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="px-4 py-2 border text-center">Tidak ada barang yang tersedia</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
