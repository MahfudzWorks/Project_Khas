<?php
require_once __DIR__ . '/../config/database.php';
$page_title = "Data Anggota";

// Search & Filter
$search = $_GET['search'] ?? '';
$filter_jabatan = $_GET['jabatan'] ?? '';
$filter_status = $_GET['status'] ?? '';

$query = "SELECT * FROM anggota WHERE 1=1";
$params = [];

if (!empty($search)) {
  $query .= " AND (nama LIKE :search OR no_hp LIKE :search)";
  $params[':search'] = "%$search%";
}
if (!empty($filter_jabatan)) {
  $query .= " AND jabatan = :jabatan";
  $params[':jabatan'] = $filter_jabatan;
}
if (!empty($filter_status)) {
  $query .= " AND status = :status";
  $params[':status'] = $filter_status;
}

$query .= " ORDER BY nama ASC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$anggota_list = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Data Anggota Karang Taruna</h1>
      <p class="text-sm text-gray-600">Kelola informasi seluruh anggota dan pengurus.</p>
    </div>
    <a href="<?= base_url('anggota/tambah.php') ?>" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition shadow-sm">
      + Tambah Anggota
    </a>
  </div>

  <!-- Filter Form -->
  <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div>
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari Nama / No HP..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <select name="jabatan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="">-- Semua Jabatan --</option>
          <?php foreach (['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator', 'Anggota'] as $j): ?>
            <option value="<?= $j ?>" <?= $filter_jabatan === $j ? 'selected' : '' ?>><?= $j ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="flex gap-2">
        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="">-- Semua Status --</option>
          <option value="Aktif" <?= $filter_status === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
          <option value="Tidak Aktif" <?= $filter_status === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900">Filter</button>
      </div>
    </form>
  </div>

  <!-- Tabel Data -->
  <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if (empty($anggota_list)): ?>
      <div class="text-center py-12 px-4">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <p class="mt-2 text-sm text-gray-600 font-medium">Belum ada data anggota.</p>
        <a href="<?= base_url('anggota/tambah.php') ?>" class="mt-4 inline-block px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-lg hover:bg-emerald-700">+ Tambah Anggota Pertama</a>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
          <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs tracking-wider">
              <th class="p-4">Nama Lengkap</th>
              <th class="p-4">Jabatan</th>
              <th class="p-4">No. HP</th>
              <th class="p-4">Tahun Masuk</th>
              <th class="p-4">Status</th>
              <th class="p-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php foreach ($anggota_list as $a): ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="p-4 font-semibold text-gray-900">
                  <a href="<?= base_url('anggota/detail.php?id=' . $a['id']) ?>" class="hover:text-emerald-600">
                    <?= htmlspecialchars($a['nama']) ?>
                  </a>
                  <div class="text-xs text-gray-400 font-normal"><?= htmlspecialchars($a['jenis_kelamin']) ?></div>
                </td>
                <td class="p-4 text-gray-700"><?= htmlspecialchars($a['jabatan']) ?></td>
                <td class="p-4 text-gray-700"><?= htmlspecialchars($a['no_hp']) ?></td>
                <td class="p-4 text-gray-700"><?= htmlspecialchars($a['tahun_bergabung']) ?></td>
                <td class="p-4">
                  <span class="px-2.5 py-1 text-xs rounded-full font-semibold <?= $a['status'] === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' ?>">
                    <?= $a['status'] ?>
                  </span>
                </td>
                <td class="p-4 text-center space-x-2">
                  <a href="<?= base_url('anggota/detail.php?id=' . $a['id']) ?>" class="text-blue-600 hover:text-blue-800 font-medium text-xs">Detail</a>
                  <a href="<?= base_url('anggota/edit.php?id=' . $a['id']) ?>" class="text-amber-600 hover:text-amber-800 font-medium text-xs">Edit</a>
                  <button type="button" data-delete-url="<?= base_url('anggota/hapus.php?id=' . $a['id']) ?>" data-delete-title="Anggota: <?= htmlspecialchars($a['nama']) ?>" class="btn-delete text-red-600 hover:text-red-800 font-medium text-xs">Hapus</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>