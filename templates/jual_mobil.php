<?php
// Dummy data (simulasi data dari database)

// Data mobil
$mobil = [
  "judul" => "Dapatkan hasil pembiayaan tanpa memengaruhi kredit Anda",
  "gambar" => "../assets/img/mobilfinance.png",
  "cta" => "Dapatkan Persyaratan"
];

// Data finance company
$finance = [
  ["nama" => "BCA Finance", "logo" => "../assets/img/bcalogo.png"],
  ["nama" => "FIFGROUP", "logo" => "../assets/img/fifgroup.png"],
  ["nama" => "BRI Finance", "logo" => "../assets/img/brifinance.png"],
  ["nama" => "PT Summit OTO Finance", "logo" => "../assets/img/ptotto.png"],
  ["nama" => "Mandiri Utama Finance", "logo" => "../assets/img/mandirifinance.png"],
];

// Data tips kredit
$tips = [
  [
    "judul" => "Tips Kredit Kendaraan 1",
    "deskripsi" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    "gambar" => "https://via.placeholder.com/150.png?text=Card+1"
  ],
  [
    "judul" => "Tips Kredit Kendaraan 2",
    "deskripsi" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    "gambar" => "https://via.placeholder.com/150.png?text=Card+2"
  ],
  [
    "judul" => "Tips Kredit Kendaraan 3",
    "deskripsi" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    "gambar" => "https://via.placeholder.com/150.png?text=Card+3"
  ],
];

