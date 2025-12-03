<?php
$title = "keranjang";

require_once __DIR__ . '/../db/config_api.php';
require_once __DIR__ . '/../db/api_client.php';
require_once __DIR__ . '/../include/header.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Kalau belum login → paksa ke login
if (!isset($_SESSION['kode_user'])) {
  header('Location: auth/auth.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
  exit;
}

$kodeUser = $_SESSION['kode_user'] ?? ($_SESSION['user_id'] ?? null);
$fullName = $_SESSION['full_name'] ?? '';
$email = $_SESSION['email'] ?? '';
$isLoggedIn = !empty($kodeUser);

$activeMenu = 'cart';

// ambil list mobil yang baru saja dilihat dari session
$recentlyViewed = $_SESSION['recently_viewed'] ?? [];

// AMBIL DATA FAVORIT USER
$favoritMobil = [];

if (!empty($kodeUser)) {
  $favApi = api_get('user/routes/favorites.php?kode_user=' . urlencode($kodeUser));

  if ($favApi && isset($favApi['success']) && $favApi['success']) {
    $favoritMobil = array_column($favApi['data'] ?? [], 'kode_mobil'); // ['MOB001', ...]
  }
}

// AMBIL DATA JANJI TEMU USER
$janjiTemu = [];

if (!empty($kodeUser)) {
  $inquireApi = api_get('user/routes/inquire_list.php?kode_user=' . urlencode($kodeUser));

  if ($inquireApi && isset($inquireApi['success']) && $inquireApi['success']) {
    $janjiTemu = $inquireApi['data'] ?? [];
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
        <!-- SECTION JANJI TEMU -->
        <div class="mt-5">
          <div class="section-header mb-3 d-flex justify-content-between align-items-center">
            <h4 class="section-title mb-0">Janji temu anda</h4>
            <a href="#" class="section-link">Lihat semua janji temu</a>
          </div>

          <?php if (empty($janjiTemu)): ?>
            <p class="text-muted" style="font-size: 14px;">
              Belum ada janji temu yang terjadwal.
            </p>
          <?php else: ?>
            <div class="row g-3">
              <?php foreach ($janjiTemu as $j): ?>
                <?php
                $status = $j['status'] ?? 'pending';

                $statusLabel = 'Menunggu';
                $statusClass = 'appointment-status-active';

                if ($status === 'pending') {
                  $statusLabel = 'Menunggu';
                  $statusClass = 'appointment-status-active';

                } elseif ($status === 'responded') {
                  $statusLabel = 'Selesai'; // misal: admin sudah kontak
                  $statusClass = 'appointment-status-done';

                } elseif ($status === 'closed') {
                  $statusLabel = 'Selesai';  // <-- hasil dari "Mark as Closed"
                  $statusClass = 'appointment-status-done';

                } elseif ($status === 'canceled') {
                  $statusLabel = 'Dibatalkan';  // hasil dari tombol X
                  $statusClass = 'appointment-status-cancelled';
                }

                $tanggal = $j['tanggal'] ?? '';
                $waktu = $j['waktu'] ?? '';

                if (strlen($waktu) >= 5) {
                  $waktu = substr($waktu, 0, 5);
                }
                ?>
                <div class="col-12 col-lg-6">
                  <div class="card border-0 shadow-sm appointment-card h-100">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <?php
                        $namaMobilJanji = $j['nama_mobil'] ?? ($j['kode_mobil'] ?? '');
                        ?>
                        <h6 class="appointment-title mb-0">
                          Janji temu mobil <?= htmlspecialchars($namaMobilJanji); ?>
                        </h6>

                        <span class="badge rounded-pill appointment-status <?= $statusClass ?>">
                          <?= htmlspecialchars($statusLabel); ?>
                        </span>
                      </div>
                      <p class="appointment-date mb-2">
                        <?= htmlspecialchars($tanggal); ?> pukul <?= htmlspecialchars($waktu); ?>
                      </p>
                      <div class="d-flex flex-wrap gap-3">
                        <a href="#" class="appointment-link appointment-detail-btn"
                          data-mobil="<?= htmlspecialchars($j['nama_mobil'] ?? ('Mobil ' . ($j['kode_mobil'] ?? ''))) ?>"
                          data-tanggal="<?= htmlspecialchars($tanggal); ?>" data-waktu="<?= htmlspecialchars($waktu); ?>"
                          data-status="<?= htmlspecialchars($statusLabel); ?>"
                          data-status-class="<?= htmlspecialchars($statusClass); ?>"
                          data-showroom="<?= htmlspecialchars($j['lokasi_showroom'] ?? 'Showroom KMJ'); ?>"
                          data-telp="<?= htmlspecialchars($j['no_telp'] ?? '-'); ?>"
                          data-note="<?= htmlspecialchars($j['note'] ?? '-'); ?>">
                          <i class="fa-regular fa-file-lines me-1"></i> Lihat detail
                        </a>

                        <a href="https://maps.app.goo.gl/qGcSdiQD9ELbNJwv7" class="appointment-link">
                          <i class="fa-solid fa-location-dot me-1"></i> Petunjuk arah
                        </a>
                      </div>

                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </section>
    </div>
  </div>

  <!-- Modal detail janji temu -->
  <div class="modal fade" id="appointmentDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content appointment-detail-modal">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title">Kamu sudah siap, <?= htmlspecialchars($_SESSION['full_name'] ?? 'Customer'); ?> 🎉
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body">
          <div class="d-flex flex-column flex-md-row gap-3 align-items-start">
            <div class="flex-grow-1">
              <p class="mb-1 text-muted small">Mobil</p>
              <h5 class="mb-2" id="detailModalCar"></h5>
              <p class="mb-0 fw-semibold" id="detailModalDatetime"></p>
              <p class="mb-0 text-muted small" id="detailModalShowroom"></p>
            </div>

            <div class="text-md-end mt-3 mt-md-0">
              <span class="badge rounded-pill" id="detailModalStatusBadge"></span>
              <p class="mb-0 mt-2 small text-muted">
                No. telepon: <span id="detailModalTelp"></span>
              </p>
            </div>
          </div>

          <hr>

          <p class="mb-1 fw-semibold">Catatan kamu</p>
          <p class="mb-0" id="detailModalNote"></p>
        </div>

        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
            Oke, mengerti
          </button>
        </div>
      </div>
    </div>
  </div>

  <style>
    /* Khusus modal detail janji temu */
    #appointmentDetailModal .modal-dialog {
      max-width: 520px !important;
      /* Biar nggak melebar */
      width: 100%;
      margin: 2.5rem auto;
      /* Tengah secara horizontal */
    }

    #appointmentDetailModal .modal-content {
      border-radius: 24px;
      padding: 0;
      overflow: hidden;
    }

    #appointmentDetailModal .modal-body {
      padding: 24px 28px 20px;
    }

    #appointmentDetailModal .modal-footer {
      padding: 16px 24px 22px;
      border-top: 0;
      display: flex;
      justify-content: flex-end;
    }

    /* Biar headernya nggak terlalu tinggi */
    #appointmentDetailModal .modal-header {
      border-bottom: 0;
      padding: 20px 24px 8px;
    }
  </style>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const modalEl = document.getElementById('appointmentDetailModal');
      if (!modalEl || typeof bootstrap === 'undefined') return;

      const modal = new bootstrap.Modal(modalEl);

      document.querySelectorAll('.appointment-detail-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();

          const d = this.dataset;

          // Isi konten modal
          document.getElementById('detailModalCar').textContent = d.mobil || '-';

          const dtText =
            (d.tanggal && d.waktu)
              ? `${d.tanggal} pukul ${d.waktu}`
              : (d.tanggal || '');
          document.getElementById('detailModalDatetime').textContent = dtText;

          document.getElementById('detailModalShowroom').textContent =
            d.showroom || '';

          document.getElementById('detailModalTelp').textContent =
            d.telp || '-';

          document.getElementById('detailModalNote').textContent =
            (d.note && d.note.trim() !== '')
              ? d.note
              : 'Tidak ada catatan tambahan.';

          const badge = document.getElementById('detailModalStatusBadge');
          badge.textContent = d.status || '';
          badge.className = 'badge rounded-pill ' + (d.statusClass || '');

          modal.show();
        });
      });
    });
  </script>


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