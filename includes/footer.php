<footer class="bg-white border-t border-gray-200 mt-12 py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
    <p class="font-medium text-emerald-700">Project_KHAS – Sistem Informasi Karang Taruna</p>
    <p class="mt-1">Mewujudkan generasi muda yang mandiri, kreatif, dan berjiwa gotong royong.</p>
    <p class="mt-2 text-xs text-gray-400">&copy; <?= date('Y') ?> Karang Taruna. All rights reserved.</p>
  </div>
</footer>

<div id="delete-modal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 space-y-4">
    <div class="flex items-center gap-3 text-red-600">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
      <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
    </div>
    <p class="text-sm text-gray-600" id="delete-modal-text">Apakah Anda yakin ingin menghapus data ini?</p>
    <div class="flex justify-end gap-3">
      <button type="button" id="modal-cancel-btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-300">Batal</button>
      <form id="delete-modal-form" method="POST" action="">
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">Ya, Hapus</button>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>

</html>