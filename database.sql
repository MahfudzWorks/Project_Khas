CREATE DATABASE IF NOT EXISTS `project_khas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `project_khas`;

-- Tabel Anggota
CREATE TABLE IF NOT EXISTS `anggota` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') NOT NULL,
  `tempat_lahir` VARCHAR(50) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `alamat` TEXT NOT NULL,
  `no_hp` VARCHAR(20) NOT NULL,
  `jabatan` ENUM('Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator', 'Anggota') NOT NULL DEFAULT 'Anggota',
  `status` ENUM('Aktif', 'Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `tahun_bergabung` YEAR NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Kegiatan
CREATE TABLE IF NOT EXISTS `kegiatan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_kegiatan` VARCHAR(150) NOT NULL,
  `tanggal` DATE NOT NULL,
  `waktu` TIME NOT NULL,
  `lokasi` VARCHAR(150) NOT NULL,
  `penanggung_jawab` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT NULL,
  `status` ENUM('Rencana', 'Akan Dilaksanakan', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Rencana',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Keuangan
CREATE TABLE IF NOT EXISTS `keuangan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tanggal` DATE NOT NULL,
  `jenis` ENUM('Pemasukan', 'Pengeluaran') NOT NULL,
  `kategori` VARCHAR(50) NOT NULL,
  `keterangan` TEXT NOT NULL,
  `nominal` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Dummy Anggota
INSERT INTO `anggota` (`nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`, `jabatan`, `status`, `tahun_bergabung`) VALUES
('Ahmad Fauzi', 'Laki-laki', 'Jakarta', '2000-05-12', 'Jl. Pemuda No. 12 RT 01/02', '081234567890', 'Ketua', 'Aktif', 2021),
('Siti Nurhaliza', 'Perempuan', 'Bandung', '2001-08-22', 'Jl. Merdeka No. 45 RT 02/02', '082198765432', 'Sekretaris', 'Aktif', 2021),
('Budi Santoso', 'Laki-laki', 'Surakarta', '1999-11-03', 'Jl. Melati No. 08 RT 03/02', '085712349876', 'Bendahara', 'Aktif', 2022),
('Rina Rose', 'Perempuan', 'Semarang', '2002-02-14', 'Jl. Mawar No. 19 RT 01/02', '083811223344', 'Koordinator', 'Aktif', 2023),
('Dodi Prasetyo', 'Laki-laki', 'Yogyakarta', '2003-07-29', 'Jl. Kenanga No. 04 RT 04/02', '089655443322', 'Anggota', 'Tidak Aktif', 2023);

-- Data Dummy Kegiatan
INSERT INTO `kegiatan` (`nama_kegiatan`, `tanggal`, `waktu`, `lokasi`, `penanggung_jawab`, `deskripsi`, `status`) VALUES
('Rapat Bulanan Pengurus', '2026-09-10', '19:30:00', 'Balai Warga RW 02', 'Siti Nurhaliza', 'Rapat pembahasan program kerja triwulan IV', 'Akan Dilaksanakan'),
('Kerja Bakti Bersih Desa', '2026-08-17', '07:00:00', 'Lingkungan RW 02', 'Budi Santoso', 'Membersihkan saluran air dan fasilitas umum', 'Selesai'),
('Lomba 17 Agustus', '2026-08-17', '09:00:00', 'Lapangan Serbaguna', 'Rina Rose', 'Aneka perlombaan menyambut HUT RI', 'Selesai');

-- Data Dummy Keuangan
INSERT INTO `keuangan` (`tanggal`, `jenis`, `kategori`, `keterangan`, `nominal`) VALUES
('2026-08-01', 'Pemasukan', 'Iuran Anggota', 'Iuran bulanan anggota bulan Agustus', 500000.00),
('2026-08-05', 'Pemasukan', 'Sponsor', 'Bantuan operasional dari Kelurahan', 2000000.00),
('2026-08-15', 'Pengeluaran', 'Perlengkapan kegiatan', 'Pembelian hadiah perlombaan 17an', 750000.00),
('2026-08-17', 'Pengeluaran', 'Konsumsi', 'Konsumsi panitia & peserta kerja bakti', 250000.00);