<?php
include '../config/koneksi.php'; // Pastikan koneksi ke database benar

// Pastikan ID barang dikirim melalui GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID barang tidak ditemukan!");
}

$id = $_GET['id'];
$query = "SELECT * FROM barang WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data barang tidak ditemukan!");
}

// Jika tombol update ditekan
if (isset($_POST['update'])) {
    $nama_barang = $_POST['nama_barang'] ?? '';
    $kode_barang = $_POST['kode_barang'] ?? '';
    $kategori_id = $_POST['kategori_id'] ?? '';
    $jumlah_barang = $_POST['jumlah_barang'] ?? 0;

    // Gunakan prepared statement untuk update data
    $query = "UPDATE barang SET nama_barang=?, kode_barang=?, kategori_id=?, jumlah_barang=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $nama_barang, $kode_barang, $kategori_id, $jumlah_barang, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='manage_barang.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Topbar -->
    <?php include('topbar.php'); ?>

    <!-- Konten Halaman Edit -->
    <div class="lg:ml-64 p-8 pt-20 min-h-screen">

        <h1 class="text-2xl font-semibold mb-6">Form Edit Data Barang</h1>

        <!-- Notifikasi -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="bg-green-500 text-white p-3 rounded-md mb-4"><?= $_SESSION['success']; ?></div>
            <script>
                setTimeout(() => {
                    document.querySelector('.bg-green-500').remove();
                }, 3000);
            </script>
            <?php unset($_SESSION['success']); ?>
        <?php elseif (isset($_SESSION['error'])) : ?>
            <div class="bg-red-500 text-white p-3 rounded-md mb-4"><?= $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Form Edit Barang -->
        <form method="POST" action="">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="mb-4">
                    <label for="nama_barang" class="block text-sm font-medium">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']); ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="kode_barang" class="block text-sm font-medium">Kode Barang</label>
                    <input type="text" id="kode_barang" name="kode_barang" value="<?= htmlspecialchars($data['kode_barang']); ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="kategori_id" class="block text-sm font-medium">Kategori ID</label>
                    <input type="text" id="kategori_id" name="kategori_id" value="<?= htmlspecialchars($data['kategori_id']); ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="jumlah_barang" class="block text-sm font-medium">Jumlah Barang</label>
                    <input type="number" id="jumlah_barang" name="jumlah_barang" value="<?= htmlspecialchars($data['jumlah_barang'] ?? 0); ?>" class="w-full px-4 py-2 border rounded-md" required min="0">
                </div>

                <button type="submit" name="update" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">Update</button>
                <a href="manage_barang.php" class="block text-center bg-gray-400 text-white px-4 py-2 rounded-md w-full mt-4">Batal</a>
            </div>
        </form>

    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

</body>

</html>
