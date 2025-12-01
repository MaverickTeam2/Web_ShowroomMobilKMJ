<?php
$title = "index";

require_once __DIR__ . '/../db/config_api.php';
require_once __DIR__ . '/../db/api_client.php';
require_once __DIR__ . '/../include/header.php';

$mobil_api = api_get('admin/web_mobil_list.php');

$mobil_list = [];

if ($mobil_api && isset($mobil_api['code']) && $mobil_api['code'] == 200 && isset($mobil_api['data'])) {
  $mobil_list = $mobil_api['data'];
}

// Karena di SQL sudah ORDER BY m.created_at DESC,
// di sini kita cukup ambil 3 data pertama saja
$latest_mobil = array_slice($mobil_list, 0, 3);

// ========== FAVORIT USER ==========
session_start();
$kodeUser = $_SESSION['kode_user'] ?? null; // sesuaikan dengan session-mu

$favorit_mobil = [];

if ($kodeUser) {
  $fav_api = api_get('user/routes/favorites.php?kode_user=' . urlencode($kodeUser));

  if ($fav_api && !empty($fav_api['success']) && !empty($fav_api['data'])) {
    $favorit_mobil = $fav_api['data'];
  }
}

// ========== REKOMENDASI SEDERHANA ==========
// contoh: ambil 3 mobil setelah 3 pertama (kalau ada)
$rekomendasi_mobil = array_slice($mobil_list, 3, 3);

/**
 * Helper: bangun URL gambar mobil dari data API
 * Wajib pakai BASE_API_URL dari config_api.php
 */
function get_mobil_image_url($foto)
{
  // kalau kosong → pakai placeholder lokal
  if (empty($foto)) {
    return '../assets/img/placeholder-car.jpg';
  }

  // API kadang kirim path jelek / lengkap → ambil nama file saja
  $fileName = basename($foto); // contoh: mobil_6925be72e11da4.72202219.jpg

  // susun ulang pakai base API
  return BASE_API_URL . '/images/mobil/' . $fileName;
}

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--Import font Lato-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Gemunu+Libre:wght@300&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <!--Import Bulma CSS-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <!--Import Font Awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!--Import Custom CSS-->
  <link rel="stylesheet" href="../assets/css/style.css?v=<?= time(); ?>" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo_KMJ_YB2.ico " />
  <title>KMJ</title>
</head>

