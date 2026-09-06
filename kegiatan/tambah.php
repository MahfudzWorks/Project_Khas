<?php
require_once __DIR__ . '/../config/database.php';
$page_title = "Tambah Kegiatan";

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_kegiatan    = trim($_POST['nama_kegiatan'] ?? '');
  $tanggal          = $_POST['tanggal'] ?? '';
  $waktu            = $_POST['waktu'] ?? '';
  $lokasi           = trim($_POST['lokasi'] ?? '');
  $penanggung_jawab = trim($_POST['penanggung_jawab'] ?? '');
  $deskripsi        = trim($_POST['deskripsi'] ?? '');
  $status           = $_POST['status'] ?? 'Rencana';

  if (empty($nama_kegiatan)) $errors[] = "Nama kegiatan wajib diisi.";
  if (empty($tanggal)) $errors[] = "Tanggal wajib diisi.";

  if (empty($errors)) {
    $stmt = $pdo->prepare("INSERT INTO kegiatan (nama_kegiatan, tanggal, waktu, lokasi, penanggung_jawab, deskripsi, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama_kegiatan, $tanggal, $waktu, $lokasi, $penanggung_jawab, $deskripsi, $status]);
    header("Location: " . base_url('kegiatan/index.php?msg=added'));
    exit;
  }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 flex-grow">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Buat Agenda Kegiatan</h1>
    <p class="text-sm text-gray-600">Jadwalkan program kegiatan baru Karang Taruna.</p>
  </div>

  <form method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4 js-validate-form">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan *</label>
      <input type="text" name="nama_kegiatan" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelaksanaan *</label>
        <input type="date" name="tanggal" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
        <input type="time" name="waktu" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
        <input type="text" name="lokasi" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Penanggung Jawab (PJ)</label>
        <input type="text" name="penanggung_jawab" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Status Kegiatan</label>
      <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
        <option value="Rencana">Rencana</option>
        <option value="Akan Dilaksanakan">Akan Dilaksanakan</option>
        <option value="Selesai">Selesai</option>
        <option value="Dibatalkan">Dibatalkan</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kegiatan</label>
      <textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
    </div>

    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
      <a href="<?= base_url('kegiatan/index.php') ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
      <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700">Simpan Kegiatan</button>
    </div>
  </form>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>