<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <!-- Import Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!--Import Font Awesome-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Import Bulma CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!--Import Custom CSS-->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/faq.css" />
    <!--Import Navbar Burger Script-->
    <script src="../assets/js/navbar_burger.js" defer></script>
    <!-- font lato -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/Logo_KMJ_YB2.ico " />
    <title>KMJ</title>
  </head>

  <body>
    <!-- Navbar -->
    <?php include '../templates/navbar_footer/navbar.php'; ?>

    <section class="section">
      <div class="container">
        <div class="columns is-vcentered">
          <!-- Kiri -->
          <div class="column is-5">
            <h1 class="title">FAQ & <br />Support</h1>
          </div>

          <!-- Kanan -->
          <div class="column is-7 has-text-centered">
            <h4 class="has-text-weight-bold">Browse By Topic</h4>
            <div class="topic-buttons">
              <a href="../templates/general.php"><button class="button is-rounded">General</button></a> 
              <button class="button is-rounded">Pembelian Mobil Bekas</button>
              <button class="button is-rounded">Proses Kredit Mobil</button>
              <button class="button is-rounded">Pembayaran</button>
              <button class="button is-rounded">Pengiriman Mobil</button>
              <button class="button is-rounded">Layanan Purna Jual</button>
              <button class="button is-rounded">Garansi Mobil</button>
              <button class="button is-rounded">Dokumen & Administrasi</button>
              <button class="button is-rounded">sky</button>
              <button class="button is-rounded">Garansi & Lainnya</button>
              <button class="button is-rounded">Security</button>
              <button class="button is-rounded">Menjual Mobil</button>
              <button class="button is-rounded">Pembiayaan</button>
              <button class="button is-rounded">Melihat Mobil</button>
              <button class="button is-rounded">Security</button>
            </div>
          </div>
        </div>
      </div>

      <!-- halaman 2 -->
      <div class="faq-contact">
        <h1 class="faq-contact-title is-5 m">Hubungi kami melalui</h1>
        <div class="columns">
          <!-- Card 1 -->
          <div class="column is-one-quarter">
            <div class="card is-danger-border">
              <div class="card-content">
                <span class="icon">
                  <i class="fa-solid fa-comments"></i>
                </span>
                <p class="content">Ada pertanyaan? Tanyakan saja?. Anda dapat mengobrol dengan kami 24/7.</p>
                <a href="https://wa.me/6282334729001?text=Halo%20saya%20ingin%20bertanya" class="button is-rounded is-custom">chat with us</a>
              </div>
            </div>
          </div>
          <!-- Card 2 -->
          <div class="column is-one-quarter">
            <div class="card is-danger-border">
              <div class="card-content">
                <span class="icon"><i class="fa-solid fa-phone"></i> </span>
                <p class="content">Ingin berbicara dengan kami melalui?telepon?</p>
                <a href="tel:082334729001" class="button is-rounded is-custom">chat with us</a>
              </div>
            </div>
          </div>
          <!-- Card 3 -->
          <div class="column is-one-quarter">
            <div class="card is-danger-border">
              <div class="card-content">
                <p class="title is-5">Hubungi KMJ Auto Finance</p>
                <p class="content">
                  Untuk pertanyaan seputar akun CarMax Auto Finance Anda: <br />
                  Jam operasional: <br />
                  Senin—Jumat: 08.00—22.00 <br />
                  Sabtu: 09.00—18.00
                </p>
                <a href="tel:082334729001" class="button is-rounded is-custom2">
                  <span class="icon"><i class="fa-solid fa-comment"></i> </span>
                </a>
              </div>
            </div>
          </div>
          <!-- Card 4 -->
          <div class="column is-one-quarter">
            <div class="card is-danger-border">
              <div class="card-content">
                <p class="title is-5">Hubungi KMJ Auto Finance</p>
                <p class="content">Tim hubungan pelanggan kami juga dengan senang hati membantu melalui saluran sosial kami.</p>
                <a href="tel:082334729001">
                  <span class="icon1"><i class="fa-brands fa-whatsapp"></i> </span>
                </a>
                <a href="tel:082334729001">
                  <span class="icon1"><i class="fa-brands fa-instagram"></i></span>
                </a>
                <a href="tel:082334729001">
                  <span class="icon1"><i class="fa-brands fa-tiktok"></i></span>
                </a>
                <a href="tel:082334729001">
                  <span class="icon1"><i class="fa-brands fa-facebook-f"></i></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="faq-question">
        <h1 class="faq-contact-title is-5 m">Pertanyaan Lainya</h1>
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Apakah saya mendapatkan garansi jika membeli mobil bekas di sini</button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
              <div class="accordion-body">Tentu, kami memberikan garansi mesin untuk periode tertentu agar pembeli lebih tenang dan percaya dengan kualitas mobil yang kami tawarkan.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Apakah mobil bekas di showroom ini sudah diperiksa kondisinya
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">Ya, semua mobil bekas yang kami jual sudah melalui proses inspeksi menyeluruh mulai dari kondisi mesin, interior, eksterior, hingga kelengkapan dokumen.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Dimana alamat showroom KMJ ini</button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">Showroom kami berlokasi di Jl. Raya Soekarno-Hatta No. 123, Jakarta (contoh, bisa diganti sesuai alamat asli). Lokasi mudah dijangkau dan tersedia area parkir luas.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Jam berapa showroom buka?</button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Kami buka setiap hari:
                <br />
                Senin – Sabtu : 08.00 – 18.00 WIB
                <br />
                Minggu & Hari Libur : 09.00 – 16.00 WIB
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <script src="../assets/js/footer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
