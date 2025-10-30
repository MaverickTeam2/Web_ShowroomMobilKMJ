<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Import Bulma-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css"
    />
    <!--Import Font Awesome-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <!--import css Perbandingan-->
    <link rel="stylesheet" href="../assets/css/perbandingan.css" />
    <!--Import Custom CSS-->
    <link rel="stylesheet" href="../assets/css/style.css" />

    <title>Perbandingan Mobil</title>
  </head>
  <body>
    <section class="section">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-half has-text-centered">
            <h1 class="title is-4">Perbandingan Mobil</h1>
          </div>
        </div>

        <div class="columns is-variable is-6 is-multiline has-text-centered">
          <div class="column is-half">
            <div class="card" style="max-width: 480px; margin: 0 auto">
              <div class="card-image">
                <figure class="image" style="margin: 0">
                  <img
                    src="https://hips.hearstapps.com/hmg-prod/images/koenigsegg-regera-mmp-1-1591115837.jpg?crop=0.779xw:0.660xh;0.0945xw,0.230xh&resize=1200:*"
                    alt="Koenigsegg Regera"
                    style="
                      width: 100%;
                      height: auto;
                      border: none;
                      box-shadow: none;
                    "
                  />
                </figure>
              </div>
              <div class="card-content" style="padding-top: 1rem">
                <p class="title is-5 mt-3">Koenigsegg Regera</p>
                <button
                  class="button is-info is-rounded mt-3"
                  style="
                    background: linear-gradient(
                      90deg,
                      #00c6ff 0%,
                      #0072ff 100%
                    );
                    color: #fff;
                    border: none;
                  "
                >
                  Ubah
                </button>
              </div>
            </div>
          </div>
          <div class="column is-half">
            <div class="card" style="max-width: 480px; margin: 0 auto">
              <div class="card-image">
                <figure class="image" style="margin: 0">
                  <img
                    src="https://www.topgear.com/sites/default/files/cars-car/image/2016/08/rh_huayrabc-67.jpg"
                    alt="Pagani Huayra"
                    style="
                      width: 100%;
                      height: auto;
                      border: none;
                      box-shadow: none;
                    "
                  />
                </figure>
              </div>
              <div class="card-content" style="padding-top: 1rem">
                <p class="title is-5 mt-3">Pagani Huayra</p>
                <button
                  class="button is-danger is-rounded mt-3"
                  style="
                    background: linear-gradient(
                      90deg,
                      #ff512f 0%,
                      #dd2476 100%
                    );
                    color: #fff;
                    border: none;
                  "
                >
                  Ubah
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="has-text-centered mt-5">
          <button class="button is-link is-rounded" id="comparePhotosBtn">
            Bandingkan Foto
          </button>
        </div>

        <div class="tabs is-centered is-boxed mt-5" id="comparisonTabs">
          <ul>
            <li><a href="#highlight">Highlight</a></li>
            <li><a href="#kesamaan">Kesamaan</a></li>
            <li><a href="#perbedaan">Perbedaan</a></li>
            <li><a href="#spesifikasi">Spesifikasi</a></li>
          </ul>
        </div>

        <!-- Highlight -->
        <h2 class="title is-5 mt-6" id="highlight">Highlight</h2>

        <h3 class="subtitle is-6">Favorit</h3>
        <table class="table is-bordered">
          <tr>
            <td>10 disukai</td>
            <td>14 disukai</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Harga</h3>
        <table class="table is-bordered">
          <tr>
            <td>Rp 6.089.000 × 60</td>
            <td>Rp 6.089.000 × 60</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Jarak Tempuh</h3>
        <table class="table is-bordered">
          <tr>
            <td>N/A</td>
            <td>N/A</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Kendaraan Sebelumnya</h3>
        <table class="table is-bordered">
          <tr>
            <td>Kendaraan sewa</td>
            <td>Tidak ada</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Warna</h3>
        <table class="table is-bordered">
          <tr>
            <td>Putih, Silver</td>
            <td>Hitam, Merah</td>
          </tr>
        </table>

        <!-- Kesamaan -->
        <h2 class="title is-5 mt-6" id="kesamaan">Kesamaan</h2>
        <h3 class="subtitle is-6">ABS</h3>
        <table class="table is-bordered">
          <tr>
            <td>✔ Ya</td>
            <td>✔ Ya</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Bluetooth</h3>
        <table class="table is-bordered">
          <tr>
            <td>✔ Ya</td>
            <td>✔ Ya</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Rear Camera</h3>
        <table class="table is-bordered">
          <tr>
            <td>✔ Ya</td>
            <td>✔ Ya</td>
          </tr>
        </table>

        <!-- Perbedaan -->
        <h2 class="title is-5 mt-6" id="perbedaan">Perbedaan</h2>
        <h3 class="subtitle is-6">Power Window</h3>
        <table class="table is-bordered">
          <tr>
            <td>✗ Tidak</td>
            <td>✔ Ya</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Power Mirror</h3>
        <table class="table is-bordered">
          <tr>
            <td>✗ Tidak</td>
            <td>✔ Ya</td>
          </tr>
        </table>

        <!-- Spesifikasi -->
        <h2 class="title is-5 mt-6" id="spesifikasi">Spesifikasi</h2>
        <h3 class="subtitle is-6">Body</h3>
        <table class="table is-bordered">
          <tr>
            <td>Extended Cab</td>
            <td>Sedan</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Transmisi</h3>
        <table class="table is-bordered">
          <tr>
            <td>Automatic</td>
            <td>Automatic</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Mesin</h3>
        <table class="table is-bordered">
          <tr>
            <td>2.5 Liter</td>
            <td>2.0 Liter</td>
          </tr>
        </table>

        <h3 class="subtitle is-6">Bahan Bakar</h3>
        <table class="table is-bordered">
          <tr>
            <td>Bensin</td>
            <td>Bensin</td>
          </tr>
        </table>
      </div>
    </section>
    <div
      style="
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 85%;
      "
    >
      <button
        id="backToTop"
        class="button is-link is-small"
        style="
          position: fixed;
          bottom: 30px;
          left: 50%;
          transform: translateX(-50%);
          display: none;
          z-index: 1000;
        "
      >
        Back to Top
      </button>
    </div>
    <!--Import perbandingan JS-->
    <script src="../assets/js/perbandingan.js"></script>

    <!--Import Footer-->
    <script src="../assets/js/footer.js"></script>
  </body>
</html>
