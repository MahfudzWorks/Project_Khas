<header class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 text-slate-800 dark:text-slate-100 sticky top-0 z-40 transition-colors duration-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">

      <!-- Logo & Brand -->
      <a href="<?= base_url('index.php') ?>" class="flex items-center gap-3 group">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-2 rounded-xl font-black text-lg tracking-wider shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform duration-200">
          KHAS
        </div>
        <div>
          <div class="font-bold text-base leading-tight text-slate-900 dark:text-white">Project_KHAS</div>
          <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">Karang Taruna Balongmojo Kulon</div>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-1">
        <?php
        $current_uri = $_SERVER['REQUEST_URI'];
        $nav_items = [
          'Dashboard' => 'index.php',
          'Anggota'   => 'anggota/index.php',
          'Kegiatan'  => 'kegiatan/index.php',
          'Keuangan'  => 'keuangan/index.php',
        ];

        foreach ($nav_items as $name => $link):
          $full_link = base_url($link);

          $is_active = false;
          if ($link === 'index.php') {
            $is_active = (basename($current_uri) === 'index.php' || basename($current_uri) === 'Project_Khas' || basename($current_uri) === '');
          } else {
            $folder_name = explode('/', $link)[0];
            $is_active = (strpos($current_uri, '/' . $folder_name . '/') !== false);
          }

          $active_class = $is_active
            ? 'bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-semibold'
            : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white font-medium';
        ?>
          <a href="<?= $full_link ?>" class="px-4 py-2 rounded-xl text-sm transition-all duration-150 <?= $active_class ?>">
            <?= $name ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <!-- Mobile Menu Button -->
      <div class="md:hidden flex items-center">
        <button id="mobile-menu-btn" type="button" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white focus:outline-none p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

    </div>
  </div>

  <!-- Mobile Dropdown Menu -->
  <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 px-4 pt-2 pb-4 space-y-1 shadow-lg">
    <?php foreach ($nav_items as $name => $link):
      $folder_name = explode('/', $link)[0];
      $is_active = ($link === 'index.php')
        ? (basename($current_uri) === 'index.php' || basename($current_uri) === '')
        : (strpos($current_uri, '/' . $folder_name . '/') !== false);

      $mobile_active_class = $is_active
        ? 'bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-bold'
        : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800';
    ?>
      <a href="<?= base_url($link) ?>" class="block px-3 py-2.5 rounded-xl text-base transition <?= $mobile_active_class ?>">
        <?= $name ?>
      </a>
    <?php endforeach; ?>
  </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');

    if (btn && menu) {
      btn.addEventListener('click', function() {
        menu.classList.toggle('hidden');
      });
    }
  });
</script>