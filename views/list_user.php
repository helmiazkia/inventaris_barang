<?php
// Check if the user is logged in and has 'admin' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit; // Stop further script execution
}

include('../config/koneksi.php');

// Ambil semua data user
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-xl font-semibold mb-4">Daftar User</h3>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2 border">Username</th>
                <th class="px-4 py-2 border">Role</th>
                <th class="px-4 py-2 border">Jabatan</th>
                <th class="px-4 py-2 border">NIP</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['username']); ?></td>
                        <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['role']); ?></td>
                        <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['jabatan']); ?></td>
                        <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['nip']); ?></td>
                        <td class="px-4 py-2 border">
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="text-blue-600 hover:text-blue-800">Edit</a> | 
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="px-4 py-2 border text-center">Tidak ada user yang tersedia</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
