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

include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="max-w-2xl mx-auto px-4 mt-8 flex-grow">
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-6">
      <div>
        <span class="text-xs uppercase font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">
          <?= htmlspecialchars($data['kategori']); ?>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 mt-2"><?= htmlspecialchars($data['nama_item']); ?></h1>
      </div>
      <span class="text-sm font-medium text-gray-500">ID: #<?= $data['id']; ?></span>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
      <div>
        <p class="text-xs text-gray-500 uppercase font-semibold">Asal Daerah</p>
        <p class="text-sm font-medium text-gray-800 mt-1"><?= htmlspecialchars($data['asal_daerah']); ?></p>
      </div>
      <div>
        <p class="text-xs text-gray-500 uppercase font-semibold">Stok Tersedia</p>
        <p class="text-sm font-medium text-gray-800 mt-1"><?= number_format($data['stok']); ?> unit</p>
      </div>
      <div>
        <p class="text-xs text-gray-500 uppercase font-semibold">Harga</p>
        <p class="text-base font-bold text-emerald-600 mt-1">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></p>
      </div>
      <div>
        <p class="text-xs text-gray-500 uppercase font-semibold">Terakhir Diperbarui</p>
        <p class="text-xs font-medium text-gray-600 mt-1"><?= date('d M Y, H:i', strtotime($data['updated_at'])); ?></p>
      </div>
    </div>

    <div class="mb-6">
      <h3 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi</h3>
      <p class="text-sm text-gray-600 leading-relaxed bg-white p-3 border border-gray-100 rounded-lg">
        <?= !empty($data['deskripsi']) ? nl2br(htmlspecialchars($data['deskripsi'])) : '<em class="text-gray-400">Tidak ada deskripsi.</em>'; ?>
      </p>
    </div>

    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
      <a href="index.php" class="text-sm text-gray-600 hover:text-gray-800 font-medium">← Kembali ke Dashboard</a>
      <div class="space-x-2">
        <a href="edit.php?id=<?= $data['id']; ?>" class="bg-amber-50 text-amber-700 hover:bg-amber-100 px-4 py-2 rounded-lg text-sm font-medium transition">Edit Data</a>
      </div>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>