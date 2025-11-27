<?php
// SETUP API DULU

$title = "katalog";

// path disesuaikan karena katalog.php ada di root WEB_SHOWROOMMOBILKMJ
require_once __DIR__ . '/../db/config_api.php';
require_once __DIR__ . '/../db/api_client.php';
require_once __DIR__ . '/../include/header.php'; // kalau mau pakai konstanta JS juga

// PANGGIL API
$api = api_get('admin/web_mobil_list.php'); // atau 'user/routes/cars.php' kalau kamu sudah pakai route user

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
  <title>KMJ</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo_KMJ_YB2.ico ">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <!-- Import Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!--Import Font Awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!--Import Custom CSS-->
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/katalog2.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="../assets/css/wishlist_sidebar.css?v=<?= time(); ?>">
  <!-- Tambahkan Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <!-- icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">



</head>

<body class="page-katalog">
  <!-- navbar -->
  <?php include '../templates/navbar_footer/navbar.php'; ?>
  <?php
  // Setelah navbar di-include, navbar.php sudah memanggil session_start()
  
  // Anggap user "login" kalau minimal nama lengkapnya ada di session
// (navbar juga pakai full_name untuk nampilkan "maida")
  $isLoggedIn = isset($_SESSION['full_name']);

  // Ambil kode user dari session kalau ada (boleh user_id atau kode_user)
  $kodeUser = $_SESSION['user_id'] ?? ($_SESSION['kode_user'] ?? '');

  // Data lain hanya buat info
  $fullName = $_SESSION['full_name'] ?? '';
  $email = $_SESSION['email'] ?? '';
  ?>
  <?php
  // =======================
