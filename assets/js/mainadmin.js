// =========================
// SIDEBAR ACTIVE STATE (PHP NATIVE VERSION)
// =========================
const allSideMenu = document.querySelectorAll('#sidebar .side-menu li a');

allSideMenu.forEach(item => {
  const li = item.parentElement;

  // Highlight menu aktif berdasar URL
  const currentPage = window.location.pathname.split("/").pop();
  const linkPage = item.getAttribute("href").split("/").pop();

  if (currentPage === linkPage) {
    li.classList.add("active");
  } else {
    li.classList.remove("active");
  }
});

// =========================
// TOGGLE SIDEBAR
// =========================
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

if (menuBar && sidebar) {
  menuBar.addEventListener('click', () => {
    sidebar.classList.toggle('hide');
  });
}

// =========================
// DARK MODE SWITCH
// =========================
const switchMode = document.getElementById('switch-mode');
if (switchMode) {
  switchMode.addEventListener('change', function () {
    document.body.classList.toggle('dark', this.checked);
  });
}

// =========================
// BREADCRUMB GENERATOR (opsional)
// =========================
function updateBreadcrumb(items) {
  const breadcrumb = document.querySelector('.breadcrumb');
  if (!breadcrumb) return;
  breadcrumb.innerHTML = items
    .map((item, i) => {
      if (item.active) return `<li><a class="active" href="#">${item.name}</a></li>`;
      else if (item.link) return `<li><a href="${item.link}">${item.name}</a></li>`;
      else return `<li>${item.name}</li>`;
    })
    .join("<li><i class='bx bx-chevron-right'></i></li>");
}
window.updateBreadcrumb = updateBreadcrumb;

// Tambahkan highlight menu aktif berdasarkan halaman sekarang
const currentPage = window.location.pathname.split("/").pop();
document.querySelectorAll("#sidebar .side-menu li a").forEach(link => {
  if (link.getAttribute("href") === currentPage) {
    link.parentElement.classList.add("active");
  } else {
    link.parentElement.classList.remove("active");
  }
});
