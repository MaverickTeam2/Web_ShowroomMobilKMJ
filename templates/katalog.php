<?php
// SETUP API DULU
$title = "katalog";

// path disesuaikan karena katalog.php ada di root WEB_SHOWROOMMOBILKMJ
require_once __DIR__ . '/../db/config_api.php';
require_once __DIR__ . '/../db/api_client.php';
require_once __DIR__ . '/../include/header.php';

// PANGGIL API
$api = api_get('admin/web_mobil_list.php');

// Bikin pengecekan defensif (aman)
if (!$api || !isset($api['success']) || !$api['success']) {
  $mobil = [];
} else {
  $mobil = $api['data'] ?? [];
}

// TOTAL MOBIL
$jumlahMobil = count($mobil);

// BAHAN BAKAR (ini boleh tetap static dulu)
$bahanBakar = [
  "Diesel" => 660,
  "Electric" => 1897,
  "Gas" => 63367,
  "Hybrid" => 2915,
  "Plug-In Hybrid" => 1256
];

$statusLabelMap = [
  'available' => 'Available',
  'reserved' => 'Reserved',
  'sold' => 'Sold',
  'shipping' => 'Shipping',
  'delivered' => 'Delivered',
];
?>

<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
  <meta charset="UTF-8">
  <title>KMJ - Katalog Mobil</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo_KMJ_YB2.ico">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/katalog2.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="../assets/css/wishlist_sidebar.css?v=<?= time(); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="page-katalog">
  <!-- navbar -->
  <?php include '../templates/navbar_footer/navbar.php'; ?>
  
  <?php
  // Cek user login
  $isLoggedIn = isset($_SESSION['full_name']);
  $kodeUser = $_SESSION['user_id'] ?? ($_SESSION['kode_user'] ?? '');
  $fullName = $_SESSION['full_name'] ?? '';
  $email = $_SESSION['email'] ?? '';
  
  // Ambil data favorit
  $favoritMobil = [];
  if (!empty($kodeUser)) {
    $favApi = api_get('user/routes/favorites.php?kode_user=' . urlencode($kodeUser));
    if ($favApi && isset($favApi['success']) && $favApi['success']) {
      $favoritMobil = array_column($favApi['data'], 'kode_mobil');
    }
  }
  ?>

  <script>
    // Konstanta untuk JavaScript
    const IS_LOGGED_IN = <?= $isLoggedIn ? 'true' : 'false' ?>;
    const CURRENT_USER = {
      kode_user: "<?= $kodeUser ?>",
      full_name: "<?= addslashes($fullName) ?>",
      email: "<?= addslashes($email) ?>"
    };
    const favoritMobil = <?= json_encode($favoritMobil) ?>;
    
    // Data mobil dari PHP
    let allMobil = <?= json_encode($mobil) ?>;
    let filteredMobil = [...allMobil];
  </script>

  <!-- Card Container -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Filter -->
      <aside class="col-12 col-md-4 col-lg-3 mb-3 order-0 order-md-0" id="sidebar-filter">
        <div class="card p-3 shadow-sm">
          <h5 class="filter-header d-flex justify-content-between align-items-center">
            <span>Filter & Urutkan</span>
            <div class="hapus" style="cursor:pointer; color:#007bff;">Hapus Filter</div>
          </h5>
          <p>Tambahkan filter untuk menyimpan pencarian Anda dan dapatkan pemberitahuan saat inventaris baru tiba.</p>
          <hr>
          
          <div class="accordion" id="accordionPanelsStayOpenExample">
            <!-- Item 1 - Urutkan -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                  Urutkan Berdasarkan
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortOption" id="bestMatch" value="best" checked>
                    <label class="form-check-label" for="bestMatch">Terbaik</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortOption" id="lowestPrice" value="lowestPrice">
                    <label class="form-check-label" for="lowestPrice">Harga Terendah</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortOption" id="highestPrice" value="highestPrice">
                    <label class="form-check-label" for="highestPrice">Harga Tertinggi</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortOption" id="newestYear" value="newestYear">
                    <label class="form-check-label" for="newestYear">Tahun Terbaru</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 2 - Harga -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                  Harga
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <div class="mb-3">
                    <label for="minPrice" class="form-label">Harga Minimal</label>
                    <select id="minPrice" class="form-select">
                      <option value="">Semua</option>
                      <option value="50000000">Rp 50 Juta</option>
                      <option value="100000000">Rp 100 Juta</option>
                      <option value="150000000">Rp 150 Juta</option>
                      <option value="200000000">Rp 200 Juta</option>
                      <option value="300000000">Rp 300 Juta</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="maxPrice" class="form-label">Harga Maksimal</label>
                    <select id="maxPrice" class="form-select">
                      <option value="">Semua</option>
                      <option value="100000000">Rp 100 Juta</option>
                      <option value="200000000">Rp 200 Juta</option>
                      <option value="300000000">Rp 300 Juta</option>
                      <option value="500000000">Rp 500 Juta</option>
                      <option value="1000000000">Rp 1 Miliar+</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 3 - Tahun -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                  Tahun
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <div class="mb-3">
                    <label for="fromYear" class="form-label">Dari Tahun</label>
                    <input class="form-control" list="fromYearOptions" id="fromYear" placeholder="Pilih tahun...">
                    <datalist id="fromYearOptions">
                      <?php for ($year = 2000; $year <= date("Y"); $year++) echo "<option value='$year'>"; ?>
                    </datalist>
                  </div>
                  <div class="mb-3">
                    <label for="toYear" class="form-label">Sampai Tahun</label>
                    <input class="form-control" list="toYearOptions" id="toYear" placeholder="Pilih tahun...">
                    <datalist id="toYearOptions">
                      <?php for ($year = 2000; $year <= date("Y"); $year++) echo "<option value='$year'>"; ?>
                    </datalist>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 4 - Jarak Tempuh -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                  Jarak Tempuh
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <div class="mb-3">
                    <label for="maxMileage" class="form-label">Maksimal Jarak (Km)</label>
                    <select id="maxMileage" class="form-select">
                      <option value="">Semua</option>
                      <option value="10000">10,000 Km</option>
                      <option value="20000">20,000 Km</option>
                      <option value="50000">50,000 Km</option>
                      <option value="100000">100,000 Km</option>
                      <option value="150000">150,000 Km</option>
                      <option value="200000">200,000 Km+</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 5 - Bahan Bakar -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                  Jenis Bahan Bakar
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <div class="fuel-filter">
                    <?php foreach ($bahanBakar as $jenis => $jumlah): ?>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="<?= $jenis ?>" id="fuel_<?= strtolower(str_replace([' ', '-'], '_', $jenis)) ?>">
                        <label class="form-check-label" for="fuel_<?= strtolower(str_replace([' ', '-'], '_', $jenis)) ?>">
                          <?= $jenis ?> (<?= number_format($jumlah, 0, ',', '.') ?>)
                        </label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </aside>

      <!-- Konten Daftar Mobil -->
      <main class="col-lg-9 col-md-8 col-12 order-1 order-md-1" id="catalog-content">
        <div class="comparison-header d-flex justify-content-between align-items-center mb-4">
          <div>
            <span class="comparison-count">
              <h5>Total <span id="totalMobil"><?= $jumlahMobil; ?></span> Mobil Tersedia</h5>
            </span>
          </div>
          <div class="comparison-toggle d-flex align-items-center">
            <span class="me-2">Perbandingan</span>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" id="togglePerbandingan">
            </div>
          </div>
        </div>

