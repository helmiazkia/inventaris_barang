<?php
include('../config/koneksi.php'); // Pastikan koneksi ke database sudah benar

// Fungsi untuk menambahkan pengguna baru
function addUser($conn, $nama, $username, $password, $role, $jabatan_id, $nip) {
    // Enkripsi password sebelum disimpan
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Query untuk menyimpan data pengguna baru
    $sql = "INSERT INTO users (nama_pegawai, username, password, role, jabatan_id, nip) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    // Persiapkan statement dan eksekusi
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssss", $nama, $username, $passwordHash, $role, $jabatan_id, $nip);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk memperbarui data pengguna
function updateUser($conn, $id, $nama, $username, $password, $role, $jabatan_id, $nip) {
    // Jika password kosong, hanya update data selain password
    if (empty($password)) {
        $sql = "UPDATE users SET nama_pegawai = ?, username = ?, role = ?, jabatan_id = ?, nip = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssi", $nama, $username, $role, $jabatan_id, $nip, $id);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    } else {
        // Jika password diisi, enkripsi dan update password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET nama_pegawai = ?, username = ?, password = ?, role = ?, jabatan_id = ?, nip = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssi", $nama, $username, $passwordHash, $role, $jabatan_id, $nip, $id);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }
    return false;
}

// Fungsi untuk menghapus pengguna
function deleteUser($conn, $id) {
    // Query untuk menghapus data pengguna berdasarkan ID
    $sql = "DELETE FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

// Menangani form untuk tambah dan edit user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $jabatan_id = $_POST['jabatan_id'];
    $nip = $_POST['nip'];
    
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Jika ada ID, berarti update data pengguna
        $id = $_POST['id'];
        if (updateUser($conn, $id, $nama, $username, $password, $role, $jabatan_id, $nip)) {
            header("Location: ../views/userView.php?success=Pengguna berhasil diperbarui");
        } else {
            header("Location: ../views/userView.php?error=Gagal memperbarui pengguna");
        }
    } else {
        // Jika tidak ada ID, berarti tambah pengguna baru
        if (addUser($conn, $nama, $username, $password, $role, $jabatan_id, $nip)) {
            header("Location: ../views/userView.php?success=Pengguna berhasil ditambahkan");
        } else {
            header("Location: ../views/userView.php?error=Gagal menambahkan pengguna");
        }
    }
}

// Menangani penghapusan pengguna
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteUser($conn, $id)) {
        header("Location: ../views/userView.php?success=Pengguna berhasil dihapus");
    } else {
        header("Location: ../views/userView.php?error=Gagal menghapus pengguna");
    }
}
?>
