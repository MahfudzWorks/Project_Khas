-- Membuat Database
CREATE DATABASE IF NOT EXISTS db_project_khas;
USE db_project_khas;

-- Membuat Tabel produk_khas
CREATE TABLE IF NOT EXISTS produk_khas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_item VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    asal_daerah VARCHAR(100) NOT NULL,
    stok INT DEFAULT 0,
    harga DECIMAL(10,2) DEFAULT 0.00,
    deskripsi TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan Data Dummy Awal
INSERT INTO produk_khas (nama_item, kategori, asal_daerah, stok, harga, deskripsi) VALUES
('Batik Mega Mendung', 'Kerajinan', 'Cirebon', 25, 250000.00, 'Kain batik motif awan khas Cirebon dengan gradasi warna yang indah.'),
('Rendang Daging', 'Kuliner', 'Padang', 50, 85000.00, 'Makanan khas Minangkabau dari daging sapi pilihan dengan bumbu rempah mentok.'),
('Ulos Ragidup', 'Kerajinan', 'Sumatera Utara', 10, 450000.00, 'Kain tenun ulos khas Batak yang sering digunakan dalam upacara adat.'),
('Gudeg Jogja', 'Kuliner', 'Yogyakarta', 40, 35000.00, 'Makanan tradisional khas Yogyakarta dari nangka muda dimasak santan.'),
('Ukiran Jepara', 'Kerajinan', 'Jepara', 8, 1200000.00, 'Kerajinan ukir kayu jati bermutu tinggi khas daerah Jepara.');