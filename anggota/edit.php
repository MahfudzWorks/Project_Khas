<?php
require_once __DIR__ . '/../config/database.php';
$page_title = "Edit Anggota";

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

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama            = trim($_POST['nama'] ?? '');
  $jenis_kelamin   = $_POST['jenis_kelamin'] ?? '';
  $tempat_lahir    = trim($_POST['tempat_lahir'] ?? '');
  $tanggal_lahir   = $_POST['tanggal_lahir'] ?? '';
  $alamat          = trim($_POST['alamat'] ?? '');
  $no_hp           = trim($_POST['no_hp'] ?? '');
  $jabatan         = $_POST['jabatan'] ?? 'Anggota';
  $status          = $_POST['status'] ?? 'Aktif';
  $tahun_bergabung = $_POST['tahun_bergabung'] ?? date('Y');

  if (empty($nama)) $errors[] = "Nama lengkap wajib diisi.";

  if (empty($errors)) {
    $stmt = $pdo->prepare("UPDATE anggota SET nama = ?, jenis_kelamin = ?, tempat_lahir = ?, tanggal_lahir = ?, alamat = ?, no_hp = ?, jabatan = ?, status = ?, tahun_bergabung = ? WHERE id = ?");
    $stmt->execute([$nama, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $alamat, $no_hp, $jabatan, $status, $tahun_bergabung, $id]);
    header("Location: " . base_url('anggota/index.php?msg=updated'));
    exit;
  }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 flex-grow">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Data Anggota</h1>
    <p class="text-sm text-gray-600">Perbarui informasi anggota Karang Taruna.</p>
  </div>

  <form method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4 js-validate-form">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
      <input type="text" name="nama" value="<?= htmlspecialchars($anggota['nama']) ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
        <select name="jenis_kelamin" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="Laki-laki" <?= $anggota['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
          <option value="Perempuan" <?= $anggota['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP / Whatsapp</label>
        <input type="text" name="no_hp" value="<?= htmlspecialchars($anggota['no_hp']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($anggota['tempat_lahir']) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
        <input type="date" name="tanggal_lahir" value="<?= $anggota['tanggal_lahir'] ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
      <textarea name="alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"><?= htmlspecialchars($anggota['alamat']) ?></textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
        <select name="jabatan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <?php foreach (['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator', 'Anggota'] as $j): ?>
            <option value="<?= $j ?>" <?= $anggota['jabatan'] === $j ? 'selected' : '' ?>><?= $j ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="Aktif" <?= $anggota['status'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
          <option value="Tidak Aktif" <?= $anggota['status'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Bergabung</label>
        <input type="number" name="tahun_bergabung" value="<?= $anggota['tahun_bergabung'] ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
      <a href="<?= base_url('anggota/index.php') ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
      <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700">Perbarui Anggota</button>
    </div>
  </form>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>