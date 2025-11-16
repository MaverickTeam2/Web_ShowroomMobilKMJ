<?php
$title = "manajemen_mobil";
include '../../db/koneksi.php';
include '../../db/config_api.php'; 
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../include/header.php';

// Ambil data mobil beserta 1 foto utamanya (jika ada)
$query = "
  SELECT 
    m.*, 
    f.nama_file AS gambar
  FROM mobil m
  LEFT JOIN mobil_foto f 
    ON m.kode_mobil = f.kode_mobil 
    AND f.urutan = 1
  ORDER BY m.created_at DESC
";
$result = $conn->query($query);
$mobils = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

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
    <div class="d-flex flex-wrap align-items-center gap-2 mb-4 mt-3">
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

          <div class="col-md-4 col-sm-6 car-card-item" data-nama="<?= htmlspecialchars($mobil['nama_mobil']) ?>"
            data-tahun="<?= htmlspecialchars($mobil['tahun_mobil']) ?>"
            data-warna="<?= htmlspecialchars($mobil['warna_exterior']) ?>/<?= htmlspecialchars($mobil['warna_interior']) ?>"
            data-tipe="<?= htmlspecialchars($mobil['jenis_kendaraan']) ?>"
            data-bbm="<?= htmlspecialchars($mobil['tipe_bahan_bakar']) ?>"
            data-status="<?= htmlspecialchars($mobil['status']) ?>">
            <div class="card shadow-sm border-0 h-100">
              <?php
              $img = $mobil['gambar']
                ? IMAGE_URL . $mobil['gambar']
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
                      Dp. Rp <?= number_format($mobil['uang_muka'] ?? 0, 0, ',', '.') ?>
                    </small>
                  </div>

                  <div class="d-flex justify-content-end gap-1"> <!-- ubah gap biar tombol lebih rapat -->
                    <button onclick="window.location.href='tambah_stok_mobil.php?kode=<?= $mobil['kode_mobil'] ?>'"
                      class="p-0 bg-transparent border-0" style="cursor:pointer; margin-right:5px;">
                      <i class="bx bx-edit-alt" style="font-size:32px; color:#2563eb;"></i> <!-- diperbesar -->
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

  </main>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const btnTambah = document.getElementById("btn-tambah-mobil");

    if (!btnTambah) return;

    btnTambah.addEventListener("click", async function (e) {
      e.preventDefault();
      const page = btnTambah.getAttribute("data-page");
      const main = document.getElementById("main-content");

      try {
        const response = await fetch(page, { cache: "no-store" });
        if (!response.ok) throw new Error("Gagal memuat halaman");
        const html = await response.text();

        // ---- PARSE HTML ----
        const temp = document.createElement("html");
        temp.innerHTML = html;

        // 1) Inject <link rel="stylesheet"> dari halaman target
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

        // 2) Jalankan <script> eksternal dari halaman target (jika ada)
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

        // 3) Ambil <script> inline penting (mis. init per-halaman).
        //    Agar aman, kita cari yang punya atribut data-page-script="true"
        const inlineScripts = temp.querySelectorAll('script[data-page-script="true"]');

        // ---- PASANG KONTEN KE MAIN ----
        const fetchedMain = temp.querySelector("#main-content");
        const inner = fetchedMain ? fetchedMain.innerHTML : temp.body.innerHTML;
        main.innerHTML = inner;
        if (typeof window.initMobilForm === 'function') {
          window.initMobilForm();
        }

        for (const s of scriptsToRun) {
          await new Promise((res, rej) => {
            const el = document.createElement('script');
            el.src = s.src;
            el.onload = res;
            el.onerror = rej;
            document.body.appendChild(el);
          });
        }

        inlineScripts.forEach(old => {
          const el = document.createElement('script');
          el.textContent = old.textContent;
          document.body.appendChild(el);
        });

        // Update URL
        window.history.pushState({}, '', page);

        // Re-init util bawaan, kalau ada
        if (typeof window.initBreadcrumbFromActiveLink === 'function') window.initBreadcrumbFromActiveLink(html);
        if (typeof window.initTheme === 'function') window.initTheme();
        if (typeof window.initSidebarState === 'function') window.initSidebarState();
        if (typeof window.initSidebarDropdowns === 'function') window.initSidebarDropdowns();
        if (typeof window.wireUI === 'function') window.wireUI();

      } catch (err) {
        main.innerHTML = `<div class='alert alert-danger text-center mt-5'>${err.message}</div>`;
      }
    });
  });
</script>
<script>
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btnDeleteMobil");
    if (!btn) return;

    const kode = btn.dataset.kode;
    if (!kode) return;

    if (!confirm("Apakah Anda yakin ingin menghapus mobil ini?")) return;

    const BASE_API_URL = window.BASE_API_URL || `${window.location.origin}/api_kmj`;

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




<?php include 'partials/footer.php'; ?>
<link rel="stylesheet" href="../../assets/css/admin/manajemen_mobil.css">