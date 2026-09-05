<?php
require_once 'config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $nama_item  = trim($_POST['nama_item'] ?? '');
  $kategori   = trim($_POST['kategori'] ?? '');
  $asal_daerah = trim($_POST['asal_daerah'] ?? '');
  $stok       = filter_var($_POST['stok'] ?? 0, FILTER_VALIDATE_INT);
  $harga      = filter_var($_POST['harga'] ?? 0, FILTER_VALIDATE_FLOAT);
  $deskripsi  = trim($_POST['deskripsi'] ?? '');

  if (empty($nama_item)) $errors[] = "Nama item wajib diisi.";
  if (empty($kategori)) $errors[] = "Kategori wajib dipilih/diisi.";
  if (empty($asal_daerah)) $errors[] = "Asal daerah wajib diisi.";
  if ($stok === false || $stok < 0) $errors[] = "Stok harus berupa angka positif.";
  if ($harga === false || $harga < 0) $errors[] = "Harga harus berupa angka positif.";

  if (empty($errors)) {
    try {
      $stmt = $pdo->prepare("INSERT INTO produk_khas (nama_item, kategori, asal_daerah, stok, harga, deskripsi) VALUES (:nama, :kategori, :asal, :stok, :harga, :deskripsi)");
      $stmt->execute([
        ':nama'      => $nama_item,
        ':kategori'  => $kategori,
        ':asal'      => $asal_daerah,
        ':stok'      => $stok,
        ':harga'     => $harga,
        ':deskripsi' => $deskripsi
      ]);

      header("Location: index.php?status=success_add");
      exit;
    } catch (PDOException $e) {
      $errors[] = "Gagal menyimpan data ke database.";
    }
  }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="max-w-2xl mx-auto px-4 mt-8 flex-grow">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
    <div class="mb-6 border-b border-gray-100 pb-4">
      <h2 class="text-xl font-bold text-gray-800">Tambah Data Produk/Khas Baru</h2>
      <p class="text-sm text-gray-500">Lengkapi formulir di bawah ini dengan benar.</p>
    </div>

    <?php if (!empty($errors)): ?>
      <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded text-sm text-red-700">
        <p class="font-bold mb-1">Periksa kembali inputan Anda:</p>
        <ul class="list-disc list-inside">
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="tambah.php" onsubmit="return validateForm(event)" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item / Produk <span class="text-red-500">*</span></label>
        <input type="text" name="nama_item" id="nama_item" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
          <input type="text" name="kategori" id="kategori" placeholder="misal: Kuliner, Kerajinan" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Asal Daerah <span class="text-red-500">*</span></label>
          <input type="text" name="asal_daerah" id="asal_daerah" placeholder="misal: Jogja, Padang" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
          <input type="number" name="stok" id="stok" min="0" value="0" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
          <input type="number" name="harga" id="harga" min="0" step="500" value="0" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Ringkas</label>
        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm"></textarea>
      </div>

      <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
        <a href="index.php" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Batal</a>
        <button type="submit" id="btnSubmit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">Simpan Data</button>
      </div>
    </form>
  </div>
</main>

<?php include 'includes/footer.php'; ?>