<<<<<<< HEAD
        <!-- BAR PERBANDINGAN (pindahkan ke sini) -->
      <div id="compareToolbar" class="compare-toolbar">
        <div class="compare-toolbar-inner">
          <div class="compare-slot" data-slot="0">
            <span class="compare-slot-placeholder">Pilih mobil pertama</span>
          </div>
          <div class="compare-slot" data-slot="1">
            <span class="compare-slot-placeholder">Pilih mobil kedua</span>
          </div>
          <button id="compareGoBtn" class="btn-compare-go" disabled>Go</button>
        </div>
      </div>

        <section class="section">
          <div class="row g-4">
            <?php if (empty($mobil)): ?>
              <div class="col-12 text-center text-muted py-5">
                Belum ada data mobil.
              </div>
              
            <?php else: ?>
              <?php foreach ($mobil as $m): ?>
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                  <div class="card car-card shadow-sm h-100">
                    <data-id="<?= $m['kode_mobil'] ?>"
                    data-name="<?= htmlspecialchars($m['nama_mobil'] ?? 'Tanpa Nama') ?>"
                    data-img="<?= $img ?>"></data-id>

                    

                    <?php
                    // gambar: dari API (full URL) atau fallback
                    $img = !empty($m['foto'])
                      ? $m['foto']
                      : '../assets/img/no-image.jpg';

                    // STATUS per mobil
                    $status = $m['status'] ?? 'available';
                    $statusLabel = $statusLabelMap[$status] ?? $status;
                    ?>
                    <div class="card-image position-relative">
                      <figure class="image image-wrapper mb-0">
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil Tanpa Nama') ?>"
                          class="img_main card-img-top">

                        <!-- STATUS di dalam gambar, pojok kiri atas -->
                        <span class="status-badge <?= htmlspecialchars($status) ?>">
                          <?= htmlspecialchars($statusLabel); ?>
                        </span>

                        <!-- Favorite, pojok kanan atas -->
                        <?php
                        // cek apakah mobil ini ada di daftar favorit user
                        $isFavorit = in_array($m['kode_mobil'], $favoritMobil ?? []);
                        ?>
                        <span class="icon-favorite <?= $isFavorit ? 'active' : '' ?>"
                          data-kode-mobil="<?= htmlspecialchars($m['kode_mobil']) ?>">
                          <i class="fa-solid fa-heart"></i>
                        </span>

                      </figure>
                    </div>

                    <div class="card-content p-3">

                      <!-- NAMA MOBIL -->
                      <a href="../templates/detail_mobil.php?kode=<?= urlencode($m['kode_mobil']) ?>"
                        class="text-decoration-none mb-2 d-inline-block" style="font-size:25px;">
                        <p class="title is-5 mb-1">
                          <?= htmlspecialchars($m['nama_mobil'] ?? 'Tanpa Nama') ?>
                        </p>
                      </a>

                      <!-- ANGSURAN x TENOR -->
                      <p class="ansguran mb-1" style="font-size:25px; font-weight:700; color:#111827; margin-bottom:4px;">
                        Rp <?= number_format($m['angsuran'] ?? 0, 0, ',', '.') ?>
                        <span style="font-weight:600;">
                          x <?= htmlspecialchars($m['tenor'] ?? '-') ?>
                        </span>
                      </p>

                      <p class="uang_dp mb-2" style="font-size:20px; font-weight:600; color:#111827; margin-bottom:6px;">
                        Dp Rp <?= number_format($m['dp'] ?? 0, 0, ',', '.') ?>
                      </p>


                      <hr class="my-2">

                      <!-- KM & TAHUN -->
                      <div class="info d-flex align-items-center gap-2">
                        <img src="../assets/img/kecepatan.jpg" alt="" style="width:30px;height:30px;">
                        <span style="font-size: 20px">
                          <?= number_format($m['jarak_tempuh'] ?? 0, 0, ',', '.'); ?> Km
                        </span>

                        <img src="../assets/img/kalender.jpg" alt="" class="ms-3" style="width:40px;height:40px;">
                        <span style="font-size: 20px">
                          <?= htmlspecialchars($m['tahun_mobil'] ?? '-'); ?>
                        </span>
                      </div>

                      <!-- TITIK 3 DROPDOWN -->
                      <div class="titik3 dropdown is-right is-hoverable mt-2">
                        <div class="dropdown-trigger">
                          <button class="button is-white btn-titik3" aria-haspopup="true" aria-controls="dropdown-menu">
                            <span class="icon is-small">
                              <i class="fa-solid fa-ellipsis-vertical"></i>
                            </span>
                          </button>
                        </div>
                        <div class="dropdown-menu" role="menu">
                          <div class="dropdown-content">
                            <a href="#" class="dropdown-item">
                              <i class="fa-solid fa-trash"></i> Hapus dari favorit
                            </a>
                            <a href="../templates/perbandingan.php" class="dropdown-item">
                              <i class="fa-solid fa-shuffle me-2"></i> Bandingkan
                            </a>
                            <a href="#" class="dropdown-item">
                              <i class="fa-solid fa-share me-2"></i> Bagikan
                            </a>

                            <?php
                            $nomor_wa = "6281234567890";
                            $pesan = urlencode("Halo, apakah mobil " . ($m['nama_mobil'] ?? '') . " masih tersedia?");
                            ?>
                            <a href="https://wa.me/<?= $nomor_wa ?>?text=<?= $pesan ?>" target="_blank"
                              class="dropdown-item">
                              <i class="fa-brands fa-whatsapp me-2"></i> Hubungi Penjual
                            </a>

                            <a href="../templates/detail_mobil.php?kode=<?= urlencode($m['kode_mobil']) ?>" class="dropdown-item">
                              <i class="fa-solid fa-car me-2"></i> Fitur &amp; Spesifikasi
                            </a>
                          </div>
                        </div>
                      </div>

                    </div> <!-- /.card-content -->
                  </div> <!-- /.card -->
                </div> <!-- /.col -->
              <?php endforeach; ?>



            <?php endif; ?>
