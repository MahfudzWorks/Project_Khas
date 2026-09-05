<?php
require_once 'config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
  header("Location: index.php");
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM produk_khas WHERE id = :id");
$stmt->execute([':id' => $id]);
$data = $stmt->fetch();

if (!$data) {
  header("Location: index.php");
  exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_item   = trim($_POST['nama_item'] ?? '');
  $kategori    = trim($_POST['kategori'] ?? '');
  $asal_daerah = trim($_POST['asal_daerah'] ?? '');
  $stok        = filter_var($_POST['stok'] ?? 0, FILTER_VALIDATE_INT);
  $harga       = filter_var($_POST['harga'] ?? 0, FILTER_VALIDATE_FLOAT);
  $deskripsi   = trim($_POST['deskripsi'] ?? '');

  if (empty($nama_item)) $errors[] = "Nama item wajib diisi.";
  if (empty($kategori)) $errors[] = "Kategori wajib diisi.";
  if (empty($asal_daerah)) $errors[] = "Asal daerah wajib diisi.";
  if ($stok === false || $stok < 0) $errors[] = "Stok tidak valid.";
  if ($harga === false || $harga < 0) $errors[] = "Harga tidak valid.";

  if (empty($errors)) {
    try {
      $updateStmt = $pdo->prepare("UPDATE produk_khas SET nama_item = :nama, kategori = :kategori, asal_daerah = :asal, stok = :stok, harga = :harga, deskripsi = :deskripsi WHERE id = :id");
      $updateStmt->execute([
        ':nama'      => $nama_item,
        ':kategori'  => $kategori,
        ':asal'      => $asal_daerah,
        ':stok'      => $stok,
        ':harga'     => $harga,
        ':deskripsi' => $deskripsi,
        ':id'        => $id
      ]);

      header("Location: index.php?status=success_edit");
      exit;
    } catch (PDOException $e) {
      $errors[] = "Gagal memperbarui data.";
    }
  }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="max-w-2xl mx-auto px-4 mt-8 flex-grow">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
    <div class="mb-6 border-b border-gray-100 pb-4">
      <h2 class="text-xl font-bold text-gray-800">Edit Data Produk</h2>
      <p class="text-sm text-gray-500">Perbarui data produk #<?= $data['id']; ?></p>
    </div>

    <?php if (!empty($errors)): ?>
      <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded text-sm text-red-700">
        <ul class="list-disc list-inside">
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?= $id; ?>" onsubmit="return validateForm(event)" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item / Produk</label>
        <input type="text" name="nama_item" id="nama_item" value="<?= htmlspecialchars($data['nama_item']); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
          <input type="text" name="kategori" id="kategori" value="<?= htmlspecialchars($data['kategori']); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Asal Daerah</label>
          <input type="text" name="asal_daerah" id="asal_daerah" value="<?= htmlspecialchars($data['asal_daerah']); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
          <input type="number" name="stok" id="stok" min="0" value="<?= htmlspecialchars($data['stok']); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
          <input type="number" name="harga" id="harga" min="0" step="500" value="<?= htmlspecialchars($data['harga']); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Ringkas</label>
        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
      </div>

      <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
        <a href="index.php" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Batal</a>
        <button type="submit" id="btnSubmit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">Perbarui Data</button>
      </div>
    </form>
  </div>
</main>

<?php include 'includes/footer.php'; ?>