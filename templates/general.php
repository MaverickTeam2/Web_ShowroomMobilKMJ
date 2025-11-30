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
    <link rel="stylesheet" href="../assets/css/faq2.css?v=<?= time(); ?>" />
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
     <div class="faq-question">
  <h1 class="faq-contact-title is-5 m">Pertanyaan Umum seputar KMJ</h1>

  <div class="accordion" id="accordionGeneral">

    <!-- 1 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading1">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1"
          aria-expanded="true" aria-controls="q1">
          Apa itu KMJ dan layanan apa saja yang disediakan?
        </button>
      </h2>
      <div id="q1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          KMJ adalah showroom mobil yang menyediakan layanan jual beli mobil bekas berkualitas, pembiayaan kredit,
          inspeksi kendaraan, serta layanan purna jual untuk membantu pelanggan mendapatkan pengalaman membeli mobil
          yang aman dan nyaman.
        </div>
      </div>
    </div>

    <!-- 2 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading2">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2"
          aria-expanded="false" aria-controls="q2">
          Apakah mobil yang dijual di KMJ sudah melalui inspeksi?
        </button>
      </h2>
      <div id="q2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Ya. Semua mobil yang kami jual telah melalui proses inspeksi menyeluruh mulai dari mesin, eksterior,
          interior, hingga pengecekan riwayat dan kelengkapan dokumen.
        </div>
      </div>
    </div>

    <!-- 3 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading3">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3"
          aria-expanded="false" aria-controls="q3">
          Apakah KMJ menyediakan garansi mobil?
        </button>
      </h2>
      <div id="q3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Tentu. Setiap pembelian mobil di KMJ mendapatkan garansi mesin dengan masa garansi tertentu sesuai ketentuan
          showroom.
        </div>
      </div>
    </div>

    <!-- 4 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading4">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q4"
          aria-expanded="false" aria-controls="q4">
          Di mana lokasi showroom KMJ?
        </button>
      </h2>
      <div id="q4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Showroom kami berlokasi di <strong>Jl. Contoh Alamat KMJ No. 123</strong> (silakan sesuaikan dengan alamat
          resmi showroom kamu). Lokasi mudah dijangkau dan tersedia area parkir yang nyaman.
        </div>
      </div>
    </div>

    <!-- 5 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading5">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q5"
          aria-expanded="false" aria-controls="q5">
          Jam berapa showroom KMJ buka?
        </button>
      </h2>
      <div id="q5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Showroom KMJ buka setiap hari:
          <br>Senin – Sabtu : 08.00 – 18.00 WIB
          <br>Minggu &amp; Hari Libur : 09.00 – 16.00 WIB
        </div>
      </div>
    </div>

    <!-- 6 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading6">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q6"
          aria-expanded="false" aria-controls="q6">
          Apakah saya bisa test drive mobil yang ingin dibeli?
        </button>
      </h2>
      <div id="q6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Bisa. Pelanggan dapat melakukan test drive setelah melakukan janji terlebih dahulu dengan tim showroom agar
          mobil dapat disiapkan.
        </div>
      </div>
    </div>

    <!-- 7 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading7">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q7"
          aria-expanded="false" aria-controls="q7">
          Apakah harga mobil di website sudah final?
        </button>
      </h2>
      <div id="q7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Harga yang tertera di website adalah harga estimasi. Harga final dapat disesuaikan setelah inspeksi, kondisi
          mobil, dan negosiasi di showroom.
        </div>
      </div>
    </div>

    <!-- 8 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading8">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q8"
          aria-expanded="false" aria-controls="q8">
          Apakah KMJ menerima tukar tambah mobil?
        </button>
      </h2>
      <div id="q8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Ya, kami melayani tukar tambah. Pelanggan dapat membawa mobil lama untuk dinilai oleh tim appraisal KMJ
          secara transparan.
        </div>
      </div>
    </div>

    <!-- 9 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading9">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q9"
          aria-expanded="false" aria-controls="q9">
          Apa saya bisa membeli mobil secara kredit?
        </button>
      </h2>
      <div id="q9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Bisa. KMJ bekerja sama dengan berbagai lembaga pembiayaan untuk menyediakan cicilan yang fleksibel sesuai
          kebutuhan pelanggan.
        </div>
      </div>
    </div>

    <!-- 10 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading10">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q10"
          aria-expanded="false" aria-controls="q10">
          Bagaimana jika saya ingin bertanya atau konsultasi?
        </button>
      </h2>
      <div id="q10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Kamu dapat menghubungi kami melalui WhatsApp, telepon, atau media sosial resmi KMJ. Tim kami siap membantu
          menjawab semua pertanyaanmu.
        </div>
      </div>
    </div>

    <!-- 11 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading11">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q11"
          aria-expanded="false" aria-controls="q11">
          Apakah saya perlu datang ke showroom untuk melihat mobil?
        </button>
      </h2>
      <div id="q11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Tidak harus. Kamu bisa melihat detail mobil melalui website, chat dengan tim, dan melakukan konsultasi online
          sebelum datang ke showroom.
        </div>
      </div>
    </div>

    <!-- 12 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading12">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q12"
          aria-expanded="false" aria-controls="q12">
          Apakah KMJ menyediakan layanan antar mobil ke rumah?
        </button>
      </h2>
      <div id="q12" class="accordion-collapse collapse" aria-labelledby="heading12" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Ya, kami menyediakan layanan pengantaran mobil ke lokasi pembeli sesuai dengan kesepakatan saat transaksi.
        </div>
      </div>
    </div>

    <!-- 13 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading13">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q13"
          aria-expanded="false" aria-controls="q13">
          Apakah semua mobil di KMJ memiliki dokumen lengkap?
        </button>
      </h2>
      <div id="q13" class="accordion-collapse collapse" aria-labelledby="heading13" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Ya. Semua unit yang kami jual telah dipastikan memiliki dokumen lengkap seperti STNK, BPKB, dan riwayat
          servis yang jelas.
        </div>
      </div>
    </div>

    <!-- 14 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading14">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q14"
          aria-expanded="false" aria-controls="q14">
          Bagaimana jika saya tidak puas dengan kondisi mobil?
        </button>
      </h2>
      <div id="q14" class="accordion-collapse collapse" aria-labelledby="heading14" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Kami berkomitmen pada transparansi. Jika ada hal yang dirasa kurang sesuai, kamu dapat menghubungi tim KMJ
          untuk dibantu solusi terbaiknya.
        </div>
      </div>
    </div>

    <!-- 15 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading15">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q15"
          aria-expanded="false" aria-controls="q15">
          Apakah booking mobil bisa dilakukan secara online?
        </button>
      </h2>
      <div id="q15" class="accordion-collapse collapse" aria-labelledby="heading15" data-bs-parent="#accordionGeneral">
        <div class="accordion-body">
          Bisa. Kamu dapat memesan mobil melalui website atau WhatsApp dan membayar biaya booking untuk mengamankan
          unit yang kamu inginkan.
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
