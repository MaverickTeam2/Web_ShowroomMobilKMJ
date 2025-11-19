<?php
$title = "Dashboard";

// urutan include
include '../../db/config_api.php';
include '../../db/api_client.php';
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../include/header.php';

// ========== 1. Ambil statistik dashboard ==========
$stats = api_get('admin/get_dashboard_stats.php');

$total_mobil = 0;
$pendapatan_bulanan = 0;
$mobil_reserved = 0;
$total_penjualan = 0;

if ($stats && isset($stats['code']) && $stats['code'] == 200 && isset($stats['data'])) {
  $total_mobil = $stats['data']['total_mobil_available'] ?? 0;
  $pendapatan_bulanan = $stats['data']['total_pendapatan_bulan_ini'] ?? 0;
  $mobil_reserved = $stats['data']['total_mobil_reserved'] ?? 0;
  $total_penjualan = $stats['data']['total_transaksi_bulan_ini'] ?? 0;
}

// ========== 2. Ambil recent activity ==========
// ========== 2. Ambil recent activity (lebih banyak untuk modal) ==========
$recent_api = api_get('admin/get_recent_activity.php?limit=50');

$recent_activity_all = [];
$recent_activity_main = [];

if ($recent_api && isset($recent_api['code']) && $recent_api['code'] == 200 && isset($recent_api['data'])) {
  foreach ($recent_api['data'] as $row) {
    $recent_activity_all[] = [
      'judul' => $row['activity_type'] ?? 'Activity',
      'deskripsi' => $row['description'] ?? '',
      'waktu' => $row['created_at'] ?? '',
    ];
  }
  // untuk card kecil di dashboard -> cuma 5 item
  $recent_activity_main = array_slice($recent_activity_all, 0, 5);
} else {
  $recent_activity_all = [];
  $recent_activity_main = [];
}

// Tambahkan block ini:
$clicks = [50, 80, 120, 90, 150, 200, 10];
$days = ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"];
$merk_labels = ["Toyota", "Honda", "Suzuki", "Daihatsu", "Mitsubishi"];
$merk_values = [12, 9, 7, 5, 80];
?>

<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <main class="p-4">
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Dashboard</h1>
        <p class="text-muted mb-0">Pantau aktivitas penjualan mobil anda</p>
      </div>
    </div>

    <!-- Statistik -->
    <div class="row mt-4 mb-3 px-2">
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <img src="../../assets/img/total_mobil.jpg" alt="total_mobil">
          <div class="stat-info">
            <div class="stat-value text-green"><?= $total_mobil ?></div>
            <div class="stat-subtext">Total Available</div>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <img src="../../assets/img/pendapatan_bulanan.jpg" alt="pendapatan_bulanan">
          <div class="stat-info">
            <div class="stat-value text-blue">Rp. <?= number_format($pendapatan_bulanan, 0, ',', '.') ?></div>
            <div class="stat-subtext">Pendapatan bulanan</div>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <img src="../../assets/img/mobil_reserved.jpg" alt="mobil_reserved">
          <div class="stat-info">
            <div class="stat-value text-purple"><?= $mobil_reserved ?></div>
            <div class="stat-subtext">Mobil Reserved</div>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <img src="../../assets/img/total_penjualan.png" alt="total_penjualan">
          <div class="stat-info">
            <div class="stat-value text-purple"><?= $total_penjualan ?></div>
            <div class="stat-subtext">Total penjualan</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Action -->
    <h3 class="QA">Quick Action</h3>
    <div class="btn-group mb-4">
      <button class="btn btn-blue" data-page="tambah_stok_mobil.php"><i class="bx bx-plus"></i> Tambah mobil</button>
      <button class="btn btn-green" data-page="tambah_transaksi.php"><i class="bx bx-dollar"></i> Transaksi
        baru</button>
      <button class="btn btn-purple"><i class="bx bx-printer"></i> Generate laporan</button>
    </div>

    <!-- Recent Activity -->
    <div class="card border-0 shadow-sm">
      <div class="card-body">

        <h3 class="RA mb-3">Recent Activity</h3>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <tbody>
              <?php foreach ($recent_activity_main as $r): ?>
                <tr>
                  <td>
                    <img src="../../assets/img/ic_recentacitivty.jpg" alt="activity"
                      style="width:40px;border-radius:50%;">
                    <div class="d-inline-block ms-2">
                      <p class="mb-0 fw-semibold"><?= htmlspecialchars($r['judul']) ?></p>
                      <small class="text-muted"><?= htmlspecialchars($r['deskripsi']) ?></small>
                    </div>
                  </td>
                  <td class="text-end text-muted"><?= $r['waktu'] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Footer kanan bawah -->
        <div class="d-flex justify-content-end mt-2">
          <button class="btn btn-link p-0 small" style="text-decoration: none !important;" data-bs-toggle="modal"
            data-bs-target="#activityModal">
            Show more 
          </button>

        </div>

      </div>
    </div>



    <!-- Chart Section -->
    <div class="chart-container d-flex flex-wrap gap-4 mt-4">
      <div class="chart-left flex-fill">
        <h3>Total clicks: <span><?= array_sum($clicks) ?></span></h3>
        <canvas id="lineChart"></canvas>
        <div class="time-filter mt-2">
          <button>1d</button>
          <button class="active">1w</button>
          <button>1m</button>
          <button>6m</button>
          <button>1y</button>
        </div>
      </div>

      <div class="chart-right flex-fill">
        <h3>Merk mobil</h3>
        <canvas id="barChart"></canvas>
      </div>
    </div>

    <p class="text-muted text-center my-4">© 2024 Showroom Mobil KMJ</p>
  </main>
