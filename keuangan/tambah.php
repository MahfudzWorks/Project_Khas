<?php
require_once __DIR__ . '/../config/database.php';
$page_title = "Tambah Transaksi Keuangan";

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tanggal    = $_POST['tanggal'] ?? '';
  $jenis      = $_POST['jenis'] ?? '';
  $kategori   = trim($_POST['kategori'] ?? '');
  $keterangan = trim($_POST['keterangan'] ?? '');
  $nominal    = filter_input(INPUT_POST, 'nominal', FILTER_VALIDATE_FLOAT);

  if (empty($tanggal)) $errors[] = "Tanggal transaksi wajib diisi.";
  if (empty($jenis)) $errors[] = "Jenis transaksi wajib dipilih.";
  if (empty($kategori)) $errors[] = "Kategori wajib diisi.";
  if ($nominal === false || $nominal <= 0) $errors[] = "Nominal harus berupa angka lebih dari 0.";

  if (empty($errors)) {
    $stmt = $pdo->prepare("INSERT INTO keuangan (tanggal, jenis, kategori, keterangan, nominal) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$tanggal, $jenis, $kategori, $keterangan, $nominal]);
    header("Location: " . base_url('keuangan/index.php?msg=added'));
    exit;
  }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 flex-grow">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Catat Transaksi Keuangan</h1>
    <p class="text-sm text-gray-600">Catat arus uang masuk atau keluar kas Karang Taruna.</p>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
      <ul class="list-disc list-inside text-sm text-red-700">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4 js-validate-form">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi *</label>
        <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi *</label>
        <select name="jenis" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="">-- Pilih --</option>
          <option value="Pemasukan">Pemasukan (+)</option>
          <option value="Pengeluaran">Pengeluaran (-)</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
        <input type="text" name="kategori" placeholder="Contoh: Iuran, Konsumsi, Sponsor" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp) *</label>
        <input type="number" name="nominal" min="1" step="any" placeholder="100000" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Catatan</label>
      <textarea name="keterangan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
    </div>

    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
      <a href="<?= base_url('keuangan/index.php') ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
      <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700">Simpan Transaksi</button>
    </div>
  </form>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>