<body class="page-home">
  <!-- Navbar-->
  <?php include '../templates/navbar_footer/navbar.php'; ?>

  <!-- Container Hero Section-->
  <section class="hero is-fullheight-with-navbar p-4 m">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-vcentered">
          <!-- Kolom teks -->
          <div class="column is-half">
            <h1 class="title is-size-1 has-text-black">
              TEMUKAN MOBIL IMPIAN ANDA
            </h1>
            <p class="subtitle has-text-black">
              Kami menyediakan berbagai pilihan kendaraan berkualitas, siap pakai, dan telah melalui proses inspeksi
              menyeluruh.
            </p>
            <a class="button is-link is-rounded" href="../templates/katalog.php">Jelajahi Sekarang</a>
          </div>

          <!-- Kolom gambar -->
          <div class="column is-half has-text-centered">
            <a href="../templates/katalog.php" class="is-rounded">
              <img src="../assets/img/sport car.png" alt="Car" class="car-img" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Container Hero Section -->

  <!-- Popular Cars Section -->
  <section class="section">
    <div class="container">

      <h2 class="title has-text-centered">Mobil Terbaru</h2>

      <!-- Tabs -->
      <div class="tabs is-centered custom-tabs" id="mobilTabs">
        <ul>
          <li class="is-active" data-target="tab-terbaru"><a>Terbaru</a></li>
          <li data-target="tab-favorit"><a>Favorit</a></li>
          <li data-target="tab-rekomendasi"><a>Rekomendasi</a></li>
        </ul>
      </div>

      <!-- PANE: TERBARU -->
      <div id="tab-terbaru" class="tab-pane-mobil">
        <div class="columns is-multiline mobil-terbaru-columns" style="
          background-image: url('../assets/img/Background.jpg');
          background-size: cover;
          background-position: center;
          padding: 50px;
          border-radius: 30px;
        ">
          <?php foreach ($latest_mobil as $m): ?>
            <div class="column is-one-third">
              <div class="card car-card">
                <div class="card-image">
                  <figure class="image">
                    <img
                      src="<?= htmlspecialchars(get_mobil_image_url($m['foto'] ?? '')) ?>"
                      alt="<?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil') ?>">
                  </figure>
                </div>
                <div class="card-content">
                  <p class="title is-5"><?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil') ?></p>
                  <p class="subtitle is-6">
                    Rp <?= number_format($m['full_prize'] ?? 0, 0, ',', '.') ?>
                  </p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- PANE: FAVORIT -->
      <div id="tab-favorit" class="tab-pane-mobil is-hidden">
        <div class="columns is-multiline mobil-terbaru-columns" style="
          background-image: url('../assets/img/Background.jpg');
          background-size: cover;
          background-position: center;
          padding: 50px;
          border-radius: 30px;
        ">
          <?php if (empty($favorit_mobil)): ?>
            <div class="column has-text-centered">
              <p class="has-text-grey">Belum ada mobil favorit.</p>
            </div>
          <?php else: ?>
            <?php foreach ($favorit_mobil as $m): ?>
              <div class="column is-one-third">
                <div class="card car-card">
                  <div class="card-image">
                    <figure class="image">
                      <img
                        src="<?= htmlspecialchars(get_mobil_image_url($m['foto'] ?? '')) ?>"
                        alt="<?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil') ?>">
                    </figure>
                  </div>
                  <div class="card-content">
                    <p class="title is-5"><?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil') ?></p>
                    <p class="subtitle is-6">
                      Angsuran Rp <?= number_format($m['angsuran'] ?? 0, 0, ',', '.') ?>/bulan
                    </p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- PANE: REKOMENDASI -->
      <div id="tab-rekomendasi" class="tab-pane-mobil is-hidden">
        <div class="columns is-multiline mobil-terbaru-columns" style="
          background-image: url('../assets/img/Background.jpg');
          background-size: cover;
          background-position: center;
          padding: 50px;
          border-radius: 30px;
        ">
          <?php if (empty($rekomendasi_mobil)): ?>
            <div class="column has-text-centered">
              <p class="has-text-grey">Belum ada rekomendasi mobil.</p>
            </div>
          <?php else: ?>
            <?php foreach ($rekomendasi_mobil as $m): ?>
              <div class="column is-one-third">
                <div class="card car-card">
                  <div class="card-image">
                    <figure class="image">
                      <img
                        src="<?= htmlspecialchars(get_mobil_image_url($m['foto'] ?? '')) ?>"
                        alt="<?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil') ?>">
                    </figure>
                  </div>
                  <div class="card-content">
                    <p class="title is-5"><?= htmlspecialchars($m['nama_mobil'] ?? 'Mobil') ?></p>
                    <p class="subtitle is-6">
                      Rp <?= number_format($m['full_prize'] ?? 0, 0, ',', '.') ?>
                    </p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>
  <!-- End Popular Cars Section -->

  <!-- Services Section -->
  <section class="section">
    <div class="container">
      <h2 class="title has-text-centered">Pelayanan Kami</h2>
      <div class="columns is-multiline is-centered">
        <div class="column is-one-third has-text-centered">
          <span class="icon is-large">
            <i class="fa-solid fa-shield-halved fa-3x"></i>
          </span>
          <h3 class="subtitle mt-2">Kualitas Terjamin</h3>
          <p>
            Setiap kendaraan telah melalui proses inspeksi menyeluruh untuk memastikan kondisinya terbaik dan siap
            digunakan.
          </p>
        </div>
        <div class="column is-one-third has-text-centered">
          <span class="icon is-large">
            <i class="fa-solid fa-handshake fa-3x"></i>
          </span>
          <h3 class="subtitle mt-2">Harga Bersahabat</h3>
          <p>
            Kami menyediakan pilihan harga dan paket pembayaran yang fleksibel sesuai kebutuhan Anda.
          </p>
        </div>
        <div class="column is-one-third has-text-centered">
          <span class="icon is-large">
            <i class="fa-solid fa-headset fa-3x"></i>
          </span>
          <h3 class="subtitle mt-2">Layanan Pelanggan Responsif</h3>
          <p>
            Tim kami siap membantu Anda dari proses awal hingga selesai agar pengalaman pembelian menjadi mudah dan
            nyaman.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End Services Section -->

  <!--Section Driver-->
  <section class="section">
    <div class="container has-text-centered">
      <h2 class="title is-3">Dipercaya Pelanggan Selama Lebih dari 30 Tahun</h2>

      <div class="customer-slider">
        <!-- Slide 1 -->
        <div class="columns is-centered mt-5 customer-slide">
          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-1.webp"
                alt="Customer konsultasi dengan sales" />
            </figure>
          </div>

          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-2.jpg" alt="Showroom modern dan nyaman" />
            </figure>
          </div>

          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-3.jpg"
                alt="Tampilan showroom dengan mobil premium" />
            </figure>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="columns is-centered mt-5 customer-slide" style="display:none;">
          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-4.jpg" alt="Unit siap test drive" />
            </figure>
          </div>

          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-5.jpg" alt="Showroom modern dan nyaman" />
            </figure>
          </div>

          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-6.jpg"
                alt="Sales memberikan penjelasan kepada customer" />
            </figure>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="columns is-centered mt-5 customer-slide" style="display:none;">
          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-7.jpg" alt="Mobil display di showroom" />
            </figure>
          </div>

          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-8.webp"
                alt="Customer senang setelah deal pembelian" />
            </figure>
          </div>

          <div class="column is-one-third">
            <figure class="image is-3by2">
              <img class="custom-rounded-customer" src="../assets/img/index-9.jpg" alt="Mobil siap serah terima" />
            </figure>
          </div>
        </div>
      </div>

      <div class="mt-3 has-text-centered">
        <span class="dot is-active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>

    </div>
  </section>
  <!--End Section Driver-->

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const slides = document.querySelectorAll(".customer-slide");
      const dots = document.querySelectorAll(".dot");

      function showSlide(index) {
        slides.forEach((slide, i) => {
          slide.style.display = i === index ? "flex" : "none";
        });

        dots.forEach((dot, i) => {
          dot.classList.toggle("is-active", i === index);
        });
      }

      dots.forEach((dot, i) => {
        dot.addEventListener("click", () => showSlide(i));
      });

      showSlide(0);
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tabItems = document.querySelectorAll('#mobilTabs li');
      const panes = document.querySelectorAll('.tab-pane-mobil');

      tabItems.forEach(li => {
        li.addEventListener('click', () => {
          tabItems.forEach(item => item.classList.remove('is-active'));
          li.classList.add('is-active');

          const targetId = li.dataset.target;

          panes.forEach(pane => {
            if (pane.id === targetId) {
              pane.classList.remove('is-hidden');
            } else {
              pane.classList.add('is-hidden');
            }
          });
        });
      });
    });
  </script>

  <!-- Footer -->
  <script src="../assets/js/footer.js" defer></script>
</body>

</html>
