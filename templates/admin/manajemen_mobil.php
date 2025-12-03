<?php
$title = "manajemen_mobil";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$kodeUserSession = $_SESSION['kode_user'] ?? null;

include '../../db/config_api.php';
include '../../db/api_client.php';   // ⬅️ PENTING: pakai API_Client
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../include/header.php';

$api = api_get('admin/web_mobil_list.php');


if (!$api['success']) {
  $mobils = [];
} else {
  $mobils = $api['data'];
}
?>

<script>
  // Global kode user untuk halaman manajemen (mode non-SPA)
  window.KMJ_KODE_USER = <?= json_encode($kodeUserSession) ?>;
  console.log('[manajemen_mobil.php] KMJ_KODE_USER dari PHP:', window.KMJ_KODE_USER);
</script>
<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <main id="main-content" class="p-4">
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1>Manajemen Mobil</h1>
        <ul class="breadcrumb">
          <li><a href="#">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Manajemen Mobil</a></li>
        </ul>
      </div>

      <!-- Tombol Tambah Mobil -->
      <button id="btn-tambah-mobil" class="btn btn-primary d-flex align-items-center" data-page="tambah_stok_mobil.php">
        <i class="bx bx-plus me-2"></i> Tambah Mobil
      </button>
    </div>

    <!-- Search dan Filter -->
    <div class="d-flex flex-wrap align-items-center gap-2 mb-4 mt-3 search-wrapper">
      <div class="input-group flex-grow-1" style="max-width: 500px;">
        <span class="input-group-text bg-white border-end-0"><i class="bx bx-search"></i></span>
        <input id="searchInput" type="text" class="form-control border-start-0"
          placeholder="Cari mobil, model, atau tahun...">
      </div>

      <button class="btn btn-outline-secondary d-flex align-items-center" data-bs-toggle="modal"
        data-bs-target="#filterModal">
        <i class="bx bx-filter-alt me-2"></i> Filter
      </button>

    </div>

    <!-- Grid Card Mobil -->
    <div class="row g-4">
      <?php if (empty($mobils)): ?>
        <div class="text-center py-5 text-muted">Belum ada data mobil.</div>
      <?php else: ?>
        <?php foreach ($mobils as $mobil): ?>

          <div class="col-md-4 col-sm-6 car-card-item" data-kode="<?= htmlspecialchars($mobil['kode_mobil']) ?>"
            data-nama="<?= htmlspecialchars($mobil['nama_mobil']) ?>"
            data-tahun="<?= htmlspecialchars($mobil['tahun_mobil']) ?>"
            data-warna="<?= htmlspecialchars($mobil['warna_exterior']) ?>"
            data-tipe="<?= htmlspecialchars($mobil['jenis_kendaraan']) ?>"
            data-bbm="<?= htmlspecialchars($mobil['tipe_bahan_bakar']) ?>"
            data-status="<?= htmlspecialchars($mobil['status']) ?>">
            <div class="card shadow-sm border-0 h-100">
              <?php
              // data dari API: 'foto' sudah full URL (http://.../images/mobil/xxx.jpg)
              $img = !empty($mobil['foto'])
                ? $mobil['foto']
                : '../../assets/img/no-image.jpg';
              ?>
              <img src="<?= $img ?>" class="card-img-top car-thumb"
                alt="<?= htmlspecialchars($mobil['nama_mobil'] ?? 'Mobil Tanpa Nama') ?>">


              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h3 class="card-title" style="font-size:20px; font-weight:800; margin-bottom:6px;">
                    <?= htmlspecialchars($mobil['nama_mobil'] ?? 'Tanpa Nama') ?>
                  </h3>


                  <?php
                  // ambil status dari database, fallback ke 'available'
                  $status = $mobil['status'] ?? 'available';

                  // mapping status → label + warna badge
                  $statusMap = [
                    'available' => ['label' => 'Available', 'class' => 'bg-success'],
                    'reserved' => ['label' => 'Reserved', 'class' => 'bg-warning text-dark'],
                    'sold' => ['label' => 'Sold', 'class' => 'bg-secondary'],
                    'shipping' => ['label' => 'Shipping', 'class' => 'bg-info text-dark'],
                    'delivered' => ['label' => 'Delivered', 'class' => 'bg-primary'],
                  ];

                  $statusCfg = $statusMap[$status] ?? $statusMap['available'];
                  ?>

                  <span class="badge <?= $statusCfg['class'] ?>" style="font-size:13px; padding:6px 10px; font-weight:600;">
                    <?= htmlspecialchars($statusCfg['label']) ?>
                  </span>
                </div>
                <p class="d-flex justify-content-between mb-1" style="font-size:20px; margin-top:-20px;">
                  <span style="color:#6b7280; font-weight:800;">
                    <?= htmlspecialchars($mobil['tahun_mobil'] ?? '-') ?>
                  </span>
                </p>

                <p class="d-flex justify-content-between mb-1" style="font-size:15px; margin-top:25px;">
                  <span style="color:#6b7280;">Warna:</span>
                  <span style="color:#111827; font-weight:600;">
                    <?= htmlspecialchars($mobil['warna_exterior'] ?? '-') ?> /
                    <?= htmlspecialchars($mobil['warna_interior'] ?? '-') ?>
                  </span>
                </p>

                <p class="d-flex justify-content-between mb-1" style="font-size:15px;">
                  <span style="color:#6b7280;">Jarak Tempuh:</span>
                  <span style="color:#111827; font-weight:600;">
                    <?= number_format($mobil['jarak_tempuh'] ?? 0) ?> KM
                  </span>
                </p>
                <p class="d-flex justify-content-between mb-1" style="font-size:15px;">
                  <span style="color:#6b7280;">Bahan Bakar:</span>
                  <span style="color:#111827; font-weight:600;">
                    <?= htmlspecialchars($mobil['tipe_bahan_bakar'] ?? '-') ?>
                  </span>
                </p>
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-2">
                  <div>
                    <h6 class="fw-bold mb-0" style="font-size:20px; color:#0f172a;">
                      Rp. <?= number_format($mobil['angsuran'] ?? 0, 0, ',', '.') ?> x
                      <?= htmlspecialchars($mobil['tenor'] ?? '-') ?>
                    </h6>
                    <small style="color:#6b7280; font-size:15px">
                      Dp. Rp <?= number_format($mobil['dp'] ?? 0, 0, ',', '.') ?>
                    </small>
                  </div>

                  <div class="d-flex justify-content-end gap-1"> <!-- ubah gap biar tombol lebih rapat -->
                    <button type="button" class="p-0 bg-transparent border-0 btnEditMobil"
                      data-page="tambah_stok_mobil.php?kode=<?= $mobil['kode_mobil'] ?>"
                      style="cursor:pointer; margin-right:5px;">
                      <i class="bx bx-edit-alt" style="font-size:32px; color:#2563eb;"></i>
                    </button>



                    <button class="p-0 bg-transparent border-0 btnDeleteMobil" data-kode="<?= $mobil['kode_mobil'] ?>"
                      style="cursor:pointer;">
                      <i class="bx bx-trash" style="font-size:32px; color:#dc2626;"></i> <!-- diperbesar -->
                    </button>
                  </div>


                </div>

              </div>



            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <!-- filter mobil  -->
    <div class="modal fade" id="filterModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">Filter Mobil</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">

            <label class="form-label">Tipe Kendaraan</label>
            <select id="filterTipe" class="form-select mb-3">
              <option value="">Semua</option>
              <option value="SUV">SUV</option>
              <option value="MPV">MPV</option>
              <option value="Sedan">Sedan</option>
              <option value="Sport">Sport</option>
            </select>

            <label class="form-label">Bahan Bakar</label>
            <select id="filterBBM" class="form-select mb-3">
              <option value="">Semua</option>
              <option value="Bensin">Bensin</option>
              <option value="Diesel">Diesel</option>
              <option value="Listrik">Listrik</option>
            </select>

            <label class="form-label">Status Mobil</label>
            <select id="filterStatus" class="form-select">
              <option value="">Semua</option>
              <option value="available">Available</option>
              <option value="reserved">Reserved</option>
              <option value="sold">Sold</option>
              <option value="shipping">Shipping</option>
              <option value="delivered">Delivered</option>
            </select>

          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button class="btn btn-primary" id="applyFilter">Terapkan</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal Detail Mobil -->
    <div class="modal fade" id="detailMobilModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="detailNama"
              style="font-size:26px; font-weight:800; letter-spacing:0.5px;">
              Detail Mobil
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <!-- Foto -->
              <div class="col-md-4 mb-3">
                <div id="detailFoto" class="d-flex flex-wrap gap-2">
                  <!-- gambar akan diisi via JS -->
                </div>
              </div>

              <!-- Info dasar -->
              <div class="col-md-8">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <th style="width:160px;">Nama Mobil</th>
                      <td id="detailNamaMobil">-</td>
                    </tr>
                    <tr>
                      <th>Tahun</th>
                      <td id="detailTahun">-</td>
                    </tr>
                    <tr>
                      <th>Jarak Tempuh</th>
                      <td id="detailJarakTempuh">-</td>
                    </tr>
                    <tr>
                      <th>Harga Full</th>
                      <td id="detailFullPrize">-</td>
                    </tr>
                    <tr>
                      <th>Angsuran × Tenor</th>
                      <td id="detailAngsuranTenor">-</td>
                    </tr>
                    <tr>
                      <th>Uang Muka</th>
                      <td id="detailUangMuka">-</td>
                    </tr>
                    <tr>
                      <th>Tipe Kendaraan</th>
                      <td id="detailTipe">-</td>
                    </tr>
                    <tr>
                      <th>Bahan Bakar</th>
                      <td id="detailBBM">-</td>
                    </tr>
                    <tr>
                      <th>Sistem Penggerak</th>
                      <td id="detailSistemPenggerak">-</td>
                    </tr>
                    <tr>
                      <th>Warna</th>
                      <td id="detailWarna">-</td>
                    </tr>
                    <tr>
                      <th>Status</th>
                      <td id="detailStatus">-</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <hr>

            <!-- Fitur -->
            <h6 class="mb-2" style="font-size:20px; font-weight:700;">Fitur Mobil</h6>

            <div id="detailFitur" class="row g-2 mt-2">
              <!-- akan diisi oleh JS -->
            </div>



          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>

        </div>
      </div>
    </div>


  </main>