=======
        <section class="section">
          <div class="row g-4" id="mobilContainer">
            <!-- Mobil akan di-render oleh JavaScript -->
>>>>>>> 6da68bc69a029e3dd402f5d6f5a4bb38b7194ecf
          </div>
        </section>
      </main>

    </div>
  </div>

  <!-- JAVASCRIPT FILTER -->
  <script>
    // ============================================
    // FUNGSI HELPER
    // ============================================
    function formatNumber(num) {
      return new Intl.NumberFormat('id-ID').format(num);
    }

    function parsePrice(priceStr) {
      if (!priceStr) return 0;
      return parseInt(priceStr.toString().replace(/[^0-9]/g, ''));
    }

    function updateTotalCount(count) {
      document.getElementById('totalMobil').textContent = count;
    }

    // ============================================
    // RENDER MOBIL
    // ============================================
    function renderMobil(cars) {
      const container = document.getElementById('mobilContainer');
      
      if (cars.length === 0) {
        container.innerHTML = `
          <div class="col-12 text-center text-muted py-5">
            <i class="fa-solid fa-car fa-3x mb-3"></i>
            <p>Tidak ada mobil yang sesuai dengan filter</p>
          </div>`;
        updateTotalCount(0);
        return;
      }

      const statusLabelMap = <?= json_encode($statusLabelMap) ?>;

      container.innerHTML = cars.map(m => {
        const img = m.foto || '../assets/img/no-image.jpg';
        const status = m.status || 'available';
        const statusLabel = statusLabelMap[status] || status;
        const isFavorit = favoritMobil.includes(m.kode_mobil);

        return `
          <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card car-card shadow-sm h-100">
              <div class="card-image position-relative">
                <figure class="image image-wrapper mb-0">
                  <img src="${img}" alt="${m.nama_mobil || 'Mobil'}" class="img_main card-img-top">
                  <span class="status-badge ${status}">${statusLabel}</span>
                  <span class="icon-favorite ${isFavorit ? 'active' : ''}" data-kode-mobil="${m.kode_mobil}">
                    <i class="fa-solid fa-heart"></i>
                  </span>
                </figure>
              </div>
              <div class="card-content p-3">
                <a href="../templates/detail_mobil.php?kode=${encodeURIComponent(m.kode_mobil)}" 
                   class="text-decoration-none mb-2 d-inline-block" style="font-size:25px;">
                  <p class="title is-5 mb-1">${m.nama_mobil || 'Tanpa Nama'}</p>
                </a>
                <p class="ansguran mb-1" style="font-size:25px; font-weight:700; color:#111827;">
                  Rp ${formatNumber(m.angsuran || 0)}
                  <span style="font-weight:600;">x ${m.tenor || '-'}</span>
                </p>
                <p class="uang_dp mb-2" style="font-size:20px; font-weight:600; color:#111827;">
                  Dp Rp ${formatNumber(m.dp || 0)}
                </p>
                <hr class="my-2">
                <div class="info d-flex align-items-center gap-2">
                  <img src="../assets/img/kecepatan.jpg" alt="" style="width:30px;height:30px;">
                  <span style="font-size: 20px">${formatNumber(m.jarak_tempuh || 0)} Km</span>
                  <img src="../assets/img/kalender.jpg" alt="" class="ms-3" style="width:40px;height:40px;">
                  <span style="font-size: 20px">${m.tahun_mobil || '-'}</span>
                </div>
                <div class="titik3 dropdown is-right is-hoverable mt-2">
                  <div class="dropdown-trigger">
                    <button class="button is-white btn-titik3">
                      <span class="icon is-small"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                    </button>
                  </div>
                  <div class="dropdown-menu" role="menu">
                    <div class="dropdown-content">
                      <a href="#" class="dropdown-item"><i class="fa-solid fa-trash"></i> Hapus dari favorit</a>
                      <a href="../templates/perbandingan.php" class="dropdown-item"><i class="fa-solid fa-shuffle me-2"></i> Bandingkan</a>
                      <a href="#" class="dropdown-item"><i class="fa-solid fa-share me-2"></i> Bagikan</a>
                      <a href="https://wa.me/6281234567890?text=${encodeURIComponent('Halo, apakah mobil ' + (m.nama_mobil || '') + ' masih tersedia?')}" 
                         target="_blank" class="dropdown-item">
                        <i class="fa-brands fa-whatsapp me-2"></i> Hubungi Penjual
                      </a>
                      <a href="../templates/detail_mobil.php?kode=${encodeURIComponent(m.kode_mobil)}" class="dropdown-item">
                        <i class="fa-solid fa-car me-2"></i> Fitur & Spesifikasi
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>`;
      }).join('');

      updateTotalCount(cars.length);
      attachFavoriteListeners();
    }

    // ============================================
    // APPLY FILTERS
    // ============================================
    function applyFilters() {
      let result = [...allMobil];

      // Filter Harga
      const minPrice = parsePrice(document.getElementById('minPrice').value);
      const maxPrice = parsePrice(document.getElementById('maxPrice').value);
      
      if (minPrice > 0) {
        result = result.filter(m => parsePrice(m.dp) >= minPrice);
      }
      if (maxPrice > 0) {
        result = result.filter(m => parsePrice(m.dp) <= maxPrice);
      }

      // Filter Tahun
      const fromYear = document.getElementById('fromYear').value;
      const toYear = document.getElementById('toYear').value;
      
      if (fromYear) {
        result = result.filter(m => parseInt(m.tahun_mobil) >= parseInt(fromYear));
      }
      if (toYear) {
        result = result.filter(m => parseInt(m.tahun_mobil) <= parseInt(toYear));
      }

      // Filter Jarak Tempuh
      const maxMileage = document.getElementById('maxMileage').value;
      if (maxMileage) {
        result = result.filter(m => parseInt(m.jarak_tempuh) <= parseInt(maxMileage));
      }

      // Filter Bahan Bakar
      const selectedFuels = Array.from(document.querySelectorAll('.fuel-filter input[type="checkbox"]:checked'))
        .map(cb => cb.value);
      
      if (selectedFuels.length > 0) {
        result = result.filter(m => selectedFuels.includes(m.bahan_bakar));
      }

      // Sorting
      const sortOption = document.querySelector('input[name="sortOption"]:checked').value;
      
      switch(sortOption) {
        case 'lowestPrice':
          result.sort((a, b) => parsePrice(a.dp) - parsePrice(b.dp));
          break;
        case 'highestPrice':
          result.sort((a, b) => parsePrice(b.dp) - parsePrice(a.dp));
          break;
        case 'newestYear':
          result.sort((a, b) => parseInt(b.tahun_mobil) - parseInt(a.tahun_mobil));
          break;
      }

      filteredMobil = result;
      renderMobil(result);
    }

    // ============================================
    // EVENT LISTENERS
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
      // Render awal
      renderMobil(allMobil);
      
      // Sorting
      document.querySelectorAll('input[name="sortOption"]').forEach(radio => {
        radio.addEventListener('change', applyFilters);
      });

      // Harga
      document.getElementById('minPrice').addEventListener('change', applyFilters);
      document.getElementById('maxPrice').addEventListener('change', applyFilters);

      // Tahun
      document.getElementById('fromYear').addEventListener('input', applyFilters);
      document.getElementById('toYear').addEventListener('input', applyFilters);

      // Jarak Tempuh
      document.getElementById('maxMileage').addEventListener('change', applyFilters);

      // Bahan Bakar
      document.querySelectorAll('.fuel-filter input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', applyFilters);
      });

      // Hapus Filter
      document.querySelector('.hapus').addEventListener('click', function() {
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
        document.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
        document.getElementById('bestMatch').checked = true;
        
        filteredMobil = [...allMobil];
        renderMobil(allMobil);
      });
    });

    const compareToggle = document.getElementById('togglePerbandingan');
    const compareToolbar = document.getElementById('compareToolbar');

