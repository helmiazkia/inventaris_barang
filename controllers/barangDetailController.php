<?php
session_start();
include('../config/koneksi.php');

// Fungsi untuk mengambil semua data barang detail
function getAllBarangDetail($conn) {
    $sql = "SELECT * FROM barang_detail";
    $result = $conn->query($sql);
    return $result;
}

// Fungsi untuk mengambil data barang detail berdasarkan kode unik
function getBarangDetailByKodeUnik($conn, $kode_unik) {
    $sql = "SELECT * FROM barang_detail WHERE kode_unik = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $kode_unik);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }
    return null;
}

// Fungsi untuk menyimpan data barang detail baru
function saveBarangDetail($conn, $kode_unik, $kode_barang, $ruangan_asal_id, $ruangan_sekarang_id, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh, $harga_beli, $kondisi) {
    $sql = "INSERT INTO barang_detail (kode_unik, kode_barang, ruangan_asal_id, ruangan_sekarang_id, tanggal_pindah, keterangan_pindah, dipindah_oleh, harga_beli, kondisi) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssiiissis", $kode_unik, $kode_barang, $ruangan_asal_id, $ruangan_sekarang_id, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh, $harga_beli, $kondisi);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk memperbarui data barang detail
function updateBarangDetail($conn, $kode_unik, $kode_barang, $ruangan_asal_id, $ruangan_sekarang_id, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh, $harga_beli, $kondisi) {
    $sql = "UPDATE barang_detail SET kode_barang = ?, ruangan_asal_id = ?, ruangan_sekarang_id = ?, tanggal_pindah = ?, keterangan_pindah = ?, dipindah_oleh = ?, harga_beli = ?, kondisi = ? WHERE kode_unik = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("siiississ", $kode_barang, $ruangan_asal_id, $ruangan_sekarang_id, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh, $harga_beli, $kondisi, $kode_unik);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

// Fungsi untuk menghapus data barang detail
function deleteBarangDetail($conn, $kode_unik) {
    $sql = "DELETE FROM barang_detail WHERE kode_unik = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $kode_unik);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

// Menangani form untuk tambah dan edit barang detail
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_unik = $_POST['kode_unik'];
    $kode_barang = $_POST['kode_barang'];
    $ruangan_asal_id = $_POST['ruangan_asal_id'];
    $ruangan_sekarang_id = $_POST['ruangan_sekarang_id'];
    $tanggal_pindah = $_POST['tanggal_pindah'];
    $keterangan_pindah = $_POST['keterangan_pindah'];
    $dipindah_oleh = $_POST['dipindah_oleh'];
    $harga_beli = $_POST['harga_beli'];
    $kondisi = $_POST['kondisi'];

    // Jika kode unik ada, maka lakukan update, jika tidak lakukan insert
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        if (updateBarangDetail($conn, $kode_unik, $kode_barang, $ruangan_asal_id, $ruangan_sekarang_id, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh, $harga_beli, $kondisi)) {
            header("Location: ../views/barangDetailView.php?success=Data barang berhasil diperbarui");
        } else {
            header("Location: ../views/barangDetailView.php?error=Gagal memperbarui data barang");
        }
    } else {
        if (saveBarangDetail($conn, $kode_unik, $kode_barang, $ruangan_asal_id, $ruangan_sekarang_id, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh, $harga_beli, $kondisi)) {
            header("Location: ../views/barangDetailView.php?success=Data barang berhasil disimpan");
        } else {
            header("Location: ../views/barangDetailView.php?error=Gagal menyimpan data barang");
        }
    }
}

// Menangani penghapusan barang detail
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $kode_unik = $_GET['delete'];
    if (deleteBarangDetail($conn, $kode_unik)) {
        header("Location: ../views/barangDetailView.php?success=Data barang berhasil dihapus");
    } else {
        header("Location: ../views/barangDetailView.php?error=Gagal menghapus data barang");
    }
}

// Mengambil data barang detail
$resultBarangDetail = getAllBarangDetail($conn);

// Cek jika ada kode_unik untuk pengeditan
$dataBarangDetail = null;
if (isset($_GET['kode_unik'])) {
    $kode_unik = $_GET['kode_unik'];
    $dataBarangDetail = getBarangDetailByKodeUnik($conn, $kode_unik);
}

// Ambil data ruangan untuk form
$ruanganResult = getAllRuangan($conn);
?>
