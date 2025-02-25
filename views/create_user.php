<?php


// Check if the user is logged in and has 'admin' role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit; // Stop further script execution
}


// Check if the user is logged in and has 'admin' role
include('../config/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = htmlspecialchars($_POST['username']);  // Sanitasi input
    $password = $_POST['password'];
    $role = $_POST['role'];
    $jabatan = $_POST['jabatan'];
    $nip = $_POST['nip'];
    $nama_pegawai = htmlspecialchars($_POST['nama_pegawai']); // Sanitasi input for employee name

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data user ke database
    $sql = "INSERT INTO users (username, password, role, jabatan, nip, nama_pegawai) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $hashed_password, $role, $jabatan, $nip, $nama_pegawai);

    if ($stmt->execute()) {
        // Set session untuk mengirimkan pesan sukses ke JavaScript
        echo "<script type='text/javascript'>
                window.onload = function() {
                    alert('User berhasil ditambahkan!');
                }
              </script>";
    } else {
        // Set session untuk mengirimkan pesan error ke JavaScript
        echo "<script type='text/javascript'>
                window.onload = function() {
                    alert('Gagal menambahkan user!');
                }
              </script>";
    }
}
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
        <input type="text" id="jabatan" name="jabatan" class="w-full px-4 py-2 border rounded-md">
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