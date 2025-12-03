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

// ========== 2. Ambil recent activity (kecil untuk card) ==========
$allowed_filters = ['all', 'mobil', 'transaksi'];
$filter = isset($_GET['filter']) && in_array($_GET['filter'], $allowed_filters)
  ? $_GET['filter']
  : 'all';

// ini cuma buat card kecil
$recent_api = api_get(
  'admin/get_recent_activity.php?limit=5&filter=' . urlencode($filter)
);

$recent_activity_main = [];

if ($recent_api && isset($recent_api['code']) && $recent_api['code'] == 200 && isset($recent_api['data'])) {
  $recent_activity_main = $recent_api['data'];
} else {
  $recent_activity_main = [];
}


// ========== 3. Ambil data chart dashboard ==========
$chart_api = api_get('admin/get_dashboard_charts.php');

$clicks = [];
$days = [];
$merk_labels = [];
$merk_values = [];

if ($chart_api && isset($chart_api['code']) && $chart_api['code'] == 200 && isset($chart_api['data'])) {
  $clicks = $chart_api['data']['clicks'] ?? [];
  $days = $chart_api['data']['days'] ?? [];
  $merk_labels = $chart_api['data']['merk_labels'] ?? [];
  $merk_values = $chart_api['data']['merk_values'] ?? [];
}
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
      <button class="btn btn-purple" onclick="window.open('report_gabungan_pdf.php', '_blank')">
        <i class="bx bx-printer"></i> Generate laporan
      </button>
    </div>

    <!-- Recent Activity -->
    <div class="card border-0 shadow-sm">
      <div class="card-body">

        <h3 class="RA mb-3 d-flex justify-content-between align-items-center">
          <span>Recent Activity</span>

          <!-- Filter kecil di sebelah kanan judul -->
          <div class="btn-group btn-group-sm" role="group">
            <a href="?filter=all" class="btn btn-outline-secondary <?= ($filter === 'all') ? 'active' : '' ?>"
              style="padding: 4px 14px;">
              Semua
            </a>

            <a href="?filter=mobil" class="btn btn-outline-secondary <?= ($filter === 'mobil') ? 'active' : '' ?>"
              style="padding: 4px 14px;">
              Mobil
            </a>

            <a href="?filter=transaksi"
              class="btn btn-outline-secondary <?= ($filter === 'transaksi') ? 'active' : '' ?>"
              style="padding: 4px 14px;">
              Transaksi
            </a>
          </div>

        </h3>


        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <tbody>
              <?php foreach ($recent_activity_main as $r): ?>
                <tr>
                  <td>
                    <img src="../../assets/img/ic_recentacitivty.jpg" alt="activity"
                      style="width:40px;border-radius:50%;">
                    <div class="d-inline-block ms-2">
                      <p class="mb-0 fw-semibold"><?= htmlspecialchars($r['activity_type']) ?></p>
                      <small class="text-muted"><?= htmlspecialchars($r['description']) ?></small>
                    </div>
                  </td>
                  <td class="text-end text-muted">
                    <?= htmlspecialchars($r['created_at']) ?>
                  </td>
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
      <div class="chart-right flex-fill">
        <h3>Merk mobil</h3>
        <canvas id="barChart"></canvas>
      </div>
    </div>

    <p class="text-muted text-center my-4">© 2024 Showroom Mobil KMJ</p>
  </main>
</section>

<?php include 'partials/footer.php'; ?>

<!-- ananta yang menambahkan  -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {


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
<script>
  document.addEventListener('DOMContentLoaded', () => {

    const activityModal = document.getElementById('activityModal');
    const loadingEl = document.getElementById('activityModalLoading');
    const tableWrapper = document.getElementById('activityModalTableWrapper');
    const tbody = document.getElementById('activityModalBody');
    let currentFilter = '<?= $filter ?>' || 'all';
    let alreadyLoaded = false; // supaya nggak fetch berkali-kali

    function loadActivities(filter) {
      loadingEl.classList.remove('d-none');
      loadingEl.textContent = 'Loading data aktivitas...';
      tableWrapper.classList.add('d-none');
      tbody.innerHTML = '';

      // ⬇️ DI SINI YANG PENTING: panggil PHP lokal, bukan API_kmj
      const url = `ajax_recent_activity.php?limit=50&filter=${encodeURIComponent(filter)}`;

      fetch(url)
        .then(res => res.json())
        .then(json => {
          if (!json || json.code !== 200 || !json.data) {
            loadingEl.textContent = 'Gagal memuat data aktivitas.';
            return;
          }

          if (json.data.length === 0) {
            loadingEl.textContent = 'Belum ada aktivitas tercatat.';
            return;
          }

          json.data.forEach(r => {
            const tr = document.createElement('tr');

            tr.innerHTML = `
              <td>
                <div>
                  <p class="mb-0 fw-semibold">${escapeHtml(r.activity_type ?? '')}</p>
                  <small class="text-muted">${escapeHtml(r.description ?? '')}</small>
                </div>
              </td>
              <td class="text-end text-muted" style="white-space: nowrap;">
                ${escapeHtml(r.created_at ?? '')}
              </td>
            `;

            tbody.appendChild(tr);
          });

          loadingEl.classList.add('d-none');
          tableWrapper.classList.remove('d-none');
        })
        .catch(err => {
          console.error('AJAX error:', err);
          loadingEl.textContent = 'Terjadi kesalahan saat memuat data.';
        });
    }

    // escape sederhana buat cegah XSS
    function escapeHtml(str) {
      if (typeof str !== 'string') return '';
      return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    // load pertama kali saat modal mau ditampilkan
    if (activityModal) {
      activityModal.addEventListener('show.bs.modal', () => {
        if (!alreadyLoaded) {
          loadActivities(currentFilter);
          alreadyLoaded = true;
        }
      });
    }

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

        <div id="activityModalLoading" class="text-muted small">
          Loading data aktivitas...
        </div>

        <div class="table-responsive d-none" id="activityModalTableWrapper">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Aktivitas</th>
                <th class="text-end">Waktu</th>
              </tr>
            </thead>
            <tbody id="activityModalBody">
              <!-- akan diisi lewat JS -->
            </tbody>
          </table>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
