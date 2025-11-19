<?php
$title = "Transaksi";
include 'partials/header.php';
include 'partials/sidebar.php';
?>

<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <main id="main-content" class="p-4">
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Transaksi</h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Transaksi</a></li>
        </ul>
      </div>

      <button id="btn-tambah-transaksi" class="btn btn-primary" data-page="tambah_transaksi.php">
        + Transaksi Baru
      </button>
    </div>

    <!-- Search dan Filter -->
    <div class="card p-3 mb-4 border-0 shadow-sm mt-4">
      <div class="d-flex flex-wrap align-items-center gap-2">
        <div class="flex-grow-1">
          <input id="searchTransaksi" type="text" class="form-control"
                 placeholder="Cari nama pembeli, ID, atau mobil...">
        </div>
        <div>
          <select id="filterStatus" class="form-select border-primary text-primary" style="min-width: 160px;">
            <option value="">All status</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
        <button class="btn btn-outline-secondary d-flex align-items-center">
          <i class='bx bx-download me-1'></i> Export
        </button>
      </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="card shadow-sm border-0">
      <div class="card-body table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nama Pembeli</th>
              <th>Mobil</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Harga Akhir</th>
              <th>Kasir</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody-transaksi">
            <!-- Akan diisi via JS dari API -->
            <tr>
              <td colspan="8" class="text-center text-muted">Memuat data...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="row mt-4 mb-3 px-2">
      <div class="col-md-4 mb-3">
        <div class="stat-card">
          <div class="stat-title">Total revenue</div>
          <div id="statTotalRevenue" class="stat-value text-green">Rp 0</div>
          <div id="statTotalTransaksi1" class="stat-subtext">Dari 0 transaksi</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="stat-card">
          <div class="stat-title">Average deal</div>
          <div id="statAverageDeal" class="stat-value text-blue">Rp 0</div>
          <div class="stat-subtext">Rata-rata per transaksi</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="stat-card">
          <div class="stat-title">Total transaksi</div>
          <div id="statTotalTransaksi2" class="stat-value text-purple">0</div>
          <div class="stat-subtext">Keseluruhan</div>
        </div>
      </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetailTransaksi" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Detail Transaksi</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" id="modalDetailBody"></div>
          <p class="text-muted text-center mb-3">© 2024 Showroom Mobil KMJ</p>
        </div>
      </div>
    </div>

  </main>
</section>

<?php include 'partials/footer.php'; ?>
<script src="../../assets/js/transaksi.js"></script>
