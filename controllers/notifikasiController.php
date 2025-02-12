<?php
include('../config/koneksi.php');

class NotifikasiController {

    public function kirimNotifikasi($user_id, $message) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO notifikasi (user_id, message) VALUES (?, ?)");
        $stmt->execute([$user_id, $message]);
    }

    public function tampilNotifikasi($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM notifikasi WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
