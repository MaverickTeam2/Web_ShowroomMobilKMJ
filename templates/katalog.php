<?php
// Contoh data mobil (ini bisa diganti query dari database MySQL)
$mobil = [
  [
    "nama" => "ABT XGT Audi R8 Street-Legal Race Car",
    "harga" => "Rp 799.000.000",
    "tahun" => "2021",
    "totalKredit" => "60",
    "dp" => "Rp. 60.000.000",
    "kecepatan" => "12.000 km",
    "gambar" => "../assets/img/1.jpg"
  ],
  [
    "nama" => "Porsche 911 GT3 RS Color Option",
    "harga" => "Rp 1.299.000.000",
    "tahun" => "2020",
    "totalKredit" => "48",
    "dp" => "Rp 37.000.000",
    "kecepatan" => "19.000 km",
    "gambar" => "../assets/img/2.jpg"
  ],
  [
    "nama" => "Buggati Tourbillon Widebody Kit",
    "harga" => "Rp 2.000.000.000",
    "tahun" => "2022",
    "totalKredit" => "60",
    "dp" => "Rp 98.000.000",
    "kecepatan" => "10.000 km",
    "gambar" => "../assets/img/3.jpg"
  ],
  [
    "nama" => "ABT XGT Audi R8 Street-Legal Race Car",
    "harga" => "Rp 799.000.000",
    "tahun" => "2021",
    "totalKredit" => "60",
    "dp" => "Rp. 60.000.000",
    "kecepatan" => "12.000 km",
    "gambar" => "../assets/img/4.jpg"
  ],
  [
    "nama" => "Porsche 911 GT3 RS Color Option",
    "harga" => "Rp 1.299.000.000",
    "tahun" => "2020",
    "totalKredit" => "48",
    "dp" => "Rp 37.000.000",
    "kecepatan" => "19.000 km",
    "gambar" => "../assets/img/5.jpg"
  ],
  [
    "nama" => "Buggati Tourbillon Widebody Kit",
    "harga" => "Rp 2.000.000.000",
    "tahun" => "2022",
    "totalKredit" => "60",
    "dp" => "Rp 98.000.000",
    "kecepatan" => "10.000 km",
    "gambar" => "../assets/img/6.jpg"
  ],
  [
    "nama" => "ABT XGT Audi R8 Street-Legal Race Car",
    "harga" => "Rp 799.000.000",
    "tahun" => "2021",
    "totalKredit" => "60",
    "dp" => "Rp. 60.000.000",
    "kecepatan" => "12.000 km",
    "gambar" => "../assets/img/7.jpg"
  ],
  [
    "nama" => "Porsche 911 GT3 RS Color Option",
    "harga" => "Rp 1.299.000.000",
    "tahun" => "2020",
    "totalKredit" => "48",
    "dp" => "Rp 37.000.000",
    "kecepatan" => "19.000 km",
    "gambar" => "../assets/img/8.jpg"
  ],
  [
    "nama" => "Buggati Tourbillon Widebody Kit",
    "harga" => "Rp 2.000.000.000",
    "tahun" => "2022",
    "totalKredit" => "60",
    "dp" => "Rp 98.000.000",
    "kecepatan" => "10.000 km",
    "gambar" => "../assets/img/9.jpg"
  ],
  [
    "nama" => "ABT XGT Audi R8 Street-Legal Race Car",
    "harga" => "Rp 799.000.000",
    "tahun" => "2021",
    "totalKredit" => "60",
    "dp" => "Rp. 60.000.000",
    "kecepatan" => "12.000 km",
    "gambar" => "../assets/img/10.jpg"
  ],
  [
    "nama" => "Porsche 911 GT3 RS Color Option",
    "harga" => "Rp 1.299.000.000",
    "tahun" => "2020",
    "totalKredit" => "48",
    "dp" => "Rp 37.000.000",
    "kecepatan" => "19.000 km",
    "gambar" => "../assets/img/11.jpg"
  ],
  [
    "nama" => "Buggati Tourbillon Widebody Kit",
    "harga" => "Rp 2.000.000.000",
    "tahun" => "2022",
    "totalKredit" => "60",
    "dp" => "Rp 98.000.000",
    "kecepatan" => "10.000 km",
    "gambar" => "../assets/img/12.jpg"
  ],
];
$jumlahMobil = count($mobil);
$bahanBakar = [
  "Diesel" => 660,
  "Electric" => 1897,
  "Gas" => 63367,
  "Hybrid" => 2915,
  "Plug-In Hybrid" => 1256
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>KMJ</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo_KMJ_YB2.ico ">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <!--Import Font Awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/katalog.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!--Import Custom CSS-->
  <link rel="stylesheet" href="../assets/css/style.css" />
  <!--Import Navbar Burger Script-->
  <script src="../assets/js/navbar_burger.js" defer></script>

</head>

<body>
  <!-- navbar -->
  <!-- Navbar -->
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href="../templates/index.html">
        <img src="../assets/img/Logo_KMJ_YB.png" alt="Showroom KMJ Logo" width="112" height="28" />
      </a>

      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>
    <!-- Navbar Menu -->
    <div id="navbarMenu" class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" href="../templates/catalog.html">Shop</a>
        <a class="navbar-item" href="../templates/jual_mobil.html">Jual Mobil</a>
        <a class="navbar-item" href="../templates/pembiayaan.html">Pembiayaan</a>
        <!--dropdown more-->
        <div class="navbar-item has-dropdown" id="moreDropdown">
          <a class="navbar-link">More</a>
          <div class="navbar-dropdown">
            <a class="navbar-item" href="../templates/FAQ&Support.html">FAQ & Support</a>
            <a class="navbar-item" href="../templates/about.html">About KMJ</a>
            <!--Move To Whatsapp CS-->
            <a class="navbar-item" href="https://wa.me/628123456789">Beli Online</a>
          </div>
        </div>
      </div>
      <!-- Right side Navbar-->
      <div class="navbar-end">
        <a class="navbar-item" href="https://maps.app.goo.gl/qGcSdiQD9ELbNJwv7">
          <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
          <span>Showroom KMJ</span>
        </a>
        <a class="navbar-item" href="favorite.html">
          <span class="icon"><i class="fa-solid fa-heart"></i></span>
          <span>Favorite</span>
        </a>
        <div class="navbar-item has-dropdown" id="accountDropdown">
          <a class="navbar-link">
            <span class="icon"><i class="fa-solid fa-user"></i></span>
            <span>Account</span>
          </a>
          <div class="navbar-dropdown is-right">
            <a class="navbar-item" href="../templates/login.html">Login</a>
            <a class="navbar-item" href="../templates/register.html">Register</a>
          </div>
        </div>
      </div>
  </nav>
  <!-- Search Bar -->
  <input class="input is-rounded my-4 mx-1" type="text" placeholder="Ingin Mencari Mobil Apa?" />

  <!-- end navbar -->

  <div class="container-fluid">
    <div class="row mt-3">
      <!-- Sidebar Filter -->
      <aside class="col-md-3">
        <div class="card p-3 shadow-sm">
          <h5 class="filter-header">
            <span>Filter & Urutkan</span>
            <div class="hapus">hapus filter</div>
          </h5>
          <p>Tambahkan filter untuk menyimpan pencarian Anda dan dapatkan pemberitahuan saat inventaris baru tiba.</p>
          <div class="button-simpan">
            <button type="button" class="btn btn-outline-secondary ">Simpan Pencarian</button>
          </div>
          <hr>
          <div class="accordion" id="accordionPanelsStayOpenExample">

            <!-- Item 1 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                  aria-expanded="true" aria-controls="collapseOne">
                  Urutkan Berdasarkan
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                <div class="accordion-body">
                  <strong>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="bestMatch" value="best"
                        checked>
                      <label class="form-check-label" for="bestMatch" style="font-size: 20px;">
                        Terbaik
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="nearestDistance"
                        value="nearest">
                      <label class="form-check-label" for="nearestDistance" style="font-size: 20px;">
                        Jarak terdekat
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="lowestPrice"
                        value="lowestPrice">
                      <label class="form-check-label" for="lowestPrice" style="font-size: 20px;">
                        Harga Terendah
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="nearestDistance"
                        value="nearest">
                      <label class="form-check-label" for="nearestDistance" style="font-size: 20px;">
                        Harga Tertinggi
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="lowestPrice"
                        value="lowestPrice">
                      <label class="form-check-label" for="lowestPrice" style="font-size: 20px;">
                        Jarak Tempuh Terendah
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="nearestDistance"
                        value="nearest">
                      <label class="form-check-label" for="nearestDistance" style="font-size: 20px;">
                        Jarak Tempuh tertinggi
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="lowestPrice"
                        value="lowestPrice">
                      <label class="form-check-label" for="lowestPrice" style="font-size: 20px;">
                        Tahun Terbaru
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="nearestDistance"
                        value="nearest">
                      <label class="form-check-label" for="nearestDistance" style="font-size: 20px;">
                        Tahun Tertua
                      </label>
                    </div>

                  </strong>
                </div>
              </div>
            </div>

            <!-- Item 2 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Harga
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                <div class="accordion-body">
                  <!-- Tabs Price -->
                  <div class="price-container">
                    <!-- Tabs -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="range-tab" data-bs-toggle="pill" data-bs-target="#range"
                          type="button" role="tab">Range</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="calculator-tab" data-bs-toggle="pill" data-bs-target="#calculator"
                          type="button" role="tab">Calculator</button>
                      </li>
                    </ul>

                    <!-- Content -->
                    <div class="tab-content" id="pills-tabContent">
                      <!-- Range -->
                      <div class="tab-pane fade show active" id="range" role="tabpanel">
                        <div class="mb-3">
                          <label for="minPrice" class="form-label">Min price</label>
                          <select id="minPrice" class="form-select">
                            <option>$7,000</option>
                            <option>$10,000</option>
                            <option>$15,000</option>
                          </select>
                        </div>
                        <div>
                          <label for="maxPrice" class="form-label">Max price</label>
                          <select id="maxPrice" class="form-select">
                            <option>$98,000+</option>
                            <option>$80,000</option>
                            <option>$60,000</option>
                          </select>
                          <br>
                        </div>
                        <div class="button-aturUlang">
                          <button type="button" class="btn btn-outline-secondary ">Simpan Pencarian</button>
                        </div>
                      </div>


                      <!-- Calculator -->
                      <div class="tab-pane fade" id="calculator" role="tabpanel">
                        <p class="text-muted">Calculator content goes here...</p>
                      </div>
                    </div>
                  </div>



                </div>
              </div>
            </div>

            <!-- Item 3 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Tahun
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                <div class="accordion-body">
                  <div class="mb-3">
                    <label for="fromYear" class="form-label">From</label>
                    <input class="form-control" list="fromYearOptions" id="fromYear"
                      placeholder="Ketik atau pilih tahun...">
                    <datalist id="fromYearOptions">
                      <?php
                      $currentYear = date("Y");
                      for ($year = 2000; $year <= $currentYear; $year++) {
                        echo "<option value='$year'>";
                      }
                      ?>
                    </datalist>
                  </div>

                  <div class="mb-3">
                    <label for="toYear" class="form-label">To</label>
                    <input class="form-control" list="toYearOptions" id="toYear"
                      placeholder="Ketik atau pilih tahun...">
                    <datalist id="toYearOptions">
                      <?php
                      $currentYear = date("Y");
                      for ($year = 2000; $year <= $currentYear; $year++) {
                        echo "<option value='$year'>";
                      }
                      ?>
                    </datalist>
                  </div>
                  <div class="button-aturUlang">
                    <button type="button" class="btn btn-outline-secondary ">Simpan Pencarian</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Item 4 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Jarak tempuh
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour">
                <div class="accordion-body">
                  <div class="tab-pane fade show active" id="range" role="tabpanel">
                    <div class="mb-3">
                      <label for="mileage" class="form-label">Jarak Tempuh (Km)</label>
                      <input class="form-control" list="mileageOptions" id="mileage"
                        placeholder="Ketik atau pilih jarak...">
                      <datalist id="mileageOptions">
                        <?php
                        for ($km = 0; $km <= 200000; $km += 5000) {
                          echo "<option value='" . number_format($km, 0, ',', '.') . " km'>";
                        }
                        ?>
                      </datalist>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <!-- Item 5 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  Jenis bahan bakar
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive">
                <div class="accordion-body">
                  <div class="fuel-filter">
  <?php foreach ($bahanBakar as $jenis => $jumlah): ?>
    <div class="form-check mb-2">
      <input class="form-check-input" type="checkbox" value="<?= $jenis ?>" id="<?= strtolower(str_replace(' ', '_', $jenis)) ?>">
      <label class="form-check-label" for="<?= strtolower(str_replace(' ', '_', $jenis)) ?>" style="font-size: 18px;">
        <?= $jenis ?> (<?= number_format($jumlah, 0, ',', '.') ?>)
      </label>
    </div>
  <?php endforeach; ?>
</div>
                </div>
              </div>
            </div>

            <!-- Item 6 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                  Body Type
                </button>
              </h2>
              <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix">
                <div class="accordion-body">
                  <strong>Isi item 6.</strong>
                </div>
              </div>
            </div>

            <!-- Item 7 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSeven">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                  Tipe
                </button>
              </h2>
              <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven">
                <div class="accordion-body">
                  <strong>Isi item 7.</strong>
                </div>
              </div>
            </div>

            <!-- Item 8 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingEight">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                  Sistem Penggerak
                </button>
              </h2>
              <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight">
                <div class="accordion-body">
                  <strong>Isi item 8.</strong>
                </div>
              </div>
            </div>

            <!-- Item 9 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingNine">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                  Transmision
                </button>
              </h2>
              <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine">
                <div class="accordion-body">
                  <strong>Isi item 9.</strong>
                </div>
              </div>
            </div>

          </div>

        </div>
      </aside>


      <!-- Konten Daftar Mobil -->
      <main class="col-md-9">
        <div class="totalMobil">
          <h5>Total <?= $jumlahMobil; ?> Mobil Tersedia</h5>
        </div>
        <div class="row">

          <?php foreach ($mobil as $m): ?>
            <div class="col-md-4 mb-4">
              <div class="card shadow-sm h-100 position-relative">
                <!-- Gambar mobil -->
                <img src="<?= $m['gambar']; ?>" class="card-img-top" alt="<?= $m['nama']; ?>">
                <!-- Tombol favorite -->
                <button class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm">
                  <img src="../assets/img/love.jpg" alt="" style="width:24px; height:24px;">
                  <i class="bi bi-heart"></i>
                </button>
                <div class="titik3"><!-- Tombol titik tiga -->
                  <div class="dropdown position-absolute bottom-0 end-0 m-2">
                    <button class="btn btn-light rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <img src="../assets/img/titik3.jpg" alt="" style="width:24px; height:24px;">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li><a class="dropdown-item" href="#"><i class="bi bi-heart me-2"></i> Tambahkan ke favorit</a></li>
                      <li><a class="dropdown-item" href="#"><i class="bi bi-shuffle me-2"></i> Bandingkan</a></li>
                      <li><a class="dropdown-item" href="#"><i class="bi bi-share me-2"></i> Bagikan</a></li>
                      <li><a class="dropdown-item" href="#"><i class="bi bi-car-front me-2"></i> Fitur & Spesifikasi</a>
                      </li>
                    </ul>
                  </div>
                </div>


                <!-- Body card -->
                <div class="card-body">
                  <h4>
                    <a href="" style="text-decoration: none; color: inherit;">
                      <?= $m['nama']; ?>
                    </a>
                  </h4>
                  <h3><?= $m['harga']; ?> X <?= $m['totalKredit']; ?></h3>
                  <h5> Dp <?= $m['dp']; ?></h5>
                  <hr class="hr-custom">
                  <div class="info">
                    <img src="../assets/img/kecepatan.jpg" alt="">
                    <span style="font-size: 25px"><?= $m['kecepatan']; ?></span>
                    <img src="../assets/img/kalender.jpg" alt="">
                    <span style="font-size: 25px"><?= $m['tahun']; ?></span>

                  </div>

                </div>
              </div>
            </div>
          <?php endforeach; ?>

        </div>
      </main>
    </div>
  </div>
  <!-- footer -->
  <footer class="footer has-background-light">
    <div class="container">
      <div class="columns">
        <!-- Logo & Sosmed -->
        <div class="column is-one-quarter">
          <figure class="image is-128x128 mb-3">
            <img src="../assets/img/Logo_KMJ_YB.png" alt="KMJ Logo" />
          </figure>
          <p>
            <a href="https://wa.me/628123456789"><i class="fab fa-whatsapp fa-lg mx-1 whatsapp-icon"></i></a>
            <a href="https://facebook.com"><i class="fab fa-facebook fa-lg mx-1 facebook-icon"></i></a>
            <a href="https://instagram.com"><i class="fab fa-instagram fa-lg mx-1 instagram-icon"></i></a>
            <a href="https://tiktok.com"><i class="fab fa-tiktok fa-lg mx-1 tiktok-icon"></i></a>
            <a href="https://youtube.com"><i class="fab fa-youtube fa-lg mx-1 youtube-icon"></i></a>
          </p>
        </div>

        <!-- Shop -->
        <div class="column">
          <p class="title is-6">Shop</p>
          <ul>
            <li><a href="#" class="has-text-black">Kategori</a></li>
            <li>
              <a href="../templates/catalog.html" class="has-text-black">Semua produk</a>
            </li>
          </ul>
        </div>

        <!-- Sell -->
        <div class="column">
          <p class="title is-6">Sell</p>
          <ul>
            <li>
              <a href="#" class="has-text-black">Bagaimana cara kerjanya?</a>
            </li>
          </ul>
        </div>

        <!-- Finance -->
        <div class="column">
          <p class="title is-6">Finance</p>
          <ul>
            <li>
              <a href="#" class="has-text-black">Kalkulator Pembayaran</a>
            </li>
            <li><a href="#" class="has-text-black">Tutorial</a></li>
          </ul>
        </div>

        <!-- About -->
        <div class="column">
          <p class="title is-6">About</p>
          <ul>
            <li>
              <a href="https://wa.me/628123456789" class="has-text-black">Contact us</a>
            </li>
            <li>
              <a href="../templates/about.html" class="has-text-black">About KMJ</a>
            </li>
            <li><a href="#" class="has-text-black">Media Center</a></li>
          </ul>
        </div>
      </div>

      <!-- Copyright -->
      <div class="content has-text-centered mt-6">
        <p>
          Dengan menggunakan <strong>kmj.com</strong>, Anda menyetujui
          pemantauan dan penyimpanan interaksi Anda dengan situs web, termasuk
          vendor KMJ.
          <br />
          <a href="#">Kebijakan Privasi</a> kami untuk detail selengkapnya.
        </p>
      </div>
    </div>
  </footer>
  <!-- end footer -->
</body>

</html>