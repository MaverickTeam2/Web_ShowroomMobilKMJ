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

// BAHAN BAKAR
$allFuelTypes = [
  "Bensin" => 0,
  "Diesel" => 0,
  "Listrik" => 0,
  "Hybrid" => 0,
];

// Hitung dari data yang ada
if (!empty($mobil)) {
  foreach ($mobil as $car) {
    $jenis = $car['tipe_bahan_bakar'] ?? '';
    if (!empty($jenis) && isset($allFuelTypes[$jenis])) {
      $allFuelTypes[$jenis]++;
    }
  }
}

$statusLabelMap = [
  'available' => 'Available',
  'reserved'  => 'Reserved',
  'sold'      => 'Sold',
  'shipping'  => 'Shipping',
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
  $kodeUser   = $_SESSION['user_id'] ?? ($_SESSION['kode_user'] ?? '');
  $fullName   = $_SESSION['full_name'] ?? '';
  $email      = $_SESSION['email'] ?? '';

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
      email: "<?= addslashes($email) ?>",
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
                    <?php foreach ($allFuelTypes as $jenis => $jumlah): ?>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="<?= $jenis ?>"
                               id="fuel_<?= strtolower(str_replace([' ', '-'], '_', $jenis)) ?>" <?= $jumlah == 0 ? 'disabled' : '' ?>>
                        <label class="form-check-label <?= $jumlah == 0 ? 'text-muted' : '' ?>"
                               for="fuel_<?= strtolower(str_replace([' ', '-'], '_', $jenis)) ?>">
                          <?= $jenis ?>
                          <span class="filter-count <?= $jumlah == 0 ? 'text-danger' : 'text-muted' ?>">
                            (<?= number_format($jumlah, 0, ',', '.') ?>)
                          </span>
                        </label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 6 Body Tipe -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                  Tipe Body
                </button>
              </h2>
              <div id="collapseSix" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <div class="body-type-filter">
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="SUV" id="body_suv">
                      <label class="form-check-label" for="body_suv">SUV</label>
                    </div>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="MPV" id="body_mpv">
                      <label class="form-check-label" for="body_mpv">MPV</label>
                    </div>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="Sedan" id="body_sedan">
                      <label class="form-check-label" for="body_sedan">Sedan</label>
                    </div>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="Sport" id="body_sport">
                      <label class="form-check-label" for="body_sport">Sport</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 7 Sistem Penggerak -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven">
                  Sistem Penggerak
                </button>
              </h2>
              <div id="collapseSeven" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <div class="drive-system-filter">
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="FWD (Front Wheel Drive)" id="drive_fwd">
                      <label class="form-check-label" for="drive_fwd">FWD (Front-Wheel Drive)</label>
                    </div>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="RWD (Rear Wheel Drive)" id="drive_rwd">
                      <label class="form-check-label" for="drive_rwd">RWD (Rear-Wheel Drive)</label>
                    </div>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="checkbox" value="AWD (All Wheel Drive)" id="drive_awd">
                      <label class="form-check-label" for="drive_awd">AWD (All-Wheel Drive)</label>
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

        <!-- BAR PERBANDINGAN -->
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
          <div class="row g-4" id="mobilContainer">
            <!-- Mobil akan di-render oleh JavaScript -->
          </div>
        </section>
      </main>

    </div>
  </div>

  <!-- JAVASCRIPT -->
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

    // Debouncing untuk filter
    let filterTimeout;
    function debouncedApplyFilters() {
      clearTimeout(filterTimeout);
      filterTimeout = setTimeout(applyFilters, 300);
    }

    // ============================================
    // VARIABEL GLOBAL PERBANDINGAN
    // ============================================
    const maxCompare = 2;
    let selectedCars = [];
    let compareMode = false;
    let compareSlots;
    let compareGoBtn;
    let compareToolbar;
    let compareToggle;

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
        const safeName = (m.nama_mobil || 'Tanpa Nama').replace(/"/g, '&quot;');

        return `
          <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card car-card shadow-sm h-100"
                 data-id="${m.kode_mobil}"
                 data-name="${safeName}"
                 data-img="${img}">
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
      attachCompareButtonListeners();
    }

    // ============================================
    // APPLY FILTERS
    // ============================================
    function applyFilters() {
      let result = [...allMobil];

      // 1. FILTER HARGA
      const minPrice = parsePrice(document.getElementById('minPrice').value);
      const maxPrice = parsePrice(document.getElementById('maxPrice').value);

      if (minPrice > 0) {
        result = result.filter(m => parsePrice(m.dp) >= minPrice);
      }
      if (maxPrice > 0) {
        result = result.filter(m => parsePrice(m.dp) <= maxPrice);
      }

      // 2. FILTER TAHUN
      const fromYear = document.getElementById('fromYear').value;
      const toYear = document.getElementById('toYear').value;

      if (fromYear) {
        result = result.filter(m => {
          const tahun = parseInt(m.tahun_mobil);
          return !isNaN(tahun) && tahun >= parseInt(fromYear);
        });
      }
      if (toYear) {
        result = result.filter(m => {
          const tahun = parseInt(m.tahun_mobil);
          return !isNaN(tahun) && tahun <= parseInt(toYear);
        });
      }

      // 3. FILTER JARAK TEMPUH
      const maxMileage = document.getElementById('maxMileage').value;
      if (maxMileage) {
        result = result.filter(m => {
          const jarak = parseInt(m.jarak_tempuh);
          return !isNaN(jarak) && jarak <= parseInt(maxMileage);
        });
      }

      // 4. FILTER BAHAN BAKAR
      const selectedFuels = Array.from(document.querySelectorAll('.fuel-filter input[type="checkbox"]:checked'))
        .map(cb => cb.value);

      if (selectedFuels.length > 0) {
        result = result.filter(m => selectedFuels.includes(m.tipe_bahan_bakar));
      }

      // 5. FILTER TIPE BODY
      const selectedBodyTypes = Array.from(document.querySelectorAll('.body-type-filter input[type="checkbox"]:checked'))
        .map(cb => cb.value);

      if (selectedBodyTypes.length > 0) {
        result = result.filter(m => {
          if (m.jenis_kendaraan) {
            return selectedBodyTypes.includes(m.jenis_kendaraan);
          }
          const namaMobil = (m.nama_mobil || '').toLowerCase();
          return selectedBodyTypes.some(bodyType => {
            const bodyLower = bodyType.toLowerCase();
            return namaMobil.includes(bodyLower);
          });
        });
      }

      // 6. FILTER SISTEM PENGGERAK
      const selectedDriveSystems = Array.from(document.querySelectorAll('.drive-system-filter input[type="checkbox"]:checked'))
        .map(cb => cb.value);

      if (selectedDriveSystems.length > 0) {
        result = result.filter(m => {
          if (m.sistem_penggerak) {
            return selectedDriveSystems.includes(m.sistem_penggerak);
          }
          const driveMap = {
            'FWD': ['FWD', 'Front Wheel Drive', 'Penggerak Depan'],
            'RWD': ['RWD', 'Rear Wheel Drive', 'Penggerak Belakang'],
            'AWD': ['AWD', 'All Wheel Drive', '4WD', 'Four Wheel Drive', '4x4'],
          };

          const allText = JSON.stringify(m).toLowerCase();
          return selectedDriveSystems.some(drive => {
            const keywords = driveMap[drive] || [drive];
            return keywords.some(keyword =>
              allText.includes(keyword.toLowerCase())
            );
          });
        });
      }

      // SORTING
      const sortOption = document.querySelector('input[name="sortOption"]:checked').value;

      switch (sortOption) {
        case 'lowestPrice':
          result.sort((a, b) => parsePrice(a.dp) - parsePrice(b.dp));
          break;
        case 'highestPrice':
          result.sort((a, b) => parsePrice(b.dp) - parsePrice(a.dp));
          break;
        case 'newestYear':
          result.sort((a, b) => parseInt(b.tahun_mobil) - parseInt(a.tahun_mobil));
          break;
        case 'best':
        default:
          result.sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));
          break;
      }

      filteredMobil = result;
      renderMobil(result);

      // Update display filter aktif
      updateActiveFiltersDisplay();
      saveFiltersToStorage();
    }

    // ============================================
    // UPDATE FILTER AKTIF DISPLAY
    // ============================================
    function updateActiveFiltersDisplay() {
      const activeFilters = [];

      const activeCheckboxes = document.querySelectorAll(
        '.fuel-filter input[type="checkbox"]:checked, ' +
        '.body-type-filter input[type="checkbox"]:checked, ' +
        '.drive-system-filter input[type="checkbox"]:checked'
      );

      const minPrice = document.getElementById('minPrice').value;
      const maxPrice = document.getElementById('maxPrice').value;
      const fromYear = document.getElementById('fromYear').value;
      const toYear = document.getElementById('toYear').value;
      const maxMileage = document.getElementById('maxMileage').value;

      if (minPrice) activeFilters.push('Harga Min');
      if (maxPrice) activeFilters.push('Harga Max');
      if (fromYear) activeFilters.push('Tahun Dari');
      if (toYear) activeFilters.push('Tahun Sampai');
      if (maxMileage) activeFilters.push('Jarak Tempuh');
      if (activeCheckboxes.length > 0) activeFilters.push(`${activeCheckboxes.length} Kategori`);

      const filterHeader = document.querySelector('.filter-header');
      const oldBadge = filterHeader.querySelector('.active-filters-badge');

      if (activeFilters.length > 0) {
        const badge = oldBadge || document.createElement('span');
        badge.className = 'badge bg-primary ms-2 active-filters-badge';
        badge.textContent = activeFilters.length;

        if (!oldBadge) {
          filterHeader.appendChild(badge);
        }
      } else if (oldBadge) {
        oldBadge.remove();
      }
    }

    // ============================================
    // LOCALSTORAGE FUNCTIONS
    // ============================================
    function saveFiltersToStorage() {
      const filters = {
        minPrice: document.getElementById('minPrice').value,
        maxPrice: document.getElementById('maxPrice').value,
        fromYear: document.getElementById('fromYear').value,
        toYear: document.getElementById('toYear').value,
        maxMileage: document.getElementById('maxMileage').value,
        sortOption: document.querySelector('input[name="sortOption"]:checked').value,
        fuels: Array.from(document.querySelectorAll('.fuel-filter input[type="checkbox"]:checked')).map(cb => cb.value),
        bodyTypes: Array.from(document.querySelectorAll('.body-type-filter input[type="checkbox"]:checked')).map(cb => cb.value),
        driveSystems: Array.from(document.querySelectorAll('.drive-system-filter input[type="checkbox"]:checked')).map(cb => cb.value),
      };

      localStorage.setItem('katalogFilters', JSON.stringify(filters));
    }

    function loadFiltersFromStorage() {
      const saved = localStorage.getItem('katalogFilters');
      if (!saved) return;

      try {
        const filters = JSON.parse(saved);

        if (filters.minPrice) document.getElementById('minPrice').value = filters.minPrice;
        if (filters.maxPrice) document.getElementById('maxPrice').value = filters.maxPrice;
        if (filters.fromYear) document.getElementById('fromYear').value = filters.fromYear;
        if (filters.toYear) document.getElementById('toYear').value = filters.toYear;
        if (filters.maxMileage) document.getElementById('maxMileage').value = filters.maxMileage;

        if (filters.sortOption) {
          const sortRadio = document.querySelector(`input[name="sortOption"][value="${filters.sortOption}"]`);
          if (sortRadio) sortRadio.checked = true;
        }

        ['fuels', 'bodyTypes', 'driveSystems'].forEach(type => {
          if (filters[type] && Array.isArray(filters[type])) {
            filters[type].forEach(value => {
              const element = document.querySelector(`[value="${value}"]`);
              if (element) element.checked = true;
            });
          }
        });

        setTimeout(applyFilters, 100);
      } catch (e) {
        console.error('Error loading filters:', e);
        localStorage.removeItem('katalogFilters');
      }
    }

    // ============================================
    // FAVORITE LISTENERS
    // ============================================
    function attachFavoriteListeners() {
      document.querySelectorAll('.icon-favorite').forEach(icon => {
        icon.addEventListener('click', async () => {
          const kodeMobil = icon.dataset.kodeMobil;

          if (!IS_LOGGED_IN) {
            const go = confirm('Kamu harus login dulu untuk menambahkan ke favorit. Pergi ke halaman login?');
            if (go) {
              window.location.href = '/web_showroommobilKMJ/templates/auth/auth.php?redirect=' + encodeURIComponent(window.location.pathname);
            }
            return;
          }

          const isActive = icon.classList.contains('active');
          const action = isActive ? 'remove' : 'add';

          try {
            const res = await fetch(BASE_API_URL + '/user/routes/favorites.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                kode_user: CURRENT_USER.kode_user,
                kode_mobil: kodeMobil,
                action: action,
              }),
            });

            const data = await res.json();
            if (data.success) {
              icon.classList.toggle('active');

              if (action === 'add') {
                favoritMobil.push(kodeMobil);
              } else {
                const index = favoritMobil.indexOf(kodeMobil);
                if (index > -1) favoritMobil.splice(index, 1);
              }
            } else {
              alert(data.message || 'Gagal mengubah data favorite');
            }
          } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan koneksi ke server.');
          }
        });
      });
    }

    // ============================================
    // FUNGSI PERBANDINGAN
    // ============================================
    function renderCompareSlots() {
      if (!compareSlots) return;

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

            document.querySelectorAll('.btn-titik3').forEach(btn => {
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

      if (compareGoBtn) {
        compareGoBtn.disabled = selectedCars.length !== 2;
      }
    }

    function onToggleCompareChange(e) {
      compareMode = e.target.checked;

      if (compareMode) {
        if (compareToolbar) compareToolbar.classList.add('is-active');
      } else {
        if (compareToolbar) compareToolbar.classList.remove('is-active');

        selectedCars = [];
        renderCompareSlots();
        document.querySelectorAll('.btn-titik3').forEach(btn => {
          btn.classList.remove('compare-mode', 'compare-selected');
          const icon = btn.querySelector('i');
          if (icon) {
            icon.classList.remove('fa-check-circle');
            icon.classList.add('fa-ellipsis-vertical');
          }
        });
      }

      // update tampilan tombol
      document.querySelectorAll('.btn-titik3').forEach(btn => {
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
    }

    function handleCompareButtonClick(e) {
      if (!compareMode) return;

      e.preventDefault();
      e.stopPropagation();

      const btn = e.currentTarget;
      const card = btn.closest('.car-card');
      if (!card) return;

      const id = card.dataset.id;
      const name = card.dataset.name;
      const img = card.dataset.img;

      const existingIndex = selectedCars.findIndex(c => c.id === id);

      if (existingIndex !== -1) {
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
    }

    function attachCompareButtonListeners() {
      const btns = document.querySelectorAll('.btn-titik3');
      btns.forEach(btn => {
        btn.removeEventListener('click', handleCompareButtonClick);
        btn.addEventListener('click', handleCompareButtonClick);

        const icon = btn.querySelector('i');
        if (!icon) return;

        if (compareMode) {
          btn.classList.add('compare-mode');
          icon.classList.remove('fa-ellipsis-vertical');
          icon.classList.add('fa-check-circle');
        } else {
          btn.classList.remove('compare-mode', 'compare-selected');
          icon.classList.remove('fa-check-circle');
          icon.classList.add('fa-ellipsis-vertical');
        }
      });
    }

    function onCompareGoClick() {
      if (selectedCars.length !== 2) return;

      const params = new URLSearchParams({
        car1: selectedCars[0].id,
        car2: selectedCars[1].id,
      });

      window.location.href = '../templates/perbandingan.php?' + params.toString();
    }

    // ============================================
    // EVENT LISTENERS GLOBAL
    // ============================================
    document.addEventListener('DOMContentLoaded', function () {
      // Render awal
      renderMobil(allMobil);

      // Sorting
      document.querySelectorAll('input[name="sortOption"]').forEach(radio => {
        radio.addEventListener('change', applyFilters);
      });

      // Harga
      document.getElementById('minPrice').addEventListener('change', debouncedApplyFilters);
      document.getElementById('maxPrice').addEventListener('change', debouncedApplyFilters);

      // Tahun
      document.getElementById('fromYear').addEventListener('input', debouncedApplyFilters);
      document.getElementById('toYear').addEventListener('input', debouncedApplyFilters);

      // Jarak Tempuh
      document.getElementById('maxMileage').addEventListener('change', debouncedApplyFilters);

      // Bahan Bakar
      document.querySelectorAll('.fuel-filter input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', debouncedApplyFilters);
      });

      // Tipe Body
      document.querySelectorAll('.body-type-filter input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', debouncedApplyFilters);
      });

      // Sistem Penggerak
      document.querySelectorAll('.drive-system-filter input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', debouncedApplyFilters);
      });

      // Hapus Filter
      document.querySelector('.hapus').addEventListener('click', function () {
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
        document.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
        document.getElementById('bestMatch').checked = true;

        filteredMobil = [...allMobil];
        renderMobil(allMobil);
        updateActiveFiltersDisplay();

        localStorage.removeItem('katalogFilters');
      });

      // Load filter dari localStorage jika ada
      loadFiltersFromStorage();

      // Inisialisasi elemen perbandingan
      compareToggle = document.getElementById('togglePerbandingan');
      compareToolbar = document.getElementById('compareToolbar');
      compareSlots = document.querySelectorAll('.compare-slot');
      compareGoBtn = document.getElementById('compareGoBtn');

      if (compareToggle && compareToolbar) {
        compareToggle.addEventListener('change', onToggleCompareChange);
      }
      if (compareGoBtn) {
        compareGoBtn.addEventListener('click', onCompareGoClick);
      }

      renderCompareSlots();
      attachCompareButtonListeners();
    });
  </script>

  <!-- footer -->
  <script src="../assets/js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
