<?php
$title = "Laporan Penjualan";
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../db/koneksi.php';

// ===== DATA DUMMY UNTUK SIMULASI LAPORAN =====
$laporan = [
  [
    'id' => 1,
    'nama_laporan' => 'Laporan Penjualan Bulanan',
    'periode' => 'Oktober 2025',
    'tanggal_generate' => '31 Okt 2025 15:20',
    'total_transaksi' => 48,
    'total_pendapatan' => 152000000
  ],
  [
    'id' => 2,
    'nama_laporan' => 'Laporan Penjualan Bulanan',
    'periode' => 'September 2025',
    'tanggal_generate' => '30 Sep 2025 18:10',
    'total_transaksi' => 62,
    'total_pendapatan' => 184500000
  ],
  [
    'id' => 3,
    'nama_laporan' => 'Laporan Penjualan Bulanan',
    'periode' => 'Agustus 2025',
    'tanggal_generate' => '31 Agt 2025 17:45',
    'total_transaksi' => 55,
    'total_pendapatan' => 164750000
  ]
];
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

    <!-- Ringkasan Statistik -->
    <div class="row mt-4 mb-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-3">
          <h6 class="text-muted">Total Laporan</h6>
          <h3 class="fw-bold text-primary"><?= count($laporan) ?></h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-3">
          <h6 class="text-muted">Total Pendapatan (Semua)</h6>
          <h3 class="fw-bold text-success">
            Rp <?= number_format(array_sum(array_column($laporan, 'total_pendapatan')), 0, ',', '.') ?>
          </h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-3">
          <h6 class="text-muted">Rata-rata Transaksi</h6>
          <h3 class="fw-bold text-warning">
            <?= number_format(array_sum(array_column($laporan, 'total_transaksi')) / count($laporan), 1) ?>
          </h3>
        </div>
      </div>
    </div>

    <!-- Quick Reports -->
    <div class="card border-0 shadow-sm rounded-3 mb-5">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">Histori Laporan</h5>
        <ul class="list-group list-group-flush">
          <?php foreach ($laporan as $row): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0 border-bottom">
              <div>
                <span class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_laporan']) ?></span>
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
      </div>
    </div>

  </main>
</section>

<?php include 'partials/footer.php'; ?>
<link rel="stylesheet" href="../../assets/css/report.css">
