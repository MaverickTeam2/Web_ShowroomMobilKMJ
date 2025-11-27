<?php
$title = "Laporan Penjualan";

include '../../db/config_api.php';
include '../../db/api_client.php';
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../include/header.php';

$apiResponse = api_get('admin/report_penjualan.php?status=all');

$laporan = [];
$ringkasan = [
  'total_laporan' => 0,
  'total_pendapatan' => 0,
  'total_transaksi' => 0,
  'rata_rata_transaksi' => 0,
];

if ($apiResponse && isset($apiResponse['status']) && $apiResponse['status'] === true) {
  $data = $apiResponse['data'] ?? [];
  $laporan = $data['items'] ?? [];

  if (isset($data['ringkasan'])) {
    $ringkasan['total_laporan'] = $data['ringkasan']['total_laporan'] ?? 0;
    $ringkasan['total_pendapatan'] = $data['ringkasan']['total_pendapatan'] ?? 0;
    $ringkasan['total_transaksi'] = $data['ringkasan']['total_transaksi'] ?? 0;
    $ringkasan['rata_rata_transaksi'] = $data['ringkasan']['rata_rata_transaksi'] ?? 0;
  }
} else {
  $errorMessage = $apiResponse['message'] ?? 'Gagal mengambil data laporan dari API';
}
// ==== AMBIL DATA MOBIL DARI API ====
$mobilList = [];
$mobilStats = [
  'total_mobil' => 0,
  'mobil_tersedia' => 0,
  'mobil_terjual' => 0,
];

$apiMobilResponse = api_get('admin/web_mobil_list.php'); // sesuaikan path di API_kmj

if ($apiMobilResponse && isset($apiMobilResponse['success']) && $apiMobilResponse['success'] === true) {
  $mobilList = $apiMobilResponse['data'] ?? [];

  // Hitung statistik
  $mobilStats['total_mobil'] = count($mobilList);

  foreach ($mobilList as $m) {
    $status = strtolower(trim($m['status'] ?? ''));

    // Mobil tersedia = status "Available" saja
    if ($status === 'available') {
      $mobilStats['mobil_tersedia']++;
    }

    // Mobil terjual = status "Sold" saja
    if ($status === 'sold') {
      $mobilStats['mobil_terjual']++;
    }
  }
} else {
  $errorMobil = $apiMobilResponse['message'] ?? 'Gagal mengambil data mobil dari API';
}

