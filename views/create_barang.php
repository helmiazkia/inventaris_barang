<?php
include('../config/koneksi.php');

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Proses tambah barang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
    $kategori_id = intval($_POST['kategori_id']);
    $jumlah_total = intval($_POST['jumlah_total']); // Pastikan input jumlah dalam bentuk angka



    $kategori_check = $conn->query("SELECT id FROM kategori WHERE id = $kategori_id");
    if ($kategori_check->num_rows == 0) {
        $error_message = "Kategori tidak valid!";
    } else {
        // Masukkan data ke database dengan nilai default untuk jumlah
        // Validasi kategori apakah ada di database
        $total_harga = 0;  // Set the default value for total_harga (or calculate it if needed)
        $sql = "INSERT INTO barang (nama_barang, kode_barang, kategori_id, jumlah_total, jumlah_baik, jumlah_rusak_ringan, jumlah_rusak_berat, total_harga)  
        VALUES ('$nama_barang', '$kode_barang', '$kategori_id', '$jumlah_total', 0, 0, 0, '$total_harga')";
        if ($conn->query($sql) === TRUE) {
            $success_message = "Barang berhasil ditambahkan!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>

<!-- Form Tambah Barang -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Tambah Barang</h2>

    <form method="POST">
        <div class="mb-4">
            <label for="nama_barang" class="block text-sm font-medium">Nama Barang</label>
            <input type="text" id="nama_barang" name="nama_barang" required class="w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="kode_barang" class="block text-sm font-medium">Kode Barang</label>
            <input type="text" id="kode_barang" name="kode_barang" required class="w-full px-4 py-2 border rounded-md">
        </div>

        <div class="mb-4">
            <label for="kategori_id" class="block text-sm font-medium">Kategori</label>
            <select id="kategori_id" name="kategori_id" required class="w-full px-4 py-2 border rounded-md">
                <option value="">Pilih Kategori</option>
                <?php
                $result = $conn->query("SELECT * FROM kategori");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nama_kategori']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="jumlah_total" class="block text-sm font-medium">Jumlah Barang</label>
            <input type="number" id="jumlah_total" name="jumlah_total" value="0" min="0" required class="w-full px-4 py-2 border rounded-md">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">Tambah Barang</button>
    </form>

    <!-- Pesan Sukses atau Error -->
    <?php if (isset($success_message)): ?>
        <p class="text-green-500 mt-2"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <p class="text-red-500 mt-2"><?php echo $error_message; ?></p>
    <?php endif; ?>
</div>