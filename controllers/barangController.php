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

// Fungsi untuk menambahkan barang
function addBarang($conn) {
    global $error_message, $success_message;

    // Validasi data yang dikirim melalui POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
        $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
        $kategori_id = intval($_POST['kategori_id']);
        $jumlah_total = intval($_POST['jumlah_total']);

        // Validasi kategori
        $kategori_check = $conn->query("SELECT id FROM kategori WHERE id = $kategori_id");
        if ($kategori_check->num_rows == 0) {
            $error_message = "Kategori tidak valid!";
        } else {
            // Masukkan barang baru ke dalam database
            $total_harga = 0;  // Set default value for total_harga
            $sql = "INSERT INTO barang (nama_barang, kode_barang, kategori_id, jumlah_total, jumlah_baik, jumlah_rusak_ringan, jumlah_rusak_berat, total_harga)  
                    VALUES ('$nama_barang', '$kode_barang', '$kategori_id', '$jumlah_total', 0, 0, 0, '$total_harga')";
            if ($conn->query($sql) === TRUE) {
                $success_message = "Barang berhasil ditambahkan!";
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    }
}

// Fungsi untuk menghapus barang
function deleteBarang($conn) {
    global $error_message, $success_message;

    // Cek apakah ID barang tersedia di GET
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id_barang = $_GET['id'];

        // Periksa apakah barang dengan ID tersebut ada
        $check_sql = "SELECT * FROM barang WHERE id_barang = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $id_barang);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows == 0) {
            $error_message = "Barang tidak ditemukan!";
        } else {
            // Hapus barang dari database
            $sql = "DELETE FROM barang WHERE id_barang = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_barang);

            if ($stmt->execute()) {
                $success_message = "Barang berhasil dihapus!";
            } else {
                $error_message = "Gagal menghapus barang!";
            }
        }
    } else {
        $error_message = "ID barang tidak ditemukan!";
    }
}

// Fungsi untuk menampilkan daftar barang
function getAllBarang($conn) {
    $sql = "SELECT barang.*, kategori.nama_kategori FROM barang
            JOIN kategori ON barang.kategori_id = kategori.id";
    return $conn->query($sql);
}

// Proses berdasarkan aksi
$action = isset($_GET['action']) ? $_GET['action'] : 'listBarang';

// Menangani aksi-aksi tertentu
switch ($action) {
    case 'addBarang':
        addBarang($conn);
        break;

    case 'deleteBarang':
        deleteBarang($conn);
        break;

    case 'listBarang':
    default:
        $result = getAllBarang($conn);
        break;
}
?>