if (compareToggle && compareToolbar) {
  compareToggle.addEventListener('change', (e) => {
    if (e.target.checked) {
      compareToolbar.classList.add('is-active');
    } else {
      compareToolbar.classList.remove('is-active');
    }
  });
}

const maxCompare = 2;
let selectedCars = [];

const compareSlots = document.querySelectorAll('.compare-slot');
const compareGoBtn = document.getElementById('compareGoBtn');

function renderCompareSlots() {
  compareSlots.forEach((slot, index) => {
    const car = selectedCars[index];
    slot.innerHTML = '';

    if (car) {
      slot.classList.add('has-car');

      const img = document.createElement('img');
      img.src = car.img;
      img.alt = car.name;

      const removeBtn = document.createElement('button');
      removeBtn.className = 'compare-remove';
      removeBtn.textContent = '×';
      removeBtn.addEventListener('click', () => {
        selectedCars = selectedCars.filter(c => c.id !== car.id);
        renderCompareSlots();
      });

      slot.appendChild(img);
      slot.appendChild(removeBtn);
    } else {
      slot.classList.remove('has-car');
      const span = document.createElement('span');
      span.className = 'compare-slot-placeholder';
      span.textContent = index === 0 ? 'Pilih mobil pertama' : 'Pilih mobil kedua';
      slot.appendChild(span);
    }
  });

  compareGoBtn.disabled = selectedCars.length !== 2;
}

