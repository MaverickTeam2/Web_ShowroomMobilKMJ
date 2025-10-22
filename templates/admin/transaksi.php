<?php
$transaksis = [
  [
    "id" => "TRX001",
    "customer" => "Budi Santoso",
    "mobil" => "Bugatti Tourbillon Widebody Kit",
    "tanggal" => "2025-10-20",
    "status" => "Completed",
    "total" => 300000000
  ],
  [
    "id" => "TRX002",
    "customer" => "Dewi Lestari",
    "mobil" => "Lamborghini Aventador SVJ",
    "tanggal" => "2025-10-19",
    "status" => "Pending",
    "total" => 250000000
  ],
  [
    "id" => "TRX003",
    "customer" => "Joko Widodo",
    "mobil" => "Ferrari F8 Tributo",
    "tanggal" => "2025-10-18",
    "status" => "Cancelled",
    "total" => 280000000
  ]
];


// Hitung statistik sederhana
$totalRevenue = array_sum(array_column($transaksis, 'total'));
$totalTransaksi = count($transaksis);
$averageDeal = $totalTransaksi > 0 ? $totalRevenue / $totalTransaksi : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi</title>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/admin/transaksi.css">
</head>

<body>

  <!-- Header Judul -->
  <div class="head-title d-flex justify-content-between align-items-center">
    <div class="left">
      <h1 class="h3 mb-1">Transaksi</h1>
      <ul class="breadcrumb mb-0">
        <li><a href="#">Dashboard</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a class="active" href="#">Transaksi</a></li>
      </ul>
    </div>

    <!-- Tombol Tambah Transaksi -->
    <button id="btn-tambah-transaksi" class="btn btn-primary d-flex align-items-center">
      <a href="#" id="btn-tambah-transaksi" 
   data-page="tambah_transaksi.php" 
   class="btn btn-primary">
   + Transaksi Baru
</a>
    </button>
  </div>

  <!-- Main Content -->
  <main class="main-content">

    <!-- Search dan Filter -->
    <!-- Search dan Filter -->
<div class="card p-3 mb-4 border-0 shadow-sm">
  <div class="d-flex flex-wrap align-items-center gap-2">
    <!-- Search Input -->
    <div class="flex-grow-1">
      <input type="text" class="form-control" placeholder="Search by customer, transaction ID, or car...">
    </div>

    <!-- Status Filter -->
    <div>
      <select class="form-select border-primary text-primary" style="min-width: 160px;">
        <option selected>All status</option>
        <option>Completed</option>
        <option>Pending</option>
        <option>Cancelled</option>
      </select>
    </div>

    <!-- Export Button -->
    <button class="btn btn-outline-secondary d-flex align-items-center">
      <i class='bx bx-download me-1'></i> Export
    </button>
  </div>
</div>


    <!-- Daftar Transaksi -->
    <div class="card shadow-sm border-0">
      <div class="card-body table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>ID Transaksi</th>
              <th>Customer</th>
              <th>Mobil</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($transaksis as $trx): ?>
              <tr>
                <td><?= htmlspecialchars($trx['id']) ?></td>
                <td><?= htmlspecialchars($trx['customer']) ?></td>
                <td><?= htmlspecialchars($trx['mobil']) ?></td>
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
                <td>Rp <?= number_format($trx['total'], 0, ',', '.') ?></td>
                <td>
                  <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm"><i class="bx bx-edit-alt"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="bx bx-trash"></i></button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Statistik Ringkasan Transaksi -->
<div class="row mt-4 mb-3 px-2">
  <div class="col-md-4 mb-3">
    <div class="stat-card">
      <div class="stat-title">Total revenue</div>
      <div class="stat-value text-green">Rp 830.000.000</div>
      <div class="stat-subtext">Dari 3 transaksi</div>
    </div>
  </div>

  <div class="col-md-4 mb-3">
    <div class="stat-card">
      <div class="stat-title">Average deal</div>
      <div class="stat-value text-blue">Rp 276.666.667</div>
      <div class="stat-subtext">Dari 3 transaksi</div>
    </div>
  </div>

  <div class="col-md-4 mb-3">
    <div class="stat-card">
      <div class="stat-title">Total transaksi</div>
      <div class="stat-value text-purple">3</div>
      <div class="stat-subtext">Dari 3 transaksi</div>
    </div>
  </div>
</div>

  </main>

</body>
</html>
