<?php
session_start();
include('../config/koneksi.php'); // Sesuaikan path koneksi

$error_message = ""; // Variabel untuk menyimpan pesan kesalahan

// Cek apakah pengguna sudah login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = htmlspecialchars($_POST['nip']);  // Sanitize input
    $password = $_POST['password'];

    // Query untuk mengambil data user berdasarkan NIP
    $sql = "SELECT * FROM users WHERE nip = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nip);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data user
        $user = $result->fetch_assoc();

        // Verifikasi password menggunakan password_hash()
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Regenerasi session ID untuk mencegah session fixation
            session_regenerate_id(true);

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: dashboard.php"); // Sesuaikan path redirect
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error_message = "NIP atau password salah!";
        }
    } else {
        $error_message = "NIP atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen relative">
    <!-- Background Image -->
    <img src="../public/background.png" class="absolute w-full h-full object-cover" alt="Background">

    <!-- Kontainer Utama -->
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
            <!-- Logo -->
            <img src="../public/image.png" class="mx-auto w-16 mb-4" alt="Logo">
            
            <!-- Judul -->
            <h2 class="text-blue-600 font-bold text-xl mb-3">SimA Login</h2>

            <!-- Pesan Error -->
            <?php if (!empty($error_message)) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3 text-sm">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nip" class="block text-left text-sm font-medium text-gray-700">NIP:</label>
                    <input type="text" id="nip" name="nip" required 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mt-2" />
                </div>

                <div class="mb-3">
                    <label for="password" class="block text-left text-sm font-medium text-gray-700">Password:</label>
                    <input type="password" id="password" name="password" required 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mt-2" />
                </div>

                <button type="submit" 
                        class="w-full bg-yellow-400 text-white font-bold py-2 mt-4 rounded-lg hover:bg-yellow-500 transition duration-200">
                    Login
                </button>
            </form>

            <!-- Link ke Scan QR -->
            <p class="mt-4 text-sm text-gray-600">
                Detail Barang? <a href="../index.php" class="text-blue-600 hover:underline">Klik di sini</a>
            </p>
        </div>
    </div>
</body>
</html>
