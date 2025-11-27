<?php
$title = "wishlist";

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

// Panggil API favorites
$api = api_get('user/routes/favorites.php?kode_user=' . urlencode($kodeUser));

if (!$api || !isset($api['success']) || !$api['success']) {
  $favorites = [];
} else {
  $favorites = $api['data'] ?? [];
}

$jumlahFavorit = count($favorites);


$statusLabelMap = [
  'available' => 'Available',
  'reserved' => 'Reserved',
  'sold' => 'Sold',
  'shipping' => 'Shipping',
  'delivered' => 'Delivered',
];
$activeMenu = 'favorite'; // halaman ini = Favorit
?>

<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
  <meta charset="UTF-8">
  <title>KMJ - Wishlist</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo_KMJ_YB2.ico ">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/katalog2.css?v=<?= time(); ?>">
  <!-- ⬇⬇ TAMBAHKAN BARIS INI -->
  <link rel="stylesheet" href="../assets/css/wishlist_sidebar.css?v=<?= time(); ?>">
  <!-- ⬆⬆ -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>

  <?php include '../templates/navbar_footer/navbar.php'; ?>
  <?php
  $fullName = $_SESSION['full_name'] ?? '';
  $email = $_SESSION['email'] ?? '';
  ?>
  <script>
    // Di wishlist, user pasti sudah login karena sudah dicek di PHP
    const IS_LOGGED_IN = true;

    const CURRENT_USER = {
      kode_user: "<?= $kodeUser ?>",
      full_name: "<?= addslashes($fullName) ?>",
      email: "<?= addslashes($email) ?>"
    };
  </script>


  <div class="container-fluid mt-4 wishlist-layout">
    <div class="row">
      <!-- SIDEBAR KIRI -->
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
      <section class="col-12 col-md-9 col-lg-10 wishlist-content">
        <h3 class="mb-3">Favorite</h3>

        <?php if (empty($favorites)): ?>
          <div class="text-muted py-5">
            Belum ada mobil di wishlist kamu.
          </div>
        <?php else: ?>
          <div class="d-flex flex-wrap gap-4">
            <?php foreach ($favorites as $m): ?>
              <div class="wishlist-card-wrapper">
                <div class="card car-card shadow-sm h-100">
                  <?php
                  $img = '../assets/img/no-image.jpg'; // default
              
                  if (!empty($m['foto'])) {
                    // ambil hanya nama file dari URL yang jelek
                    $fileName = basename($m['foto']); // contoh: mobil_6925be72e11da4.72202219.jpg
              
                    // susun ulang URL yang benar (samain dengan struktur folder API kamu)
                    $img = 'http://localhost:80/API_kmj/images/mobil/' . $fileName;
                  }

                  $status = $m['status'] ?? 'available';
                  $statusLabel = $statusLabelMap[$status] ?? $status;
                  ?>
                  <div class="card-image position-relative">
                    <figure class="image image-wrapper mb-0">
                      <img src="<?= htmlspecialchars($img) ?>"
                        alt="<?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil Tanpa Nama') ?>" class="img_main card-img-top">

                      <!-- Di wishlist biasanya nggak ada badge status, jadi bisa dihapus / dibiarkan -->
                      <!-- Heart merah di pojok kanan atas -->
                      <span class="icon-favorite active" data-kode-mobil="<?= htmlspecialchars($m['kode_mobil']) ?>">
                        <i class="fa-solid fa-heart"></i>
                      </span>
                    </figure>
                  </div>

                  <div class="card-content p-3">
                    <a href="../templates/detail_mobil.php?kode=<?= urlencode($m['kode_mobil']) ?>"
                      class="text-decoration-none mb-2 d-inline-block" style="font-size:16px;">
                      <p class="title is-5 mb-1">
                        <?= htmlspecialchars($m['nama_mobil'] ?? 'Tanpa Nama') ?>
                      </p>
                    </a>

                    <p class="ansguran mb-1" style="font-size:16px; font-weight:700; color:#111827; margin-bottom:4px;">
                      Rp <?= number_format($m['angsuran'] ?? 0, 0, ',', '.') ?>
                      <span style="font-weight:600;">
                        x <?= htmlspecialchars($m['tenor'] ?? '-') ?>
                      </span>
                    </p>

                    <p class="uang_dp mb-2" style="font-size:14px; font-weight:600; color:#111827; margin-bottom:6px;">
                      Dp Rp <?= number_format($m['dp'] ?? 0, 0, ',', '.') ?>
                    </p>

                    <hr class="my-2">

                    <div class="info d-flex align-items-center gap-2">
                      <i class="fa-regular fa-clock" style="font-size:14px;"></i>
                      <span style="font-size: 14px">
                        <?= number_format($m['jarak_tempuh'] ?? 0, 0, ',', '.'); ?> Km
                      </span>

                      <i class="fa-regular fa-calendar ms-3" style="font-size:14px;"></i>
                      <span style="font-size: 14px">
                        <?= htmlspecialchars($m['tahun_mobil'] ?? '-'); ?>
                      </span>
                    </div>

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
                          <a href="#" class="dropdown-item btn-remove-fav"
                            data-kode-mobil="<?= htmlspecialchars($m['kode_mobil']) ?>">
                            <i class="fa-solid fa-trash"></i> Hapus dari favorit
                          </a>
                          <a href="../templates/perbandingan.php" class="dropdown-item">
                            <i class="fa-solid fa-shuffle me-2"></i> Bandingkan
                          </a>
                          <a href="#" class="dropdown-item">
                            <i class="fa-solid fa-share me-2"></i> Bagikan
                          </a>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </section>
    </div>
  </div>


  <script>
    document.querySelectorAll('.icon-favorite').forEach(icon => {
      icon.addEventListener('click', async () => {
        const kodeMobil = icon.dataset.kodeMobil;

        // 1. CEK LOGIN
        if (!IS_LOGGED_IN) {
          const go = confirm('Kamu harus login untuk menambahkan ke favorit. Pergi ke halaman login?');
          if (go) {
            const currentUrl = window.location.pathname + window.location.search;

            // ==== PERBAIKAN DISINI ====
            window.location.href =
              '/web_showroommobilKMJ/templates/auth/auth.php?redirect=' +
              encodeURIComponent(currentUrl);
          }
          return;
        }

        // 2. ADD / REMOVE FAVORITE
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