</section>

<script>
  async function loadInnerPage(page) {
  const main = document.getElementById("main-content");

  try {
    const response = await fetch(page, { cache: "no-store" });
    if (!response.ok) throw new Error("Gagal memuat halaman");
    const html = await response.text();

    const temp = document.createElement("div");
    temp.innerHTML = html;

    // 1) inject CSS
    const head = document.head;
    const existingHrefs = Array.from(document.querySelectorAll('link[rel="stylesheet"]'))
      .map(l => new URL(l.href, location.href).href);

    temp.querySelectorAll('link[rel="stylesheet"]').forEach(link => {
      const href = link.getAttribute('href');
      if (!href) return;
      const abs = new URL(href, location.href).href;
      if (!existingHrefs.includes(abs)) {
        const el = document.createElement('link');
        el.rel = 'stylesheet';
        el.href = href;
        head.appendChild(el);
      }
    });

    // 2) Masukkan konten ke #main-content DULU
    const fetchedMain = temp.querySelector("#main-content");
    const inner = fetchedMain ? fetchedMain.innerHTML : temp.innerHTML;
    main.innerHTML = inner;

    // 3) Jalankan script inline PHP DULU (untuk set window.existingPhotos)
    const phpScripts = temp.querySelectorAll('script:not([src]):not([data-page-script="true"])');
    phpScripts.forEach(old => {
         if (old.textContent.includes("BASE_API_URL")) return;
      const el = document.createElement('script');
      el.textContent = old.textContent;
      document.body.appendChild(el);
    });

    // 4) Tunggu sebentar supaya data PHP ter-inject
    await new Promise(resolve => setTimeout(resolve, 50));

    // 5) Jalankan script page (data-page-script="true")
    const pageScripts = temp.querySelectorAll('script[data-page-script="true"]');
    pageScripts.forEach(old => {
         if (old.textContent.includes("BASE_API_URL")) return;
      const el = document.createElement('script');
      el.textContent = old.textContent;
      document.body.appendChild(el);
    });

    // 6) Load script eksternal
    const existingSrcs = Array.from(document.scripts)
      .filter(s => s.src).map(s => new URL(s.src, location.href).href);

    const scriptsToRun = [];
    temp.querySelectorAll('script[src]').forEach(s => {
      const src = s.getAttribute('src');
      const abs = new URL(src, location.href).href;
      if (!existingSrcs.includes(abs)) {
        scriptsToRun.push({ src });
      }
    });

    for (const s of scriptsToRun) {
      await new Promise((res, rej) => {
        const el = document.createElement('script');
        el.src = s.src;
        el.onload = res;
        el.onerror = rej;
        document.body.appendChild(el);
      });
    }

    // 7) Init functions
    if (typeof window.initMobilForm === 'function') {
      window.initMobilForm();
    }

    window.history.pushState({}, '', page);

    if (typeof window.initBreadcrumbFromActiveLink === 'function') window.initBreadcrumbFromActiveLink(html);
    if (typeof window.initTheme === 'function') window.initTheme();
    if (typeof window.initSidebarState === 'function') window.initSidebarState();
    if (typeof window.initSidebarDropdowns === 'function') window.initSidebarDropdowns();
    if (typeof window.wireUI === 'function') window.wireUI();

  } catch (err) {
    console.error(err);
    main.innerHTML = `<div class='alert alert-danger text-center mt-5'>${err.message}</div>`;
  }
}

  // handle tombol Tambah Mobil (id: btn-tambah-mobil)
  document.addEventListener("DOMContentLoaded", function () {
    const btnTambah = document.getElementById("btn-tambah-mobil");
    if (btnTambah) {
      btnTambah.addEventListener("click", function (e) {
        e.preventDefault();
        const page = this.getAttribute("data-page");
        if (page) loadInnerPage(page);
      });
    }
  });

  // handle tombol Edit (class: .btnEditMobil)
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btnEditMobil");
    if (!btn) return;

    e.preventDefault();
    const page = btn.getAttribute("data-page");
    if (page) loadInnerPage(page);
  });
