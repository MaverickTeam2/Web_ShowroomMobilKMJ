<?php
$title = "keranjang";

require_once __DIR__ . '/../db/config_api.php';
require_once __DIR__ . '/../db/api_client.php';
require_once __DIR__ . '/../include/header.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Kalau belum login → paksa ke login
if (!isset($_SESSION['user_id'])) {
  header('Location: ../admin/auth/auth.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
  exit;
}

$kodeUser = $_SESSION['user_id'] ?? null;
$fullName = $_SESSION['full_name'] ?? '';
$email = $_SESSION['email'] ?? '';
$isLoggedIn = !empty($kodeUser);

// aktifkan menu "cart" di sidebar
$activeMenu = 'cart';

// ambil list mobil yang baru saja dilihat dari session
$recentlyViewed = $_SESSION['recently_viewed'] ?? [];

// DEBUG SEMENTARA: hitung berapa item recently_viewed
$recentCount = is_array($recentlyViewed) ? count($recentlyViewed) : 0;


// =======================
// AMBIL DATA FAVORIT USER
// =======================
$favoritMobil = [];

if (!empty($kodeUser)) {
  $favApi = api_get('user/routes/favorites.php?kode_user=' . urlencode($kodeUser));

  if ($favApi && isset($favApi['success']) && $favApi['success']) {
    $favoritMobil = array_column($favApi['data'] ?? [], 'kode_mobil'); // ['MOB001', ...]
  }
}
?>
<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
  <meta charset="UTF-8">
  <title>KMJ - Keranjang</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo_KMJ_YB2.ico ">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/keranjang.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/account_sidebar.css?v=<?= time(); ?>">
  
</head>

<body>

  <?php include '../templates/navbar_footer/navbar.php'; ?>

  <!-- VARIABEL USER UNTUK JS (FAVORITE) -->
  <script>
    const IS_LOGGED_IN = <?= $isLoggedIn ? 'true' : 'false' ?>;
    const CURRENT_USER = {
      kode_user: "<?= $kodeUser ?>",
      full_name: "<?= addslashes($fullName) ?>",
      email: "<?= addslashes($email) ?>"
    };
  </script>

  <div class="container-fluid mt-4 wishlist-layout">
    <div class="row">
      <!-- SIDEBAR KIRI -->
      <?php include __DIR__ . '/partials/account_sidebar.php'; ?>

      <!-- KONTEN KANAN -->
      <section class="col-12 col-md-9 col-lg-10 wishlist-content">

        <!-- Sapaan -->
        <div class="mb-4">
          <h3 class="page-greeting">
            Hai <?= htmlspecialchars($_SESSION['full_name'] ?? 'Kamu'); ?>, selamat datang kembali.
          </h3>
        </div>

        <!-- ROW ATAS: recently viewed + panel kanan -->
        <div class="row g-4 align-items-stretch">

          <!-- KIRI: Mobil yang baru saja dilihat -->
          <div class="col-12 col-lg-8">
            <div class="section-header d-flex justify-content-between align-items-center mb-3">
              <h4 class="section-title mb-0">Mobil yang baru saja kamu lihat</h4>
              <a href="../templates/katalog.php" class="section-link">Lihat semua mobil</a>
            </div>

            <?php if (empty($recentlyViewed)): ?>
              <p class="text-muted" style="font-size: 14px;">
                Belum ada mobil yang kamu lihat. Coba jelajahi dulu di halaman katalog.
              </p>
            <?php else: ?>
              <div class="row g-3 flex-nowrap flex-lg-wrap overflow-auto recent-cars-row">
                <?php foreach ($recentlyViewed as $m): ?>
                  <?php
                  $kodeMobil = $m['kode_mobil'] ?? '';
                  $isFavorit = in_array($kodeMobil, $favoritMobil);

                  // === PERBAIKAN URL FOTO ===
                  $img = '../assets/img/no-image.jpg'; // default
              
                  if (!empty($m['foto'])) {
                    $fileName = basename($m['foto']);

                    //WOI INI 
                    $img = 'http://localhost:80/API_kmj/images/mobil/' . $fileName;
                  }
                  ?>
                  <div class="col-10 col-sm-6 col-md-4 flex-shrink-0">
                    <a href="../templates/detail_mobil.php?kode=<?= urlencode($kodeMobil); ?>"
                      class="car-card-link text-decoration-none text-reset">
                      <div class="car-card card border-0 shadow-sm h-100">
                        <div class="car-card-image-wrapper">
                          <img src="<?= htmlspecialchars($img); ?>" class="card-img-top"
                            alt="<?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil'); ?>">
                          <button type="button" class="car-card-fav-btn icon-favorite <?= $isFavorit ? 'active' : '' ?>"
                            data-kode-mobil="<?= htmlspecialchars($kodeMobil); ?>">
                            <i class="fa-solid fa-heart"></i>
                          </button>
                        </div>

                        <div class="card-body">
                          <h6 class="car-card-title mb-1">
                            <?= htmlspecialchars($m['nama_mobil'] ?? 'Tanpa nama'); ?>
                          </h6>

                          <p class="car-card-price mb-1">
                            Rp <?= number_format($m['angsuran'] ?? 0, 0, ',', '.'); ?>
                            <span class="text-muted">
                              x <?= htmlspecialchars($m['tenor'] ?? '-'); ?>
                            </span>
                          </p>

                          <p class="car-card-subtext mb-2">
                            DP Rp <?= number_format($m['dp'] ?? 0, 0, ',', '.'); ?>
                          </p>

                          <div class="d-flex justify-content-between car-card-meta">
                            <span>
                              <i class="fa-regular fa-clock me-1"></i>
                              <?= number_format($m['jarak_tempuh'] ?? 0, 0, ',', '.'); ?> km
                            </span>
                            <span>
                              <i class="fa-regular fa-calendar me-1"></i>
                              <?= htmlspecialchars($m['tahun_mobil'] ?? '-'); ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>

          <!-- KANAN: panel mulai belanja -->
          <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100 start-panel">
              <div class="card-body d-flex flex-column">
                <h5 class="start-panel-title mb-2">Mulai belanja mobil online</h5>
                <p class="start-panel-text mb-3">
                  Cari mobil yang kamu suka dan atur anggaran untuk menemukan cicilan yang pas buat kamu.
                </p>

                <div class="d-flex flex-column gap-2 mb-3">
                  <a href="#" class="start-panel-link">
                    <i class="fa-solid fa-car-on me-2"></i>
                    Dapatkan penawaran tukar tambah
                  </a>
                  <a href="#" class="start-panel-link">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                    Ajukan pre-approval kredit
                  </a>
                  <a href="../templates/katalog.php" class="start-panel-link">
                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                    Lihat semua mobil
                  </a>
                </div>

                <button class="btn btn-warning mt-auto fw-semibold start-panel-cta">
                  Mulai mencari mobil
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- SECTION JANJI TEMU -->
        <div class="mt-5">
          <div class="section-header mb-3 d-flex justify-content-between align-items-center">
            <h4 class="section-title mb-0">Janji temu anda</h4>
            <a href="#" class="section-link">Lihat semua janji temu</a>
          </div>

          <div class="row g-3">

            <!-- Appointment 1 (contoh dummy) -->
            <div class="col-12 col-lg-6">
              <div class="card border-0 shadow-sm appointment-card h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="appointment-title mb-0">Uji coba mobil di KMJ Kaliwates</h6>
                    <span class="badge rounded-pill appointment-status appointment-status-cancelled">
                      Dibatalkan
                    </span>
                  </div>
                  <p class="appointment-date mb-2">
                    Rabu, 3 Desember pukul 17.00
                  </p>
                  <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="appointment-link">
                      <i class="fa-regular fa-file-lines me-1"></i> Lihat detail
                    </a>
                    <a href="#" class="appointment-link">
                      <i class="fa-solid fa-location-dot me-1"></i> Petunjuk arah
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Appointment 2 (contoh dummy) -->
            <div class="col-12 col-lg-6">
              <div class="card border-0 shadow-sm appointment-card h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="appointment-title mb-0">Kunjungan showroom KMJ Kaliwates</h6>
                    <span class="badge rounded-pill appointment-status appointment-status-active">
                      Terjadwal
                    </span>
                  </div>
                  <p class="appointment-date mb-2">
                    Selasa, 2 Desember pukul 10.30
                  </p>
                  <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="appointment-link">
                      <i class="fa-solid fa-pen-to-square me-1"></i> Atur janji temu
                    </a>
                    <a href="#" class="appointment-link">
                      <i class="fa-solid fa-location-dot me-1"></i> Petunjuk arah
                    </a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </section>
    </div>
  </div>

  <!-- SCRIPT FAVORITE UNTUK HALAMAN KERANJANG -->
  <script>
    document.querySelectorAll('.icon-favorite').forEach(icon => {
      icon.addEventListener('click', async (event) => {
        // jangan buka link detail saat klik heart
        event.stopPropagation();
        event.preventDefault();

        const kodeMobil = icon.dataset.kodeMobil;

        // cek login (harusnya selalu true, tapi jaga-jaga)
        if (!IS_LOGGED_IN) {
          const go = confirm('Kamu harus login untuk menambahkan ke favorit. Pergi ke halaman login?');
          if (go) {
            const currentUrl = window.location.pathname + window.location.search;
            window.location.href =
              '/web_showroommobilKMJ/templates/auth/auth.php?redirect=' +
              encodeURIComponent(currentUrl);
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
              action: action
            })
          });

          const data = await res.json();
          if (data.success) {
            icon.classList.toggle('active');
          } else {
            alert(data.message || 'Gagal mengubah data favorit');
          }
        } catch (err) {
          console.error(err);
          alert('Terjadi kesalahan server.');
        }
      });
    });
  </script>

  <script src="../assets/js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>