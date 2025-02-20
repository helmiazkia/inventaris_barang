<?php
// controllers/BarangController.php

class BarangController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Method untuk menambah barang
    public function tambahBarang($data, $files) {
        $nama_barang = $data['nama_barang'];
        $kode_barang = $data['kode_barang'];
        $barcode = $data['barcode'];
        $kategori_id = $data['kategori_id'];
        $tahun_pembuatan = $data['tahun_pembuatan'];
        $bahan = $data['bahan'];
        $ukuran = $data['ukuran'];
        $nomor_seri_pabrik = $data['nomor_seri_pabrik'];
        $merk_model = $data['merk_model'];
        $jenis_barang = $data['jenis_barang'];
        $jumlah = $data['jumlah'];
        $harga_beli = $data['harga_beli'];
        $kondisi_barang = $data['kondisi_barang'];
        $status = $data['status'];

        // Mengupload foto
        $foto = $files['foto']['name'];
        $foto_tmp = $files['foto']['tmp_name'];
        $foto_path = 'images/' . $foto;  // Direktori tempat foto disimpan

        // Pindahkan foto ke direktori tujuan
        move_uploaded_file($foto_tmp, $foto_path);

        // Insert data barang ke database
        $sql = "INSERT INTO barang (nama_barang, kode_barang, barcode, kategori_id, tahun_pembuatan, bahan, ukuran, nomor_seri_pabrik, 
                merk_model, jenis_barang, jumlah, harga_beli, kondisi_barang, status, foto) 
                VALUES ('$nama_barang', '$kode_barang', '$barcode', '$kategori_id', '$tahun_pembuatan', '$bahan', '$ukuran', 
                '$nomor_seri_pabrik', '$merk_model', '$jenis_barang', '$jumlah', '$harga_beli', '$kondisi_barang', '$status', '$foto_path')";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}