</section>

<?php include 'partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctxLine = document.getElementById('lineChart').getContext('2d');
  new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: <?= json_encode($days) ?>,
      datasets: [{
        label: 'Clicks',
        data: <?= json_encode($clicks) ?>,
        borderColor: '#007bff',
        fill: false,
        tension: 0.3
      }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
  });

  const ctxBar = document.getElementById('barChart').getContext('2d');
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: <?= json_encode($merk_labels) ?>,
      datasets: [{
        label: 'Jumlah Mobil',
        data: <?= json_encode($merk_values) ?>,
        backgroundColor: '#8b5cf6'
      }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- ananta yang menambahkan  -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {

    // LINE CHART
    const lineCanvas = document.getElementById('lineChart');
    if (lineCanvas) {
      const ctxLine = lineCanvas.getContext('2d');
      new Chart(ctxLine, {
        type: 'line',
        data: {
          labels: <?= json_encode($days) ?>,
          datasets: [{
            label: 'Clicks',
            data: <?= json_encode($clicks) ?>,
            borderColor: '#007bff',
            fill: false,
            tension: 0.3
          }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
      });
    } else {
      console.error("Canvas lineChart tidak ditemukan!");
    }

    // BAR CHART
    const barCanvas = document.getElementById('barChart');
    if (barCanvas) {
      const ctxBar = barCanvas.getContext('2d');
      new Chart(ctxBar, {
        type: 'bar',
        data: {
          labels: <?= json_encode($merk_labels) ?>,
          datasets: [{
            label: 'Jumlah Mobil',
            data: <?= json_encode($merk_values) ?>,
            backgroundColor: '#8b5cf6'
          }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
      });
    } else {
      console.error("Canvas barChart tidak ditemukan!");
    }

  });
</script>

<!-- untuk data-page agar bisa di bukak  -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-page]').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.getAttribute('data-page');
        if (target) {
          window.location.href = target;
        }
      });
    });
  });
</script>

<!-- showmore -->
<!-- Modal Recent Activity -->
<div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="activityModalLabel">Semua Aktivitas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <?php if (empty($recent_activity_all)): ?>
          <p class="text-muted mb-0">Belum ada aktivitas tercatat.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Aktivitas</th>
                  <th class="text-end">Waktu</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recent_activity_all as $r): ?>
                  <tr>
                    <td>
                      <div>
                        <p class="mb-0 fw-semibold"><?= htmlspecialchars($r['judul']) ?></p>
                        <small class="text-muted"><?= htmlspecialchars($r['deskripsi']) ?></small>
                      </div>
                    </td>
                    <td class="text-end text-muted" style="white-space: nowrap;">
                      <?= htmlspecialchars($r['waktu']) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>