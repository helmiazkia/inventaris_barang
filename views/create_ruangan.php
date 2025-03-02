<?php
include('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_ruangan = $_POST['nama_ruangan'];
    $stmt = $conn->prepare("INSERT INTO ruangan (nama_ruangan) VALUES (?)");
    $stmt->bind_param("s", $nama_ruangan);
    
    if ($stmt->execute()) {
        header("Location: list_ruangan.php");
    } else {
        echo "Gagal menambahkan ruangan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Ruangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Tambah Ruangan</h2>
        <form method="POST">
            <label class="block mb-2">Nama Ruangan:</label>
            <input type="text" name="nama_ruangan" required class="w-full border p-2 rounded">
            <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
            <a href="list_ruangan.php" class="ml-2 text-blue-500">Kembali</a>
        </form>
    </div>
</body>
</html>
