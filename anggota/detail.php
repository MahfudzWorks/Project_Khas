<?php
require_once __DIR__ . '/../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
  header("Location: " . base_url('anggota/index.php'));
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = ?");
$stmt->execute([$id]);
$anggota = $stmt->fetch();

if (!$anggota) {
  header("Location: " . base_url('anggota/index.php'));
  exit;
}

$page_title = "Detail " . $anggota['nama'];
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 flex-grow">
  <div class="mb-6 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Detail Anggota</h1>
      <p class="text-sm text-gray-600">Informasi profil lengkap anggota Karang Taruna.</p>
    </div>
    <a href="<?= base_url('anggota/index.php') ?>" class="text-sm text-emerald-600 font-semibold hover:underline">&larr; Kembali</a>
  </div>

  <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="bg-emerald-700 p-6 text-white flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold"><?= htmlspecialchars($anggota['nama']) ?></h2>
        <p class="text-emerald-100 text-sm"><?= htmlspecialchars($anggota['jabatan']) ?></p>
      </div>
      <span class="px-3 py-1 text-xs rounded-full font-bold bg-white text-emerald-800">
        <?= $anggota['status'] ?>
      </span>
    </div>

    <div class="p-6 space-y-4 text-sm text-gray-700">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-b border-gray-100 pb-4">
        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase">Jenis Kelamin</span>
          <span class="font-medium"><?= htmlspecialchars($anggota['jenis_kelamin']) ?></span>
        </div>
        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase">No. HP / WA</span>
          <span class="font-medium"><?= htmlspecialchars($anggota['no_hp']) ?: '-' ?></span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-b border-gray-100 pb-4">
        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase">Tempat, Tanggal Lahir</span>
          <span class="font-medium"><?= htmlspecialchars($anggota['tempat_lahir']) ?>, <?= format_tanggal($anggota['tanggal_lahir']) ?></span>
        </div>
        <div>
          <span class="block text-xs font-semibold text-gray-400 uppercase">Tahun Bergabung</span>
          <span class="font-medium"><?= htmlspecialchars($anggota['tahun_bergabung']) ?></span>
        </div>
      </div>

      <div>
        <span class="block text-xs font-semibold text-gray-400 uppercase">Alamat</span>
        <p class="font-medium mt-1"><?= nl2br(htmlspecialchars($anggota['alamat'])) ?: '-' ?></p>
      </div>
    </div>

    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
      <a href="<?= base_url('anggota/edit.php?id=' . $anggota['id']) ?>" class="px-4 py-2 bg-amber-600 text-white rounded-lg text-xs font-semibold hover:bg-amber-700">Edit Profil</a>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>