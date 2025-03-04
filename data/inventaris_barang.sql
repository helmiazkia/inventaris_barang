CREATE DATABASE inventaris_barang;
USE inventaris_barang;

-- Tabel Users (Admin & Pegawai)
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') NOT NULL,
    jabatan VARCHAR(100),
    nip VARCHAR(50) NOT NULL UNIQUE,
    nama_pegawai VARCHAR(100) NOT NULL
);

CREATE TABLE jabatan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jabatan VARCHAR(255) NOT NULL
);


-- Tabel Kategori Barang
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL UNIQUE
);

-- Tabel Ruangan
CREATE TABLE ruangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ruangan VARCHAR(100) NOT NULL UNIQUE
);

-- Tabel Barang (Data Umum Barang)
CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL UNIQUE,  -- Kode barang yang sama untuk barang sejenis
    nama_barang VARCHAR(100) NOT NULL,
    kategori_id INT,
    jumlah_total INT NOT NULL,  -- Total barang dari kode yang sama
    jumlah_baik INT NOT NULL,   -- Jumlah barang dalam kondisi baik
    jumlah_rusak_ringan INT NOT NULL, -- Jumlah barang rusak ringan
    jumlah_rusak_berat INT NOT NULL,  -- Jumlah barang rusak berat
    total_harga BIGINT NOT NULL,  -- Total harga semua barang ini
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);

-- Tabel Barang Detail (Setiap Barang Unik)
CREATE TABLE barang_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_unik VARCHAR(50) NOT NULL UNIQUE,  -- Setiap barang memiliki kode unik
    kode_barang VARCHAR(50) NOT NULL,  -- Referensi ke tabel barang
    ruangan_asal_id INT,  -- Ruangan asal barang ini sebelumnya
    ruangan_sekarang_id INT NOT NULL, -- Ruangan saat ini
    tanggal_pindah DATETIME DEFAULT NULL,  -- Tanggal pindah jika ada pemindahan
    keterangan_pindah TEXT DEFAULT NULL,  -- Keterangan saat pindah
    dipindah_oleh VARCHAR(100) DEFAULT NULL,  -- Nama pegawai yang memindahkan
    harga_beli BIGINT NOT NULL,  -- Harga beli satuan barang ini
    kondisi ENUM('baik', 'rusak ringan', 'rusak berat') NOT NULL, -- Kondisi barang
    FOREIGN KEY (kode_barang) REFERENCES barang(kode_barang),
    FOREIGN KEY (ruangan_asal_id) REFERENCES ruangan(id),
    FOREIGN KEY (ruangan_sekarang_id) REFERENCES ruangan(id)
);

CREATE TABLE pemindahan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_unik VARCHAR(50) NOT NULL,  -- Barang yang dipindahkan
    ruangan_asal_id INT NOT NULL,
    ruangan_tujuan_id INT NOT NULL,
    tanggal_pindah DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Otomatis saat pindah
    keterangan_pindah TEXT DEFAULT NULL,  -- Keterangan pemindahan
    dipindah_oleh VARCHAR(100) NOT NULL,  -- Nama pegawai yang memindahkan
    FOREIGN KEY (kode_unik) REFERENCES barang_detail(kode_unik),
    FOREIGN KEY (ruangan_asal_id) REFERENCES ruangan(id),
    FOREIGN KEY (ruangan_tujuan_id) REFERENCES ruangan(id)
);
