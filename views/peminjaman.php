<?php
session_start();
include('../config/koneksi.php');
include('../controllers/peminjamanController.php');

$peminjamanController = new PeminjamanController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barang_id = $_POST['barang_id'];
    $user_id = $_SESSION['user_id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $catatan = $_POST['catatan'];

    $peminjamanController->pinjamBarang($barang_id, $user_id, $tanggal_pinjam, $tanggal_kembali, $catatan);
    echo "Barang berhasil dipinjam!";
}
?>

<form method="POST" action="">
    <label for="barang_id">Pilih Barang:</label><br>
    <select name="barang_id" id="barang_id">
        <?php
        $stmt = $pdo->query("SELECT * FROM barang WHERE status = 'tersedia'");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['id'] . "'>" . $row['nama_barang'] . "</option>";
        }
        ?>
    </select><br><br>
    <label for="tanggal_pinjam">Tanggal Pinjam:</label><br>
    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" required><br><br>
    <label for="tanggal_kembali">Tanggal Kembali:</label><br>
    <input type="date" id="tanggal_kembali" name="tanggal_kembali" required><br><br>
    <label for="catatan">Catatan:</label><br>
    <textarea name="catatan" id="catatan"></textarea><br><br>
    <button type="submit">Pinjam Barang</button>
</form>
