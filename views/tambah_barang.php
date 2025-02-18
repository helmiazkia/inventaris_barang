<?php
session_start();
include('../config/koneksi.php');
include('../controllers/barangController.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $kode_barang = $_POST['kode_barang'];
    $barcode = $_POST['barcode'];
    $kategori_id = $_POST['kategori_id'];
    $ruangan_id = $_POST['ruangan_id'];
    $jumlah = $_POST['jumlah'];

    // Validasi: Pastikan input tidak kosong
    if (empty($nama_barang) || empty($kode_barang) || empty($barcode) || empty($kategori_id) || empty($ruangan_id)) {
        echo "Semua kolom harus diisi!";
    } else {
        $barangController = new BarangController();
        $barangController->tambahBarang($nama_barang, $kode_barang, $barcode, $kategori_id, $ruangan_id, $jumlah);
        echo "Barang berhasil ditambahkan!";
    }
}
?>

<form method="POST" action="">
    <label for="nama_barang">Nama Barang:</label><br>
    <input type="text" id="nama_barang" name="nama_barang" required><br><br>
    <label for="kode_barang">Kode Barang:</label><br>
    <input type="text" id="kode_barang" name="kode_barang" required><br><br>
    <label for="barcode">Barcode:</label><br>
    <input type="text" id="barcode" name="barcode" required><br><br>
    <label for="kategori_id">Kategori:</label><br>
    <select name="kategori_id" id="kategori_id">
        <?php
        $stmt = $pdo->query("SELECT * FROM kategori");
        while ($kategori = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $kategori['id'] . "'>" . $kategori['nama_kategori'] . "</option>";
        }
        ?>
    </select><br><br>
    <label for="ruangan_id">Ruangan:</label><br>
    <select name="ruangan_id" id="ruangan_id">
        <?php
        $stmt = $pdo->query("SELECT * FROM ruangan");
        while ($ruangan = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $ruangan['id'] . "'>" . $ruangan['nama_ruangan'] . "</option>";
        }
        ?>
    </select><br><br>
    <label for="jumlah">Jumlah:</label><br>
    <input type="number" id="jumlah" name="jumlah" required><br><br>
    <button type="submit">Tambah Barang</button>
</form>
