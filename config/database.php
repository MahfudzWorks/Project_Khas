<?php
$host = 'localhost';
$db   = 'project_khas';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {

  die("Koneksi ke database gagal. Silakan periksa konfigurasi server.");
}

function base_url($path = '')
{
  return 'http://localhost/Project_Khas/' . ltrim($path, '/');
}

function format_rupiah($angka)
{
  return 'Rp ' . number_format($angka, 0, ',', '.');
}

function format_tanggal($tanggal)
{
  if (!$tanggal || $tanggal == '0000-00-00') return '-';
  $bulan = [
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  ];
  $split = explode('-', $tanggal);
  return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}
