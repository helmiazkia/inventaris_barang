<?php
// Proses form submit untuk menambah barang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $kode_barang = $_POST['kode_barang'];
    $barcode = $_POST['barcode'];
    $kategori_id = $_POST['kategori_id'];
    $tahun_pembuatan = $_POST['tahun_pembuatan'];
    $bahan = $_POST['bahan'];
    $ukuran = $_POST['ukuran'];
    $nomor_seri_pabrik = $_POST['nomor_seri_pabrik'];
    $merk_model = $_POST['merk_model'];
    $jenis_barang = $_POST['jenis_barang'];
    $jumlah = $_POST['jumlah'];
    $harga_beli = $_POST['harga_beli'];
    $kondisi_barang = $_POST['kondisi_barang'];
    $status = $_POST['status'];

    // Mengupload foto
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
<<<<<<< HEAD
    $foto_path = '../images/' . basename($foto);  // Nama file foto dengan path
=======
    $foto_path = 'images/' . basename($foto);  // Nama file foto dengan path
>>>>>>> b253cbb1f8b6208e99f0bdc0bf68493b2f7d8e86

    // Cek jika file foto valid
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Ekstensi file yang diizinkan
    $file_extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar
    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Hanya file gambar (jpg, jpeg, png, gif) yang diperbolehkan!";
        exit;
    }

    // Cek ukuran file (maksimal 2MB)
    $max_size = 2 * 1024 * 1024; // 2MB
    if ($_FILES['foto']['size'] > $max_size) {
        echo "Ukuran file terlalu besar. Maksimal 2MB!";
        exit;
    }

    // Pindahkan foto ke direktori tujuan
    if (move_uploaded_file($foto_tmp, $foto_path)) {
        // Insert data barang ke database
        $sql = "INSERT INTO barang (nama_barang, kode_barang, barcode, kategori_id, tahun_pembuatan, bahan, ukuran, nomor_seri_pabrik, 
                merk_model, jenis_barang, jumlah, harga_beli, kondisi_barang, status, foto) 
                VALUES ('$nama_barang', '$kode_barang', '$barcode', '$kategori_id', '$tahun_pembuatan', '$bahan', '$ukuran', 
                '$nomor_seri_pabrik', '$merk_model', '$jenis_barang', '$jumlah', '$harga_beli', '$kondisi_barang', '$status', '$foto_path')";

        if ($conn->query($sql) === TRUE) {
            echo "Barang berhasil ditambahkan!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Gagal mengupload foto!";
    }
}
?>

<!-- Form tambah barang -->
<form method="POST" enctype="multipart/form-data">
    <div class="mb-4">
        <label for="nama_barang" class="block text-sm font-medium">Nama Barang</label>
        <input type="text" id="nama_barang" name="nama_barang" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="kode_barang" class="block text-sm font-medium">Kode Barang</label>
        <input type="text" id="kode_barang" name="kode_barang" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="barcode" class="block text-sm font-medium">Barcode</label>
        <input type="text" id="barcode" name="barcode" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="kategori_id" class="block text-sm font-medium">Kategori</label>
        <select id="kategori_id" name="kategori_id" required class="w-full px-4 py-2 border rounded-md">
            <?php
            $result = $conn->query("SELECT * FROM kategori");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nama_kategori'] . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-4">
        <label for="tahun_pembuatan" class="block text-sm font-medium">Tahun Pembuatan</label>
        <input type="number" id="tahun_pembuatan" name="tahun_pembuatan" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="bahan" class="block text-sm font-medium">Bahan</label>
        <input type="text" id="bahan" name="bahan" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="ukuran" class="block text-sm font-medium">Ukuran</label>
        <input type="text" id="ukuran" name="ukuran" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="nomor_seri_pabrik" class="block text-sm font-medium">Nomor Seri Pabrik</label>
        <input type="text" id="nomor_seri_pabrik" name="nomor_seri_pabrik" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="merk_model" class="block text-sm font-medium">Merk/Model</label>
        <input type="text" id="merk_model" name="merk_model" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="jenis_barang" class="block text-sm font-medium">Jenis Barang</label>
        <input type="text" id="jenis_barang" name="jenis_barang" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="jumlah" class="block text-sm font-medium">Jumlah Barang</label>
        <input type="number" id="jumlah" name="jumlah" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="harga_beli" class="block text-sm font-medium">Harga Beli</label>
        <input type="number" id="harga_beli" name="harga_beli" required class="w-full px-4 py-2 border rounded-md">
    </div>

    <div class="mb-4">
        <label for="kondisi_barang" class="block text-sm font-medium">Kondisi Barang</label>
        <select id="kondisi_barang" name="kondisi_barang" required class="w-full px-4 py-2 border rounded-md">
            <option value="baik">Baik</option>
            <option value="kurang baik">Kurang Baik</option>
            <option value="rusak">Rusak</option>
            <option value="rusak berat">Rusak Berat</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="status" class="block text-sm font-medium">Status</label>
        <select id="status" name="status" required class="w-full px-4 py-2 border rounded-md">
            <option value="tersedia">Tersedia</option>
            <option value="dipinjam">Dipinjam</option>
            <option value="hilang">Hilang</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="foto" class="block text-sm font-medium">Foto Barang</label>
        <input type="file" id="foto" name="foto" required class="w-full px-4 py-2 border rounded-md">
        <p class="text-sm text-gray-600">Hanya file gambar (jpg, jpeg, png, gif) dengan ukuran maksimal 2MB yang diperbolehkan.</p>
    </div>


    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">Tambah Barang</button>
</form>

<!-- Tampilkan pesan error/sukses -->
<?php if (isset($success_message)): ?>
    <p class="text-green-500"><?php echo $success_message; ?></p>
<?php endif; ?>

<?php if (isset($error_message)): ?>
    <p class="text-red-500"><?php echo $error_message; ?></p>
<?php endif; ?>