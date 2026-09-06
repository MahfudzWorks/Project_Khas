<?php
require_once __DIR__ . '/../config/database.php';
$page_title = "Data Kegiatan";

$search = $_GET['search'] ?? '';
$filter_status = $_GET['status'] ?? '';

$query = "SELECT * FROM kegiatan WHERE 1=1";
$params = [];

if (!empty($search)) {
  $query .= " AND (nama_kegiatan LIKE :search OR lokasi LIKE :search)";
  $params[':search'] = "%$search%";
}
if (!empty($filter_status)) {
  $query .= " AND status = :status";
  $params[':status'] = $filter_status;
}

$query .= " ORDER BY tanggal DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$kegiatan_list = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Agenda & Kegiatan</h1>
      <p class="text-sm text-gray-600">Jadwal kegiatan program kerja Karang Taruna.</p>
    </div>
    <a href="<?= base_url('kegiatan/tambah.php') ?>" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition shadow-sm">
      + Tambah Kegiatan
    </a>
  </div>

  <!-- Filter Form -->
  <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div>
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari Nama Kegiatan / Lokasi..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
      </div>
      <div>
        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
          <option value="">-- Semua Status --</option>
          <?php foreach (['Rencana', 'Akan Dilaksanakan', 'Selesai', 'Dibatalkan'] as $s): ?>
            <option value="<?= $s ?>" <?= $filter_status === $s ? 'selected' : '' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="flex gap-2">
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900">Filter</button>
      </div>
    </form>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if (empty($kegiatan_list)): ?>
      <div class="text-center py-12 px-4">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <p class="mt-2 text-sm text-gray-600 font-medium">Belum ada data kegiatan.</p>
        <a href="<?= base_url('kegiatan/tambah.php') ?>" class="mt-4 inline-block px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-lg hover:bg-emerald-700">+ Tambah Kegiatan Baru</a>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
          <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs tracking-wider">
              <th class="p-4">Nama Kegiatan</th>
              <th class="p-4">Waktu & Lokasi</th>
              <th class="p-4">PJ</th>
              <th class="p-4">Status</th>
              <th class="p-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php foreach ($kegiatan_list as $k): ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="p-4 font-semibold text-gray-900">
                  <a href="<?= base_url('kegiatan/detail.php?id=' . $k['id']) ?>" class="hover:text-emerald-600">
                    <?= htmlspecialchars($k['nama_kegiatan']) ?>
                  </a>
                </td>
                <td class="p-4 text-gray-700">
                  <div><?= format_tanggal($k['tanggal']) ?> - <?= date('H:i', strtotime($k['waktu'])) ?></div>
                  <div class="text-xs text-gray-400"><?= htmlspecialchars($k['lokasi']) ?></div>
                </td>
                <td class="p-4 text-gray-700"><?= htmlspecialchars($k['penanggung_jawab']) ?></td>
                <td class="p-4">
                  <span class="px-2.5 py-1 text-xs rounded-full font-semibold 
                                        <?= $k['status'] === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : ($k['status'] === 'Akan Dilaksanakan' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') ?>">
                    <?= $k['status'] ?>
                  </span>
                </td>
                <td class="p-4 text-center space-x-2">
                  <a href="<?= base_url('kegiatan/detail.php?id=' . $k['id']) ?>" class="text-blue-600 hover:text-blue-800 font-medium text-xs">Detail</a>
                  <a href="<?= base_url('kegiatan/edit.php?id=' . $k['id']) ?>" class="text-amber-600 hover:text-amber-800 font-medium text-xs">Edit</a>
                  <button type="button" data-delete-url="<?= base_url('kegiatan/hapus.php?id=' . $k['id']) ?>" data-delete-title="Kegiatan: <?= htmlspecialchars($k['nama_kegiatan']) ?>" class="btn-delete text-red-600 hover:text-red-800 font-medium text-xs">Hapus</button>
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