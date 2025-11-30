<?php
$title = "detail_mobil";

require_once __DIR__ . '/../db/config_api.php';
require_once __DIR__ . '/../db/api_client.php';
require_once __DIR__ . '/../include/header.php';

$kode = $_GET['kode'] ?? '';

if (!$kode) {
  die("Kode mobil tidak dikirim.");
}

// Panggil API detail
$api = api_get('admin/web_mobil_detail.php?kode_mobil=' . urlencode($kode));

if (!$api || !isset($api['success']) || !$api['success']) {
  die("Gagal mengambil data mobil: " . ($api['message'] ?? 'Unknown error'));
}

$mobil = $api['mobil'] ?? null;
$fitur = $api['fitur'] ?? [];
$foto = $api['foto'] ?? [];
$jaminan = $api['jaminan'] ?? []; // kalau kamu tambahkan di API

if (!$mobil) {
  die("Data mobil tidak ditemukan.");
}

// ========== Olah data untuk dipakai di view ==========
$carTitle = $mobil['nama_mobil'] . ' ' . $mobil['tahun_mobil'];
$downPayment = $mobil['uang_muka'] ?? 0;
$installment = $mobil['angsuran'] ?? 0;
$tenor = $mobil['tenor'] ?? 0;
$warnaExt = $mobil['warna_exterior'] ?? '-';
$warnaInt = $mobil['warna_interior'] ?? '-';
$jenis = $mobil['jenis_kendaraan'] ?? '-';
$drive = $mobil['sistem_penggerak'] ?? '-';
$bahanBakar = $mobil['tipe_bahan_bakar'] ?? '-';
$jarakTempuh = $mobil['jarak_tempuh'] ?? 0;
$fullPrice = $mobil['full_prize'] ?? 0;

// Foto: jadikan array URL
$images = [];
foreach ($foto as $f) {
  $images[] = $f['nama_file']; // sudah full URL dari API
}

// Kalau tidak ada foto sama sekali
if (empty($images)) {
  $images[] = '../assets/img/no-image.jpg';
}

// Group fitur per kategori biar rapi
$fiturByKategori = [];
foreach ($fitur as $f) {
  $kat = $f['nama_kategori'] ?? 'Lainnya';
  if (!isset($fiturByKategori[$kat])) {
    $fiturByKategori[$kat] = [];
  }
  $fiturByKategori[$kat][] = $f['nama_fitur'] ?? ('Fitur #' . $f['id_fitur']);
}
$kategoriIcon = [
  'Keselamatan' => 'fa-shield-halved',
  'Kenyamanan & Hiburan' => 'fa-music',
  'Exterior' => 'fa-car-side',
  'Fitur Tambahan' => 'fa-circle-plus',
  'Lainnya' => 'fa-circle-info'
];

// =====================
// REKOMENDASI MOBIL
// =====================
$rekomendasi = [];

// label status biar mirip di katalog
$statusLabelMap = [
  'available' => 'Available',
  'reserved' => 'Reserved',
  'sold' => 'Sold',
  'shipping' => 'Shipping',
  'delivered' => 'Delivered',
];

// panggil API list mobil
$apiList = api_get('admin/web_mobil_list.php');
if ($apiList && !empty($apiList['success']) && $apiList['success']) {
  $allCars = $apiList['data'] ?? [];

  // cari "merk" mobil sekarang
  // kalau di tabel kamu ada kolom merk_mobil / merek, bisa ganti:
  // $currentBrand = $mobil['merk_mobil'] ?? $mobil['merek'] ?? ...
  $currentBrand = $mobil['merek'] ?? $mobil['brand'] ?? strtok($mobil['nama_mobil'], ' ');

  $sameBrand = [];
  foreach ($allCars as $m) {
    // jangan rekomendasikan dirinya sendiri
    if (($m['kode_mobil'] ?? '') === ($mobil['kode_mobil'] ?? '')) {
      continue;
    }

    // ambil brand dari data list
    $brand = $m['merek'] ?? $m['brand'] ?? strtok($m['nama_mobil'], ' ');

    if (strcasecmp($brand, $currentBrand) === 0) {
      $sameBrand[] = $m;
    }
  }

  // fungsi sort berdasarkan tahun mobil (paling baru dulu)
  $sortByYearDesc = function (&$arr) {
    usort($arr, function ($a, $b) {
      return (int) ($b['tahun_mobil'] ?? 0) <=> (int) ($a['tahun_mobil'] ?? 0);
    });
  };

  if (!empty($sameBrand)) {
    // kalau ada merk sama, pakai itu
    $sortByYearDesc($sameBrand);
    $rekomendasi = array_slice($sameBrand, 0, 4);
  } else {
    // kalau tidak ada merk sama, pakai mobil paling baru
    $sortByYearDesc($allCars);
    $rekomendasi = array_slice($allCars, 0, 4);
  }
}