document.querySelectorAll('.btn-add-compare').forEach(btn => {
  btn.addEventListener('click', () => {
    const card = btn.closest('.car-card');
    const id = card.dataset.id;

    // kalau sudah kepilih, abaikan
    if (selectedCars.find(c => c.id === id)) return;

    if (selectedCars.length >= maxCompare) {
      alert('Maksimal 2 mobil untuk dibandingkan');
      return;
    }

    selectedCars.push({
      id,
      name: card.dataset.name,
      img: card.dataset.img
    });

    renderCompareSlots();
  });
});
  </script>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const compareToggle   = document.getElementById('togglePerbandingan');
    const compareToolbar  = document.getElementById('compareToolbar');
    const btnTitik3List   = document.querySelectorAll('.btn-titik3');

    const maxCompare = 2;
    let selectedCars = [];
    let compareMode  = false;

    const compareSlots = document.querySelectorAll('.compare-slot');
    const compareGoBtn = document.getElementById('compareGoBtn');

    function renderCompareSlots() {
      compareSlots.forEach((slot, index) => {
        const car = selectedCars[index];
        slot.innerHTML = '';

        if (car) {
          slot.classList.add('has-car');

          const img = document.createElement('img');
          img.src = car.img;
          img.alt = car.name;

          const removeBtn = document.createElement('button');
          removeBtn.className = 'compare-remove';
          removeBtn.textContent = '×';
          removeBtn.addEventListener('click', () => {
            selectedCars = selectedCars.filter(c => c.id !== car.id);

            // hilangkan highlight di button card juga
            btnTitik3List.forEach(btn => {
              const card = btn.closest('.car-card');
              if (card && card.dataset.id === car.id) {
                btn.classList.remove('compare-selected');
              }
            });

            renderCompareSlots();
          });

          slot.appendChild(img);
          slot.appendChild(removeBtn);
        } else {
          slot.classList.remove('has-car');
          const span = document.createElement('span');
          span.className = 'compare-slot-placeholder';
          span.textContent = index === 0 ? 'Pilih mobil pertama' : 'Pilih mobil kedua';
          slot.appendChild(span);
        }
      });

      compareGoBtn.disabled = selectedCars.length !== 2;
    }

    // === Toggle Perbandingan ON/OFF ===
    if (compareToggle && compareToolbar) {
      compareToggle.addEventListener('change', function (e) {
        compareMode = e.target.checked;

        if (compareMode) {
          compareToolbar.classList.add('is-active');
        } else {
          compareToolbar.classList.remove('is-active');

          // reset semua pilihan kalau mode dimatikan
          selectedCars = [];
          renderCompareSlots();
          btnTitik3List.forEach(btn => {
            btn.classList.remove('compare-mode', 'compare-selected');
            const icon = btn.querySelector('i');
            if (icon) {
              icon.classList.remove('fa-check-circle');
              icon.classList.add('fa-ellipsis-vertical');
            }
          });
        }

        // ubah tampilan tombol titik3
        btnTitik3List.forEach(btn => {
          const icon = btn.querySelector('i');
          if (!icon) return;

          if (compareMode) {
            btn.classList.add('compare-mode');
            icon.classList.remove('fa-ellipsis-vertical');
            icon.classList.add('fa-check-circle');
          } else {
            btn.classList.remove('compare-mode');
            icon.classList.remove('fa-check-circle');
            icon.classList.add('fa-ellipsis-vertical');
          }
        });
      });
    }

    // === Klik tombol titik3 saat mode perbandingan ===
    btnTitik3List.forEach(btn => {
      btn.addEventListener('click', function (e) {
        if (!compareMode) return;       // kalau bukan mode perbandingan, biarkan dropdown normal

        e.preventDefault();             // jangan buka dropdown
        e.stopPropagation();

        const card = btn.closest('.car-card');
        if (!card) return;

        const id   = card.dataset.id;
        const name = card.dataset.name;
        const img  = card.dataset.img;

        const existingIndex = selectedCars.findIndex(c => c.id === id);

        if (existingIndex !== -1) {
          // sudah dipilih → unselect
          selectedCars.splice(existingIndex, 1);
          btn.classList.remove('compare-selected');
        } else {
          if (selectedCars.length >= maxCompare) {
            alert('Maksimal 2 mobil untuk dibandingkan');
            return;
          }
          selectedCars.push({ id, name, img });
          btn.classList.add('compare-selected');
        }

        renderCompareSlots();
      });
    });

    // === Klik Go → ke perbandingan.php ===
    compareGoBtn.addEventListener('click', () => {
      if (selectedCars.length !== 2) return;

      const params = new URLSearchParams({
        car1_name: selectedCars[0].name,
        car1_img:  selectedCars[0].img,
        car2_name: selectedCars[1].name,
        car2_img:  selectedCars[1].img
      });

      window.location.href = '../templates/perbandingan.php?' + params.toString();
    });
  });
</script>


  <!-- footer -->
  <script src="../assets/js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>