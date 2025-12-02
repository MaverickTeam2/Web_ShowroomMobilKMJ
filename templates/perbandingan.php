<?php
// =======================================
// Ambil parameter dari URL
// Hanya pakai KODE MOBIL (car1 & car2)
// =======================================
$car1Code = isset($_GET['car1']) ? $_GET['car1'] : '';
$car2Code = isset($_GET['car2']) ? $_GET['car2'] : '';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/perbandingan.css" />
  <title>Perbandingan Mobil</title>
</head>
<body>

<!--
  data-car1 & data-car2 dipakai perbandingan.js
  supaya bisa langsung tau kode mobil mana yg mau dibandingkan.
-->
<section
  class="section compare-section"
  data-car1="<?php echo htmlspecialchars($car1Code); ?>"
  data-car2="<?php echo htmlspecialchars($car2Code); ?>"
>
  <div class="container is-fluid">

    <!-- ===== HEADER + INFO MOBIL (STICKY) ===== -->
    <header class="compare-header-sticky">

      <!-- Bar atas: back + title -->
      <div class="compare-header-bar">
        <a href="../templates/katalog.php" class="compare-back-link">
          <i class="fa-solid fa-arrow-left"></i>
          <span>Kembali ke daftar mobil</span>
        </a>
        <h1 class="compare-header-title">Perbandingan Mobil</h1>
      </div>

      <!-- Kartu informasi 2 mobil -->
      <div class="compare-info-wrapper">
        <div class="compare-info-row">
          <div class="compare-info-col" data-car="1">
            <h2 class="compare-info-title" id="car1-title">
              <!-- Placeholder, nanti di-override JS dari API -->
              Memuat mobil 1...
            </h2>
            <p class="compare-info-sub" id="car1-subtitle">
              Tipe / tahun mobil 1
            </p>
            <div class="compare-info-actions">
              <button class="btn-compare-primary">Reservasi</button>
              <button class="btn-compare-outline">Lihat detail</button>
            </div>
          </div>

          <div class="compare-info-col" data-car="2">
            <h2 class="compare-info-title" id="car2-title">
              <!-- Placeholder, nanti di-override JS dari API -->
              Memuat mobil 2...
            </h2>
            <p class="compare-info-sub" id="car2-subtitle">
              Tipe / tahun mobil 2
            </p>
            <div class="compare-info-actions">
              <button class="btn-compare-primary">Reservasi</button>
              <button class="btn-compare-outline">Lihat detail</button>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- ===== FOTO MOBIL (2 KOLOM) ===== -->
    <div class="compare-photo-row">
      <div class="compare-photo-col">
        <img
          id="car1-photo"
          src=""  <!-- nanti diisi dari API lewat JS -->
          alt="Foto mobil 1"
        />
      </div>
      <div class="compare-photo-col">
        <img
          id="car2-photo"
          src=""  <!-- nanti diisi dari API lewat JS -->
          alt="Foto mobil 2"
        />
      </div>
    </div>

    <!-- ===== TAB ===== -->
    <div class="tabs is-centered is-boxed compare-tabs" id="comparisonTabs">
      <ul>
        <li class="is-active" data-tab="highlight"><a>Highlight</a></li>
        <li data-tab="kesamaan"><a>Kesamaan</a></li>
        <li data-tab="perbedaan"><a>Perbedaan</a></li>
        <li data-tab="spesifikasi"><a>Spesifikasi</a></li>
      </ul>
    </div>

    <!-- ===== HIGHLIGHT ===== -->
    <div class="comparison-section" id="tab-highlight">
      <h2 class="section-title">Highlight</h2>
      <!-- diisi penuh lewat API (JS) -->
      <div class="compare-feature-group" id="highlight-group"></div>
    </div>

    <!-- ===== KESAMAAN ===== -->
    <div class="comparison-section" id="tab-kesamaan">
      <h2 class="section-title">Kesamaan</h2>
      <!-- diisi JS dari API -->
      <div class="compare-feature-group" id="similarities-group"></div>
    </div>

    <!-- ===== PERBEDAAN ===== -->
    <div class="comparison-section" id="tab-perbedaan">
      <h2 class="section-title">Perbedaan</h2>
      <!-- diisi JS dari API -->
      <div class="compare-feature-group" id="differences-group"></div>
    </div>

    <!-- ===== SPESIFIKASI ===== -->
    <div class="comparison-section" id="tab-spesifikasi">
      <h2 class="section-title">Spesifikasi</h2>
      <!-- diisi JS dari API -->
      <div class="compare-feature-group" id="specs-group"></div>
    </div>

  </div>
</section>

<!-- Tombol back to top -->
<div style="display:flex;justify-content:center;align-items:center;opacity:85%;">
  <button id="backToTop" class="button is-link is-small"
          style="position:fixed;bottom:30px;left:50%;transform:translateX(-50%);display:none;z-index:1000;">
    Back to Top
  </button>
</div>

<script src="../assets/js/perbandingan.js"></script>
<script src="../assets/js/footer.js"></script>
</body>
</html>
