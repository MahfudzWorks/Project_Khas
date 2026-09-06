USE `project_khas`;

-- Disable foreign key checks & truncate
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `keuangan`;
TRUNCATE TABLE `anggota`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. INSERT DATA ANGGOTA (57 Orang dari PDF)
INSERT INTO `anggota` 
(`id`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`, `jabatan`, `status`, `tahun_bergabung`) 
VALUES
(1, 'Mas Wanda', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000001', 'Anggota', 'Aktif', 2024),
(2, 'Mas Arifin', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000002', 'Anggota', 'Aktif', 2024),
(3, 'Mas Ari', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000003', 'Anggota', 'Aktif', 2024),
(4, 'Mas Dani', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000004', 'Anggota', 'Aktif', 2024),
(5, 'Mas Gufron', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000005', 'Anggota', 'Aktif', 2024),
(6, 'Mas Sahril', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000006', 'Anggota', 'Aktif', 2024),
(7, 'Mas Angki', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000007', 'Anggota', 'Aktif', 2024),
(8, 'Mas Viqi', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000008', 'Anggota', 'Aktif', 2024),
(9, 'Mas Ilham', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000009', 'Anggota', 'Aktif', 2024),
(10, 'Mas Luki', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000010', 'Anggota', 'Aktif', 2024),
(11, 'Mas Agis', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000011', 'Anggota', 'Aktif', 2024),
(12, 'Mas Imam', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000012', 'Anggota', 'Aktif', 2024),
(13, 'Mas Inul', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000013', 'Anggota', 'Aktif', 2024),
(14, 'Mas Dayat', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000014', 'Anggota', 'Aktif', 2024),
(15, 'Mas Yusuf', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000015', 'Anggota', 'Aktif', 2024),
(16, 'Mas Eka', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000016', 'Anggota', 'Aktif', 2024),
(17, 'Mas Mamat', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000017', 'Anggota', 'Aktif', 2024),
(18, 'Mas Hais', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000018', 'Anggota', 'Aktif', 2024),
(19, 'Mas Albi', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000019', 'Anggota', 'Aktif', 2024),
(20, 'Mas Prass', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000020', 'Anggota', 'Aktif', 2024),
(21, 'Mas Radit', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000021', 'Anggota', 'Aktif', 2024),
(22, 'Mas Rehan', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000022', 'Anggota', 'Aktif', 2024),
(23, 'Mas Lutfan', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000023', 'Anggota', 'Aktif', 2024),
(24, 'Mas Azam', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000024', 'Anggota', 'Aktif', 2024),
(25, 'Mas Nico', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000025', 'Anggota', 'Aktif', 2024),
(26, 'Mas Ali', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000026', 'Anggota', 'Aktif', 2024),
(27, 'Mas Angga', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000027', 'Anggota', 'Aktif', 2024),
(28, 'Mbak Nita', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000028', 'Anggota', 'Aktif', 2024),
(29, 'Mbak Kristin', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000029', 'Anggota', 'Aktif', 2024),
(30, 'Mbak Vivan', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000030', 'Anggota', 'Aktif', 2024),
(31, 'Mbak Tasya', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000031', 'Anggota', 'Aktif', 2024),
(32, 'Mbak Dila', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000032', 'Anggota', 'Aktif', 2024),
(33, 'Mbak Syifa', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000033', 'Anggota', 'Aktif', 2024),
(34, 'Mbak Anggun 03', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000034', 'Anggota', 'Aktif', 2024),
(35, 'Mbak Nanda', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000035', 'Anggota', 'Aktif', 2024),
(36, 'Mbak Olivia', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000036', 'Anggota', 'Aktif', 2024),
(37, 'Mbak Viona', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000037', 'Anggota', 'Aktif', 2024),
(38, 'Mbak Viani', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000038', 'Anggota', 'Aktif', 2024),
(39, 'Mbak Sevi', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000039', 'Anggota', 'Aktif', 2024),
(40, 'Mbak Zulfa', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000040', 'Anggota', 'Aktif', 2024),
(41, 'Mbak Diva', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000041', 'Anggota', 'Aktif', 2024),
(42, 'Mbak Intan', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000042', 'Anggota', 'Aktif', 2024),
(43, 'Mbak Anggun 02', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000043', 'Anggota', 'Aktif', 2024),
(44, 'Mbak Aprilia', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000044', 'Anggota', 'Aktif', 2024),
(45, 'Mbak Laras', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000045', 'Anggota', 'Aktif', 2024),
(46, 'Mbak Mila', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000046', 'Anggota', 'Aktif', 2024),
(47, 'Mbak Siti', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000047', 'Anggota', 'Aktif', 2024),
(48, 'Mbak Endang', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000048', 'Anggota', 'Aktif', 2024),
(49, 'Mbak Lutfi', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000049', 'Anggota', 'Aktif', 2024),
(50, 'Mbak Dela', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000050', 'Anggota', 'Aktif', 2024),
(51, 'Mas Arifin 03', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000051', 'Anggota', 'Aktif', 2024),
(52, 'Mas Huda', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000052', 'Anggota', 'Aktif', 2024),
(53, 'Mbak Nelis', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000053', 'Anggota', 'Aktif', 2024),
(54, 'Mbak Sheila', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000054', 'Anggota', 'Aktif', 2024),
(55, 'Mbak Icha', 'Perempuan', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000055', 'Anggota', 'Aktif', 2024),
(56, 'Hamba Allah R', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000056', 'Anggota', 'Aktif', 2024),
(57, 'Wahyu', 'Laki-laki', 'Gresik', '2000-01-01', 'Balongmojo Kulon', '082100000057', 'Anggota', 'Aktif', 2024);

-- 2. INSERT TRANSAKSI AWAL KEUANGAN (Saldo Kas Rp 5.650.000)
INSERT INTO `keuangan` (`tanggal`, `jenis`, `kategori`, `keterangan`, `nominal`) VALUES
(CURRENT_DATE, 'Pemasukan', 'Uang Kas', 'Saldo Awal Kas Karang Taruna Balongmojo Kulon', 5650000.00);