</script>

<script>
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btnDeleteMobil");
    if (!btn) return;

    const kode = btn.dataset.kode;
    if (!kode) return;

    if (!confirm("Apakah Anda yakin ingin menghapus mobil ini?")) return;



    // Kirim POST dengan body FormData supaya mobil_tambah.php tahu ini delete
    const formData = new FormData();
    formData.append("delete", 1);
    formData.append("kode_mobil", kode);

    fetch(`${BASE_API_URL}/admin/mobil_tambah.php`, {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert("Mobil berhasil dihapus!");
          const card = btn.closest(".col-md-4, .col-sm-6");
          if (card) card.remove();
        } else {
          alert("Gagal menghapus mobil: " + (data.message || ""));
        }
      })
      .catch(err => alert("Terjadi kesalahan: " + err));
  });

</script>

<!-- Script Search + Filter  -->
<script>
  function normalize(str) {
    return (str || "").toString().toLowerCase();
  }

  function applySearchAndFilter() {
    const q = normalize(document.getElementById("searchInput")?.value || "");

    const tipe = document.getElementById("filterTipe")?.value || "";
    const bbm = document.getElementById("filterBBM")?.value || "";
    const status = document.getElementById("filterStatus")?.value || "";

    const items = document.querySelectorAll(".car-card-item");

    items.forEach(card => {
      let nama = normalize(card.dataset.nama);
      let tahun = normalize(card.dataset.tahun);
      let warna = normalize(card.dataset.warna);
      let tipe_mobil = normalize(card.dataset.tipe);
      let bbm_mobil = normalize(card.dataset.bbm);
      let status_mobil = normalize(card.dataset.status);

      let matchSearch =
        nama.includes(q) ||
        tahun.includes(q) ||
        warna.includes(q);

      let matchFilter =
        (!tipe || tipe_mobil === normalize(tipe)) &&
        (!bbm || bbm_mobil === normalize(bbm)) &&
        (!status || status_mobil === normalize(status));

      card.style.display = (matchSearch && matchFilter) ? "" : "none";
    });
  }

  document.getElementById("searchInput").addEventListener("input", applySearchAndFilter);

  document.getElementById("applyFilter").addEventListener("click", () => {
    applySearchAndFilter();
    bootstrap.Modal.getInstance(document.getElementById("filterModal")).hide();
  });
