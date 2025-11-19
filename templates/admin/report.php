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
  'total_laporan'       => 0,
  'total_pendapatan'    => 0,
  'total_transaksi'     => 0,
  'rata_rata_transaksi' => 0,
];

if ($apiResponse && isset($apiResponse['status']) && $apiResponse['status'] === true) {
    $data    = $apiResponse['data'] ?? [];
    $laporan = $data['items'] ?? [];

    if (isset($data['ringkasan'])) {
        $ringkasan['total_laporan']       = $data['ringkasan']['total_laporan']       ?? 0;
        $ringkasan['total_pendapatan']    = $data['ringkasan']['total_pendapatan']    ?? 0;
        $ringkasan['total_transaksi']     = $data['ringkasan']['total_transaksi']     ?? 0;
        $ringkasan['rata_rata_transaksi'] = $data['ringkasan']['rata_rata_transaksi'] ?? 0;
    }
} else {
    $errorMessage = $apiResponse['message'] ?? 'Gagal mengambil data laporan dari API';
}
?>

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
          <h6 class="text-muted">Total Pendapatan (Semua)</h6>
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

    <!-- Histori Laporan -->
    <div class="card border-0 shadow-sm rounded-3 mb-5">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">Histori Laporan</h5>

        <?php if (empty($laporan)): ?>
          <p class="text-muted mb-0">Belum ada data laporan penjualan.</p>
        <?php else: ?>
          <ul class="list-group list-group-flush">
            <?php foreach ($laporan as $row): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0 border-bottom">
                <div>
                  <span class="fw-semibold text-dark">
                    <?= htmlspecialchars($row['nama_laporan']) ?>
                  </span>
                  <p class="mb-0 text-muted small">
                    Periode: <?= htmlspecialchars($row['periode']) ?> • 
                    <?= htmlspecialchars($row['total_transaksi']) ?> transaksi • 
                    Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?>
                  </p>
                </div>
                <div>
                  <a href="#" class="text-primary me-3">View</a>
                  <i class="bi bi-download text-secondary"></i>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>

  </main>
</section>

<?php include 'partials/footer.php'; ?>
<link rel="stylesheet" href="../../assets/css/report.css">
