<?php
require_once 'config/database.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

$totalDataQuery = $pdo->query("SELECT COUNT(*) FROM produk_khas")->fetchColumn();
$totalStokQuery = $pdo->query("SELECT SUM(stok) FROM produk_khas")->fetchColumn() ?: 0;
$totalKategoriQuery = $pdo->query("SELECT COUNT(DISTINCT kategori) FROM produk_khas")->fetchColumn();

$sql = "SELECT * FROM produk_khas WHERE 1=1";
$params = [];

if ($search !== '') {
  $sql .= " AND (nama_item LIKE :search OR asal_daerah LIKE :search)";
  $params[':search'] = "\%$search%";
}

if ($kategori_filter !== '') {
  $sql .= " AND kategori = :kategori";
  $params[':kategori'] = $kategori_filter;
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll();

$katStmt = $pdo->query("SELECT DISTINCT kategori FROM produk_khas");
$kategoriList = $katStmt->fetchAll(PDO::FETCH_COLUMN);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 flex-grow">

  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Dashboard Catalog</h1>
      <p class="text-sm text-gray-600">Kelola informasi produk dan kekayaan khas daerah secara ringkas.</p>
    </div>
    <a href="tambah.php" class="mt-4 md:mt-0 inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
      </svg>
      Tambah Data Baru
    </a>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Item</p>
        <p class="text-2xl font-extrabold text-gray-800 mt-1"><?= $totalDataQuery; ?></p>
      </div>
      <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
      </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Stok</p>
        <p class="text-2xl font-extrabold text-emerald-600 mt-1"><?= number_format($totalStokQuery); ?></p>
      </div>
      <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
      </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Kategori Aktif</p>
        <p class="text-2xl font-extrabold text-blue-600 mt-1"><?= $totalKategoriQuery; ?></p>
      </div>
      <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M11 7h8M11 11h8M11 15h8"></path>
        </svg>
      </div>
    </div>
  </div>

  <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
    <form method="GET" action="index.php" class="flex flex-col sm:flex-row gap-3">
      <div class="flex-grow">
        <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Cari berdasarkan nama atau asal daerah..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
      </div>
      <div class="w-full sm:w-48">
        <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm bg-white">
          <option value="">Semua Kategori</option>
          <?php foreach ($kategoriList as $kat): ?>
            <option value="<?= htmlspecialchars($kat); ?>" <?= $kategori_filter === $kat ? 'selected' : ''; ?>>
              <?= htmlspecialchars($kat); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">Filter</button>
        <?php if ($search !== '' || $kategori_filter !== ''): ?>
          <a href="index.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-300 transition">Reset</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm text-gray-600">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 font-semibold uppercase text-xs">
          <tr>
            <th class="px-6 py-3">No</th>
            <th class="px-6 py-3">Nama Item</th>
            <th class="px-6 py-3">Kategori</th>
            <th class="px-6 py-3">Asal Daerah</th>
            <th class="px-6 py-3 text-center">Stok</th>
            <th class="px-6 py-3">Harga</th>
            <th class="px-6 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <?php if (count($items) > 0): ?>
            <?php foreach ($items as $index => $row): ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900"><?= $index + 1; ?></td>
                <td class="px-6 py-4 font-semibold text-indigo-900"><?= htmlspecialchars($row['nama_item']); ?></td>
                <td class="px-6 py-4">
                  <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-indigo-50 text-indigo-700 border border-indigo-100">
                    <?= htmlspecialchars($row['kategori']); ?>
                  </span>
                </td>
                <td class="px-6 py-4"><?= htmlspecialchars($row['asal_daerah']); ?></td>
                <td class="px-6 py-4 text-center font-semibold <?= $row['stok'] < 10 ? 'text-red-500' : 'text-gray-700'; ?>">
                  <?= number_format($row['stok']); ?>
                </td>
                <td class="px-6 py-4 font-medium text-emerald-600">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td class="px-6 py-4 text-center space-x-2">
                  <a href="detail.php?id=<?= $row['id']; ?>" class="text-blue-600 hover:text-blue-800 font-medium text-xs bg-blue-50 hover:bg-blue-100 px-2.5 py-1.5 rounded transition">Detail</a>
                  <a href="edit.php?id=<?= $row['id']; ?>" class="text-amber-600 hover:text-amber-800 font-medium text-xs bg-amber-50 hover:bg-amber-100 px-2.5 py-1.5 rounded transition">Edit</a>
                  <button onclick="confirmDelete(<?= $row['id']; ?>, '<?= htmlspecialchars(addslashes($row['nama_item'])); ?>')" class="text-red-600 hover:text-red-800 font-medium text-xs bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded transition">Hapus</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada data yang ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</main>

<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
  <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6 text-center transform transition-all">
    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
      </svg>
    </div>
    <h3 class="text-lg font-bold text-gray-900 mb-1">Konfirmasi Hapus</h3>
    <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus <span id="deleteItemName" class="font-semibold text-gray-800"></span>?</p>
    <div class="flex justify-center space-x-3">
      <button onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50 transition">Batal</button>
      <form id="deleteForm" method="POST" action="hapus.php">
        <input type="hidden" name="id" id="deleteInputId">
        <button type="submit" id="btnConfirmDelete" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition">Ya, Hapus</button>
      </form>
    </div>
  </div>
</div>

<div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

<?php include 'includes/footer.php'; ?>