// AMBIL DATA FAVORIT USER
// =======================
  
  $favoritMobil = []; // array untuk menampung kode_mobil yang difavoritkan user ini
  
  if (!empty($kodeUser)) {
    $favApi = api_get('user/routes/favorites.php?kode_user=' . urlencode($kodeUser));

    if ($favApi && isset($favApi['success']) && $favApi['success']) {
      // ambil hanya kolom kode_mobil menjadi array sederhana
      // contoh: ['MOB001', 'MOB005', ...]
      $favoritMobil = array_column($favApi['data'], 'kode_mobil');
    }
  }
  ?>
  <script>
    // dipakai di script favorit
    const IS_LOGGED_IN = <?= $isLoggedIn ? 'true' : 'false' ?>;

    const CURRENT_USER = {
      kode_user: "<?= $kodeUser ?>",
      full_name: "<?= addslashes($fullName) ?>",
      email: "<?= addslashes($email) ?>"
    };

    console.log("IS_LOGGED_IN =", IS_LOGGED_IN, "CURRENT_USER =", CURRENT_USER);
  </script>



  <!-- Card Container -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Filter -->
      <aside class="col-12 col-md-4 col-lg-3 mb-3 order-0 order-md-0" id="sidebar-filter">
        <div class="card p-3 shadow-sm">
          <h5 class="filter-header d-flex justify-content-between align-items-center">
            <span>Filter & Urutkan</span>
            <div class="hapus">hapus filter</div>
          </h5>
          <p>Tambahkan filter untuk menyimpan pencarian Anda dan dapatkan pemberitahuan saat inventaris baru tiba.</p>
          <div class="button-simpan mb-3">
            <button type="button" class="btn btn-outline-secondary w-100">Simpan Pencarian</button>
          </div>
          <hr>
          <div class="accordion" id="accordionPanelsStayOpenExample">

            <!-- Item 1 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                  aria-expanded="true" aria-controls="collapseOne">
                  Urutkan Berdasarkan
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                <div class="accordion-body">
                  <strong>
                    <!-- radio button list tetap sama -->
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="bestMatch" value="best"
                        checked>
                      <label class="form-check-label" for="bestMatch" style="font-size: 20px;">Terbaik</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="nearestDistance"
                        value="nearest">
                      <label class="form-check-label" for="nearestDistance" style="font-size: 20px;">Jarak
                        terdekat</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="lowestPrice"
                        value="lowestPrice">
                      <label class="form-check-label" for="lowestPrice" style="font-size: 20px;">Harga Terendah</label>
                    </div>

                  </strong>
                </div>
              </div>
            </div>

            <!-- Item 2 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Harga
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                <div class="accordion-body">
                  <!-- Tabs Price -->
                  <div class="price-container">
                    <!-- Tabs -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="range-tab" data-bs-toggle="pill" data-bs-target="#range"
                          type="button" role="tab">Range</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="calculator-tab" data-bs-toggle="pill" data-bs-target="#calculator"
                          type="button" role="tab">Calculator</button>
                      </li>
                    </ul>

                    <!-- Content -->
                    <div class="tab-content" id="pills-tabContent">
                      <!-- Range -->
                      <div class="tab-pane fade show active" id="range" role="tabpanel">
                        <div class="mb-3">
                          <label for="minPrice" class="form-label">Min price</label>
                          <select id="minPrice" class="form-select">
                            <option>$7,000</option>
                            <option>$10,000</option>
                            <option>$15,000</option>
                          </select>
                        </div>
                        <div>
                          <label for="maxPrice" class="form-label">Max price</label>
                          <select id="maxPrice" class="form-select">
                            <option>$98,000+</option>
                            <option>$80,000</option>
                            <option>$60,000</option>
                          </select>
                          <br>
                        </div>
                        <div class="button-aturUlang">
                          <button type="button" class="btn btn-outline-secondary ">Simpan Pencarian</button>
                        </div>
                      </div>


                      <!-- Calculator -->
                      <div class="tab-pane fade" id="calculator" role="tabpanel">
                        <p class="text-muted">Calculator content goes here...</p>
                      </div>
                    </div>
                  </div>



                </div>
              </div>
            </div>

            <!-- Item 3 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Tahun
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                <div class="accordion-body">
                  <div class="mb-3">
                    <label for="fromYear" class="form-label">From</label>
                    <input class="form-control" list="fromYearOptions" id="fromYear"
                      placeholder="Ketik atau pilih tahun...">
                    <datalist id="fromYearOptions">
                      <?php
                      $currentYear = date("Y");
                      for ($year = 2000; $year <= $currentYear; $year++) {
                        echo "<option value='$year'>";
                      }
                      ?>
                    </datalist>
                  </div>

                  <div class="mb-3">
                    <label for="toYear" class="form-label">To</label>
                    <input class="form-control" list="toYearOptions" id="toYear"
                      placeholder="Ketik atau pilih tahun...">
                    <datalist id="toYearOptions">
                      <?php
                      $currentYear = date("Y");
                      for ($year = 2000; $year <= $currentYear; $year++) {
                        echo "<option value='$year'>";
                      }
                      ?>
                    </datalist>
                  </div>
                  <div class="button-aturUlang">
                    <button type="button" class="btn btn-outline-secondary ">Simpan Pencarian</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 4 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Jarak tempuh
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour">
                <div class="accordion-body">
                  <div class="tab-pane fade show active" id="range" role="tabpanel">
                    <div class="mb-3">
                      <label for="mileage" class="form-label">Jarak Tempuh (Km)</label>
                      <input class="form-control" list="mileageOptions" id="mileage"
                        placeholder="Ketik atau pilih jarak...">
                      <datalist id="mileageOptions">
                        <?php
                        for ($km = 0; $km <= 200000; $km += 5000) {
                          echo "<option value='" . number_format($km, 0, ',', '.') . " km'>";
                        }
                        ?>
                      </datalist>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <!-- Item 5 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  Jenis bahan bakar
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive">
                <div class="accordion-body">
                  <div class="fuel-filter">
                    <?php foreach ($bahanBakar as $jenis => $jumlah): ?>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="<?= $jenis ?>"
                          id="<?= strtolower(str_replace(' ', '_', $jenis)) ?>">
                        <label class="form-check-label" for="<?= strtolower(str_replace(' ', '_', $jenis)) ?>"
                          style="font-size: 18px;">
                          <?= $jenis ?> (<?= number_format($jumlah, 0, ',', '.') ?>)
                        </label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 6 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                  Body Type
                </button>
              </h2>
              <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix">
                <div class="accordion-body">
                  <strong>Isi item 6.</strong>
                </div>
              </div>
            </div>

            <!-- Item 7 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSeven">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                  Tipe
                </button>
              </h2>
              <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven">
                <div class="accordion-body">
                  <strong>Isi item 7.</strong>
                </div>
              </div>
            </div>

            <!-- Item 8 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingEight">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                  Sistem Penggerak
                </button>
              </h2>
              <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight">
                <div class="accordion-body">
                  <strong>Isi item 8.</strong>
                </div>
              </div>
            </div>

            <!-- Item 9 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingNine">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                  Transmision
                </button>
              </h2>
              <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine">
                <div class="accordion-body">
                  <strong>Isi item 9.</strong>
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
              <h5>Total <?= $jumlahMobil; ?> Mobil Tersedia</h5>
            </span>
          </div>

          <div class="comparison-toggle d-flex align-items-center">
            <span class="me-2">Perbandingan</span>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" id="togglePerbandingan">
            </div>
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

                            <a href="#" class="dropdown-item">
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
          </div>
        </section>

      </main>


    </div>
  </div>
  <script>
    document.querySelectorAll('.icon-favorite').forEach(icon => {
      icon.addEventListener('click', async () => {
        const kodeMobil = icon.dataset.kodeMobil;

        // ========== 1. Cek sudah login atau belum ==========
        // ========== 1. Cek sudah login atau belum ==========
        if (!IS_LOGGED_IN) {
          const go = confirm('Kamu harus login dulu untuk menambahkan ke favorit. Pergi ke halaman login?');
          if (go) {
            const currentUrl = window.location.pathname + window.location.search;
            window.location.href = '/web_showroommobilKMJ/templates/auth/auth.php?redirect='
              + encodeURIComponent(currentUrl);
          }
          return;
        }


        // ========== 2. Tentukan action: add / remove ==========
        const isActive = icon.classList.contains('active');
        const action = isActive ? 'remove' : 'add';

        try {
          const res = await fetch(BASE_API_URL + '/user/routes/favorites.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              kode_user: CURRENT_USER.kode_user,
              kode_mobil: kodeMobil,
              action: action
            })
          });

          const data = await res.json();

          if (data.success) {
            // toggle tampilan love
            icon.classList.toggle('active');
          } else {
            alert(data.message || 'Gagal mengubah data favorite');
          }
        } catch (err) {
          console.error(err);
          alert('Terjadi kesalahan koneksi ke server.');
        }
      });
    });
  </script>



  <!-- footer -->
  <script src="../assets/js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>