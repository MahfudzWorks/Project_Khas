<?php
require_once __DIR__ . '/../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
  header("Location: " . base_url('kegiatan/index.php'));
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM kegiatan WHERE id = ?");
$stmt->execute([$id]);
$kegiatan = $stmt->fetch();

if (!$kegiatan) {
  header("Location: " . base_url('kegiatan/index.php'));
  exit;
}

$page_title = "Detail Kegiatan";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 flex-grow">
  <div class="mb-6 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Detail Kegiatan</h1>
      <p class="text-sm text-gray-600">Rincian pelaksanaan agenda organisasi.</p>
    </div>
    <a href="<?= base_url('kegiatan/index.php') ?>" class="text-sm text-emerald-600 font-semibold hover:underline">&larr; Kembali</a>
  </div>

  <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
      <span class="px-3 py-1 text-xs rounded-full font-bold bg-emerald-100 text-emerald-800">
        <?= $kegiatan['status'] ?>
      </span>
      <h2 class="text-2xl font-bold text-gray-900 mt-2"><?= htmlspecialchars($kegiatan['nama_kegiatan']) ?></h2>
    </div>

    <div class="p-6 space-y-4 text-sm text-gray-700">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-b border-gray-100 pb-4">
        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase">Waktu Pelaksanaan</span>
          <span class="font-medium"><?= format_tanggal($kegiatan['tanggal']) ?> - <?= date('H:i', strtotime($kegiatan['waktu'])) ?> WIB</span>
        </div>
        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase">Lokasi</span>
          <span class="font-medium"><?= htmlspecialchars($kegiatan['lokasi']) ?: '-' ?></span>
        </div>
      </div>

      <div class="border-b border-gray-100 pb-4">
        <span class="block text-xs font-semibold text-gray-400 uppercase">Penanggung Jawab</span>
        <span class="font-medium text-gray-900"><?= htmlspecialchars($kegiatan['penanggung_jawab']) ?: '-' ?></span>
      </div>

      <div>
        <span class="block text-xs font-semibold text-gray-400 uppercase mb-1">Deskripsi</span>
        <p class="leading-relaxed text-gray-600"><?= nl2br(htmlspecialchars($kegiatan['deskripsi'])) ?: 'Tidak ada deskripsi.' ?></p>
      </div>
    </div>

    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
      <a href="<?= base_url('kegiatan/edit.php?id=' . $kegiatan['id']) ?>" class="px-4 py-2 bg-amber-600 text-white rounded-lg text-xs font-semibold hover:bg-amber-700">Edit Kegiatan</a>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>