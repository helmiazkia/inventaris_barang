<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kode Barang</title>
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
            <h2 class="text-blue-600 font-bold text-xl mb-3">Kode Barang</h2>

            <!-- Input Manual Kode -->
            <input type="text" id="barcodeInput" placeholder="Masukkan kode barang..." 
                   class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2 transition"
                   autofocus>
            <button onclick="searchBarcode()" 
                    class="w-full bg-yellow-400 text-white font-bold py-2 mt-4 rounded-lg hover:bg-yellow-500 transition duration-200">
                Cari Barang
            </button>

            <!-- Link ke Login -->
            <p class="mt-4 text-sm text-gray-600">
                Kembali ke login? <a href="login.php" class="text-blue-600 hover:underline">Klik di sini</a>
            </p>
        </div>
    </div>

    <!-- Overlay Loading -->
    <div id="loading-screen" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-blue-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <p class="text-blue-600 font-semibold">Loading...</p>
        </div>
    </div>

    <script>
        function showLoadingScreen() {
            document.getElementById("loading-screen").classList.remove("hidden");
        }

        function searchBarcode() {
            let barcodeInput = document.getElementById("barcodeInput");
            let barcode = barcodeInput.value.trim();

            if (barcode === "") {
                barcodeInput.classList.add("border-red-500");
                alert("❌ Masukkan kode barang terlebih dahulu!");
                return;
            }

            barcodeInput.classList.remove("border-red-500");
            showLoadingScreen();

            setTimeout(() => {
                window.location.href = "detail_barang.php?barcode=" + encodeURIComponent(barcode);
            }, 2000);
        }
    </script>
</body>
</html>
