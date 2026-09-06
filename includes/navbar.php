<header class="bg-emerald-700 text-white shadow-md sticky top-0 z-40">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">

      <a href="<?= base_url('index.php') ?>" class="flex items-center gap-3 group">
        <div class="bg-white text-emerald-700 p-2 rounded-lg font-black text-xl tracking-wider group-hover:scale-105 transition">
          KHAS
        </div>
        <div>
          <div class="font-bold text-lg leading-tight">Project_KHAS</div>
          <div class="text-xs text-emerald-200">Sistem Informasi Karang Taruna</div>
        </div>
      </a>

      <nav class="hidden md:flex space-x-1">
        <?php
        $current_uri = $_SERVER['REQUEST_URI'];
        $nav_items = [
          'Dashboard' => 'index.php',
          'Anggota' => 'anggota/index.php',
          'Kegiatan' => 'kegiatan/index.php',
          'Keuangan' => 'keuangan/index.php',
        ];
        foreach ($nav_items as $name => $link):
          $full_link = base_url($link);
          $is_active = (strpos($current_uri, str_replace('index.php', '', $link)) !== false && $link !== 'index.php') || ($link === 'index.php' && (basename($current_uri) === 'index.php' || basename($current_uri) === 'Project_Khas'));
          $active_class = $is_active ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-600 hover:text-white';
        ?>
          <a href="<?= $full_link ?>" class="px-4 py-2 rounded-md text-sm font-medium transition <?= $active_class ?>">
            <?= $name ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <div class="md:hidden flex items-center">
        <button id="mobile-menu-btn" type="button" class="text-emerald-200 hover:text-white focus:outline-none p-2 rounded-md">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <div id="mobile-menu" class="hidden md:hidden bg-emerald-800 px-2 pt-2 pb-3 space-y-1 sm:px-3">
    <?php foreach ($nav_items as $name => $link): ?>
      <a href="<?= base_url($link) ?>" class="block px-3 py-2 rounded-md text-base font-medium text-emerald-100 hover:bg-emerald-700 hover:text-white">
        <?= $name ?>
      </a>
    <?php endforeach; ?>
  </div>
</header>