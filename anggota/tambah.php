<?php
require_once __DIR__ . '/../config/database.php';
$page_title = "Tambah Anggota";

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
  if (empty($jenis_kelamin)) $errors[] = "Jenis kelamin wajib dipilih.";
  if (empty($tanggal_lahir)) $errors[] = "Tanggal lahir wajib diisi.";

  if (empty($errors)) {
    $stmt = $pdo->prepare("INSERT INTO anggota (nama, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_hp, jabatan, status, tahun_bergabung) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $alamat, $no_hp, $jabatan, $status, $tahun_bergabung]);
    header("Location: " . base_url('anggota/index.php?msg=added'));
    exit;
  }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 flex-grow">
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Anggota Baru</h1>
    <p class="text-sm text-gray-600">Isi formulir di bawah ini untuk menambahkan anggota Karang Taruna.</p>
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
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
      <input type="text" name="nama" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
        <select name="jenis_kelamin" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="">-- Pilih --</option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP / Whatsapp</label>
        <input type="text" name="no_hp" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
        <input type="date" name="tanggal_lahir" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
      <textarea name="alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
        <select name="jabatan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <?php foreach (['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator', 'Anggota'] as $j): ?>
            <option value="<?= $j ?>"><?= $j ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="Aktif">Aktif</option>
          <option value="Tidak Aktif">Tidak Aktif</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Bergabung</label>
        <input type="number" name="tahun_bergabung" value="<?= date('Y') ?>" min="2000" max="2099" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
    </div>

    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
      <a href="<?= base_url('anggota/index.php') ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
      <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700">Simpan Anggota</button>
    </div>
  </form>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>