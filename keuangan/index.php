<?php
require_once __DIR__ . '/../config/database.php';
$page_title = "Data Keuangan";

$filter_jenis = $_GET['jenis'] ?? '';
$filter_kategori = $_GET['kategori'] ?? '';

$query = "SELECT * FROM keuangan WHERE 1=1";
$params = [];

if (!empty($filter_jenis)) {
  $query .= " AND jenis = :jenis";
  $params[':jenis'] = $filter_jenis;
}
if (!empty($filter_kategori)) {
  $query .= " AND kategori LIKE :kategori";
  $params[':kategori'] = "%$filter_kategori%";
}

$query .= " ORDER BY tanggal DESC, id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$keuangan_list = $stmt->fetchAll();

// Calculate Summary
$tot_masuk = $pdo->query("SELECT SUM(nominal) FROM keuangan WHERE jenis = 'Pemasukan'")->fetchColumn() ?: 0;
$tot_keluar = $pdo->query("SELECT SUM(nominal) FROM keuangan WHERE jenis = 'Pengeluaran'")->fetchColumn() ?: 0;
$saldo = $tot_masuk - $tot_keluar;

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Arus Kas Keuangan</h1>
      <p class="text-sm text-gray-600">Catatan transaksi pemasukan dan pengeluaran kas.</p>
    </div>
    <a href="<?= base_url('keuangan/tambah.php') ?>" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition shadow-sm">
      + Catat Transaksi
    </a>
  </div>

  <!-- Summary Box -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
      <span class="text-xs font-semibold text-gray-400 uppercase">Total Pemasukan</span>
      <div class="text-lg font-bold text-emerald-600 mt-1"><?= format_rupiah($tot_masuk) ?></div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
      <span class="text-xs font-semibold text-gray-400 uppercase">Total Pengeluaran</span>
      <div class="text-lg font-bold text-red-600 mt-1"><?= format_rupiah($tot_keluar) ?></div>
    </div>
    <div class="bg-emerald-800 text-white p-4 rounded-xl shadow-sm">
      <span class="text-xs font-semibold text-emerald-200 uppercase">Saldo Kas Saat Ini</span>
      <div class="text-xl font-black mt-1"><?= format_rupiah($saldo) ?></div>
    </div>
  </div>

  <!-- Filter Form -->
  <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div>
        <select name="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="">-- Semua Jenis --</option>
          <option value="Pemasukan" <?= $filter_jenis === 'Pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
          <option value="Pengeluaran" <?= $filter_jenis === 'Pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
        </select>
      </div>
      <div>
        <input type="text" name="kategori" value="<?= htmlspecialchars($filter_kategori) ?>" placeholder="Cari Kategori..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div class="flex gap-2">
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900">Filter</button>
      </div>
    </form>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if (empty($keuangan_list)): ?>
      <div class="text-center py-12 px-4">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="mt-2 text-sm text-gray-600 font-medium">Belum ada transaksi keuangan.</p>
        <a href="<?= base_url('keuangan/tambah.php') ?>" class="mt-4 inline-block px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-lg hover:bg-emerald-700">+ Catat Transaksi</a>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
          <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs tracking-wider">
              <th class="p-4">Tanggal</th>
              <th class="p-4">Jenis</th>
              <th class="p-4">Kategori</th>
              <th class="p-4">Keterangan</th>
              <th class="p-4 text-right">Nominal</th>
              <th class="p-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php foreach ($keuangan_list as $t): ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="p-4 text-gray-700 whitespace-nowrap"><?= format_tanggal($t['tanggal']) ?></td>
                <td class="p-4">
                  <span class="px-2.5 py-1 text-xs rounded-full font-bold <?= $t['jenis'] === 'Pemasukan' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' ?>">
                    <?= $t['jenis'] ?>
                  </span>
                </td>
                <td class="p-4 font-medium text-gray-900"><?= htmlspecialchars($t['kategori']) ?></td>
                <td class="p-4 text-gray-600"><?= htmlspecialchars($t['keterangan']) ?></td>
                <td class="p-4 text-right font-bold whitespace-nowrap <?= $t['jenis'] === 'Pemasukan' ? 'text-emerald-600' : 'text-red-600' ?>">
                  <?= format_rupiah($t['nominal']) ?>
                </td>
                <td class="p-4 text-center space-x-2">
                  <a href="<?= base_url('keuangan/edit.php?id=' . $t['id']) ?>" class="text-amber-600 hover:text-amber-800 font-medium text-xs">Edit</a>
                  <button type="button" data-delete-url="<?= base_url('keuangan/hapus.php?id=' . $t['id']) ?>" data-delete-title="Transaksi <?= htmlspecialchars($t['kategori']) ?>" class="btn-delete text-red-600 hover:text-red-800 font-medium text-xs">Hapus</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>