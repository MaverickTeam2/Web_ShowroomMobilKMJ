<?php
$title = "Detail Laporan Penjualan";

include '../../db/config_api.php';
include '../../db/api_client.php';
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../include/header.php';

$periode = $_GET['periode'] ?? null;

if (!$periode) {
  $errorMessage = 'Periode tidak ditemukan.';
  $transaksi = [];
} else {
  $apiResponse = api_get('admin/report_penjualan_detail.php?periode=' . urlencode($periode));

  $transaksi = [];
  if ($apiResponse && isset($apiResponse['status']) && $apiResponse['status'] === true) {
    $data = $apiResponse['data'] ?? [];
    $periode = $data['periode'] ?? $periode;
    $transaksi = $data['items'] ?? [];
  } else {
    $errorMessage = $apiResponse['message'] ?? 'Gagal mengambil data transaksi dari API';
  }
}
?>
<style>
  /* Paksa link breadcrumb bisa diklik */
  .breadcrumb a {
    position: relative;
    z-index: 9999;
    pointer-events: auto !important;
    cursor: pointer;
  }
</style>

<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <main id="main-content" class="p-4">

    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Detail Laporan Penjualan</h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a href="report.php">Report</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Detail</a></li>
        </ul>

      </div>
      <div>
        <a href="report_penjualan.php" class="btn btn-secondary btn-sm">Kembali</a>
      </div>
    </div>

    <div class="mt-3 mb-3">
      <h5 class="mb-0">Periode: <span class="text-primary"><?= htmlspecialchars($periode) ?></span></h5>
    </div>

    <?php if (isset($errorMessage)): ?>
      <div class="alert alert-danger mt-3">
        <?= htmlspecialchars($errorMessage) ?>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3 mt-3">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">Daftar Transaksi</h5>

        <?php if (empty($transaksi)): ?>
          <p class="text-muted mb-0">Belum ada transaksi pada periode ini.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Kode Transaksi</th>
                  <th>Nama Pembeli</th>
                  <th>Mobil</th>
                  <th>Tipe Pembayaran</th>
                  <th>Harga Akhir</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($transaksi as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td>
                      <?= htmlspecialchars(
                        date('d-m-Y H:i', strtotime($row['created_at']))
                      ) ?>
                    </td>
                    <td><?= htmlspecialchars($row['kode_transaksi']) ?></td>
                    <td><?= htmlspecialchars($row['nama_pembeli'] ?? '-') ?></td>
                    <td>
                      <?= htmlspecialchars($row['nama_mobil'] ?? '-') ?>
                      <br>
                      <small class="text-muted">
                        <?= htmlspecialchars($row['kode_mobil'] ?? '-') ?>
                      </small>
                    </td>
                    <td><?= htmlspecialchars(ucfirst($row['tipe_pembayaran'])) ?></td>
                    <td>Rp <?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                    <td>
                      <span class="badge 
                        <?php
                        $status = $row['status'] ?? '';
                        if ($status === 'completed')
                          echo 'bg-success';
                        elseif ($status === 'pending')
                          echo 'bg-warning text-dark';
                        elseif ($status === 'cancelled')
                          echo 'bg-danger';
                        else
                          echo 'bg-secondary';
                        ?>">
                        <?= htmlspecialchars($status) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </main>
</section>

<?php include 'partials/footer.php'; ?>