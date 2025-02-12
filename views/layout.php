<?php
$page = isset($page) ? $page : 'dashboard.php'; // Menentukan default page jika tidak ada variabel $page
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark p-3">
    <a class="navbar-brand mx-3" href="#">Inventaris Barang</a>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar p-3">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="barang.php">Manajemen Barang</a></li>
                <li class="nav-item"><a class="nav-link" href="kategori.php">Kategori Barang</a></li>
                <li class="nav-item"><a class="nav-link" href="ruangan.php">Manajemen Ruangan</a></li>
                <li class="nav-item"><a class="nav-link" href="peminjaman.php">Peminjaman</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="../logout.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Konten Utama -->
        <main class="col-md-10 p-4">
            <?php include($page); ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
