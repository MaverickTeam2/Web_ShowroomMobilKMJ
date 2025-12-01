<?php
$title = "janji_temu";

require_once __DIR__ . '/../db/config_api.php';
require_once __DIR__ . '/../db/api_client.php';
require_once __DIR__ . '/../include/header.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// cek login
if (!isset($_SESSION['user_id'])) {
  header('Location: ../admin/auth/auth.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
  exit;
}

$kode = $_GET['kode'] ?? '';
if (!$kode) {
  header('Location: katalog.php');
  exit;
}

$fullName = $_SESSION['full_name'] ?? 'Akun KMJ';

// ambil detail mobil
$api = api_get('admin/web_mobil_detail.php?kode_mobil=' . urlencode($kode));
if (!$api || !isset($api['success']) || !$api['success']) {
  die("Gagal mengambil data mobil: " . ($api['message'] ?? 'Unknown error'));
}

$mobil = $api['mobil'] ?? null;
$foto  = $api['foto'] ?? [];

if (!$mobil) {
  die("Data mobil tidak ditemukan.");
}

// olah data
$namaMobil   = $mobil['nama_mobil'] ?? 'Mobil Tanpa Nama';
$tahunMobil  = $mobil['tahun_mobil'] ?? '';
$jarakTempuh = $mobil['jarak_tempuh'] ?? 0;
$angsuran    = $mobil['angsuran'] ?? 0;
$tenor       = $mobil['tenor'] ?? 0;
$dp          = $mobil['uang_muka'] ?? 0;
$lokasiShowroom = $mobil['lokasi_showroom'] ?? 'Showroom utama KMJ';

// foto utama
$images = [];
foreach ($foto as $f) {
  if (!empty($f['nama_file'])) {
    $images[] = $f['nama_file'];
  }
}
if (empty($images)) {
  $images[] = '../assets/img/no-image.jpg';
}
$fotoUtama = $images[0];
?>
<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
  <meta charset="UTF-8">
  <title>KMJ - Janji Temu</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <link rel="stylesheet" href="../assets/css/janji_temu.css?v=<?= time(); ?>">
</head>

<body class="page-appointment">

  <!-- TOPBAR FULLSCREEN -->
  <header class="appointment-topnav">
    <div class="appointment-topnav-inner">
      <div class="appointment-topnav-left">
        <img src="../assets/img/Logo_KMJ_YB2.ico" class="appointment-logo" alt="KMJ">
      </div>
      <div class="appointment-topnav-right">
        <i class="fa-regular fa-user"></i>
        <span><?= htmlspecialchars($fullName) ?></span>
      </div>
    </div>
  </header>

  <!-- MAIN -->
  <main class="appointment-main-wrapper">
    <div class="container appointment-container">

      <!-- HEADER MOBIL -->
      <div class="d-flex align-items-center gap-3 mb-4">
        <img src="<?= htmlspecialchars($fotoUtama) ?>" class="appointment-car-thumb" alt="Mobil">
        <div>
          <h4 class="mb-0"><?= htmlspecialchars($namaMobil) ?></h4>
          <div class="text-muted" style="font-size:13px;">
            <?= htmlspecialchars($tahunMobil) ?> • <?= number_format($jarakTempuh, 0, ',', '.') ?> km
          </div>
        </div>
      </div>

      <div class="card border-0 shadow-sm appointment-main-card">
        <div class="row g-0">

          <!-- SIDEBAR STEP -->
          <div class="col-12 col-md-3 border-end">
            <div class="appointment-sidebar-inner">
              <h6 class="appointment-sidebar-title mb-3">Test drive atau beli</h6>
              <ul class="appointment-steps list-unstyled mb-0">
                <li class="appointment-step-item active" data-step-index="1">
                  <div class="step-circle step-circle--active"><span>1</span></div>
                  <div class="step-label">
                    Pilih bagaimana Anda<br> menginginkan mobil ini
                  </div>
                </li>
                <li class="appointment-step-item" data-step-index="2">
                  <div class="step-circle"><span>2</span></div>
                  <div class="step-label">
                    Jadwalkan janji temu
                  </div>
                </li>
                <li class="appointment-step-item" data-step-index="3">
                  <div class="step-circle"><span>3</span></div>
                  <div class="step-label">
                    Tinjau dan konfirmasi
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <!-- KONTEN STEP -->
          <div class="col-12 col-md-9">
            <div class="appointment-content p-4">

              <form id="appointmentForm" autocomplete="off">
                <!-- STEP 1 -->
                <div class="appointment-step-panel" data-step="1">
                  <h2 class="appointment-heading mb-2">
                    Pilihan yang bagus! Begini cara membuatnya menjadi milik Anda
                  </h2>
                  <p class="appointment-subheading mb-4">
                    Pilih cara yang paling cocok untuk kamu. Kamu bisa uji coba dulu atau langsung mulai proses beli online.
                  </p>

                  <label class="choice-card">
                    <input type="radio" name="tipe_cara" value="test_drive" checked>
                    <div class="choice-card-inner">
                      <div class="choice-icon">
                        <i class="fa-solid fa-car-side"></i>
                      </div>
                      <div class="choice-text">
                        <div class="choice-title">Uji coba sebelum membeli</div>
                        <div class="choice-desc">
                          Pastikan mobil ini benar-benar tepat untuk kamu sebelum memutuskan untuk membeli.
                        </div>
                      </div>
                    </div>
                  </label>

                  <label class="choice-card">
                    <input type="radio" name="tipe_cara" value="buy_online">
                    <div class="choice-card-inner">
                      <div class="choice-icon">
                        <i class="fa-solid fa-credit-card"></i>
                      </div>
                      <div class="choice-text">
                        <div class="choice-title">Beli online dan hemat waktu di showroom</div>
                        <div class="choice-desc">
                          Mulai proses beli online, lalu selesaikan di showroom atau di rumah—sesuai pilihanmu.
                        </div>
                      </div>
                    </div>
                  </label>

                  <div class="appointment-footer d-flex justify-content-between align-items-center mt-4">
                    <a href="detail_mobil.php?kode=<?= urlencode($kode) ?>"
                       class="appointment-link-back">&larr; Kembali ke detail mobil</a>
                    <button type="button" class="btn btn-primary appointment-btn-next" data-target-step="2">
                      Lanjutkan
                    </button>
                  </div>
                </div>

                <!-- STEP 2 -->
                <div class="appointment-step-panel d-none" data-step="2">
                  <h2 class="appointment-heading mb-3">Pilih jenis janji temu</h2>

                  <label class="choice-card">
                    <input type="radio" name="tipe_janji" value="this_car" checked>
                    <div class="choice-card-inner">
                      <div class="choice-avatar">
                        <img src="<?= htmlspecialchars($fotoUtama); ?>" alt="<?= htmlspecialchars($namaMobil); ?>">
                      </div>
                      <div class="choice-text">
                        <div class="choice-title">Uji coba atau beli mobil ini</div>
                        <div class="choice-desc">
                          Buat janji temu khusus untuk mobil ini.
                        </div>
                      </div>
                    </div>
                  </label>

                  <label class="choice-card">
                    <input type="radio" name="tipe_janji" value="all_cars">
                    <div class="choice-card-inner">
                      <div class="choice-icon">
                        <i class="fa-solid fa-warehouse"></i>
                      </div>
                      <div class="choice-text">
                        <div class="choice-title">Uji beberapa mobil di showroom</div>
                        <div class="choice-desc">
                          Jadwalkan janji temu untuk melihat dan mencoba beberapa mobil sekaligus.
                        </div>
                      </div>
                    </div>
                  </label>

                  <div class="row g-3 mt-3">
                    <div class="col-12 col-md-6">
                      <label class="form-label appointment-label">
                        <i class="fa-regular fa-calendar me-1"></i>Pilih tanggal:
                      </label>
                      <input type="date" class="form-control appointment-input" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="col-12 col-md-6">
                      <label class="form-label appointment-label">
                        <i class="fa-regular fa-clock me-1"></i>Pilih waktu:
                      </label>
                      <select class="form-select appointment-input" id="waktu" name="waktu" required>
                        <option value="">Pilih jam</option>
                        <option value="09:00">09.00</option>
                        <option value="10:30">10.30</option>
                        <option value="13:00">13.00</option>
                        <option value="14:30">14.30</option>
                        <option value="16:00">16.00</option>
                      </select>
                    </div>
                  </div>

                  <div class="appointment-footer d-flex justify-content-between align-items-center mt-4">
                    <button type="button" class="appointment-link-back btn btn-link p-0"
                            data-target-step="1">&larr; Kembali</button>
                    <button type="button" class="btn btn-primary appointment-btn-next" data-target-step="3">
                      Lanjutkan
                    </button>
                  </div>
                </div>

                <!-- STEP 3 -->
                <div class="appointment-step-panel d-none" data-step="3">
                  <h2 class="appointment-heading mb-3">Tinjau detail janji temu Anda</h2>

                  <div class="card appointment-review-card mb-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge appointment-badge">
                          Test drive atau beli
                        </span>
                        <span class="appointment-review-dealer">
                          <?= htmlspecialchars($lokasiShowroom); ?>
                        </span>
                      </div>

                      <div class="d-flex gap-3 align-items-center mb-3">
                        <div class="appointment-review-thumb">
                          <img src="<?= htmlspecialchars($fotoUtama); ?>" alt="<?= htmlspecialchars($namaMobil); ?>">
                        </div>
                        <div class="flex-grow-1">
                          <div class="appointment-review-name">
                            <?= htmlspecialchars($namaMobil); ?>
                          </div>
                          <div class="appointment-review-price">
                            Rp <?= number_format($angsuran, 0, ',', '.'); ?>
                            <span>x <?= htmlspecialchars($tenor); ?></span>
                          </div>
                          <div class="appointment-review-dp">
                            DP Rp <?= number_format($dp, 0, ',', '.'); ?>
                          </div>
                          <div class="appointment-review-meta mt-1">
                            <span><i class="fa-solid fa-gauge-high me-1"></i>
                              <?= number_format($jarakTempuh, 0, ',', '.'); ?> Km
                            </span>
                            <span><i class="fa-regular fa-calendar me-1"></i>
                              <?= htmlspecialchars($tahunMobil); ?>
                            </span>
                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="appointment-review-datetime">
                        <div class="fw-semibold mb-1">
                          <i class="fa-regular fa-calendar-days me-1"></i>Detail janji temu
                        </div>
                        <div id="reviewDatetime" class="appointment-review-datetime-text">
                          (Tanggal & waktu akan muncul di sini)
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label appointment-label">Konfirmasi nomor telepon *</label>
                    <input type="tel" name="telepon" class="form-control appointment-input" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label appointment-label">Catatan (opsional)</label>
                    <textarea name="catatan" rows="3" class="form-control appointment-input"></textarea>
                  </div>

                  <div class="appointment-footer d-flex justify-content-between align-items-center mt-4">
                    <button type="button" class="appointment-link-back btn btn-link p-0"
                            data-target-step="2">&larr; Kembali</button>
                    <button type="submit" class="btn btn-primary">
                      Lanjutkan
                    </button>
                  </div>
                </div>

              </form>

            </div>

            <div class="appointment-bottom-note">
              Dengan menggunakan situs KMJ, Anda menyetujui pemantauan dan penyimpanan interaksi Anda
              untuk peningkatan dan personalisasi layanan. Lihat Kebijakan Privasi kami untuk info selengkapnya.
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

    <script src="../assets/js/janji_temu.js?v=<?= time(); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
