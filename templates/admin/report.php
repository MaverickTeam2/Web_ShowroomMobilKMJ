<?php
$title = "Laporan Penjualan";
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../db/koneksi.php';

$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('m');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');

$query_stats = "
    SELECT
        COUNT(*) as total_transaksi,
        COALESCE(SUM(harga_akhir), 0) as total_pendapatan,
        COALESCE(AVG(harga_akhir), 0) as rata_pendapatan
    FROM transaksi
    WHERE status = 'completed'
    AND MONTH(created_at) = ?
    AND YEAR(created_at) = ?
";
$stmt = $conn->prepare($query_stats);
$stmt->bind_param("ii", $bulan, $tahun);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();


$query_histori = "
    SELECT
        DATE_FORMAT(MIN(created_at), '%Y-%m') as periode,
        DATE_FORMAT(MIN(created_at), '%M %Y') as periode_formatted,
        COUNT(*) as total_transaksi,
        COALESCE(SUM(harga_akhir), 0) as total_pendapatan
    FROM transaksi
    WHERE status = 'completed'
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY periode DESC
    LIMIT 12
";

$result_histori = $conn->query($query_histori);

if (!$result_histori) {
    error_log("Query histori gagal: " . $conn->error);
    $result_histori = null;
}

$query_transaksi = "
    SELECT
        t.kode_transaksi,
        t.nama_pembeli,
        t.no_hp,
        t.tipe_pembayaran,
        t.harga_akhir,
        t.created_at,
        m.nama_mobil,
        m.tahun_mobil,
        u.full_name as admin_name
    FROM transaksi t
    LEFT JOIN mobil m ON t.kode_mobil = m.kode_mobil
    LEFT JOIN users u ON t.kode_user = u.kode_user
    WHERE t.status = 'completed'
    AND MONTH(t.created_at) = ?
    AND YEAR(t.created_at) = ?
    ORDER BY t.created_at DESC
";
$stmt_transaksi = $conn->prepare($query_transaksi);
$stmt_transaksi->bind_param("ii", $bulan, $tahun);
$stmt_transaksi->execute();
$result_transaksi = $stmt_transaksi->get_result();