?>
<style>
  .tab-switch {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
  }

  .tab-link {
    padding: 8px 20px;
    border: 2px solid #d1d5db;
    /* Abu muda */
    border-radius: 8px;
    color: #4b5563;
    /* Abu teks */
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  /* Hover */
  .tab-link:hover {
    border-color: #007bff;
    color: #007bff;
  }

  /* Active */
  .tab-link.active {
    border-color: #007bff;
    color: #007bff;
  }
</style>


<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>
  <main id="main-content" class="p-4">

    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Laporan Penjualan</h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Report</a></li>
        </ul>
      </div>
    </div>

    <?php if (isset($errorMessage)): ?>
      <div class="alert alert-danger mt-3">
        <?= htmlspecialchars($errorMessage) ?>
      </div>
    <?php endif; ?>

    <div class="btn-group btn-group-sm mb-3" role="group"
      style="border:1px solid #0d6efd; border-radius:8px; overflow:hidden;">

      <a href="#" id="tabTransaksi" class="btn btn-outline-primary active"
        style="padding: 6px 20px; border-right:1px solid #0d6efd;">
        Report Transaksi
      </a>

      <a href="#" id="tabMobil" class="btn btn-outline-primary" style="padding: 6px 20px;">
        Report Mobil
      </a>

    </div>





    <!-- ====================== REPORT TRANSAKSI ====================== -->
    <div id="contentTransaksi">

      <!-- Ringkasan Statistik -->
      <div class="row mt-4 mb-4">
        <div class="col-md-4">
          <div class="card shadow-sm border-0 text-center p-3">
            <h6 class="text-muted">Total Laporan</h6>
            <h3 class="fw-bold text-primary">
              <?= number_format($ringkasan['total_laporan'], 0, ',', '.') ?>
            </h3>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm border-0 text-center p-3">
            <h6 class="text-muted">Total Pendapatan</h6>
            <h3 class="fw-bold text-success">
              Rp <?= number_format($ringkasan['total_pendapatan'], 0, ',', '.') ?>
            </h3>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm border-0 text-center p-3">
            <h6 class="text-muted">Rata-rata Transaksi</h6>
            <h3 class="fw-bold text-warning">
              <?= number_format($ringkasan['rata_rata_transaksi'], 1, ',', '.') ?>
            </h3>
          </div>
        </div>
      </div>

      <!-- Tombol Download -->
      <form action="report_penjualan_pdf.php" method="GET" style="display:inline;">
        <button class="btn btn-primary mb-3" type="submit">
          Download PDF Transaksi
        </button>
      </form>

      <form action="report_penjualan_excel.php" method="GET" style="display:inline; margin-left: 5px;">
        <button class="btn btn-success mb-3" type="submit">
          Download Excel Transaksi
        </button>
      </form>


      <!-- Histori -->
      <div class="card border-0 shadow-sm rounded-3 mb-5">
        <div class="card-body">
          <h5 class="fw-semibold mb-3">Histori Laporan</h5>

          <?php if (empty($laporan)): ?>
            <p class="text-muted mb-0">Belum ada data laporan penjualan.</p>
          <?php else: ?>
            <ul class="list-group list-group-flush">
              <?php foreach ($laporan as $row): ?>
                <li
                  class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0 border-bottom">
                  <div>
                    <span class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_laporan']) ?></span>
                    <p class="mb-0 text-muted small">
                      Periode: <?= htmlspecialchars($row['periode']) ?> •
                      <?= htmlspecialchars($row['total_transaksi']) ?> transaksi •
                      Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?>
                    </p>
                  </div>

                  <div>
                    <a href="report_penjualan_detail.php?periode=<?= urlencode($row['periode']) ?>"
                      class="text-primary me-3">
                      View
                    </a>
                    <i class="bi bi-download text-secondary"></i>
                  </div>


                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

        </div>
      </div>

    </div>
    <!-- ====================== END REPORT TRANSAKSI ====================== -->



    <!-- ======================== REPORT MOBIL =========================== -->
    <div id="contentMobil" style="display:none;">

      <div class="row mt-4 mb-4">
        <div class="col-md-4">
          <div class="card shadow-sm border-0 text-center p-3">
            <h6 class="text-muted">Total Mobil</h6>
            <h3 class="fw-bold text-primary">
              <?= number_format($mobilStats['total_mobil'], 0, ',', '.') ?>
            </h3>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm border-0 text-center p-3">
            <h6 class="text-muted">Mobil Tersedia</h6>
            <h3 class="fw-bold text-success">
              <?= number_format($mobilStats['mobil_tersedia'], 0, ',', '.') ?>
            </h3>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm border-0 text-center p-3">
            <h6 class="text-muted">Mobil Terjual</h6>
            <h3 class="fw-bold text-warning">
              <?= number_format($mobilStats['mobil_terjual'], 0, ',', '.') ?>
            </h3>
          </div>
        </div>
      </div>

      <!-- Tombol Download -->
      <form action="report_mobil_pdf.php" method="GET" style="display:inline;">
        <button class="btn btn-primary mb-3" type="submit">
          Download PDF Mobil
        </button>
      </form>

      <form action="report_mobil_excel.php" method="GET" style="display:inline; margin-left: 5px;">
        <button class="btn btn-success mb-3" type="submit">
          Download Excel Mobil
        </button>
      </form>


      <div class="card border-0 shadow-sm rounded-3 mb-5">
        <div class="card-body">
          <h5 class="fw-semibold mb-3">Histori Data Mobil</h5>

          <?php if (isset($errorMobil)): ?>
            <p class="text-danger mb-0"><?= htmlspecialchars($errorMobil) ?></p>
          <?php elseif (empty($mobilList)): ?>
            <p class="text-muted mb-0">Belum ada data mobil.</p>
          <?php else: ?>
            <ul class="list-group list-group-flush">
              <?php foreach ($mobilList as $m): ?>
                <li
                  class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0 border-bottom">
                  <div>
                    <span class="fw-semibold text-dark">
                      <?= htmlspecialchars($m['nama_mobil']) ?> (<?= htmlspecialchars($m['tahun_mobil']) ?>)
                    </span>
                    <p class="mb-0 text-muted small">
                      Kode: <?= htmlspecialchars($m['kode_mobil']) ?> •
                      Status: <?= htmlspecialchars($m['status']) ?> •
                      Harga: Rp <?= number_format($m['full_prize'], 0, ',', '.') ?>
                    </p>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

        </div>
      </div>

    </div>

    <!-- ====================== END REPORT MOBIL ======================== -->

  </main>

</section>
<script>
  const tabTransaksi = document.getElementById("tabTransaksi");
  const tabMobil = document.getElementById("tabMobil");

  const contentTransaksi = document.getElementById("contentTransaksi");
  const contentMobil = document.getElementById("contentMobil");

  tabTransaksi.addEventListener("click", function (e) {
    e.preventDefault();
    tabTransaksi.classList.add("active");
    tabMobil.classList.remove("active");

    contentTransaksi.style.display = "block";
    contentMobil.style.display = "none";
  });

  tabMobil.addEventListener("click", function (e) {
    e.preventDefault();
    tabMobil.classList.add("active");
    tabTransaksi.classList.remove("active");

    contentMobil.style.display = "block";
    contentTransaksi.style.display = "none";
  });
</script>

<script>
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-group .btn");
    if (!btn) return;

    // hapus active dari semua tombol
    document.querySelectorAll(".btn-group .btn").forEach(b => b.classList.remove("active"));

    // tambah ke tombol yang diklik
    btn.classList.add("active");
  });
</script>

<?php include 'partials/footer.php'; ?>
<link rel="stylesheet" href="/web_showroommobilKMJ/assets/css/admin/report.css">