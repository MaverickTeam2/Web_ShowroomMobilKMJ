<?php
$title = "Transaksi";
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../db/koneksi.php';

$query = "
  SELECT 
    t.id_transaksi,
    t.nama_pembeli,
    m.nama_mobil,
    t.created_at AS tanggal,
    t.status,
    t.harga_akhir,
    u.full_name AS kasir
  FROM transaksi t
  LEFT JOIN mobil m ON t.id_mobil = m.id_mobil
  LEFT JOIN users u ON t.user_id = u.id
  ORDER BY t.created_at DESC
";

$result = $conn->query($query);
$transaksis = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $transaksis[] = $row;
  }
}

// Statistik
$totalRevenue = array_sum(array_column($transaksis, 'harga_akhir'));
$totalTransaksi = count($transaksis);
$averageDeal = $totalTransaksi > 0 ? $totalRevenue / $totalTransaksi : 0;
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
          <input type="text" class="form-control" placeholder="Cari nama pembeli, ID, atau mobil...">
        </div>
        <div>
          <select class="form-select border-primary text-primary" style="min-width: 160px;">
            <option selected>All status</option>
            <option>Completed</option>
            <option>Pending</option>
            <option>Cancelled</option>
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
          <tbody>
            <?php if (!empty($transaksis)): ?>
              <?php foreach ($transaksis as $trx): ?>
                <tr>
                  <td><?= htmlspecialchars($trx['id_transaksi']) ?></td>
                  <td><?= htmlspecialchars($trx['nama_pembeli']) ?></td>
                  <td><?= htmlspecialchars($trx['nama_mobil'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($trx['tanggal']) ?></td>
                  <td>
                    <?php if ($trx['status'] === 'Completed'): ?>
                      <span class="badge bg-success">Completed</span>
                    <?php elseif ($trx['status'] === 'Pending'): ?>
                      <span class="badge bg-warning text-dark">Pending</span>
                    <?php else: ?>
                      <span class="badge bg-danger">Cancelled</span>
                    <?php endif; ?>
                  </td>
                  <td>Rp <?= number_format($trx['harga_akhir'], 0, ',', '.') ?></td>
                  <td><?= htmlspecialchars($trx['kasir'] ?? '-') ?></td>
                  <td>
                    <div class="d-flex gap-2">
                      <button class="btn btn-outline-primary btn-sm btn-detail" 
                              data-id="<?= htmlspecialchars($trx['id_transaksi']) ?>">
                        <i class="bx bx-detail"></i>
                      </button>
                      <button class="btn btn-outline-secondary btn-sm">
                        <i class="bx bx-download"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="8" class="text-center text-muted">Belum ada transaksi</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="row mt-4 mb-3 px-2">
      <div class="col-md-4 mb-3">
        <div class="stat-card">
          <div class="stat-title">Total revenue</div>
          <div class="stat-value text-green">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></div>
          <div class="stat-subtext">Dari <?= $totalTransaksi ?> transaksi</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="stat-card">
          <div class="stat-title">Average deal</div>
          <div class="stat-value text-blue">Rp <?= number_format($averageDeal, 0, ',', '.') ?></div>
          <div class="stat-subtext">Rata-rata per transaksi</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="stat-card">
          <div class="stat-title">Total transaksi</div>
          <div class="stat-value text-purple"><?= $totalTransaksi ?></div>
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
