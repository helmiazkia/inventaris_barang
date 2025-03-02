<?php

include('../config/koneksi.php');

// Periksa apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $jabatan_id = $_POST['jabatan']; // Jabatan sekarang menggunakan ID
    $nip = $_POST['nip'];
    $nama_pegawai = htmlspecialchars($_POST['nama_pegawai']);

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menyimpan user baru
    $sql = "INSERT INTO users (username, password, role, jabatan_id, nip, nama_pegawai) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $hashed_password, $role, $jabatan_id, $nip, $nama_pegawai);

    if ($stmt->execute()) {
        $success_message = "User berhasil ditambahkan!";
    } else {
        $error_message = "Gagal menambahkan user!";
    }
}

// Ambil daftar jabatan dari database
$jabatan_query = "SELECT id, nama_jabatan FROM jabatan";
$jabatan_result = $conn->query($jabatan_query);
?>

<!-- Form Tambah User -->
<form method="POST" action="">
    <div class="mb-4">
        <label for="nama_pegawai" class="block text-sm font-medium">Nama Pegawai</label>
        <input type="text" id="nama_pegawai" name="nama_pegawai" required class="w-full px-4 py-2 border rounded-md">
    </div>
    <div class="mb-4">
        <label for="username" class="block text-sm font-medium">Username</label>
        <input type="text" id="username" name="username" required class="w-full px-4 py-2 border rounded-md">
    </div>
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium">Password</label>
        <input type="password" id="password" name="password" required class="w-full px-4 py-2 border rounded-md">
    </div>
    <div class="mb-4">
        <label for="role" class="block text-sm font-medium">Role</label>
        <select id="role" name="role" required class="w-full px-4 py-2 border rounded-md">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>
    <div class="mb-4">
        <label for="jabatan" class="block text-sm font-medium">Jabatan</label>
        <select id="jabatan" name="jabatan" required class="w-full px-4 py-2 border rounded-md">
            <?php while ($row = $jabatan_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_jabatan']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-4">
        <label for="nip" class="block text-sm font-medium">NIP</label>
        <input type="text" id="nip" name="nip" required class="w-full px-4 py-2 border rounded-md">
    </div>
    <button type="submit" name="add_user" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition">Tambah User</button>
</form>

<!-- Tampilkan pesan error/sukses -->
<?php if (isset($success_message)): ?>
    <p class="text-green-500"><?php echo $success_message; ?></p>
<?php endif; ?>

<?php if (isset($error_message)): ?>
    <p class="text-red-500"><?php echo $error_message; ?></p>
<?php endif; ?>