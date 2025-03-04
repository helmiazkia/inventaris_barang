<?php
session_start();
include('../config/koneksi.php');

// Fungsi untuk mengambil semua data pemindahan barang
function getAllPemindahanBarang($conn) {
    $sql = "SELECT pemindahan_barang.*, 
                   ruangan_asal.nama_ruangan AS ruangan_asal_name, 
                   ruangan_tujuan.nama_ruangan AS ruangan_tujuan_name, 
                   barang_detail.kode_unik, 
                   barang_detail.kode_barang, 
                   barang_detail.harga_beli, 
                   barang_detail.kondisi 
            FROM pemindahan_barang
            JOIN ruangan AS ruangan_asal ON pemindahan_barang.ruangan_asal_id = ruangan_asal.id
            JOIN ruangan AS ruangan_tujuan ON pemindahan_barang.ruangan_tujuan_id = ruangan_tujuan.id
            JOIN barang_detail ON pemindahan_barang.kode_unik = barang_detail.kode_unik";
    $result = $conn->query($sql);
    return $result;
}

// Fungsi untuk mengambil data pemindahan barang berdasarkan ID
function getPemindahanBarangById($conn, $id) {
    $sql = "SELECT * FROM pemindahan_barang WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }
    return null;
}

// Fungsi untuk mengambil data ruangan
function getAllRuangan($conn) {
    $sql = "SELECT * FROM ruangan";
    return $conn->query($sql);
}

// Fungsi untuk mengambil data barang
function getAllBarang($conn) {
    $sql = "SELECT * FROM barang_detail";
    return $conn->query($sql);
}

// Fungsi untuk mengambil nama pegawai dari session (dari tabel `users`)
function getNamaPegawai($conn, $user_id) {
    $sql = "SELECT nama_pegawai FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data['nama_pegawai'];
    }
    return null;
}

// Fungsi untuk menyimpan data pemindahan barang baru
function savePemindahanBarang($conn, $kode_unik, $ruangan_asal, $ruangan_tujuan, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh) {
    $sql = "INSERT INTO pemindahan_barang (kode_unik, ruangan_asal_id, ruangan_tujuan_id, tanggal_pindah, keterangan_pindah, dipindah_oleh) 
            VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $kode_unik, $ruangan_asal, $ruangan_tujuan, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk memperbarui data pemindahan barang
function updatePemindahanBarang($conn, $id, $kode_unik, $ruangan_asal, $ruangan_tujuan, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh) {
    $sql = "UPDATE pemindahan_barang SET kode_unik = ?, ruangan_asal_id = ?, ruangan_tujuan_id = ?, tanggal_pindah = ?, keterangan_pindah = ?, dipindah_oleh = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssi", $kode_unik, $ruangan_asal, $ruangan_tujuan, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh, $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

// Fungsi untuk menghapus data pemindahan barang
function deletePemindahanBarang($conn, $id) {
    $sql = "DELETE FROM pemindahan_barang WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

// Menangani form untuk tambah dan edit pemindahan barang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_unik = $_POST['kode_unik'];
    $ruangan_asal = $_POST['ruangan_asal_id'];
    $ruangan_tujuan = $_POST['ruangan_tujuan_id'];
    $tanggal_pindah = $_POST['tanggal_pindah'];
    $keterangan_pindah = $_POST['keterangan_pindah'];

    // Menangkap ID pengguna yang sedang login (misalnya disimpan di session)
    $user_id = $_SESSION['user_id']; // ID pengguna yang sedang login
    // Mengambil nama pegawai berdasarkan ID pengguna yang sedang login
    $dipindah_oleh = getNamaPegawai($conn, $user_id);

    // Jika ID ada, maka lakukan update, jika tidak lakukan insert
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        if (updatePemindahanBarang($conn, $id, $kode_unik, $ruangan_asal, $ruangan_tujuan, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh)) {
            header("Location: ../views/pemindahanBarangView.php?success=Data pemindahan barang berhasil diperbarui");
        } else {
            header("Location: ../views/pemindahanBarangView.php?error=Gagal memperbarui data pemindahan barang");
        }
    } else {
        if (savePemindahanBarang($conn, $kode_unik, $ruangan_asal, $ruangan_tujuan, $tanggal_pindah, $keterangan_pindah, $dipindah_oleh)) {
            header("Location: ../views/pemindahanBarangView.php?success=Data pemindahan barang berhasil disimpan");
        } else {
            header("Location: ../views/pemindahanBarangView.php?error=Gagal menyimpan data pemindahan barang");
        }
    }
}

// Menangani penghapusan pemindahan barang
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deletePemindahanBarang($conn, $id)) {
        header("Location: ../views/pemindahanBarangView.php?success=Data pemindahan barang berhasil dihapus");
    } else {
        header("Location: ../views/pemindahanBarangView.php?error=Gagal menghapus data pemindahan barang");
    }
}

// Mengambil data pemindahan barang
$resultPemindahan = getAllPemindahanBarang($conn);

// Cek jika ada ID untuk pengeditan
$dataPemindahan = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $dataPemindahan = getPemindahanBarangById($conn, $id);
}

// Ambil data ruangan dan barang untuk form
$ruanganResult = getAllRuangan($conn);
$barangResult = getAllBarang($conn);
?>
