<?php
include('../config/koneksi.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
$result = $conn->query("SELECT * FROM ruangan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>List Ruangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Daftar Ruangan</h2>
        <a href="create_ruangan.php" class="px-4 py-2 bg-blue-500 text-white rounded">Tambah Ruangan</a>
        <table class="mt-4 w-full border-collapse border">
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Nama Ruangan</th>
                <th class="border p-2">Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="border p-2"><?= $row['id'] ?></td>
                    <td class="border p-2"><?= htmlspecialchars($row['nama_ruangan']) ?></td>
                    <td class="border p-2">
                        <a href="edit_ruangan.php?id=<?= $row['id'] ?>" class="text-blue-500">Edit</a> | 
                        <a href="delete_ruangan.php?id=<?= $row['id'] ?>" class="text-red-500" onclick="return confirm('Hapus ruangan ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
