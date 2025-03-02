<?php
session_start();
include('../config/koneksi.php');

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil ID user yang ingin diedit
$user_id = $_GET['id'] ?? 0;

if (!$user_id) {
    $_SESSION['error'] = "ID user tidak valid!";
    header("Location: manage_user.php?action=listUser");
    exit();
}

// Ambil data user dari database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "User tidak ditemukan!";
    header("Location: manage_user.php?action=listUser");
    exit();
}

$user = $result->fetch_assoc();

// Proses update user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pegawai = htmlspecialchars(trim($_POST['nama_pegawai']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $role = $_POST['role'];
    $nip = htmlspecialchars(trim($_POST['nip']));
    $jabatan_id = !empty($_POST['jabatan_id']) ? $_POST['jabatan_id'] : null;

    // Validasi wajib isi
    if (empty($nama_pegawai) || empty($username) || empty($role) || empty($nip)) {
        $_SESSION['error'] = "Semua bidang harus diisi!";
    } else {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET nama_pegawai = ?, username = ?, password = ?, role = ?, jabatan_id = ?, nip = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $nama_pegawai, $username, $hashed_password, $role, $jabatan_id, $nip, $user_id);
        } else {
            $sql = "UPDATE users SET nama_pegawai = ?, username = ?, role = ?, jabatan_id = ?, nip = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nama_pegawai, $username, $role, $jabatan_id, $nip, $user_id);
        }

        if ($stmt->execute()) {
            header("Location: manage_user.php?action=listUser");
            exit();
        } else {
            $_SESSION['error'] = "Gagal memperbarui user!";
        }
    }
}

// Ambil daftar jabatan dari database
$jabatanQuery = "SELECT id, nama_jabatan FROM jabatan";
$jabatanResult = $conn->query($jabatanQuery);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <?php include('sidebar.php'); ?>

    <!-- Topbar -->
    <?php include('topbar.php'); ?>

    <!-- Konten Halaman Edit -->
    <div class="lg:ml-64 p-8 pt-20 min-h-screen">

        <h1 class="text-2xl font-semibold mb-6">Form Edit Data Pegawai</h1>

        <!-- Notifikasi -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="bg-green-500 text-white p-3 rounded-md mb-4"><?= $_SESSION['success']; ?></div>
            <script>
                setTimeout(() => {
                    document.querySelector('.bg-green-500').remove();
                }, 3000);
            </script>
            <?php unset($_SESSION['success']); ?>
        <?php elseif (isset($_SESSION['error'])) : ?>
            <div class="bg-red-500 text-white p-3 rounded-md mb-4"><?= $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Form Edit User -->
        <form method="POST" action="">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="mb-4">
                    <label for="nama_pegawai" class="block text-sm font-medium">Nama Pegawai</label>
                    <input type="text" id="nama_pegawai" name="nama_pegawai" value="<?= htmlspecialchars($user['nama_pegawai']); ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-md">
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium">Role</label>
                    <select id="role" name="role" class="w-full px-4 py-2 border rounded-md" required>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="jabatan_id" class="block text-sm font-medium">Jabatan</label>
                    <select id="jabatan_id" name="jabatan_id" class="w-full px-4 py-2 border rounded-md">
                        <option value="">Pilih Jabatan</option>
                        <?php while ($jabatan = $jabatanResult->fetch_assoc()) : ?>
                            <option value="<?= $jabatan['id']; ?>" <?= ($user['jabatan_id'] == $jabatan['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($jabatan['nama_jabatan']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="nip" class="block text-sm font-medium">NIP</label>
                    <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($user['nip']); ?>" class="w-full px-4 py-2 border rounded-md" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">Perbarui User</button>
            </div>
        </form>

    </div>
    <?php include('footer.php'); ?>
</body>

</html>
