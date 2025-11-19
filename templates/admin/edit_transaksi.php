<?php 
$title = "Edit Transaksi";

// Hanya layout (jika aman)
require_once 'partials/header.php';
require_once 'partials/sidebar.php';

// Wajib ada untuk API URL
require_once '../../include/header.php';   // ← kalau ini tidak include DB
require_once '../../db/config_api.php';    // ← WAJIB untuk BASE_API_URL
?>

<section id="content">
  <!-- NAVBAR -->
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <!-- MAIN -->
  <main id="main-content" class="p-4">
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Edit Transaksi</h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a href="transaksi.php">Transaksi</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Edit Transaksi</a></li>
        </ul>
      </div>
    </div>

    <!-- FORM TAMBAH TRANSAKSI -->
    <div class="content-area mt-4">
      <form class="tambah-transaksi-form">
        <div class="card p-3 mb-4 informasi-pembelian">
          <h5 class="section-title mb-3">Informasi Pembelian</h5>

          <div class="row align-items-start g-3">
            <div class="col-md-5">
              <div class="mb-3">
                <label class="form-label">Jenis Mobil</label>

                <select id="jenisMobil" class="form-select" required>
  <option value="" selected disabled>Pilih jenis mobil</option>
  <?php foreach ($mobilList as $m): ?>
    <option value="<?= htmlspecialchars($m['kode_mobil']) ?>">
      <?= htmlspecialchars($m['nama_mobil']) ?>
      <?= $m['tahun_mobil'] ? " (" . htmlspecialchars($m['tahun_mobil']) . ")" : "" ?>
    </option>
  <?php endforeach; ?>
</select>
              </div>

              <div class="mb-3">
                <label class="form-label">Tipe Mobil</label>
                <input id="tipeMobil" type="text" class="form-control" placeholder="-" readonly>
              </div>
            </div>

            <div class="col-md-7">
              <div id="mobilPreview" class="mobil-preview d-none">
                <div class="mobil-card">
                  <div class="mobil-image">
                    <img id="mobilImage" src="" alt="Foto Mobil">
                  </div>
                  <div class="mobil-info">
                    <h5 id="mobilNama">-</h5>
                    <p class="mobilHarga" id="mobilHarga">Rp -</p>
                    <p class="mobilDetail" id="mobilDetail">-</p>
                    <div class="mobilExtra">
                      <span id="mobilKm">- Km</span> · <span id="mobilTahun">-</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Data Pembeli dan Pembayaran -->
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card p-3 h-100">
              <h5 class="section-title mb-3">Data Pembeli</h5>
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input id="namaPembeli" type="text" class="form-control" placeholder="Masukkan nama pembeli">
              </div>
              <div class="mb-3">
                <label class="form-label">No HP</label>
                <input id="noHp" type="text" class="form-control" placeholder="Masukkan nomor HP">
              </div>
              <div class="d-flex gap-3 flex-wrap">
                <label><input type="checkbox"> KTP</label>
                <label><input type="checkbox" checked> KK</label>
                <label><input type="checkbox"> Rekening Tabungan</label>
              </div>
            </div>
          </div>

          <!-- Pembayaran -->
          <div class="col-md-6">
            <div class="card p-3 h-100">
              <h5 class="section-title mb-3">Pembayaran</h5>
              <div class="mb-3">
                <label class="form-label">Jenis Pembayaran</label>
                <select id="jenisPembayaran" class="form-select">
                  <option value="kredit" selected>Kredit</option>
                  <option value="tunai">Tunai</option>
                </select>
              </div>

              <div id="field-nama-kredit" class="mb-3">
                <label class="form-label">Nama Kredit</label>
                <input id="namaKredit" type="text" class="form-control" placeholder="Contoh: BRI Finance">
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Full Price</label>
                  <input id="fullPrice" type="text" class="form-control" disabled placeholder="Rp 0">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Deal Price</label>
                  <input id="dealPrice" type="text" class="form-control" placeholder="Rp 0">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea id="catatan" class="form-control" rows="2" placeholder="Tambahkan catatan jika ada..."></textarea>
              </div>
            </div>
          </div>
        </div>

                <!-- Status Transaksi -->
        <div class="row g-4 mt-3">
          <div class="col-12">
            <div class="card p-3">
              <h5 class="section-title mb-3">Status Transaksi</h5>
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select id="statusTransaksi" class="form-select">
                  <option value="pending" selected>Pending</option>
                  <option value="completed">Completed</option>
                  <option value="cancelled">Cancelled</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary" style="width: 910px;">Submit</button>
        </div>
      </form>
    </div> 
  </main>
</section> 

<script>const BASE_API_URL = "<?= BASE_API_URL ?>";</script>
<script src="../../assets/js/edit_transaksi.js"></script>

</body>
</html>
