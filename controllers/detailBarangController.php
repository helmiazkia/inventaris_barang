<?php
session_start();
include('../config/koneksi.php');

// Cek apakah pengguna adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Variabel untuk menyimpan pesan sukses atau error
$success_message = null;
$error_message = null;

// Fungsi untuk menambahkan detail barang
function addDetailBarang($conn) {
    global $success_message, $error_message;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
        $ruangan_asal_id = intval($_POST['ruangan_asal_id']);
        $ruangan_sekarang_id = intval($_POST['ruangan_sekarang_id']);
        $tanggal_pindah = $_POST['tanggal_pindah'];
        $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
        $dipindah_oleh = mysqli_real_escape_string($conn, $_POST['dipindah_oleh']);
        $harga_beli = floatval($_POST['harga_beli']);
        $kondisi = mysqli_real_escape_string($conn, $_POST['kondisi']);

        // Validasi input ruangan asal dan ruangan sekarang
        $ruangan_check = $conn->query("SELECT id FROM ruangan WHERE id IN ($ruangan_asal_id, $ruangan_sekarang_id)");
        if ($ruangan_check->num_rows != 2) {
            $error_message = "Ruangan tidak valid!";
        } else {
            // Validasi dipindah oleh
            $user_check = $conn->query("SELECT id FROM users WHERE nama = '$dipindah_oleh'");
            if ($user_check->num_rows == 0) {
                $error_message = "Nama pengguna tidak valid!";
            } else {
                // Insert data ke tabel detail_barang
                $sql = "INSERT INTO detail_barang (kode_barang, ruangan_asal_id, ruangan_sekarang_id, tanggal_pindah, keterangan, dipindah_oleh, harga_beli, kondisi)
                        VALUES ('$kode_barang', '$ruangan_asal_id', '$ruangan_sekarang_id', '$tanggal_pindah', '$keterangan', '$dipindah_oleh', '$harga_beli', '$kondisi')";
                if ($conn->query($sql) === TRUE) {
                    $success_message = "Detail Barang berhasil ditambahkan!";
                } else {
                    $error_message = "Error: " . $conn->error;
                }
            }
        }
    }
}

// Fungsi untuk menampilkan daftar detail barang
function getAllDetailBarang($conn) {
    $sql = "SELECT db.*, b.nama_barang, r1.nama_ruangan AS ruangan_asal, r2.nama_ruangan AS ruangan_sekarang, u.nama AS dipindah_oleh 
            FROM detail_barang db
            JOIN barang b ON db.kode_barang = b.kode_barang
            JOIN ruangan r1 ON db.ruangan_asal_id = r1.id
            JOIN ruangan r2 ON db.ruangan_sekarang_id = r2.id
            JOIN users u ON db.dipindah_oleh = u.nama";
    return $conn->query($sql);
}

// Proses berdasarkan aksi
$action = isset($_GET['action']) ? $_GET['action'] : 'listDetailBarang';

// Menangani aksi-aksi tertentu
switch ($action) {
    case 'addDetailBarang':
        addDetailBarang($conn);
        break;

    case 'listDetailBarang':
    default:
        $result = getAllDetailBarang($conn);
        break;
}
?>
