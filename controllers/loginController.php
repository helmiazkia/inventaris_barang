<?php
include('../config/koneksi.php');

function login($nip, $tanggal_lahir) {
    global $conn;
    
    // Enkripsi password (tanggal lahir)
    $password = md5($tanggal_lahir);
    
    $query = "SELECT * FROM users WHERE username = '$nip' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nip'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['jabatan'] = $user['jabatan'];

        if ($user['role'] == 'admin') {
            header("Location: ../views/dashboard.php");
        } else {
            header("Location: ../views/index.php");
        }
    } else {
        return "NIP atau Tanggal Lahir Salah!";
    }
}
?>
