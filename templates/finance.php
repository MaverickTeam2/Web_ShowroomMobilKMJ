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
</head>
<body>

<!-- navbar -->
 <?php include '../templates/navbar_footer/navbar.php'; ?>

<!-- Sub Navigation -->
<div class="container">
  <div class="tab-switch">
    <a href="#" id="tabHow" class="active">How it works</a>
    <a href="#" id="tabKalkulator">Kalkulator Pembayaran</a>
  </div>
</div>



<!-- ================= HOW IT WORKS SECTION ================= -->
<div id="howItWorks" class="tab-content active">

    <!-- Hero -->
    <section class="section">
        <div class="columns is-vcentered">
            <div class="column is-half">
                <h1 class="title"><?= $mobil['judul']; ?></h1>
                <button class="button is-warning"><?= $mobil['cta']; ?></button>
            </div>
            <div class="column is-half">
                <figure class="image-placeholder" style="background-image: url('../assets/img/mobilfinance.png');">
                </figure>
            </div>
        </div>
    </section>

    <!-- Finance Company -->
    <section class="section">
        <div class="box has-text-centered">
            <div class="columns is-multiline is-mobile is-centered">
                <?php foreach ($finance as $f): ?>
                    <div class="column is-2">
                        <figure class="image is-128x128"">
                            <img src="<?= $f['logo']; ?>" alt="<?= $f['nama']; ?>">
                        </figure>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Tips Kredit -->
    <section class="section">
        <h2 class="title is-4">Tips Kredit Kendaraan</h2>
        <div class="columns">
            <?php foreach ($tips as $t): ?>
                <div class="column is-one-third">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <img src="<?= $t['gambar']; ?>" alt="<?= $t['judul']; ?>">
                            </figure>
                        </div>
                        <div class="card-content">
                            <p class="title is-6"><?= $t['judul']; ?></p>
                            <p><?= $t['deskripsi']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- FAQ -->
  <div class="container my-5">
    <h2 class="fw-bold mb-4">Finance FAQs</h2>

    <div class="accordion custom-accordion" id="resourcesAccordion">

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#office">
            Corporate Home Office
          </button>
        </h2>
        <div id="office" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for Corporate Home Office.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#foundation">
            The KMJ Foundation
          </button>
        </h2>
        <div id="foundation" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for The KMJ Foundation.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#marketing">
            Marketing Vendoring Inquiries
          </button>
        </h2>
        <div id="marketing" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for Marketing Vendoring Inquiries.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#news">
            News Media Inquiries
          </button>
        </h2>
        <div id="news" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for News Media Inquiries.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#supplied">
            Supplied Inquiries
          </button>
        </h2>
        <div id="supplied" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for Supplied Inquiries.
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

  
<!-- ================= KALKULATOR PEMBAYARAN SECTION ================= -->
<div id="kalkulator" class="tab-content">
  <section class="section kalkulator-section">
    <h2 class="title is-4 has-text-centered mb-5">Pembayaran Bulanan</h2>
    <div class="columns">
      <!-- Form Input -->
      <div class="column is-half">
        <div class="box kalkulator-box">
          <div class="field">
            <label class="label">Harga Kendaraan</label>
            <input class="input" id="hargaKendaraan" type="number" placeholder="200000000">
          </div>
          <div class="field">
            <label class="label">Uang Muka</label>
            <input class="input" id="uangMuka" type="number" placeholder="10000000">
          </div>
          <div class="field">
            <label class="label">Nama Leasing</label>
            <input class="input" id="leasing" type="text" placeholder="Contoh: BCA Finance">
          </div>
          <div class="field">
            <label class="label">Bunga (%)</label>
            <input class="input" id="bunga" type="number" value="5">
          </div>
          <div class="field">
            <label class="label">Jangka Waktu (bulan)</label>
            <input class="input" id="lamaCicilan" type="number" value="72">
          </div>
          <button class="button is-warning mt-3" id="btnHitung">Hitung Estimasi</button>
        </div>
      </div>

      <!-- Summary -->
      <div class="column is-half">
        <div class="box summary-box text-center">
          <h3 class="fw-bold mb-4">Summary</h3>
          <div class="d-flex justify-content-between mb-2">
            <span>Harga Kendaraan</span> <span id="summaryHarga">Rp. 0</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span>Uang Muka</span> <span id="summaryDP">Rp. 0</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span>Nama Leasing</span> <span id="summaryLeasing">-</span>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <span>Total</span> <span id="summaryTotal">Rp. 0</span>
          </div>
          <hr>
          <h4 class="mt-3">Estimasi Pembayaran Bulanan</h4>
          <h2 class="fw-bold fs-2 text-primary" id="hasilPembayaran">Rp. 0</h2>
          <button class="button cari-btn is-warning mt-4" id="btnCari" disabled>Cari</button>
        </div>
      </div>
    </div>
  </section>

    <!-- === Section: Cara kerja pembayaran === -->
<section class="section cara-kerja-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="image-placeholder" style="background-image: url('../assets/img/bgfinance.jpg');">
        </div>
      </div>
      <div class="col-md-6">
        <h2 class="fw-bold">Bagaimana cara kerja pembayaran di KHM</h2>
        <p class="text-muted mb-3">
          Dapatkan pra-kualifikasi untuk mendapatkan gambaran tentang apa yang bisa Anda belanjakan.
        </p>
        <a href="#" class="btn-outline-blue">Dapatkan Informasi</a>
      </div>
    </div>
  </div>
</section>

<!-- === Section: Belanja Mobil dengan Harga Terbaik === -->
<section class="section harga-terbaik-section">
  <div class="container">
    <div class="row align-items-start">
      <div class="col-md-6">
        <h2 class="fw-bold text-dark-blue">Belanja Mobil<br>dengan Harga Terbaik!</h2>
      </div>
      <div class="col-md-6">
        <div class="list-harga">
          <a href="#" class="harga-item">Harga &lt; Rp. 200 Juta <i class="fa-solid fa-arrow-right"></i></a>
          <a href="#" class="harga-item">Harga &lt; Rp. 500 Juta <i class="fa-solid fa-arrow-right"></i></a>
          <a href="#" class="harga-item">Harga &lt; Rp. 700 Juta <i class="fa-solid fa-arrow-right"></i></a>
          <a href="#" class="harga-item">Harga &lt; Rp. 1 Miliar <i class="fa-solid fa-arrow-right"></i></a>
          <a href="#" class="harga-item">Harga &lt; Rp. 10 Miliar <i class="fa-solid fa-arrow-right"></i></a>
        </div>
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
