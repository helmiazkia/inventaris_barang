<?php
session_start();
include('../config/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $password = $_POST['password'];

    // Cek apakah data pegawai ada di database
    $sql = "SELECT * FROM users WHERE nip = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nip, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data user
        $user = $result->fetch_assoc();

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan jabatan
        if ($user['role'] == 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: index.php");
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

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="relative w-full h-full">
        <img src="../public/background.png" class="absolute w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                <img src="../public/image.png" class="mx-auto w-16 mb-4" alt="Logo">
                <h2 class="text-blue-600 font-bold text-xl mb-3">SimA Login</h2>
                
                <?php if (isset($error_message)): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-2">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nip" class="block text-left text-sm font-medium text-gray-700">Nomor Induk Pegawai (NIP):</label>
                        <input type="text" id="nip" name="nip" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mt-2" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="block text-left text-sm font-medium text-gray-700">password:</label>
                        <input type="password" id="password" name="password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mt-2" />
                    </div>

                    <button type="submit" class="w-full bg-yellow-400 text-white font-bold py-2 mt-4 rounded-lg hover:bg-yellow-500 transition duration-200">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
