<?php
require_once __DIR__ . '/../config/database.php';
$page_title = "Edit Kegiatan";

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_kegiatan    = trim($_POST['nama_kegiatan'] ?? '');
  $tanggal          = $_POST['tanggal'] ?? '';
  $waktu            = $_POST['waktu'] ?? '';
  $lokasi           = trim($_POST['lokasi'] ?? '');
  $penanggung_jawab = trim($_POST['penanggung_jawab'] ?? '');
  $deskripsi        = trim($_POST['deskripsi'] ?? '');
  $status           = $_POST['status'] ?? 'Rencana';

  if (!empty($nama_kegiatan) && !empty($tanggal)) {
    $stmt = $pdo->prepare("UPDATE kegiatan SET nama_kegiatan = ?, tanggal = ?, waktu = ?, lokasi = ?, penanggung_jawab = ?, deskripsi = ?, status = ? WHERE id = ?");
    $stmt->execute([$nama_kegiatan, $tanggal, $waktu, $lokasi, $penanggung_jawab, $deskripsi, $status, $id]);
    header("Location: " . base_url('kegiatan/index.php?msg=updated'));
    exit;
  }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 flex-grow">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Kegiatan</h1>
    <p class="text-sm text-gray-600">Perbarui jadwal atau perincian kegiatan.</p>
  </div>

  <form method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4 js-validate-form">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan *</label>
      <input type="text" name="nama_kegiatan" value="<?= htmlspecialchars($kegiatan['nama_kegiatan']) ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelaksanaan *</label>
        <input type="date" name="tanggal" value="<?= $kegiatan['tanggal'] ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
        <input type="time" name="waktu" value="<?= $kegiatan['waktu'] ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
        <input type="text" name="lokasi" value="<?= htmlspecialchars($kegiatan['lokasi']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Penanggung Jawab (PJ)</label>
        <input type="text" name="penanggung_jawab" value="<?= htmlspecialchars($kegiatan['penanggung_jawab']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Status Kegiatan</label>
      <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
        <?php foreach (['Rencana', 'Akan Dilaksanakan', 'Selesai', 'Dibatalkan'] as $s): ?>
          <option value="<?= $s ?>" <?= $kegiatan['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kegiatan</label>
      <textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"><?= htmlspecialchars($kegiatan['deskripsi']) ?></textarea>
    </div>

    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
      <a href="<?= base_url('kegiatan/index.php') ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
      <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700">Perbarui Kegiatan</button>
    </div>
  </form>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>