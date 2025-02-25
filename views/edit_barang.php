<?php
// Cek jika user sudah login dan memiliki role admin
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Include koneksi database
include('../config/koneksi.php');

// Ambil id barang dari URL
$id_barang = $_GET['id'];

// Query untuk mendapatkan data barang berdasarkan ID (menggunakan prepared statement)
$sql = "SELECT * FROM barang WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_barang); // 'i' untuk integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $barang = $result->fetch_assoc();
} else {
    echo "Barang tidak ditemukan!";
    exit;
}

// Proses update data barang jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan sanitasi
    $nama_barang = htmlspecialchars($_POST['nama_barang']);
    $kode_barang = htmlspecialchars($_POST['kode_barang']);
    $barcode = htmlspecialchars($_POST['barcode']);
    $kategori_id = htmlspecialchars($_POST['kategori_id']);
    $tahun_pembuatan = htmlspecialchars($_POST['tahun_pembuatan']);
    $bahan = htmlspecialchars($_POST['bahan']);
    $ukuran = htmlspecialchars($_POST['ukuran']);
    $nomor_seri_pabrik = htmlspecialchars($_POST['nomor_seri_pabrik']);
    $merk_model = htmlspecialchars($_POST['merk_model']);
    $jenis_barang = htmlspecialchars($_POST['jenis_barang']);
    $jumlah = htmlspecialchars($_POST['jumlah']);
    $harga_beli = htmlspecialchars($_POST['harga_beli']);
    $kondisi_barang = htmlspecialchars($_POST['kondisi_barang']);
    $status = htmlspecialchars($_POST['status']);

    // Mengupload foto baru jika ada
    $foto = $_FILES['foto']['name'];
    if ($foto) {
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = '../images/' . basename($foto);

        // Cek jika file foto valid
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Hanya file gambar (jpg, jpeg, png, gif) yang diperbolehkan!";
            exit;
        }

        // Cek ukuran file
        $max_size = 2 * 1024 * 1024; // 2MB
        if ($_FILES['foto']['size'] > $max_size) {
            echo "Ukuran file terlalu besar. Maksimal 2MB!";
            exit;
        }

        // Pindahkan foto ke direktori tujuan
        move_uploaded_file($foto_tmp, $foto_path);
    } else {
        $foto_path = $barang['foto'];  // Jika tidak ada foto baru, tetap gunakan foto lama
    }

    // Query untuk update data barang (menggunakan prepared statement)
    $stmt_update = $conn->prepare("UPDATE barang SET 
        nama_barang = ?, kode_barang = ?, barcode = ?, kategori_id = ?, tahun_pembuatan = ?, bahan = ?, ukuran = ?, nomor_seri_pabrik = ?, 
        merk_model = ?, jenis_barang = ?, jumlah = ?, harga_beli = ?, kondisi_barang = ?, status = ?, foto = ? WHERE id_barang = ?");
    $stmt_update->bind_param("ssssiissssiiissi", $nama_barang, $kode_barang, $barcode, $kategori_id, $tahun_pembuatan, $bahan, $ukuran, $nomor_seri_pabrik,
        $merk_model, $jenis_barang, $jumlah, $harga_beli, $kondisi_barang, $status, $foto_path, $id_barang);

    if ($stmt_update->execute()) {
        echo "Barang berhasil diperbarui!";
    } else {
        echo "Error: " . $stmt_update->error;
    }
}
?>
<<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Panggil Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Konten Halaman Edit Barang -->
    <div class="ml-64 p-8 pt-16 mt-3">

        <h1 class="text-2xl font-semibold mb-6">Edit Barang</h1>

        <!-- Form Edit Barang -->
        <form method="POST" action="">

            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <!-- Nama Barang Field -->
                <div class="mb-4">
                    <label for="nama_barang" class="block text-sm font-medium">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" value="<?php echo $barang['nama_barang']; ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <!-- Deskripsi Barang Field -->
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="w-full px-4 py-2 border rounded-md" required><?php echo $barang['deskripsi']; ?></textarea>
                </div>

                <!-- Harga Barang Field -->
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium">Harga</label>
                    <input type="number" id="harga" name="harga" value="<?php echo $barang['harga']; ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <!-- Stok Barang Field -->
                <div class="mb-4">
                    <label for="stok" class="block text-sm font-medium">Stok</label>
                    <input type="number" id="stok" name="stok" value="<?php echo $barang['stok']; ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <!-- Kategori Barang Field -->
                <div class="mb-4">
                    <label for="kategori" class="block text-sm font-medium">Kategori</label>
                    <select id="kategori" name="kategori" class="w-full px-4 py-2 border rounded-md" required>
                        <option value="elektronik" <?php echo $barang['kategori'] == 'elektronik' ? 'selected' : ''; ?>>Elektronik</option>
                        <option value="furniture" <?php echo $barang['kategori'] == 'furniture' ? 'selected' : ''; ?>>Furniture</option>
                        <option value="pakaian" <?php echo $barang['kategori'] == 'pakaian' ? 'selected' : ''; ?>>Pakaian</option>
                        <option value="aksesori" <?php echo $barang['kategori'] == 'aksesori' ? 'selected' : ''; ?>>Aksesori</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">Perbarui Barang</button>
            </div>
        </form>

    </div>

</body>
</html>