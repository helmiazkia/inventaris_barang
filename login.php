<?php
session_start();
include "config/koneksi.php"; // Memastikan koneksi dengan database

// Cek apakah ada data yang dikirimkan melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username (menggunakan prepared statements untuk mencegah SQL Injection)
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika user ditemukan dan password valid
    if ($user && password_verify($password, $user['password'])) {
        // Regenerasi ID session untuk mencegah session fixation
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id']; // Menyimpan user_id di session
        $_SESSION['role'] = $user['role']; // Menyimpan role (admin/user) di session

        // Redirect berdasarkan role user
        if ($user['role'] == 'admin') {
            header("Location: views/dashboard.php"); // Arahkan ke dashboard admin
        } else {
            header("Location: user/daftar_barang.php"); // Arahkan ke halaman daftar barang untuk user
        }
        exit(); // Pastikan eksekusi berhenti setelah redirect
    } else {
        // Jika login gagal, tampilkan pesan error
        $error_message = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimA Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="relative w-full h-full">
        <img src="./public/background.png" class="absolute w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                <img src="./public/image.png" class="mx-auto w-16 mb-4" alt="Logo">
                <h2 class="text-blue-600 font-bold text-xl mb-3">SimA Login</h2>
                <?php if (!empty($error_message)): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-2">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <input type="text" name="username" placeholder="Nomer Induk Pegawai" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button class="w-full bg-yellow-400 text-white font-bold py-2 mt-4 rounded">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
