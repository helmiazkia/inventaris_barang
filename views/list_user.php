<?php
include('../config/koneksi.php');

// Ambil semua data user
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!-- Tabel Daftar User -->
<table class="min-w-full table-auto">
    <thead>
        <tr>
            <th class="px-4 py-2">Username</th>
            <th class="px-4 py-2">Role</th>
            <th class="px-4 py-2">Jabatan</th>
            <th class="px-4 py-2">NIP</th>
            <th class="px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($user['username']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($user['role']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($user['jabatan']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($user['nip']); ?></td>
                <td class="border px-4 py-2">
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="text-blue-600 hover:underline">Edit</a> | 
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
