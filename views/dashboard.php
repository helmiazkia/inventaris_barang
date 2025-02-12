<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include "../config/koneksi.php";
$page = "dashboard.php";
include "layout.php";
?>

<div class="container">
    <h2 class="mt-3">Dashboard Admin</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Barang</h5>
                    <p class="card-text">
                        <?php
                        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM barang");
                        $data = mysqli_fetch_assoc($result);
                        echo $data['total'] . " Item";
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