$current_year = date('Y');
$years = range($current_year - 5, $current_year);
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
      <div class="right">
        <button class="btn btn-primary" onclick="generatePDF()">
          <i class="bi bi-file-pdf me-2"></i>Generate PDF
        </button>
        <button class="btn btn-success ms-2" onclick="exportExcel()">
          <i class="bi bi-file-excel me-2"></i>Export Excel
        </button>
      </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mt-4 mb-4">
      <div class="card-body">
        <form method="GET" action="" class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-select">
              <?php
              $bulan_names = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
              ];
              foreach ($bulan_names as $num => $name) {
                $selected = ($num == $bulan) ? 'selected' : '';
                echo "<option value='$num' $selected>$name</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tahun</label>
            <select name="tahun" class="form-select">
              <?php
              foreach ($years as $year) {
                $selected = ($year == $tahun) ? 'selected' : '';
                echo "<option value='$year' $selected>$year</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bi bi-search me-2"></i>Filter
            </button>
            <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='report.php'">
              <i class="bi bi-arrow-clockwise me-2"></i>Reset
          </button>
          </div>
        </form>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-3">
          <h6 class="text-muted">Total Transaksi</h6>
          <h3 class="fw-bold text-primary"><?= $stats['total_transaksi'] ?></h3>
          <small class="text-muted"><?= $bulan_names[$bulan] ?> <?= $tahun ?></small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-3">
          <h6 class="text-muted">Total Pendapatan</h6>
          <h3 class="fw-bold text-success">
            Rp <?= number_format($stats['total_pendapatan'], 0, ',', '.') ?>
          </h3>
          <small class="text-muted"><?= $bulan_names[$bulan] ?> <?= $tahun ?></small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-3">
          <h6 class="text-muted">Rata-rata Transaksi</h6>
          <h3 class="fw-bold text-warning">
            Rp <?= number_format($stats['rata_pendapatan'], 0, ',', '.') ?>
          </h3>
          <small class="text-muted"><?= $bulan_names[$bulan] ?> <?= $tahun ?></small>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mb-4">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">Detail Transaksi - <?= $bulan_names[$bulan] ?> <?= $tahun ?></h5>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Pembeli</th>
                <th>Mobil</th>
                <th>Pembayaran</th>
                <th>Harga</th>
                <th>Admin</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result_transaksi->num_rows > 0): ?>
                <?php while ($row = $result_transaksi->fetch_assoc()): ?>
                  <tr>
                    <td><span class="badge bg-primary"><?= htmlspecialchars($row['kode_transaksi']) ?></span></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                    <td>
                      <div><?= htmlspecialchars($row['nama_pembeli']) ?></div>
                      <small class="text-muted"><?= htmlspecialchars($row['no_hp']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($row['nama_mobil']) ?> (<?= $row['tahun_mobil'] ?>)</td>
                    <td>
                      <span class="badge bg-<?= $row['tipe_pembayaran'] == 'cash' ? 'success' : 'info' ?>">
                        <?= strtoupper($row['tipe_pembayaran']) ?>
                      </span>
                    </td>
                    <td class="fw-bold">Rp <?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['admin_name']) ?></td>
                    <td>
                      <a href="report_transaksi_detail.php?kode=<?= $row['kode_transaksi'] ?>" class="btn btn-sm btn-info">
                          View
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Tidak ada transaksi pada periode ini
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

        <!-- Histori Laporan Bulanan -->
    <div class="card border-0 shadow-sm rounded-3 mb-5">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">Histori Laporan Bulanan</h5>
        <ul class="list-group list-group-flush">
          <?php if ($result_histori && $result_histori->num_rows > 0): ?>
            <?php while ($row = $result_histori->fetch_assoc()): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0 border-bottom">
                <div>
                  <span class="fw-semibold text-dark">Laporan Penjualan Bulanan</span>
                  <p class="mb-0 text-muted small">
                    Periode: <?= htmlspecialchars($row['periode_formatted']) ?> •
                    <?= htmlspecialchars($row['total_transaksi']) ?> transaksi •
                    Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?>
                  </p>
                </div>
                <div>
                  <?php list($y, $m) = explode('-', $row['periode']); ?>
                  <a href="?bulan=<?= $m ?>&tahun=<?= $y ?>" class="text-primary me-3">View</a>
                  <a href="report_pdf.php?bulan=<?= $m ?>&tahun=<?= $y ?>" target="_blank" class="text-secondary">
                    Download
                  </a>
                </div>
              </li>
            <?php endwhile; ?>
          <?php else: ?>
            <li class="list-group-item text-center text-muted py-4">
              Belum ada histori laporan
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

<!-- QUICK REPORTS -->
<div class="card border-0 shadow-sm rounded-3 mb-5">
  <div class="card-body">
    <h5 class="fw-semibold mb-3">Quick Reports</h5>

    <div class="d-flex flex-column gap-3">
      <?php
      $quick_reports = [
        'daily'                => ['Daily Sales Summary',            'Ringkasan penjualan harian'],
        'top_models'           => ['Top Selling Models',             'Model mobil terlaris'],
        'team_performance'     => ['Sales Team Performance',         'Performa tiap admin'],
        'customer_satisfaction'=> ['Customer Satisfaction',          'Tingkat kepuasan'],
        'inventory_turnover'   => ['Inventory Turnover',             'Perputaran stok'],
      ];

      foreach ($quick_reports as $type => $info):
      ?>
      <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded shadow-sm">
        <div>
          <h6 class="mb-1 fw-semibold text-dark"><?= $info[0] ?></h6>
          <small class="text-muted"><?= $info[1] ?></small>
        </div>
        <a href="report_detail.php?type=<?= $type ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>"
           class="btn btn-sm btn-primary">View</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailContent">
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function viewDetail(kodeTransaksi) {
  const modal = new bootstrap.Modal(document.getElementById('detailModal'));
  modal.show();

  fetch('report_transaksi_detail.php?kode=' + kodeTransaksi)
    .then(response => response.text())
    .then(data => {
      document.getElementById('detailContent').innerHTML = data;
    })
    .catch(error => {
      document.getElementById('detailContent').innerHTML =
        '<div class="alert alert-danger">Gagal memuat detail transaksi</div>';
    });
}

function generatePDF() {
  window.open(`report_pdf.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>`, '_blank');
}

function exportExcel() {
  window.location.href = `report_excel.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>`;
}
</script>

<?php include 'partials/footer.php'; ?>
<link rel="stylesheet" href="../../assets/css/report.css">