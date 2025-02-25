<?php
<<<<<<< HEAD
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
=======
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
    $barcode = $_POST['barcode'] ?? '';
    $kategori_id = $_POST['kategori_id'] ?? '';
    $tahun_pembuatan = $_POST['tahun_pembuatan'] ?? '';
    $bahan = $_POST['bahan'] ?? '';
    $ukuran = $_POST['ukuran'] ?? '';
    $nomor_seri_pabrik = $_POST['nomor_seri_pabrik'] ?? '';
    $merk_model = $_POST['merk_model'] ?? '';
    $jenis_barang = $_POST['jenis_barang'] ?? '';
    $jumlah = $_POST['jumlah'] ?? '0';
    $harga_beli = $_POST['harga_beli'] ?? '0';
    $status = $_POST['status'] ?? 'Tersedia';

    // Validasi kondisi_barang agar sesuai ENUM di database
    $kondisi_barang = $_POST['kondisi_barang'] ?? 'Baik';
    $kondisi_valid = ['Baik', 'Rusak', 'Perlu Perbaikan'];
    if (!in_array($kondisi_barang, $kondisi_valid)) {
        $kondisi_barang = 'Baik';
    }

    // Menangani upload file foto jika ada
    if (!empty($_FILES['foto']['name'])) {
        $foto = basename($_FILES['foto']['name']);
        $target_dir = "../images/";
        $target_file = $target_dir . $foto;

        // Pindahkan file yang diupload ke folder images
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            // Hapus gambar lama jika ada
            if (!empty($data['foto']) && file_exists($target_dir . $data['foto'])) {
                unlink($target_dir . $data['foto']);
            }
        } else {
            echo "<script>alert('Gagal mengupload foto!');</script>";
        }
    } else {
        $foto = $data['foto']; // Gunakan foto lama jika tidak diubah
    }

    // Gunakan prepared statement untuk update data
    $query = "UPDATE barang SET 
                nama_barang=?, kode_barang=?, barcode=?, kategori_id=?, tahun_pembuatan=?, 
                bahan=?, ukuran=?, nomor_seri_pabrik=?, merk_model=?, jenis_barang=?, 
                jumlah=?, harga_beli=?, kondisi_barang=?, foto=?, status=? 
              WHERE id=?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssssddsssi", 
        $nama_barang, $kode_barang, $barcode, $kategori_id, $tahun_pembuatan, 
        $bahan, $ukuran, $nomor_seri_pabrik, $merk_model, $jenis_barang, 
        $jumlah, $harga_beli, $kondisi_barang, $foto, $status, $id
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='manage_barang.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
>>>>>>> c8255e8881d21df6f3e3f4aef10bc38f96fb2bea
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<<<<<<< HEAD

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
=======
    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mx-auto p-6 max-w-2xl bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Edit Data Barang</h2>

        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-gray-700">Nama Barang:</label>
                <input type="text" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']) ?>" class="border rounded w-full p-2" required>
            </div>

            <div>
                <label class="block text-gray-700">Kode Barang:</label>
                <input type="text" name="kode_barang" value="<?= htmlspecialchars($data['kode_barang']) ?>" class="border rounded w-full p-2" required>
            </div>

            <div>
                <label class="block text-gray-700">Barcode:</label>
                <input type="text" name="barcode" value="<?= htmlspecialchars($data['barcode']) ?>" class="border rounded w-full p-2">
            </div>

            <div>
                <label class="block text-gray-700">Kategori ID:</label>
                <input type="text" name="kategori_id" value="<?= htmlspecialchars($data['kategori_id']) ?>" class="border rounded w-full p-2">
            </div>

            <div>
                <label class="block text-gray-700">Tahun Pembuatan:</label>
                <input type="text" name="tahun_pembuatan" value="<?= htmlspecialchars($data['tahun_pembuatan']) ?>" class="border rounded w-full p-2">
            </div>
            <div>
    <label class="block text-gray-700">Bahan:</label>
    <input type="text" name="bahan" value="<?= htmlspecialchars($data['bahan']) ?>" class="border rounded w-full p-2">
</div>

<div>
    <label class="block text-gray-700">Ukuran:</label>
    <input type="text" name="ukuran" value="<?= htmlspecialchars($data['ukuran']) ?>" class="border rounded w-full p-2">
</div>

<div>
    <label class="block text-gray-700">Nomor Seri Pabrik:</label>
    <input type="text" name="nomor_seri_pabrik" value="<?= htmlspecialchars($data['nomor_seri_pabrik']) ?>" class="border rounded w-full p-2">
</div>

<div>
    <label class="block text-gray-700">Merk Model:</label>
    <input type="text" name="merk_model" value="<?= htmlspecialchars($data['merk_model']) ?>" class="border rounded w-full p-2">
</div>

<div>
    <label class="block text-gray-700">Jenis Barang:</label>
    <input type="text" name="jenis_barang" value="<?= htmlspecialchars($data['jenis_barang']) ?>" class="border rounded w-full p-2">
</div>

<div>
    <label class="block text-gray-700">Jumlah:</label>
    <input type="number" name="jumlah" value="<?= htmlspecialchars($data['jumlah']) ?>" class="border rounded w-full p-2" required>
</div>

<div>
    <label class="block text-gray-700">Harga Beli:</label>
    <input type="number" step="0.01" name="harga_beli" value="<?= htmlspecialchars($data['harga_beli']) ?>" class="border rounded w-full p-2" required>
</div>


            <div>
                <label class="block text-gray-700">Kondisi Barang:</label>
                <select name="kondisi_barang" class="border rounded w-full p-2">
                    <option value="Baik" <?= $data['kondisi_barang'] == 'Baik' ? 'selected' : '' ?>>Baik</option>
                    <option value="Rusak" <?= $data['kondisi_barang'] == 'Rusak' ? 'selected' : '' ?>>Rusak</option>
                    <option value="Perlu Perbaikan" <?= $data['kondisi_barang'] == 'Perlu Perbaikan' ? 'selected' : '' ?>>Perlu Perbaikan</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700">Foto Barang:</label>
                
                <!-- Pratinjau gambar jika tersedia -->
                <?php if (!empty($data['foto'])): ?>
                    <img src="../images/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Barang" class="w-32 h-32 object-cover rounded">
                <?php else: ?>
                    <p class="text-gray-500">Tidak ada gambar</p>
                <?php endif; ?>

                <input type="file" name="foto" class="border rounded w-full p-2 mt-2">
            </div>

            <div>
                <label class="block text-gray-700">Status:</label>
                <select name="status" class="border rounded w-full p-2">
                    <option value="Tersedia" <?= $data['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="Dipinjam" <?= $data['status'] == 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                    <option value="Hilang" <?= $data['status'] == 'Hilang' ? 'selected' : '' ?>>Hilang</option>
                </select>
            </div>

            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Update</button>
            <a href="manage_barang.php" class="block text-center bg-gray-400 text-white px-4 py-2 rounded w-full">Batal</a>
        </form>
    </div>
</body>
</html>
>>>>>>> c8255e8881d21df6f3e3f4aef10bc38f96fb2bea
