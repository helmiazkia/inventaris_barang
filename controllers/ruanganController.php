<?php
session_start();
include('../config/koneksi.php');
// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fungsi untuk menambah ruangan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_room'])) {
    $nama_ruangan = htmlspecialchars($_POST['nama_ruangan']);
    $sql = "INSERT INTO ruangan (nama_ruangan) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama_ruangan);
    if ($stmt->execute()) {
        header("Location: ../views/ruanganView.php?success=Ruangan berhasil ditambahkan!");
        exit;
    } else {
        header("Location: ../views/ruanganView.php?error=Gagal menambahkan ruangan!");
        exit;
    }
}

// Fungsi untuk mengedit ruangan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_room'])) {
    $id = $_POST['id'];
    $nama_ruangan = htmlspecialchars($_POST['nama_ruangan']);
    $sql = "UPDATE ruangan SET nama_ruangan = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nama_ruangan, $id);
    if ($stmt->execute()) {
        header("Location: ../views/ruanganView.php?success=Ruangan berhasil diperbarui!");
        exit;
    } else {
        header("Location: ../views/ruanganView.php?error=Gagal memperbarui ruangan!");
        exit;
    }
}

// Fungsi untuk menghapus ruangan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM ruangan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: ../views/ruanganView.php?success=Ruangan berhasil dihapus!");
        exit;
    } else {
        header("Location: ../views/ruanganView.php?error=Gagal menghapus ruangan!");
        exit;
    }
}

// Mengambil data ruangan untuk ditampilkan
$sql = "SELECT * FROM ruangan";
$ruangan_result = $conn->query($sql);

?>
