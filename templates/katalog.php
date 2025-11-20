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
<html lang="id" data-theme="light">

<head>
  <meta charset="UTF-8">
  <title>KMJ</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/Logo_KMJ_YB2.ico ">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <!-- Import Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!--Import Font Awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!--Import Custom CSS-->
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="../assets/css/katalog2.css">
  <!-- Tambahkan Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <!-- icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">



</head>

<body>
  <!-- navbar -->
  <?php include '../templates/navbar_footer/navbar.php'; ?>

  <!-- Card Container -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Filter -->
      <aside class="col-12 col-md-4 col-lg-3 mb-3 order-0 order-md-0" id="sidebar-filter">
        <div class="card p-3 shadow-sm">
          <h5 class="filter-header d-flex justify-content-between align-items-center">
            <span>Filter & Urutkan</span>
            <div class="hapus">hapus filter</div>
          </h5>
          <p>Tambahkan filter untuk menyimpan pencarian Anda dan dapatkan pemberitahuan saat inventaris baru tiba.</p>
          <div class="button-simpan mb-3">
            <button type="button" class="btn btn-outline-secondary w-100">Simpan Pencarian</button>
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
                    <!-- radio button list tetap sama -->
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="bestMatch" value="best"
                        checked>
                      <label class="form-check-label" for="bestMatch" style="font-size: 20px;">Terbaik</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="nearestDistance"
                        value="nearest">
                      <label class="form-check-label" for="nearestDistance" style="font-size: 20px;">Jarak
                        terdekat</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="sortOption" id="lowestPrice"
                        value="lowestPrice">
                      <label class="form-check-label" for="lowestPrice" style="font-size: 20px;">Harga Terendah</label>
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
                        <input class="form-check-input" type="checkbox" value="<?= $jenis ?>"
                          id="<?= strtolower(str_replace(' ', '_', $jenis)) ?>">
                        <label class="form-check-label" for="<?= strtolower(str_replace(' ', '_', $jenis)) ?>"
                          style="font-size: 18px;">
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
      <main class="col-lg-9 col-md-8 col-12 order-1 order-md-1" id="catalog-content">
        <div class="totalMobil mb-4">
          <h5>Total <?= $jumlahMobil; ?> Mobil Tersedia</h5>
        </div>

        <section class="section">
          <div class="columns is-multiline is-justify-content-left">

            <?php foreach ($mobil as $m): ?>
              <div class="column">
                <div class="card car-card">
                  <div class="card-image">
                    <figure class="image image-wrapper">
                      <img src="<?= $m['gambar']; ?>" alt="<?= $m['nama']; ?>" class="img_main" />
                      <span class="icon-favorite"><i class="fa-solid fa-heart"></i></span>
                    </figure>
                  </div>

                  <div class="card-content">
                    <a href="../templates/detail_mobil.php" class="text-decoration-none mb-3 d-inline-block"><p class="title is-5"><?= $m['nama']; ?></p></a>
                    <p class="ansguran"><?= $m['harga']; ?> x <?= $m['totalKredit']; ?></p>
                    <p class="uang_dp"><?= $m['dp']; ?></p>
                    <hr>

                    <div class="info">
                      <img src="../assets/img/kecepatan.jpg" alt="">
                      <span style="font-size: 15px"><?= $m['kecepatan']; ?></span>
                      <img src="../assets/img/kalender.jpg" alt="">
                      <span style="font-size: 20px"><?= $m['tahun']; ?></span>
                    </div>

                    <div class="titik3 dropdown is-right is-hoverable">
                      <div class="dropdown-trigger">
                        <button class="button is-white btn-titik3" aria-haspopup="true" aria-controls="dropdown-menu">
                          <span class="icon is-small">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                          </span>
                        </button>
                      </div>
                      <div class="dropdown-menu" role="menu">
                        <div class="dropdown-content">
                          <a href="#" class="dropdown-item"><i class="fa-solid fa-trash"></i> Hapus dari favorit</a>
                          <a href="../templates/perbandingan.php" class="dropdown-item"><i class="fa-solid fa-shuffle me-2"></i> Bandingkan</a>
                          <a href="#" class="dropdown-item"><i class="fa-solid fa-share me-2"></i> Bagikan</a>
                          <a href="#" class="dropdown-item"><i class="fa-solid fa-car me-2"></i> Fitur & Spesifikasi</a>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </section>
      </main>


    </div>
  </div>
  <script>
  document.querySelectorAll('.icon-favorite').forEach(icon => {
    icon.addEventListener('click', () => {
      icon.classList.toggle('active');
    });
  });
</script>

  <!-- footer -->
  <script src="../assets/js/footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>