?>

<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($carTitle); ?></title>

  <!-- CSS lib -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS custom -->
  <link rel="stylesheet" href="../assets/css/detailmob.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="../assets/css/katalog2.css?v=<?= time(); ?>">

</head>

<body>
  <!-- Navbar -->
  <?php include '../templates/navbar_footer/navbar.php'; ?>

  <div class="container mt-4">
    <a href="katalog.php" class="text-decoration-none mb-3 d-inline-block">← Kembali ke katalog</a>
    <h3 class="fw-bold"><?= htmlspecialchars($carTitle); ?></h3>

    <!-- Warna -->
    <div class="mb-3">
      <span class="badge bg-light text-dark border me-2">
        Exterior: <?= htmlspecialchars($warnaExt); ?>
      </span>
      <span class="badge bg-light text-dark border me-2">
        Interior: <?= htmlspecialchars($warnaInt); ?>
      </span>
      <span class="badge bg-light text-dark border me-2">
        <?= htmlspecialchars($jenis); ?>
      </span>
    </div>

    <!-- Harga -->
    <div class="d-flex flex-wrap gap-3 mb-4">
      <div><b>Harga OTR:</b> Rp <?= number_format($fullPrice, 0, ',', '.'); ?></div>
      <div><b>DP:</b> Rp <?= number_format($downPayment, 0, ',', '.'); ?></div>
      <div><b>Angsuran:</b> Rp <?= number_format($installment, 0, ',', '.'); ?> x <?= (int) $tenor; ?></div>
    </div>

    <!-- GALERI -->
    <div class="gallery-container">
      <!-- Tombol kiri -->
      <button class="scroll-btn left">❮</button>

      <div class="gallery-wrapper">
        <div class="gallery-item">
          <!-- Foto besar -->
          <div class="hero-image">
            <img src="<?= htmlspecialchars($images[0]); ?>" alt="">
            <!-- Tab navigasi -->
            <div class="gallery-tabs">
              <button class="tab active">Exterior</button>
              <button class="tab">Interior</button>
              <button class="tab">Key features</button>
            </div>
          </div>

          <!-- Foto kecil kiri -->
          <div class="sub-col">
            <?php if (isset($images[1])): ?>
              <img src="<?= htmlspecialchars($images[1]); ?>" alt="" class="thumb-img">
            <?php endif; ?>
            <?php if (isset($images[2])): ?>
              <img src<?= '="' . htmlspecialchars($images[2]) . '"'; ?> alt="" class="thumb-img">
            <?php endif; ?>
          </div>

          <!-- Foto kecil kanan -->
          <div class="sub-col">
            <?php if (isset($images[3])): ?>
              <img src="<?= htmlspecialchars($images[3]); ?>" alt="" class="thumb-img">
            <?php endif; ?>
            <?php if (isset($images[4])): ?>
              <img src="<?= htmlspecialchars($images[4]); ?>" alt="" class="thumb-img">
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Tombol kanan -->
      <button class="scroll-btn right">❯</button>
    </div>

    <!-- STICKY NAVBAR / TABS -->
    <div class="sticky-tabs">
      <div class="tabs-wrapper">
        <button class="tab-item active" data-target="#info">Informasi</button>
        <button class="tab-item" data-target="#features">Features & specs</button>
        <button class="tab-item" data-target="#history">History & Inspection</button>
        <button class="tab-item" data-target="#warranty">Warranty</button>
      </div>
    </div>

    <!-- Informasi -->
    <section id="info" class="container px-0 mt-4">
      <h4 class="mt-4"><b>Informasi</b></h4>
      <div class="row">
        <div class="col-md-4">
          <p><b>Bahan Bakar:</b> <?= htmlspecialchars($bahanBakar); ?></p>
        </div>
        <div class="col-md-4">
          <p><b>Sistem Penggerak:</b> <?= htmlspecialchars($drive); ?></p>
        </div>
        <div class="col-md-4">
          <p><b>Jarak Tempuh:</b> <?= number_format($jarakTempuh, 0, ',', '.'); ?> Km</p>
        </div>
      </div>
    </section>

    <!-- Fitur & Spesifikasi -->
    <!-- Fitur & Spesifikasi -->
    <section id="features" class="container px-0 mt-4">
      <h4 class="fw-bold mb-3">Fitur & spesifikasi</h4>

      <?php if (empty($fiturByKategori)): ?>
        <p class="text-muted">Belum ada fitur terdaftar untuk mobil ini.</p>
      <?php else: ?>

        <?php
        $prioritasKategori = [
          'Keselamatan',
          'Kenyamanan & Hiburan',
          'Exterior'
        ];
        ?>

        <div class="row">

          <?php foreach ($prioritasKategori as $kat): ?>
            <?php if (!isset($fiturByKategori[$kat]))
              continue; ?>

            <?php
            $items = $fiturByKategori[$kat];
            $tigaPertama = array_slice($items, 0, 3);
            $icon = $kategoriIcon[$kat] ?? 'fa-circle-info';
            ?>

            <div class="col-md-4 mb-4">

              <h6 class="fw-bold mb-2">
                <i class="fa-solid <?= $icon ?> me-2 text-primary"></i>
                <?= htmlspecialchars($kat); ?>
              </h6>

              <ul class="mb-1">
                <?php foreach ($tigaPertama as $namaFitur): ?>
                  <li>
                    <i class="fa-solid fa-check text-success me-1"></i>
                    <?= htmlspecialchars($namaFitur); ?>
                  </li>
                <?php endforeach; ?>
              </ul>

              <?php if ($kat === 'Keselamatan'): ?>
                <!-- Tombol showmore di bawah kolom Keselamatan -->
                <button type="button" class="btn btn-outline-primary px-4 py-2 mt-2 fitur-showmore" data-bs-toggle="modal"
                  data-bs-target="#fiturModal">
                  <i class="fa-solid fa-list-check me-2"></i>
                  Lihat semua fitur
                </button>
              <?php endif; ?>

            </div>

          <?php endforeach; ?>
        </div>

      <?php endif; ?>
    </section>

    <!-- Modal: Fitur Lengkap -->
    <div class="modal fade" id="fiturModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-width:550px;">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title fw-bold">Fitur & Spesifikasi Lengkap</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">

            <?php foreach ($fiturByKategori as $kategori => $items): ?>
              <div class="mb-3">
                <h6 class="fw-bold mb-2"><?= htmlspecialchars($kategori); ?></h6>
                <ul class="mb-0">
                  <?php foreach ($items as $namaFitur): ?>
                    <li>
                      <i class="fa-solid fa-circle-check text-success me-1"></i>
                      <?= htmlspecialchars($namaFitur); ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>

          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>

        </div>
      </div>
    </div>






    <!-- History (sementara statis / bisa nanti dari DB transaksi) -->
    <!-- History (sementara statis / bisa nanti dari DB transaksi) -->
    <div id="history" class="py-4">
      <h4 class="fw-bold mb-3">Sejarah & Inspeksi</h4>
      <p class="text-muted mb-3">
        Setiap unit yang dipajang di katalog kami melalui proses pengecekan dasar berikut:
      </p>

      <div class="row g-3">
        <div class="col-md-4">
          <div class="border rounded-3 p-3 h-100">
            <div class="d-flex align-items-center mb-2">
              <i class="fa-solid fa-gauge-high text-primary me-2"></i>
              <strong>Cek Kilometer</strong>
            </div>
            <p class="mb-0 text-muted">
              Pengecekan jarak tempuh dan kondisi pemakaian mobil secara keseluruhan.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="border rounded-3 p-3 h-100">
            <div class="d-flex align-items-center mb-2">
              <i class="fa-solid fa-file-shield text-success me-2"></i>
              <strong>Dokumen & Legalitas</strong>
            </div>
            <p class="mb-0 text-muted">
              STNK dan BPKB dipastikan sesuai dengan data kendaraan yang terdaftar.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="border rounded-3 p-3 h-100">
            <div class="d-flex align-items-center mb-2">
              <i class="fa-solid fa-stethoscope text-warning me-2"></i>
              <strong>Inspeksi Visual</strong>
            </div>
            <p class="mb-0 text-muted">
              Pengecekan eksterior & interior untuk melihat kondisi umum bodi dan kabin.
            </p>
          </div>
        </div>
      </div>

      <p class="mt-3 text-muted">
        Untuk hasil inspeksi detail, silakan hubungi tim sales kami.
      </p>
    </div>



    <!-- Warranty / Jaminan -->
    <!-- Warranty / Jaminan -->
    <div id="warranty" class="py-4">
      <h4 class="fw-bold mb-3">Jaminan</h4>

      <?php if (empty($jaminan)): ?>
        <p class="text-muted">
          Saat ini belum ada jaminan khusus yang terikat pada unit ini.
          Silakan konsultasikan dengan tim sales kami untuk mengetahui opsi garansi dan perlindungan yang tersedia.
        </p>

        <ul class="text-muted">
          <li><i class="fa-solid fa-circle-check text-success me-1"></i> Opsi garansi mesin & transmisi (sesuai kebijakan
            showroom)</li>
          <li><i class="fa-solid fa-circle-check text-success me-1"></i> Bantuan pengurusan administrasi kendaraan</li>
          <li><i class="fa-solid fa-circle-check text-success me-1"></i> Penjelasan detail kondisi unit sebelum transaksi
          </li>
        </ul>

      <?php else: ?>
        <div class="accordion" id="warrantyAccordion">
          <?php $i = 0;
          foreach ($jaminan as $j):
            $id = 'collapse' . $i; ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading<?= $i; ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#<?= $id; ?>" aria-expanded="false" aria-controls="<?= $id; ?>">
                  <i class="bi bi-check2-circle text-success me-2"></i>
                  <?= htmlspecialchars($j['nama_jaminan']); ?>
                </button>
              </h2>
              <div id="<?= $id; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $i; ?>"
                data-bs-parent="#warrantyAccordion">
                <div class="accordion-body">
                  Detail jaminan bisa diisi sesuai kebijakan showroom.
                </div>
              </div>
            </div>
            <?php $i++; endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    <!-- REKOMENDASI MOBIL -->
    <?php if (!empty($rekomendasi)): ?>
      <div id="recommendation" class="py-4">
        <h4 class="fw-bold mb-3">Rekomendasi untuk Anda</h4>

        <div class="row g-3">
          <?php foreach ($rekomendasi as $r): ?>
            <?php
            $imgR = !empty($r['foto']) ? $r['foto'] : '../assets/img/no-image.jpg';
            $statusR = $r['status'] ?? 'available';
            $statusLabelR = $statusLabelMap[$statusR] ?? ucfirst($statusR);
            ?>
            <div class="col-lg-3 col-md-4 col-6">
              <div class="card car-card shadow-sm h-100">

                <div class="card-image position-relative">
                  <figure class="image image-wrapper mb-0">
                    <img src="<?= htmlspecialchars($imgR); ?>" alt="<?= htmlspecialchars($r['nama_mobil'] ?? 'Mobil'); ?>"
                      class="img_main card-img-top">
                    <span class="status-badge <?= htmlspecialchars($statusR); ?>">
                      <?= htmlspecialchars($statusLabelR); ?>
                    </span>
                  </figure>
                </div>

                <div class="card-content p-3">

                  <!-- Nama mobil -->
                  <a href="detail_mobil.php?kode=<?= urlencode($r['kode_mobil']); ?>"
                    class="text-decoration-none d-block mb-1" style="font-size:16px;">
                    <p class="mb-1 fw-semibold">
                      <?= htmlspecialchars($r['nama_mobil'] ?? 'Tanpa nama'); ?>
                    </p>
                  </a>

                  <!-- Angsuran x tenor -->
                  <p class="mb-1" style="font-size:15px; font-weight:700; color:#111827;">
                    Rp <?= number_format($r['angsuran'] ?? 0, 0, ',', '.'); ?>
                    <span style="font-weight:500;">
                      x <?= htmlspecialchars($r['tenor'] ?? '-'); ?>
                    </span>
                  </p>

                  <!-- DP -->
                  <p class="mb-2" style="font-size:13px; font-weight:500; color:#4b5563;">
                    DP Rp <?= number_format($r['dp'] ?? 0, 0, ',', '.'); ?>
                  </p>

                  <!-- KM & Tahun -->
                  <div class="d-flex align-items-center gap-2" style="font-size:13px; color:#4b5563;">
                    <span><?= number_format($r['jarak_tempuh'] ?? 0, 0, ',', '.'); ?> Km</span>
                    <span class="mx-1">•</span>
                    <span><?= htmlspecialchars($r['tahun_mobil'] ?? '-'); ?></span>
                  </div>

                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>




    <!-- Rekomendasi: nanti bisa diganti dengan API lain / list mobil serupa -->
    <!-- Untuk sekarang boleh kosong atau pakai dummy seperti punyamu -->
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/detail_mobil.js"></script>
  <script src="../assets/js/footer.js" defer></script>
</body>

</html>