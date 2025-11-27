<?php

$title = "Transaksi";
require_once 'partials/header.php';
require_once 'partials/sidebar.php';
require_once '../../include/header.php';
// kalau memang BUTUH langsung, pakai require_once juga:
require_once '../../db/config_api.php';
?>

<link rel="stylesheet" href="../../assets/css/admin/detail_transaksi.css?v=1">

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


    <!-- Modal Detail Transaksi -->
<div class="modal fade" id="modalDetailTransaksi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detail Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="dt-container">
          <div class="row g-3 mb-3">
      <!-- Card 1: Data pembeli -->
      <div class="col-md-4">
        <div class="dt-card">
          <div class="dt-card-title">Data pembeli</div>

          <div class="dt-label">Nama pembeli</div>
          <div class="dt-value" id="dt-nama">-</div>

          <div class="dt-label mt-3">No Handphone</div>
          <div class="dt-value" id="dt-nohp">-</div>

          <div class="mt-3">
            <span id="dt-jaminan-ktp">KTP</span>
            <span id="dt-jaminan-kk" class="ms-3">KK</span>
            <span id="dt-jaminan-rek" class="ms-3">Rekening tabungan</span>
          </div>
        </div>
      </div>

      <!-- Card 2: Pembayaran -->
      <div class="col-md-4">
        <div class="dt-card">
          <div class="dt-card-title">Pembayaran</div>

          <div class="dt-label">Jenis</div>
          <div class="dt-value" id="dt-jenis-bayar">-</div>

          <div class="dt-label mt-3">Nama Kredit</div>
          <div class="dt-value" id="dt-nama-kredit">-</div>

          <div class="dt-label mt-3">Note</div>
          <div class="dt-value" id="dt-note-bayar">-</div>
        </div>
      </div>

      <!-- Card 3: Info transaksi -->
      <div class="col-md-4">
        <div class="dt-card">
          <div class="dt-card-title">Info transaksi</div>

          <div class="dt-label">Tanggal transaksi</div>
          <div class="dt-value" id="dt-tanggal">-</div>

          <hr class="dt-separator">

          <div class="dt-label">Kode transaksi</div>
          <div class="dt-value" id="dt-kode">-</div>

          <hr class="dt-separator">

          <div class="dt-label">Kasir</div>
          <div class="dt-value" id="dt-kasir">-</div>
        </div>
      </div>
    </div>

    <!-- Tabel mobil -->
    <div class="dt-table-wrapper">
      <table class="table dt-table mb-0">
        <thead>
          <tr>
            <th>Kode transaksi</th>
            <th>Nama mobil</th>
            <th>Merk</th>
            <th>Tahun</th>
            <th>Full price</th>
            <th>Deal price</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td id="dt-row-kode">-</td>
            <td id="dt-row-mobil">-</td>
            <td id="dt-row-merk">-</td>
            <td id="dt-row-tahun">-</td>
            <td id="dt-row-fullprice">-</td>
            <td id="dt-row-dealprice">-</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Status di pojok kanan bawah -->
        <div class="d-flex justify-content-end mt-2">
          <span id="dt-status-badge" class="badge bg-secondary">-</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

  </main>
</section>

<?php include 'partials/footer.php'; ?>
<!-- JS Bootstrap (kalau belum ada di header) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/transaksi_list.js"></script>