</script>
<!-- untuk popUp -->
<script>
  // mapping id_fitur → label (sesuai form di tambah_stok_mobil.php)
  const FITUR_MAP = {
    1: "Airbag Pengemudi",
    2: "Traction Control",
    3: "Blind Spot Monitoring",
    4: "Forward Collision Warning",
    5: "Rearview Camera",
    6: "ABS (Anti-lock Braking System)",
    7: "ESC (Electronic Stability Control)",
    8: "Lane Departure Warning",
    9: "Emergency Braking",
    10: "Parking Sensors",

    11: "Air Conditioning",
    12: "Power Steering",
    13: "Central Locking",
    14: "Bluetooth",
    15: "Premium Audio System",
    16: "Heated Seats",
    17: "Climate Control",
    18: "Power Windows",
    19: "USB Port",
    20: "Wireless Charging",
    21: "Navigation Seats",
    22: "Ventilated Seats",

    23: "LED Headlights",
    24: "Fog Lamps",
    25: "Panoramic Roof",
    26: "Roof Rails",
    27: "Alloy Wheels",
    28: "LED Taillights",
    29: "Sunroof",
    30: "Spoiler",
    31: "Chrome Trim",
    32: "Run-flat Tires",

    33: "Engine Immobilizer",
    34: "Push Botton Start",
    35: "Rain Sensing Wipers",
    36: "Cruise Control",
    37: "Hill Start Assist",
    38: "Keyless Entry",
    39: "Auto Headlamps",
    40: "Parking Assist",
    41: "Adaptive Cruise Control",
    42: "Tire Pressure Monitoring",
  };
