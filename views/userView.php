<?php
include('../controllers/userController.php');

// Ambil semua data user dengan informasi jabatan
$sql = "SELECT users.*, jabatan.nama_jabatan 
        FROM users 
        LEFT JOIN jabatan ON users.jabatan_id = jabatan.id";
$result = $conn->query($sql);

// Ambil data jabatan untuk dropdown di form tambah user
$sqlJabatan = "SELECT * FROM jabatan";
$jabatanResult = $conn->query($sqlJabatan);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function showNotification(type, message) {
            alert(message);
        }

        <?php if (isset($_GET['success'])): ?>
            window.onload = function() {
                showNotification('success', '<?php echo $_GET['success']; ?>');
            }
        <?php elseif (isset($_GET['error'])): ?>
            window.onload = function() {
                showNotification('error', '<?php echo $_GET['error']; ?>');
            }
        <?php endif; ?>
    </script>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Topbar -->
    <?php include('topbar.php'); ?>

    <div class="lg:ml-64 p-8 pt-20 min-h-screen">

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="mb-6 text-left">
                <button onclick="openAddUserModal()" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-md hover:bg-blue-700 transition">
                    Tambah Pengguna
                </button>
            </div>

            <h2 class="text-lg font-bold mt-6 mb-2">Daftar Pengguna</h2>

            <!-- Daftar User -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-max table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Nama Pegawai</th>
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
                                <tr class="hover:bg-gray-100 transition">
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['nama_pegawai']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['nama_jabatan'] ?? '-'); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($user['nip']); ?></td>
                                    <td class="px-4 py-2 border">
                                        <button onclick="openEditUserModal(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['nama_pegawai']); ?>', '<?php echo htmlspecialchars($user['username']); ?>', '<?php echo htmlspecialchars($user['role']); ?>', '<?php echo htmlspecialchars($user['jabatan_id']); ?>', '<?php echo htmlspecialchars($user['nip']); ?>')" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                            Edit
                                        </button>
                                        <a href="?delete=<?php echo $user['id']; ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-4 py-2 border text-center">Tidak ada user yang tersedia</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div id="addUserModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-xl font-semibold ">Tambah User</h3>
            <form action="../controllers/userController.php" method="POST">
                <input type="hidden" name="id" id="editUserId">
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-semibold">Nama Pegawai</label>
                    <input type="text" name="nama" id="nama" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="username" class="block text-sm font-semibold">Username</label>
                    <input type="username" name="username" id="username" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-semibold">Role</label>
                    <select name="role" id="role" class="w-full p-2 border rounded">
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="jabatan_id" class="block text-sm font-semibold">Jabatan</label>
                    <select name="jabatan_id" id="jabatan_id" class="w-full p-2 border rounded">
                        <?php while ($jabatan = $jabatanResult->fetch_assoc()): ?>
                            <option value="<?php echo $jabatan['id']; ?>"><?php echo $jabatan['nama_jabatan']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="nip" class="block text-sm font-medium">NIP</label>
                    <input type="text" id="nip" name="nip" required class="w-full px-4 py-2 border rounded-md">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Simpan</button>
            </form>
            <button onclick="closeAddUserModal()" class="w-full mt-4 bg-gray-500 text-white p-2 rounded">Tutup</button>
        </div>
    </div>

    <script>
        // Modal control
        function openAddUserModal() {
            document.getElementById('addUserModal').classList.remove('hidden');
        }

        function closeAddUserModal() {
            document.getElementById('addUserModal').classList.add('hidden');
        }

        // Edit User Modal
        function openEditUserModal(id, nama, username, role, jabatan_id, nip) {
            document.getElementById('editUserId').value = id;
            document.getElementById('nama').value = nama;
            document.getElementById('username').value = username;
            document.getElementById('password').value = password; // leave password blank for editing
            document.getElementById('role').value = role;
            document.getElementById('jabatan_id').value = jabatan_id;
            document.getElementById('nip').value = nip;
            document.getElementById('addUserModal').classList.remove('hidden');
        }
    </script>
    <?php include('footer.php') ?>
</body>

</html>