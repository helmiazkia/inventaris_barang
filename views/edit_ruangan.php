<?php
include('../config/koneksi.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM ruangan WHERE id = $id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_ruangan = $_POST['nama_ruangan'];
    $stmt = $conn->prepare("UPDATE ruangan SET nama_ruangan = ? WHERE id = ?");
    $stmt->bind_param("si", $nama_ruangan, $id);
    
    if ($stmt->execute()) {
        header("Location: list_ruangan.php");
    } else {
        echo "Gagal mengupdate ruangan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Ruangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Edit Ruangan</h2>
        <form method="POST">
            <label class="block mb-2">Nama Ruangan:</label>
            <input type="text" name="nama_ruangan" value="<?= htmlspecialchars($row['nama_ruangan']) ?>" required class="w-full border p-2 rounded">
            <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Update</button>
            <a href="list_ruangan.php" class="ml-2 text-blue-500">Kembali</a>
        </form>
    </div>
</body>
</html>
