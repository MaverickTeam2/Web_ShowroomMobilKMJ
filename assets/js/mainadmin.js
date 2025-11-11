/* ==========================================================================
   Main Admin (Non-SPA) + Sidebar Toggle + Dark Mode
   --------------------------------------------------------------------------
   - Tidak intercept link (no preventDefault pada <a> ke halaman)
   - Highlight menu aktif
   - Dropdown submenu aman
   - Toggle sidebar (persist ke localStorage)
   - Dark mode (auto-detect + persist ke localStorage)
   ========================================================================== */

(function () {
  'use strict';

  // ====== Storage helpers ==================================================
  var storage = {
    get(key, fallback) {
      try { const v = localStorage.getItem(key); return v === null ? fallback : JSON.parse(v); }
      catch (_) { return fallback; }
    },
    set(key, value) {
      try { localStorage.setItem(key, JSON.stringify(value)); } catch (_) { /* noop */ }
    }
  };

  // ====== THEME / DARK MODE ===============================================
  var THEME_KEY = 'ui:theme';           // "dark" | "light"
  var SIDEBAR_KEY = 'ui:sidebar:collapsed'; // true | false

  function applyTheme(theme) {
    // Pakai class 'dark' di <html> (compatible dengan Tailwind/umum)
    var root = document.documentElement;
    if (theme === 'dark') root.classList.add('dark');
    else root.classList.remove('dark');
  }

  function initTheme() {
    // 1) Baca preferensi tersimpan
    var saved = storage.get(THEME_KEY, null);
    // 2) Jika belum ada, pakai preferensi OS
    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    var theme = saved || (prefersDark ? 'dark' : 'light');
    applyTheme(theme);
  }

  function toggleTheme() {
    var currentDark = document.documentElement.classList.contains('dark');
    var next = currentDark ? 'light' : 'dark';
    applyTheme(next);
    storage.set(THEME_KEY, next);
  }

  // ====== SIDEBAR TOGGLE ===================================================
  function applySidebarCollapsed(collapsed) {
    // Tambahkan class di body/elemen sidebar sesuai CSS kamu
    document.body.classList.toggle('sidebar-collapsed', !!collapsed);
    var sidebar = document.querySelector('#sidebar');
    if (sidebar) sidebar.classList.toggle('collapsed', !!collapsed);
  }

  function initSidebarState() {
    var collapsed = storage.get(SIDEBAR_KEY, false);
    applySidebarCollapsed(collapsed);
  }

  function toggleSidebar() {
    var next = !document.body.classList.contains('sidebar-collapsed');
    applySidebarCollapsed(next);
    storage.set(SIDEBAR_KEY, next);
  }

  // ====== MENU HIGHLIGHT (Non-SPA) ========================================
  function getCurrentFilename() {
    try {
      var path = window.location.pathname || '';
      var file = path.split('/').pop();
      return file && file.length ? file : 'index.php';
    } catch (e) {
      return 'index.php';
    }
  }

  function normalize(href) {
    href = (href || '').split('#')[0].split('?')[0];
    var file = href.split('/').pop();
    return file || href || '';
  }

  function highlightSidebarByHref(current) {
    var sidebar = document.querySelector('#sidebar');
    if (!sidebar) return;

    var links = sidebar.querySelectorAll('.side-menu a, a.side-link, nav a');
    links.forEach(function (a) {
      var href = a.getAttribute('href') || '';
      var li = a.closest('li');
      if (normalize(href) === normalize(current)) {
        a.classList.add('active');
        if (li) li.classList.add('active');
        var parent = a.closest('.has-sub, .dropdown, .menu-group');
        if (parent) parent.classList.add('open');
      } else {
        a.classList.remove('active');
        if (li) li.classList.remove('active');
      }
    });
  }

  // ====== DROPDOWN SUBMENU (tidak ganggu link halaman) =====================
  function initSidebarDropdowns() {
    var toggles = document.querySelectorAll('#sidebar .has-sub > a, #sidebar .dropdown > a');
    toggles.forEach(function (t) {
      t.addEventListener('click', function (e) {
        var href = (t.getAttribute('href') || '').trim();
        var isToggle =
          t.dataset.toggle === 'submenu' ||
          href === '' || href === '#' ||
          t.getAttribute('role') === 'button';

        if (isToggle) {
          e.preventDefault();
          var parent = t.closest('.has-sub, .dropdown');
          if (parent) parent.classList.toggle('open');
        }
        // Jika href mengarah ke halaman nyata -> biarkan browser navigasi normal (full reload)
      });
    });
  }

  // ====== UI WIRING (buttons & overlays) ===================================
  function wireUI() {
    // Tombol toggle sidebar:
    //   - <button id="btn-toggle-sidebar">, atau
    //   - <button data-action="toggle-sidebar">
    var btnSidebar = document.querySelector('#btn-toggle-sidebar, [data-action="toggle-sidebar"]');
    if (btnSidebar) btnSidebar.addEventListener('click', function (e) {
      e.preventDefault();
      toggleSidebar();
    });

    // (Opsional) overlay untuk close sidebar di mobile
    var overlay = document.querySelector('#sidebar-overlay');
    if (overlay) overlay.addEventListener('click', function () {
      if (document.body.classList.contains('sidebar-collapsed')) return;
      // Jika desainmu kebalik (collapsed = kecil), sesuaikan logic ini
      // Contoh: di mobile kita tutup (set collapsed = true)
      applySidebarCollapsed(true);
      storage.set(SIDEBAR_KEY, true);
    });

    // Tombol dark mode:
    //   - <button id="btn-toggle-dark">, atau
    //   - <button data-action="toggle-dark">
    var btnDark = document.querySelector('#btn-toggle-dark, [data-action="toggle-dark"]');
    if (btnDark) btnDark.addEventListener('click', function (e) {
      e.preventDefault();
      toggleTheme();
    });
  }

  // ====== Breadcrumb Dinamis (global) ==================================
function initBreadcrumbFromActiveLink(optionalHtml) {
  var breadcrumb = document.querySelector('.breadcrumb');
  if (!breadcrumb) return;

  // Jika kita memuat halaman via fetch (optionalHtml dikirim)
  // maka kita ambil breadcrumb dari halaman tersebut
  if (optionalHtml) {
    const temp = document.createElement('div');
    temp.innerHTML = optionalHtml.trim();
    const newBreadcrumb = temp.querySelector('.breadcrumb');
    if (newBreadcrumb) {
      breadcrumb.innerHTML = newBreadcrumb.innerHTML;
      return; // stop di sini kalau halaman punya breadcrumb sendiri
    }
  }

  // Kalau tidak ada breadcrumb di halaman yang dimuat,
  // pakai deteksi dari sidebar (default behaviour)
  var activeTextEl =
    document.querySelector('#sidebar .side-menu a.active .text') ||
    document.querySelector('#sidebar .side-menu a.active') ||
    document.querySelector('#sidebar a.active');

  var name = (activeTextEl && (activeTextEl.textContent || '').trim()) || 'Dashboard';

  breadcrumb.innerHTML =
    '<li><a href="dashboard.php">Home</a></li>' +
    '<li><i class="bx bx-chevron-right"></i></li>' +
    '<li>' + escapeHtml(name) + '</li>';
}

// pastikan fungsi tersedia di global (opsional tapi aman)
window.initBreadcrumbFromActiveLink = initBreadcrumbFromActiveLink;



  function escapeHtml(s) {
    return String(s)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  // ====== BOOT =============================================================
  document.addEventListener('DOMContentLoaded', function () {
    // Theme & sidebar state
    initTheme();
    initSidebarState();

    // Nav (non-SPA)
    var current = getCurrentFilename();
    highlightSidebarByHref(current);
    initSidebarDropdowns();
    wireUI();
    initBreadcrumbFromActiveLink();

    
  });

})();
