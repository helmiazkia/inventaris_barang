<?php
include('../config/koneksi.php');

if (isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'];

    // Ambil data barang berdasarkan barcode / Barcode code
    $query = "SELECT barang.*, kategori.nama_kategori 
              FROM barang
              JOIN kategori ON barang.kategori_id = kategori.id
              WHERE barcode = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $barang = $result->fetch_assoc();
    } else {
        echo "<script>alert('Barang tidak ditemukan!'); window.location.href = 'input_kode.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Silakan input_kode atau input_kode kode.'); window.location.href = 'input_kode.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen relative">
    <!-- Background Image -->
    <img src="../public/background.png" class="absolute w-full h-full object-cover" alt="Background">

    <!-- Kontainer Utama -->
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-3xl flex items-center gap-6">

            <!-- Gambar Barang -->
            <div class="w-1/3 flex justify-center">
                <?php if ($barang['foto']) { ?>
                    <img src="../images/<?= htmlspecialchars($barang['foto']); ?>"
                        class="w-full max-w-[200px] h-auto object-contain rounded-lg shadow-md">
                <?php } else { ?>
                    <div class="w-full max-w-[200px] h-48 flex items-center justify-center bg-gray-200 text-gray-500 rounded-lg shadow-md">
                        Tidak ada foto
                    </div>
                <?php } ?>
            </div>

            <!-- Data Barang -->
            <div class="w-2/3">
                <h2 class="text-blue-600 font-bold text-2xl mb-4">Detail Barang</h2>
                <table class="w-full text-sm text-gray-700">
                    <tbody class="divide-y divide-gray-300">
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Nama Barang</td>
                            <td class="py-2"><?= htmlspecialchars($barang['nama_barang']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Kode Barang</td>
                            <td class="py-2"><?= htmlspecialchars($barang['kode_barang']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Kategori</td>
                            <td class="py-2"><?= htmlspecialchars($barang['nama_kategori']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Merk / Model</td>
                            <td class="py-2"><?= htmlspecialchars($barang['merk_model']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Kondisi</td>
                            <td class="py-2"><?= htmlspecialchars($barang['kondisi_barang']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Harga Beli</td>
                            <td class="py-2">Rp <?= number_format($barang['harga_beli'], 2, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold text-gray-600">Status</td>
                            <td class="py-2"><?= htmlspecialchars($barang['status']); ?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Tombol Kembali -->
                <a href="input_kode.php"
                    class="mt-4 inline-block bg-yellow-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-yellow-600 transition duration-200 shadow-md">
                    Kembali ke input Kode
                </a>
            </div>
        </div>
    </div>
</body>

</html>