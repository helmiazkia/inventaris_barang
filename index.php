<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimA Cek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="relative w-full h-full">
        <img src="./public/background.png" class="absolute w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
                <img src="./public/image.png" class="mx-auto w-16 mb-4" alt="Logo">
                <h2 class="text-blue-600 font-bold text-xl">SimA Cek</h2>
                <input type="text" placeholder="Masukkan data" class="w-full px-4 py-2 mt-4 border rounded">
                <button class="w-full bg-yellow-400 text-white font-bold py-2 mt-4 rounded">Cari</button>
                <p class="mt-4 text-sm">Sudah memiliki akun? <a href="./login.php" class="text-blue-500">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>