</script>
<script>
  document.addEventListener("click", async function (e) {
    const card = e.target.closest(".car-card-item");
    if (!card) return;

    // kalau yang diklik tombol edit / delete, jangan buka modal
    if (e.target.closest(".btnEditMobil") || e.target.closest(".btnDeleteMobil")) {
      return;
    }

    const kode = card.dataset.kode;
    if (!kode) return;

    try {
      // panggil proxy PHP (same origin, no CORS)
      const res = await fetch(`web_mobil_detail_popup.php?kode_mobil=${encodeURIComponent(kode)}`);
      if (!res.ok) throw new Error("Gagal menghubungi server");

      const json = await res.json();
      if (!json.success) {
        alert(json.message || "Gagal mengambil detail mobil");
        return;
      }

      const m = json.mobil || {};
      const fitur = json.fitur || [];
      const foto = json.foto || [];

      // ====== isi teks dasar ======
      document.getElementById("detailNama").textContent = m.nama_mobil || "Detail Mobil";
      document.getElementById("detailNamaMobil").textContent = m.nama_mobil || "-";
      document.getElementById("detailTahun").textContent = m.tahun_mobil || "-";
      document.getElementById("detailJarakTempuh").textContent =
        m.jarak_tempuh ? Number(m.jarak_tempuh).toLocaleString("id-ID") + " KM" : "-";

      document.getElementById("detailFullPrize").textContent =
        m.full_prize ? "Rp " + Number(m.full_prize).toLocaleString("id-ID") : "-";

      document.getElementById("detailAngsuranTenor").textContent =
        m.angsuran && m.tenor
          ? "Rp " + Number(m.angsuran).toLocaleString("id-ID") + " x " + m.tenor
          : "-";

      document.getElementById("detailUangMuka").textContent =
        m.uang_muka ? "Rp " + Number(m.uang_muka).toLocaleString("id-ID") : "-";

      document.getElementById("detailTipe").textContent = m.jenis_kendaraan || "-";
      document.getElementById("detailBBM").textContent = m.tipe_bahan_bakar || "-";
      document.getElementById("detailSistemPenggerak").textContent = m.sistem_penggerak || "-";
      document.getElementById("detailWarna").textContent =
        (m.warna_exterior || "-") + " / " + (m.warna_interior || "-");
      document.getElementById("detailStatus").textContent = m.status || "-";

      // ====== isi foto ======
      const fotoWrap = document.getElementById("detailFoto");
      fotoWrap.innerHTML = "";

      if (foto.length === 0) {
        fotoWrap.innerHTML = "<span class='text-muted'>Tidak ada foto.</span>";
      } else {
        foto.forEach(f => {
          if (!f.nama_file) return;
          const img = document.createElement("img");
          img.src = f.nama_file;
          img.alt = f.tipe_foto || "";
          img.className = "img-fluid rounded border";
          img.style.maxWidth = "100px";
          img.style.maxHeight = "70px";
          fotoWrap.appendChild(img);
        });
      }

      // ====== isi fitur ======
      // ====== isi fitur ======
      const fiturWrap = document.getElementById("detailFitur");
      fiturWrap.innerHTML = "";

      if (fitur.length === 0) {
        fiturWrap.innerHTML = `
    <div class="col-12">
      <div class="alert alert-secondary w-100 text-center" style="font-size:16px;">
        Tidak ada fitur yang tersimpan.
      </div>
    </div>
  `;
      } else {
        fitur.forEach(f => {
    // Ambil id fitur dari objek
    const id = f.id_fitur || f.id || parseInt(f);

    const col = document.createElement("div");
    col.className = "col-md-4 col-sm-6";

    col.innerHTML = `
      <div 
        class="alert alert-info d-flex align-items-center py-2 px-3 mb-0"
        style="font-size:16px; font-weight:600; border-radius:10px;"
      >
        <i class="bx bx-check-circle me-2" style="font-size:20px;"></i>
        <span>${FITUR_MAP[id] || ("Fitur ID " + id)}</span>
      </div>
    `;

    fiturWrap.appendChild(col);
});
      }


      // ====== tampilkan modal ======
      const modalEl = document.getElementById("detailMobilModal");
      const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
      modal.show();

    } catch (err) {
      console.error(err);
      alert("Terjadi kesalahan: " + err.message);
    }
  });
</script>



<?php include 'partials/footer.php'; ?>
<link rel="stylesheet" href="../../assets/css/admin/manajemen_mobil.css">