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

$kodeUser = $_SESSION['user_id'];

// aktifkan menu "cart" di sidebar
$activeMenu = 'cart';

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
</head>

<body>

  <?php include '../templates/navbar_footer/navbar.php'; ?>

  <div class="container-fluid mt-4 wishlist-layout">
    <div class="row">
      <!-- SIDEBAR KIRI (SAMA PERSIS DENGAN DI wishlist.php) -->
      <aside class="col-12 col-md-3 col-lg-2 wishlist-sidebar">
        <div class="wishlist-menu">

          <div class="wishlist-section-title">Belanja</div>

          <!-- Keranjang -->
          <a href="keranjang.php"
            class="wishlist-menu-item <?= ($activeMenu === 'cart') ? 'wishlist-menu-item--active' : '' ?>">
            <span class="wishlist-menu-indicator"></span>
            <i class="fa-solid fa-cart-shopping me-2"></i>
            <span>Keranjang saya</span>
          </a>

          <!-- Favorit -->
          <a href="wishlist.php"
            class="wishlist-menu-item <?= ($activeMenu === 'favorite') ? 'wishlist-menu-item--active' : '' ?>">
            <span class="wishlist-menu-indicator"></span>
            <i class="fa-solid fa-heart me-2"></i>
            <span>Favorit</span>
          </a>

          <hr class="wishlist-divider">

          <div class="wishlist-section-title">Akun</div>

          <a href="profil.php" class="wishlist-menu-item">
            <span class="wishlist-menu-indicator"></span>
            <i class="fa-solid fa-user me-2"></i>
            <span>Pengaturan Profil</span>
          </a>

          <hr class="wishlist-divider">

          <a href="../admin/auth/logout.php" class="wishlist-menu-item wishlist-menu-item--logout">
            <span class="wishlist-menu-indicator"></span>
            <i class="fa-solid fa-arrow-left me-2"></i>
            <span>Keluar</span>
          </a>

        </div>
      </aside>

      <!-- KONTEN KANAN -->
      <!-- KONTEN KANAN -->
      <section class="col-12 col-md-9 col-lg-10 wishlist-content">

        <!-- Sapaan -->
        <h3 class="mb-3">
          Hai <?= htmlspecialchars($_SESSION['full_name'] ?? 'Kamu'); ?> , selamat datang kembali.
        </h3>

        <!-- KARTU MOBIL DI KERANJANG -->
        <div class="mb-4">
          <div class="card shadow-sm border-0">
            <div class="row g-0 align-items-center">
              <!-- Foto mobil -->
              <div class="col-md-5">
                <img src="../assets/img/no-image.jpg" class="img-fluid rounded-start" alt="Mobil di keranjang">
              </div>

              <!-- Info mobil -->
              <div class="col-md-7">
                <div class="card-body">

                  <!-- badge hijau -->
                  <span class="badge rounded-pill bg-success-subtle text-success fw-semibold mb-2"
                    style="font-size:12px;">
                    Uji coba dijadwalkan
                  </span>

                  <!-- Nama mobil -->
                  <h5 class="card-title mb-1" style="font-size:16px; font-weight:700; color:#2563eb;">
                    Mercedes-Maybach S 680 4MATIC Night Series
                  </h5>

                  <!-- Harga / angsuran -->
                  <p class="mb-1" style="font-size:14px; font-weight:700; color:#111827;">
                    Rp. 7.998.000 x 60
                  </p>
                  <p class="mb-2" style="font-size:12px; color:#6b7280;">
                    Dp Rp. 39.000.000
                  </p>

                  <!-- Km & Tahun -->
                  <div class="d-flex align-items-center gap-3" style="font-size:12px; color:#374151;">
                    <span>
                      <i class="fa-regular fa-clock me-1"></i>120000 Km
                    </span>
                    <span>
                      <i class="fa-regular fa-calendar me-1"></i>2021
                    </span>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- JUDUL JANJI TEMU -->
        <h4 class="mb-3" style="font-size:18px; font-weight:700;">
          Janji temu anda
        </h4>

        <!-- BOX JANJI TEMU -->
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="d-flex align-items-center mb-1">
              <h6 class="mb-0 me-2" style="font-size:15px; font-weight:700;">
                Uji coba mobil
              </h6>
              <span class="badge rounded-pill bg-danger-subtle text-danger" style="font-size:11px;">
                Dibatalkan
              </span>
            </div>

            <p class="mb-2" style="font-size:13px; color:#6b7280;">
              Jumat, 14 November pukul 11.00
            </p>

            <a href="#" style="font-size:13px; text-decoration:none; color:#2563eb;">
              <i class="fa-solid fa-location-dot me-1"></i>
              Lihat petunjuk arah
            </a>
          </div>
        </div>

      </section>

    </div>
  </div>

  <script src="../assets/js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>