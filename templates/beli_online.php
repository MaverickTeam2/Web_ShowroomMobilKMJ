<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Import Bulma CSS-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css"
    />
    <!--Import Font Awesome-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <!--Import Custom CSS-->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <!--Import Navbar Burger Script-->
    <script src="../assets/js/navbar_burger.js" defer></script>
    <!-- Favicon -->
    <link
      rel="icon"
      type="image/x-icon"
      href="../assets/img/Logo_KMJ_YB2.ico "
    />
    <title>KMJ</title>
  </head>
  <body>
    <!-- Navbar -->
    <?php include '../templates/navbar_footer/navbar.php'; ?>

    <!-- Container Hero Section-->
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

    <!-- Hero2, 1 Choose Online or on Dealer-->
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
            <div class="card" style="background-image: url('../assets/img/online-bg.jpg'); background-size: cover; background-position: center;">
              <div class="card-content has-text-centered" style="background: rgba(255,255,255,0.85); border-radius: 8px;">
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
            <div class="card" style="background-image: url('../assets/img/offline-bg.jpg'); background-size: cover; background-position: center;">
              <div class="card-content has-text-centered" style="background: rgba(255,255,255,0.85); border-radius: 8px;">
          <span class="icon is-large">
            <i class="fas fa-store fa-2x"></i>
          </span>
          <h3 class="title is-size-4">Buy at Dealer</h3>
          <p class="subtitle is-size-6">Visit our showroom and buy directly from our dealer.</p>
          <a href="https://maps.google.com/?q=Showroom+KMJ" target="_blank" class="button is-link is-fullwidth mt-3">
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
          <img src="https://hips.hearstapps.com/hmg-prod/images/koenigsegg-regera-mmp-1-1591115837.jpg?crop=0.779xw:0.660xh;0.0945xw,0.230xh&resize=1200:*" alt="Chat and Buy" style="width: 630px; max-width: auto;" />
        </figure>
        </div>
        <div class="column is-half">
        <h2 class="title is-size-3 has-text-black">3. Confirm your purchase and continou in our store</h2>
        </div>
      </div>
      </div>
    </section>


    <!-- Footer -->
    <script src="../assets/js/footer.js"></script>
  </body>
</html>
