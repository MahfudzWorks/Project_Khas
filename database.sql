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
