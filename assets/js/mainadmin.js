// =========================
// SIDEBAR ACTIVE STATE + PAGE LOADER
// =========================

const allSideMenu = document.querySelectorAll('#sidebar .side-menu li a[data-page]');
const mainContent = document.getElementById("main-content");

// Fungsi untuk load halaman ke <main>
async function loadPage(page) {
  try {
    const response = await fetch(page); // cukup page saja
    if (!response.ok) throw new Error(`Halaman "${page}" tidak ditemukan`);
    const html = await response.text();
    mainContent.innerHTML = html;
  } catch (err) {
    mainContent.innerHTML = `<p style="color:red; text-align:center; padding:20px;">
      ⚠️ Gagal memuat halaman: ${err.message}
    </p>`;
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
loadPage("dashboard.php");


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


// =========================
// TAMBAHAN: TOMBOL TAMBAH MOBIL & BREADCRUMB DINAMIS
// =========================

// Fungsi untuk update breadcrumb
function updateBreadcrumb(items) {
  const breadcrumb = document.querySelector('.breadcrumb');
  if (!breadcrumb) return;

  breadcrumb.innerHTML = items
    .map((item, i) => {
      if (item.active) {
        return `<li><a class="active" href="#">${item.name}</a></li>`;
      } else if (item.link) {
        return `<li><a href="${item.link}">${item.name}</a></li>`;
      } else {
        return `<li>${item.name}</li>`;
      }
    })
    .join("<li><i class='bx bx-chevron-right'></i></li>");
}

// Event listener untuk tombol tambah mobil
document.addEventListener('click', function (e) {
  const btnTambah = e.target.closest('#btn-tambah-mobil');
  if (btnTambah) {
    e.preventDefault();
    const page = btnTambah.getAttribute('data-page');
    if (page) {
      loadPage(page);
      updateBreadcrumb([
        { name: 'Dashboard', link: '#' },
        { name: 'Manajemen Mobil', link: '#' },
        { name: 'Tambah Stok Mobil', active: true }
      ]);
    }
  }
});

// =========================
// TOMBOL TAMBAH TRANSAKSI
// =========================
document.addEventListener('click', function (e) {
  const btnTambahTransaksi = e.target.closest('#btn-tambah-transaksi');
  if (btnTambahTransaksi) {
    e.preventDefault();

    const page = btnTambahTransaksi.getAttribute('data-page');
    if (page) {
      loadPage(page);
      updateBreadcrumb([
        { name: 'Dashboard', link: '#' },
        { name: 'Transaksi', link: '#' },
        { name: 'Tambah Transaksi', active: true }
      ]);
    }
  }
});

// =========================
// TOMBOL TAMBAH TRANSAKSI
// =========================
document.addEventListener('click', function (e) {
  const btnTambahTransaksi = e.target.closest('#btn-tambah-transaksi');
  if (btnTambahTransaksi) {
    e.preventDefault();

    const page = btnTambahTransaksi.getAttribute('data-page');
    if (page) {
      loadPage(page);
      updateBreadcrumb([
        { name: 'Dashboard', link: '#' },
        { name: 'Transaksi', link: '#' },
        { name: 'Tambah Transaksi', active: true }
      ]);
    }
  }
});

