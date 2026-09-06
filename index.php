<?php
require_once __DIR__ . '/config/database.php';
$page_title = "Dashboard";

// Fetch Stats
$total_anggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
$anggota_aktif = $pdo->query("SELECT COUNT(*) FROM anggota WHERE status = 'Aktif'")->fetchColumn();
$total_kegiatan = $pdo->query("SELECT COUNT(*) FROM kegiatan")->fetchColumn();

$total_pemasukan = $pdo->query("SELECT SUM(nominal) FROM keuangan WHERE jenis = 'Pemasukan'")->fetchColumn() ?: 0;
$total_pengeluaran = $pdo->query("SELECT SUM(nominal) FROM keuangan WHERE jenis = 'Pengeluaran'")->fetchColumn() ?: 0;
$saldo_kas = $total_pemasukan - $total_pengeluaran;

// Fetch Recent Data
$kegiatan_terbaru = $pdo->query("SELECT * FROM kegiatan ORDER BY tanggal DESC, waktu DESC LIMIT 4")->fetchAll();
$transaksi_terbaru = $pdo->query("SELECT * FROM keuangan ORDER BY tanggal DESC, id DESC LIMIT 4")->fetchAll();

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">
  <!-- Header Page -->
  <div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Administrasi</h1>
    <p class="text-gray-600 text-sm">Selamat datang di Sistem Informasi Karang Taruna <strong>Project_KHAS</strong>.</p>
  </div>

  <!-- Ringkasan Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Anggota</p>
        <p class="text-2xl font-black text-gray-900 mt-1"><?= $total_anggota ?></p>
        <p class="text-xs text-emerald-600 font-medium mt-1"><?= $anggota_aktif ?> Aktif</p>
      </div>
      <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Anggota Aktif</p>
        <p class="text-2xl font-black text-emerald-600 mt-1"><?= $anggota_aktif ?></p>
        <p class="text-xs text-gray-500 mt-1">Pengurus & Anggota</p>
      </div>
      <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Kegiatan</p>
        <p class="text-2xl font-black text-gray-900 mt-1"><?= $total_kegiatan ?></p>
        <p class="text-xs text-gray-500 mt-1">Terjadwal & Selesai</p>
      </div>
      <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo Kas</p>
        <p class="text-xl font-black text-emerald-700 mt-1"><?= format_rupiah($saldo_kas) ?></p>
        <p class="text-xs text-gray-500 mt-1">Masuk: <?= format_rupiah($total_pemasukan) ?></p>
      </div>
      <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
    </div>
  </div>

  <!-- Card Informasi -->
  <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 rounded-xl p-6 text-white mb-8 shadow-md">
    <div class="flex items-start gap-4">
      <div class="p-3 bg-white bg-opacity-20 rounded-lg flex-shrink-0">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <h3 class="text-lg font-bold">Informasi Karang Taruna</h3>
        <p class="text-emerald-100 text-sm mt-1 leading-relaxed">
          Karang Taruna merupakan wadah kegiatan generasi muda untuk meningkatkan kebersamaan, kepedulian sosial, kreativitas, dan partisipasi dalam lingkungan masyarakat.
        </p>
      </div>
    </div>
  </div>

  <!-- Grid Activity terbaru -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Kegiatan Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-900">Kegiatan Terbaru</h2>
        <a href="<?= base_url('kegiatan/index.php') ?>" class="text-xs text-emerald-600 hover:underline font-semibold">Lihat Semua &rarr;</a>
      </div>
      <?php if (empty($kegiatan_terbaru)): ?>
        <p class="text-sm text-gray-500 py-4 text-center">Belum ada data kegiatan.</p>
      <?php else: ?>
        <div class="divide-y divide-gray-100">
          <?php foreach ($kegiatan_terbaru as $k): ?>
            <div class="py-3 flex justify-between items-center">
              <div>
                <h4 class="font-semibold text-gray-800 text-sm"><?= htmlspecialchars($k['nama_kegiatan']) ?></h4>
                <p class="text-xs text-gray-500"><?= format_tanggal($k['tanggal']) ?> &bull; <?= htmlspecialchars($k['lokasi']) ?></p>
              </div>
              <span class="px-2.5 py-1 text-xs rounded-full font-medium 
                                <?= $k['status'] === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : ($k['status'] === 'Akan Dilaksanakan' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') ?>">
                <?= $k['status'] ?>
              </span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h2>
        <a href="<?= base_url('keuangan/index.php') ?>" class="text-xs text-emerald-600 hover:underline font-semibold">Lihat Semua &rarr;</a>
      </div>
      <?php if (empty($transaksi_terbaru)): ?>
        <p class="text-sm text-gray-500 py-4 text-center">Belum ada data keuangan.</p>
      <?php else: ?>
        <div class="divide-y divide-gray-100">
          <?php foreach ($transaksi_terbaru as $t): ?>
            <div class="py-3 flex justify-between items-center">
              <div>
                <h4 class="font-semibold text-gray-800 text-sm"><?= htmlspecialchars($t['kategori']) ?></h4>
                <p class="text-xs text-gray-500"><?= format_tanggal($t['tanggal']) ?> &bull; <?= htmlspecialchars($t['keterangan']) ?></p>
              </div>
              <span class="text-sm font-bold <?= $t['jenis'] === 'Pemasukan' ? 'text-emerald-600' : 'text-red-600' ?>">
                <?= $t['jenis'] === 'Pemasukan' ? '+' : '-' ?> <?= format_rupiah($t['nominal']) ?>
              </span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>