// =========================
// SIDEBAR ACTIVE STATE (PHP NATIVE VERSION)
// =========================

const allSideMenu = document.querySelectorAll('#sidebar .side-menu li a[data-page]');
const mainContent = document.getElementById("main-content");

// Fungsi untuk load halaman ke <main>
async function loadPage(page) {
  try {
    const response = await fetch(page); // cukup page saja
    if (!response.ok) throw new Error(`Halaman "${page}" tidak ditemukan`);
    const html = await response.text();

    // Tampilkan konten ke main
    mainContent.innerHTML = html;
    if (page.includes("setting1")) {
      setTimeout(() => {
        // initCropperFeature();
        initScheduleFeature();
        initRestoreFeature();
      }, 100);
    }

    mainContent.querySelectorAll("script").forEach(oldScript => {
      const newScript = document.createElement("script");
      if (oldScript.src) {
        newScript.src = oldScript.src;
      } else {
        newScript.textContent = oldScript.textContent;
      }
      document.body.appendChild(newScript);
    });

    // 🔹 Tambahan KHUSUS untuk setting1.html agar tab Bootstrap aktif
    if (page.includes("setting1")) {
      // Pastikan Bootstrap JS sudah ada di index (bootstrap.bundle.min.js)
      const tabTriggers = mainContent.querySelectorAll('[data-bs-toggle="pill"]');
      tabTriggers.forEach(triggerEl => {
        triggerEl.addEventListener('shown.bs.tab', function () {
          const activeText = this.textContent.trim();
          const breadcrumb = document.getElementById("breadcrumb-current");
          if (breadcrumb) breadcrumb.textContent = activeText;
        });
      });
    }


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

    const openModals = document.querySelectorAll('.modal.show');
    openModals.forEach(modalEl => {
      const modalInstance = bootstrap.Modal.getInstance(modalEl);
      if (modalInstance) modalInstance.hide();
    });

    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.overflow = 'auto';

    allSideMenu.forEach(i => i.parentElement.classList.remove('active'));
    li.classList.add('active');

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

// Schedull setting ADIS
function initScheduleFeature() {
  const container = document.getElementById("scheduleContainer");
  if (!container) return;

  const days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
  container.innerHTML = "";

  days.forEach(day => {
    const row = document.createElement("div");
    row.className = "day-row d-flex align-items-start justify-content-between border-bottom py-3";

    row.innerHTML = `
      <div class="d-flex align-items-center gap-3">
        <div class="form-check form-switch">
          <input class="form-check-input schedule-toggle" type="checkbox" id="toggle-${day}" ${["Jumat", "Sabtu", "Minggu"].includes(day) ? "" : "checked"}>
        </div>
        <label for="toggle-${day}" class="fw-semibold" style="width:80px;">${day}</label>
      </div>
      <div class="flex-fill ms-3" id="slots-${day}"></div>
    `;
    container.appendChild(row);
  });

  function createTimeDropdown(defaultValue = "09.00") {
    const select = document.createElement("select");
    select.className = "form-select form-select-sm d-inline-block w-auto mx-1";
    const times = [];
    for (let h = 0; h < 24; h++) {
      for (let m = 0; m < 60; m += 30) {
        const time = `${String(h).padStart(2, "0")}.${String(m).padStart(2, "0")}`;
        times.push(time);
      }
    }
    times.forEach(t => {
      const opt = document.createElement("option");
      opt.value = t;
      opt.textContent = t;
      if (t === defaultValue) opt.selected = true;
      select.appendChild(opt);
    });
    return select;
  }

  function addSlot(day, start = "09.00", end = "12.00") {
    const container = document.getElementById(`slots-${day}`);
    const slotDiv = document.createElement("div");
    slotDiv.className = "slot d-flex align-items-center gap-2 mb-2 flex-wrap";

    const startSelect = createTimeDropdown(start);
    const endSelect = createTimeDropdown(end);

    const deleteBtn = document.createElement("i");
    deleteBtn.className = "bx bx-trash text-danger fs-5 ms-2 delete-slot";
    deleteBtn.style.cursor = "pointer";

    slotDiv.appendChild(startSelect);
    slotDiv.insertAdjacentText("beforeend", "—");
    slotDiv.appendChild(endSelect);
    slotDiv.appendChild(deleteBtn);

    container.insertBefore(slotDiv, container.querySelector(".add-slot-btn"));

    deleteBtn.addEventListener("click", () => {
      slotDiv.remove();
    });
  }

  document.querySelectorAll(".schedule-toggle").forEach(toggle => {
    const day = toggle.id.replace("toggle-", "");
    const slotContainer = document.getElementById(`slots-${day}`);

    function setState() {
      slotContainer.innerHTML = "";

      if (toggle.checked) {
        // buat slot pertama
        addSlot(day);

        // tombol add slot hanya sekali
        const addBtn = document.createElement("a");
        addBtn.href = "#";
        addBtn.className = "text-primary small fw-semibold add-slot-btn d-block mt-1";
        addBtn.textContent = "+ Add slot";

        addBtn.addEventListener("click", e => {
          e.preventDefault();
          addSlot(day);
        });

        slotContainer.appendChild(addBtn);
      } else {
        const unavailable = document.createElement("div");
        unavailable.className = "text-muted small mt-1";
        unavailable.textContent = "Unavailable";
        slotContainer.appendChild(unavailable);
      }
    }

    toggle.addEventListener("change", setState);
    setState();
  });
}

// bakup pop up ADIS
function initRestoreFeature() {
  const importBtn = document.getElementById('importBtn');
  const confirmModalEl = document.getElementById('confirmRestoreModal');
  const confirmImportBtn = document.getElementById('confirmImportBtn');

  if (!importBtn || !confirmModalEl || !confirmImportBtn) {
    console.warn("⚠️ Restore modal elements not found (skip init)");
    return;
  }

  const confirmModal = new bootstrap.Modal(confirmModalEl);

  importBtn.addEventListener('click', () => {
    confirmModal.show();
  });

  confirmImportBtn.addEventListener('click', () => {
    confirmModal.hide();
    window.location.href = "import_database.php"; 
  });

  console.log("✅ Restore modal initialized");
}

