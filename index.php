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

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow bg-slate-50 dark:bg-slate-900 transition-colors duration-200">
  <!-- Header Page -->
  <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Dashboard Administrasi</h1>
      <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Selamat datang di Sistem Informasi Karang Taruna <span class="font-semibold text-blue-600 dark:text-blue-400">Project_KHAS</span>.</p>
    </div>
  </div>

  <!-- Ringkasan Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card Total Anggota -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-md border border-slate-100 dark:border-slate-700/60 p-6 transition-all duration-200 flex items-center justify-between">
      <div>
        <p class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Total Anggota</p>
        <p class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2"><?= $total_anggota ?></p>
        <p class="text-xs text-blue-600 dark:text-blue-400 font-semibold mt-1 flex items-center gap-1">
          <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
          <?= $anggota_aktif ?> Aktif
        </p>
      </div>
      <div class="p-3.5 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-xl shadow-md shadow-blue-500/20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </div>
    </div>

    <!-- Card Anggota Aktif -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-md border border-slate-100 dark:border-slate-700/60 p-6 transition-all duration-200 flex items-center justify-between">
      <div>
        <p class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Anggota Aktif</p>
        <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mt-2"><?= $anggota_aktif ?></p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Pengurus & Anggota</p>
      </div>
      <div class="p-3.5 bg-gradient-to-br from-blue-600 to-cyan-500 text-white rounded-xl shadow-md shadow-cyan-500/20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
    </div>

    <!-- Card Total Kegiatan -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-md border border-slate-100 dark:border-slate-700/60 p-6 transition-all duration-200 flex items-center justify-between">
      <div>
        <p class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Total Kegiatan</p>
        <p class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2"><?= $total_kegiatan ?></p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Terjadwal & Selesai</p>
      </div>
      <div class="p-3.5 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl shadow-md shadow-indigo-500/20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    </div>

    <!-- Card Saldo Kas -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-md border border-slate-100 dark:border-slate-700/60 p-6 transition-all duration-200 flex items-center justify-between">
      <div>
        <p class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Saldo Kas</p>
        <p class="text-2xl font-black text-blue-700 dark:text-blue-300 mt-2"><?= format_rupiah($saldo_kas) ?></p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Masuk: <?= format_rupiah($total_pemasukan) ?></p>
      </div>
      <div class="p-3.5 bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl shadow-md shadow-blue-700/20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
    </div>
  </div>

  <!-- Card Informasi -->
  <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 rounded-2xl p-6 text-white mb-8 shadow-lg shadow-blue-500/10 border border-blue-500/20 relative overflow-hidden">
    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="flex items-start gap-4 relative z-10">
      <div class="p-3 bg-white/15 backdrop-blur-md rounded-xl flex-shrink-0 border border-white/20">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <h3 class="text-lg font-bold tracking-wide">Informasi Karang Taruna</h3>
        <p class="text-blue-100 text-sm mt-1 leading-relaxed max-w-3xl">
          Karang Taruna merupakan wadah kegiatan generasi muda untuk meningkatkan kebersamaan, kepedulian sosial, kreativitas, dan partisipasi dalam lingkungan masyarakat.
        </p>
      </div>
    </div>
  </div>

  <!-- Grid Activity terbaru -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Kegiatan Terbaru -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 p-6">
      <div class="flex justify-between items-center mb-5 pb-3 border-b border-slate-100 dark:border-slate-700/60">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Kegiatan Terbaru</h2>
        <a href="<?= base_url('kegiatan/index.php') ?>" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-semibold transition-colors">Lihat Semua &rarr;</a>
      </div>
      <?php if (empty($kegiatan_terbaru)): ?>
        <p class="text-sm text-slate-400 py-6 text-center">Belum ada data kegiatan.</p>
      <?php else: ?>
        <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
          <?php foreach ($kegiatan_terbaru as $k): ?>
            <div class="py-3.5 flex justify-between items-center gap-4">
              <div>
                <h4 class="font-semibold text-slate-800 dark:text-slate-200 text-sm"><?= htmlspecialchars($k['nama_kegiatan']) ?></h4>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5"><?= format_tanggal($k['tanggal']) ?> &bull; <?= htmlspecialchars($k['lokasi']) ?></p>
              </div>
              <span class="px-3 py-1 text-xs rounded-full font-semibold flex-shrink-0 
                <?= $k['status'] === 'Selesai' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800' : ($k['status'] === 'Akan Dilaksanakan' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300 border border-sky-200 dark:border-sky-800' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300') ?>">
                <?= $k['status'] ?>
              </span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/60 p-6">
      <div class="flex justify-between items-center mb-5 pb-3 border-b border-slate-100 dark:border-slate-700/60">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Transaksi Terbaru</h2>
        <a href="<?= base_url('keuangan/index.php') ?>" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-semibold transition-colors">Lihat Semua &rarr;</a>
      </div>
      <?php if (empty($transaksi_terbaru)): ?>
        <p class="text-sm text-slate-400 py-6 text-center">Belum ada data keuangan.</p>
      <?php else: ?>
        <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
          <?php foreach ($transaksi_terbaru as $t): ?>
            <div class="py-3.5 flex justify-between items-center gap-4">
              <div>
                <h4 class="font-semibold text-slate-800 dark:text-slate-200 text-sm"><?= htmlspecialchars($t['kategori']) ?></h4>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5"><?= format_tanggal($t['tanggal']) ?> &bull; <?= htmlspecialchars($t['keterangan']) ?></p>
              </div>
              <span class="text-sm font-bold flex-shrink-0 <?= $t['jenis'] === 'Pemasukan' ? 'text-blue-600 dark:text-blue-400' : 'text-rose-500 dark:text-rose-400' ?>">
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