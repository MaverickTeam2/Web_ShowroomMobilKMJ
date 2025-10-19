<?php
$mobils = [
  [
    "nama" => "Bugatti Tourbillon Widebody Kit",
    "tahun" => 2023,
    "warna" => "Hitam",
    "stok" => 20,
    "harga" => 30000000,
    "status" => "Available",
    "gambar" => "../../assets/img/12.jpg"
  ],
  [
    "nama" => "Bugatti Tourbillon Widebody Kit",
    "tahun" => 2023,
    "warna" => "Hitam",
    "stok" => 20,
    "harga" => 30000000,
    "status" => "Available",
    "gambar" => "../../assets/img/1.jpg"
  ],
  [
    "nama" => "Bugatti Tourbillon Widebody Kit",
    "tahun" => 2023,
    "warna" => "Hitam",
    "stok" => 0,
    "harga" => 30000000,
    "status" => "Sold",
    "gambar" => "../../assets/img/2.jpg"
  ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../assets/css/admin/manajemen_mobil.css">
</head>

<body>
  <div class="head-title d-flex justify-content-between align-items-center">
    <div class="left">
      <h1>Manajemen Mobil</h1>
      <ul class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a class="active" href="#">manajemen Mobil</a></li>
      </ul>
    </div>

    <!-- Tombol Tambah Mobil -->
   <button id="btn-tambah-mobil" class="btn btn-primary d-flex align-items-center" data-page="tambah_stok_mobil.php">
  <i class="bx bx-plus me-2"></i> Tambah Mobil
</button>
  </div>
  <!-- Main Content -->
  <main class="p-4">


    <!-- Search dan Filter -->
    <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
      <div class="input-group" style="max-width: 1000px;">
        <span class="input-group-text bg-white border-end-0"><i class="bx bx-search"></i></span>
        <input type="text" class="form-control border-start-0" placeholder="Cari mobil, model, atau tahun...">
      </div>
      <button class="btn btn-outline-secondary d-flex align-items-center">
        <i class="bx bx-filter-alt me-2"></i> Filter
      </button>
    </div>

    <!-- Grid Card Mobil -->
    <div class="row g-4">
      <?php foreach ($mobils as $mobil): ?>
        <div class="col-md-4 col-sm-6">
          <div class="card shadow-sm border-0 h-100">
            <img src="<?= htmlspecialchars($mobil['gambar']) ?>" class="card-img-top"
              alt="<?= htmlspecialchars($mobil['nama']) ?>">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="card-title fw-bold mb-0"><?= htmlspecialchars($mobil['nama']) ?></h5>
                <?php if ($mobil['status'] === 'Available'): ?>
                  <span class="badge bg-success">Available</span>
                <?php else: ?>
                  <span class="badge bg-danger">Sold</span>
                <?php endif; ?>
              </div>
              <p class="text-muted mb-1">Tahun: <?= $mobil['tahun'] ?></p>
              <p class="text-muted mb-1">Warna: <?= htmlspecialchars($mobil['warna']) ?></p>
              <p class="text-muted mb-2">Stok: <?= $mobil['stok'] ?> Unit</p>
              <h6 class="fw-bold text-primary mb-3">
                Rp. <?= number_format($mobil['harga'], 0, ',', '.') ?> x <?= $mobil['stok'] ?>
              </h6>
              <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-outline-primary btn-sm">
                  <i class="bx bx-edit-alt"></i>
                </button>
                <button class="btn btn-outline-danger btn-sm">
                  <i class="bx bx-trash"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

</body>

</html>