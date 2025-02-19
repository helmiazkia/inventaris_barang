-- Membuat database 'inventaris_barang'
CREATE DATABASE inventaris_barang;

-- Menggunakan database 'inventaris_barang'
USE inventaris_barang;

-- Tabel User (Admin & User)
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') NOT NULL,
    jabatan VARCHAR(100),
    nip VARCHAR(50) NOT NULL
);

-- Tabel Kategori Barang
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

-- Tabel Barang dengan Penambahan Kolom Baru
CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    kode_barang VARCHAR(50) UNIQUE NOT NULL,  -- Kode barang yang unik
    barcode VARCHAR(50) UNIQUE NOT NULL,  -- Barcode yang unik
    kategori_id INT NOT NULL,
    tahun_pembuatan INT,  -- Tahun pembuatan/pembelian barang
    bahan VARCHAR(100),  -- Bahan barang
    ukuran VARCHAR(100),  -- Ukuran barang
    nomor_seri_pabrik VARCHAR(50),  -- Nomor seri pabrik
    merk_model VARCHAR(100),  -- Merk/Model barang
    jenis_barang VARCHAR(100),  -- Jenis barang (misalnya elektronik, furnitur, dll)
    jumlah INT DEFAULT 1,  -- Jumlah barang yang ada
    harga_beli DECIMAL(10, 2),  -- Harga beli barang
    kondisi_barang ENUM('baik', 'kurang baik', 'rusak', 'rusak berat') DEFAULT 'baik',  -- Keadaan barang
    foto VARCHAR(255),  -- Foto barang (untuk menyimpan path gambar)
    status ENUM('tersedia', 'dipinjam', 'hilang') DEFAULT 'tersedia',  -- Status barang (tersedia, dipinjam, hilang)
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE CASCADE
);

-- Tabel Pemindahan Barang
CREATE TABLE pemindahan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barang_id INT NOT NULL,
    ruangan_asal_id INT NOT NULL,
    ruangan_tujuan_id INT NOT NULL,
    tanggal_pindah DATE NOT NULL,
    catatan TEXT,
    FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE CASCADE,
    FOREIGN KEY (ruangan_asal_id) REFERENCES ruangan(id) ON DELETE CASCADE,
    FOREIGN KEY (ruangan_tujuan_id) REFERENCES ruangan(id) ON DELETE CASCADE
);

-- Tabel Peminjaman Barang
CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barang_id INT NOT NULL,
    user_id INT NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE DEFAULT NULL,
    status ENUM('dipinjam', 'dikembalikan') DEFAULT 'dipinjam',
    catatan TEXT,
    FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
