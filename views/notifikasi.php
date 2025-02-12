<?php
session_start();
include('../config/koneksi.php');
include('../controllers/notifikasiController.php');

$notifikasiController = new NotifikasiController();
$user_id = $_SESSION['user_id'];
$notifikasi = $notifikasiController->tampilNotifikasi($user_id);

echo "<h1>Notifikasi</h1>";
if ($notifikasi) {
    foreach ($notifikasi as $notif) {
        echo "<p>" . $notif['message'] . " - " . $notif['created_at'] . "</p>";
    }
} else {
    echo "<p>Tidak ada notifikasi baru.</p>";
}
?>
