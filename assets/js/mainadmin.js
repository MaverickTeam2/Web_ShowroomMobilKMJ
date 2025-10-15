// =========================
// SIDEBAR ACTIVE STATE + PAGE LOADER
// =========================

const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a[data-page]');
const mainContent = document.getElementById("main-content");

// Fungsi untuk load halaman ke <main>
async function loadPage(page) {
  try {
    const response = await fetch(page);
    if (!response.ok) throw new Error("Halaman tidak ditemukan");
    const html = await response.text();
    mainContent.innerHTML = html;
  } catch (err) {
    mainContent.innerHTML = `<p style="color:red;">Gagal memuat halaman: ${err.message}</p>`;
  }
}

// Klik menu di sidebar
allSideMenu.forEach(item => {
  const li = item.parentElement;

  item.addEventListener('click', function (e) {
    e.preventDefault();

    // ubah menu aktif
    allSideMenu.forEach(i => i.parentElement.classList.remove('active'));
    li.classList.add('active');

    // ambil halaman dari atribut data-page
    const page = item.getAttribute('data-page');
    if (page) loadPage(page);
  });
});

// load default halaman saat awal
loadPage("dashboard.html");


// =========================
// TOGGLE SIDEBAR
// =========================
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
  sidebar.classList.toggle('hide');
});


// =========================
// SEARCH FORM (Mobile)
// =========================
const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

if (searchButton) {
  searchButton.addEventListener('click', function (e) {
    if (window.innerWidth < 576) {
      e.preventDefault();
      searchForm.classList.toggle('show');
      if (searchForm.classList.contains('show')) {
        searchButtonIcon.classList.replace('bx-search', 'bx-x');
      } else {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
      }
    }
  });
}

if (window.innerWidth < 768) {
  sidebar.classList.add('hide');
} else if (window.innerWidth > 576) {
  if (searchButtonIcon) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
  }
}

window.addEventListener('resize', function () {
  if (this.innerWidth > 576) {
    if (searchButtonIcon) {
      searchButtonIcon.classList.replace('bx-x', 'bx-search');
      searchForm.classList.remove('show');
    }
  }
});


// =========================
// DARK MODE SWITCH
// =========================
const switchMode = document.getElementById('switch-mode');
if (switchMode) {
  switchMode.addEventListener('change', function () {
    if (this.checked) {
      document.body.classList.add('dark');
    } else {
      document.body.classList.remove('dark');
    }
  });
}
