<?php include '../templates/navbar_footer/navbar.php'; ?>

<?php
// ambil ID / nama mobil dari query string (nanti backend/API bisa pakai ini)
$car1Name = isset($_GET['car1_name']) ? $_GET['car1_name'] : 'Koenigsegg Regera';
$car2Name = isset($_GET['car2_name']) ? $_GET['car2_name'] : 'Pagani Huayra';
$car1Img  = isset($_GET['car1_img'])  ? $_GET['car1_img']  : 'https://hips.hearstapps.com/hmg-prod/images/koenigsegg-regera-mmp-1-1591115837.jpg?crop=0.779xw:0.660xh;0.0945xw,0.230xh&resize=1200:*';
$car2Img  = isset($_GET['car2_img'])  ? $_GET['car2_img']  : 'https://www.topgear.com/sites/default/files/cars-car/image/2016/08/rh_huayrabc-67.jpg';
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/perbandingan.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />
  <title>Perbandingan Mobil</title>
</head>
<body>
<section class="section">
  <div class="container">

    <!-- HEADER -->
    <div class="columns is-vcentered mb-5">
      <div class="column">
        <h1 class="title is-4">Perbandingan Mobil</h1>
        <p class="subtitle is-6">Bandingkan fitur dan spesifikasi 2 mobil sekaligus.</p>
      </div>
    </div>

    <!-- KARTU MOBIL DI ATAS -->
    <div class="columns is-variable is-6 is-multiline has-text-centered">
      <div class="column is-half">
        <div class="card compare-card">
          <div class="card-image">
            <figure class="image">
              <img src="<?php echo htmlspecialchars($car1Img); ?>" alt="<?php echo htmlspecialchars($car1Name); ?>">
            </figure>
          </div>
          <div class="card-content">
            <p class="title is-5"><?php echo htmlspecialchars($car1Name); ?></p>
            <button class="button is-info is-rounded is-small">Ubah</button>
          </div>
        </div>
      </div>
      <div class="column is-half">
        <div class="card compare-card">
          <div class="card-image">
            <figure class="image">
              <img src="<?php echo htmlspecialchars($car2Img); ?>" alt="<?php echo htmlspecialchars($car2Name); ?>">
            </figure>
          </div>
          <div class="card-content">
            <p class="title is-5"><?php echo htmlspecialchars($car2Name); ?></p>
            <button class="button is-danger is-rounded is-small">Ubah</button>
          </div>
        </div>
      </div>
    </div>

    <!-- TAB -->
    <div class="tabs is-centered is-boxed mt-5" id="comparisonTabs">
      <ul>
        <li class="is-active" data-tab="highlight"><a>Highlight</a></li>
        <li data-tab="kesamaan"><a>Kesamaan</a></li>
        <li data-tab="perbedaan"><a>Perbedaan</a></li>
        <li data-tab="spesifikasi"><a>Spesifikasi</a></li>
      </ul>
    </div>

    <!-- ===== HIGHLIGHT ===== -->
    <div class="comparison-section" id="tab-highlight">
      <h2 class="title is-5 mt-4">Highlight</h2>
      <table class="table is-bordered is-fullwidth">
        <thead>
          <tr>
            <th></th>
            <th><?php echo htmlspecialchars($car1Name); ?></th>
            <th><?php echo htmlspecialchars($car2Name); ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Wishlist</th>
            <td>10 disukai</td>
            <td>14 disukai</td>
          </tr>
          <tr>
            <th>Harga</th>
            <td>Rp 6.089.000 × 60</td>
            <td>Rp 6.089.000 × 60</td>
          </tr>
          <tr>
            <th>Jarak Tempuh</th>
            <td>N/A</td>
            <td>N/A</td>
          </tr>
          <tr>
            <th>Kendaraan Sebelumnya</th>
            <td>Kendaraan sewa</td>
            <td>Tidak ada</td>
          </tr>
          <tr>
            <th>Warna</th>
            <td>Putih, Silver</td>
            <td>Hitam, Merah</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ===== KESAMAAN ===== -->
        <!-- ===== KESAMAAN ===== -->
    <div class="comparison-section is-hidden" id="tab-kesamaan">
      <h2 class="title is-5 mt-4">Kesamaan</h2>

      <div class="compare-feature-group">

        <!-- ABS -->
        <div class="compare-feature-row">
          <div class="compare-feature-name">ABS Brakes</div>
          <div class="compare-feature-values">
            <div class="compare-feature-box">
              <span class="compare-feature-check">✓</span>
              <span>Yes</span>
            </div>
            <div class="compare-feature-box">
              <span class="compare-feature-check">✓</span>
              <span>Yes</span>
            </div>
          </div>
        </div>

        <!-- AM/FM Stereo -->
        <div class="compare-feature-row">
          <div class="compare-feature-name">AM/FM Stereo</div>
          <div class="compare-feature-values">
            <div class="compare-feature-box">
              <span class="compare-feature-check">✓</span>
              <span>Yes</span>
            </div>
            <div class="compare-feature-box">
              <span class="compare-feature-check">✓</span>
              <span>Yes</span>
            </div>
          </div>
        </div>

        <!-- Air Conditioning -->
        <div class="compare-feature-row">
          <div class="compare-feature-name">Air Conditioning</div>
          <div class="compare-feature-values">
            <div class="compare-feature-box">
              <span class="compare-feature-check">✓</span>
              <span>Yes</span>
            </div>
            <div class="compare-feature-box">
              <span class="compare-feature-check">✓</span>
              <span>Yes</span>
            </div>
          </div>
        </div>

      </div>
    </div>


    <!-- ===== PERBEDAAN ===== -->
    <div class="comparison-section is-hidden" id="tab-perbedaan">
      <h2 class="title is-5 mt-4">Perbedaan</h2>
      <table class="table is-bordered is-fullwidth">
        <thead>
          <tr>
            <th>Fitur</th>
            <th><?php echo htmlspecialchars($car1Name); ?></th>
            <th><?php echo htmlspecialchars($car2Name); ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Power Window</th>
            <td>✗ Tidak</td>
            <td>✔ Ya</td>
          </tr>
          <tr>
            <th>Power Mirror</th>
            <td>✗ Tidak</td>
            <td>✔ Ya</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ===== SPESIFIKASI ===== -->
    <div class="comparison-section is-hidden" id="tab-spesifikasi">
      <h2 class="title is-5 mt-4">Spesifikasi</h2>
      <table class="table is-bordered is-fullwidth">
        <thead>
          <tr>
            <th>Detail</th>
            <th><?php echo htmlspecialchars($car1Name); ?></th>
            <th><?php echo htmlspecialchars($car2Name); ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Body</th>
            <td>Extended Cab</td>
            <td>Sedan</td>
          </tr>
          <tr>
            <th>Transmisi</th>
            <td>Automatic</td>
            <td>Automatic</td>
          </tr>
          <tr>
            <th>Mesin</th>
            <td>2.5 Liter</td>
            <td>2.0 Liter</td>
          </tr>
          <tr>
            <th>Bahan Bakar</th>
            <td>Bensin</td>
            <td>Bensin</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</section>

<!-- Tombol back to top -->
<div style="display:flex;justify-content:center;align-items:center;opacity:85%;">
  <button id="backToTop" class="button is-link is-small"
          style="position:fixed;bottom:30px;left:50%;transform:translateX(-50%);display:none;z-index:1000;">
    Back to Top
  </button>
</div>

<script src="../assets/js/perbandingan.js"></script>
<script src="../assets/js/footer.js"></script>
</body>
</html>