// Data FAQ
$faqs = [
  "Lorem Ipsum is simply dummy text of the printing text?",
  "Apa keuntungan menggunakan kredit di KMJ?",
  "Bagaimana cara mengajukan pembiayaan?",
  "Apa saja syarat dokumen yang diperlukan?",
  "Berapa lama proses persetujuan kredit?",
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KMJ Finance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="../assets/css/finance.css">
  <!--Import Custom CSS-->
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>

  <!-- navbar -->
  <?php include '../templates/navbar_footer/navbar.php'; ?>

  <!-- Sub Navigation -->
  <div class="container">
    <div class="tab-switch">
      <a href="#" id="tabHow" class="active">Beli Mobil</a>
      <a href="#" id="tabKalkulator">Jual Mobil</a>
    </div>
  </div>



  <!-- ================= HOW IT WORKS SECTION ================= -->
  <div id="howItWorks" class="tab-content active">

    <!-- Hero -->
    <section class="hero is-fullheight-with-navbar p-4 m">
      <div class="hero-body">
        <div class="container">
          <div class="columns is-hcentered">
            <!-- Kolom teks -->
            <div class="column is-half">
              <h1 class="title is-size-1 has-text-black">
                FIND AND BUY IT ONLINE
              </h1>
            </div>
            <!-- Kolom gambar -->
            <div class="column is-half">
              <figure class="image is-4by2">
                <img src="../assets/img/sport car.png" alt="Gambar Mobil" />
              </figure>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-half has-text-centered">
            <h2 class="title is-size-3 has-text-black">1. Choose.</h2>
            <p class="subtitle is-size-5 has-text-black">
              Once you find a car to buy, decide how you want it. We'll continue
              chat you to talk next steps.
            </p>
          </div>
        </div>
        <div class="columns">
          <!-- Online Card (Kiri) -->
          <div class="column is-half">
            <div class="card"
              style="background-image: url('../assets/img/online-bg.jpg'); background-size: cover; background-position: center;">
              <div class="card-content has-text-centered"
                style="background: rgba(255,255,255,0.85); border-radius: 8px;">
                <span class="icon is-large">
                  <i class="fas fa-globe fa-2x"></i>
                </span>
                <h3 class="title is-size-4">Buy Online</h3>
                <p class="subtitle is-size-6">Order your car online and get it delivered to your door.</p>
                <a href="https://wa.me/6281234567890" target="_blank" class="button is-success is-fullwidth mt-3">
                  <span class="icon"><i class="fab fa-whatsapp"></i></span>
                  <span>Chat WhatsApp</span>
                </a>
              </div>
            </div>
          </div>
          <!-- Offline Card (Kanan) -->
          <div class="column is-half">
            <div class="card"
              style="background-image: url('../assets/img/offline-bg.jpg'); background-size: cover; background-position: center;">
              <div class="card-content has-text-centered"
                style="background: rgba(255,255,255,0.85); border-radius: 8px;">
                <span class="icon is-large">
                  <i class="fas fa-store fa-2x"></i>
                </span>
                <h3 class="title is-size-4">Buy at Dealer</h3>
                <p class="subtitle is-size-6">Visit our showroom and buy directly from our dealer.</p>
                <a href="https://maps.google.com/?q=Showroom+KMJ" target="_blank"
                  class="button is-link is-fullwidth mt-3">
                  <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                  <span>Lihat Lokasi</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--End Section-->
    <!-- 2 Chat and Buy-->
    <section class="section">
      <div class="container">
        <div class="columns is-vcentered is-half">
          <div class="column is-half">
            <h2 class="title is-size-3 has-text-black">2. Chat & Buy. We provide remote support along way</h2>
          </div>
          <!-- Kolom gambar-->
          <div class="column is-half has-text-centered">
            <figure class="image is-4by3">
              <img src="../assets/img/sport car.png" alt="Chat and Buy" style="width: 630px; max-width: auto;" />
            </figure>
          </div>
        </div>
      </div>
    </section>
    <!-- End Footer-->

    <!-- 3 Confirm purchase -->
    <section class="section">
      <div class="container">
        <div class="columns is-vcentered is-half">
          <!-- Kolom gambar-->
          <div class="column is-half has-text-centered">
            <figure class="image is-4by3">
              <img
                src="https://hips.hearstapps.com/hmg-prod/images/koenigsegg-regera-mmp-1-1591115837.jpg?crop=0.779xw:0.660xh;0.0945xw,0.230xh&resize=1200:*"
                alt="Chat and Buy" style="width: 630px; max-width: auto;" />
            </figure>
          </div>
          <div class="column is-half">
            <h2 class="title is-size-3 has-text-black">3. Confirm your purchase and continou in our store</h2>
          </div>
        </div>
      </div>
    </section>
  </div>


  <!-- ================= KALKULATOR PEMBAYARAN SECTION ================= -->
  <div id="kalkulator" class="tab-content">

    <!-- Hero Jual Mobil -->
    <section class="section py-5">
      <div class="container">
        <div class="row align-items-center g-4">
          <div class="col-md-6">
            <h1 class="fw-bold mb-3" style="font-size: 28px;">
              Jual mobilmu secara online<br>
              dengan cepat dan mudah
            </h1>
            <p class="text-muted mb-0">
              Proses simpel dari rumah, tim kami bantu dari awal hingga deal di showroom.
            </p>
          </div>
          <div class="col-md-6 text-center">
            <img src="../assets/img/sport car.png" alt="Jual Mobil Online" class="img-fluid rounded-4 shadow-sm">
          </div>
        </div>
      </div>
    </section>


    <!-- ================== LANGKAH 1 ================== -->
<section class="section pt-0 pb-5">
  <div class="container">
    <div class="row align-items-center g-4">

      <!-- Gambar kiri -->
      <div class="col-lg-6 order-lg-1 order-1">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
          <div class="position-relative" style="background: linear-gradient(135deg,#0f172a,#1d4ed8);">

            <img src="../assets/img/sport car.png"
                 class="img-fluid w-100"
                 style="opacity:.9; mix-blend-mode:screen;"
                 alt="Hubungi Kami">

            <!-- Chat Bubble -->
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3">

              <div class="bg-white bg-opacity-90 rounded-3 p-2 mb-2 shadow-sm" style="max-width:85%;">
                <div class="d-flex align-items-center mb-1">
                  <div class="rounded-circle bg-success d-flex justify-content-center align-items-center me-2"
                       style="width:22px; height:22px;">
                    <i class="fab fa-whatsapp text-white" style="font-size:12px;"></i>
                  </div>
                  <span class="fw-semibold small">KMJ Support</span>
                </div>
                <p class="mb-0 small text-muted">Halo, kak! Mau jual mobil? Kirim detailnya di sini ya 😊</p>
              </div>

              <div class="ms-auto bg-primary text-white rounded-3 p-2 small shadow-sm"
                   style="max-width:75%;">
                Saya mau jual mobil kak, bisa dibantu prosesnya?
              </div>

            </div>

          </div>
        </div>
      </div>

      <!-- Teks kanan -->
      <div class="col-lg-6 order-lg-2 order-2">
        <span class="text-uppercase fw-semibold text-primary small">Langkah 1</span>
        <h2 class="fw-bold fs-3 mt-2 mb-3">Hubungi Kami</h2>

        <p class="text-muted mb-2">
          Mulai proses penjualan hanya dengan menghubungi tim kami.
          Tidak perlu mengisi form apa pun — cukup chat saja.
        </p>

        <p class="text-muted mb-4">
          Kami akan menjelaskan proses, estimasi harga, dan jadwal inspeksi sesuai kenyamananmu.
        </p>

        <a href="https://wa.me/6281234567890" target="_blank"
           class="btn btn-success btn-lg d-inline-flex align-items-center px-4">
          <i class="fab fa-whatsapp me-2"></i>Chat via WhatsApp
        </a>

        <div class="d-flex align-items-center gap-2 mt-3 text-muted small">
          <i class="fa-regular fa-clock"></i>
          <span>Respon cepat pada jam kerja</span>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ================== LANGKAH 2 ================== -->
<section class="section py-5">
  <div class="container">
    <div class="row align-items-center g-4">

      <!-- Teks kiri -->
      <div class="col-lg-6 order-lg-1 order-2">
        <span class="text-uppercase fw-semibold text-primary small">Langkah 2</span>
        <h2 class="fw-bold fs-3 mt-2 mb-3">Chat & Konsultasi</h2>

        <p class="text-muted">
          Setelah kamu menghubungi kami, tim akan melakukan pengecekan singkat
          melalui chat atau telepon.
        </p>

        <p class="text-muted mb-4">
          Kamu bisa menanyakan harga, proses administrasi, estimasi waktu jual,
          hingga tips agar mobilmu cepat terjual.
        </p>
      </div>

      <!-- Gambar kanan -->
      <div class="col-lg-6 order-lg-2 order-1 text-center">
        <img src="../assets/img/car-step2.jpg"
             class="img-fluid rounded-4 shadow-sm w-100"
             alt="Chat & Konsultasi">
      </div>

    </div>
  </div>
</section>


<!-- ================== LANGKAH 3 ================== -->
<section class="section py-5">
  <div class="container">
    <div class="row align-items-center g-4">

      <!-- Gambar kiri -->
      <div class="col-lg-6 order-lg-1 order-1 text-center">
        <img src="../assets/img/car-step3.jpg"
             class="img-fluid rounded-4 shadow-sm w-100"
             alt="Inspeksi & Deal">
      </div>

      <!-- Teks kanan -->
      <div class="col-lg-6 order-lg-2 order-2">
        <span class="text-uppercase fw-semibold text-primary small">Langkah 3</span>
        <h2 class="fw-bold fs-3 mt-2 mb-3">Inspeksi & Deal di Showroom</h2>

        <p class="text-muted">
          Kunjungi showroom untuk pengecekan kondisi mobil secara langsung oleh tim kami.
        </p>

        <p class="text-muted mb-0">
          Setelah inspeksi selesai, proses negosiasi & pembayaran bisa langsung diselesaikan
          secara aman dan transparan.
        </p>
      </div>

    </div>
  </div>
</section>


  </div>



  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Footer -->
  <script src="../assets/js/footer.js" defer></script>
  <script src="../assets/js/finance.js" defer></script>

</body>

</html>