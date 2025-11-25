<?php
// Cek apakah file ini dibuka langsung di browser (bukan via fetch)
$is_direct = (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__));

if ($is_direct) {
  $title = 'tambah_stok_mobil';
}

if ($is_direct) {
  include '../../db/config_api.php';   // ← penting
  include '../../include/header.php';  // ← buat BASE_API_URL & IMAGE_URL di JS
  include 'partials/header.php';
  include 'partials/sidebar.php';
  echo '<section id="content"><nav><i class="bx bx-menu"></i></nav><main id="main-content" class="p-4">';
} else {
  // kalau dimuat via fetch dari manajemen_mobil.php
  include '../../db/koneksi.php';
  include '../../db/config_api.php';   // ← supaya IMAGE_URL bisa dipakai
}

$kodeEdit = $_GET['kode'] ?? null;
$isEdit = !empty($kodeEdit);

if ($isEdit) {


  require_once '../../db/api_client.php';
  $data = api_get("admin/web_mobil_detail.php?kode_mobil=$kodeEdit");

  if (!$data['success']) {
    die("Gagal mengambil data dari API");
  }

  // isi data
  $mobilData = $data['mobil'];
  $mobilFitur = $data['fitur'];
  $mobilFoto = $data['foto'];
}



?>
<link rel="stylesheet" href="../../assets/css/admin/tambah_stok_mobil.css">


<!-- ======================== KONTEN HALAMAN ======================== -->
<div class="head-title d-flex justify-content-between align-items-center">
  <div class="left">
    <h1>Tambah Stok Mobil</h1>
    <ul class="breadcrumb" data-fixed="true">
      <li><a href="manajemen_mobil.php" data-page="manajemen_mobil.php">Manajemen Mobil</a></li>
      <li><i class='bx bx-chevron-right'></i></li>
      <li><a class="active" href="#">Tambah Stok Mobil</a></li>
    </ul>
  </div>
</div>
<form id="formMobil" class="form-no-border" method="POST" enctype="multipart/form-data">

  <input type="hidden" name="kode_user" value="US001">
  <?php if ($isEdit): ?>
    <input type="hidden" name="update" value="1">
    <input type="hidden" name="kode_mobil" value="<?= htmlspecialchars($kodeEdit) ?>">
  <?php endif; ?>

  <!-- ================= FOTO MOBIL ================= -->
  <div class="card p-4 shadow-sm mb-4">
    <h5 class="section-title mb-3">Foto Mobil</h5>

    <div class="row g-3">
      <!-- 360 View -->
      <div class="col-md-3">
        <label class="foto-dropzone w-100 text-center">
          <span class="dz-title">360° View</span>
          <span class="dz-sub">Click to Upload</span>
          <div class="dz-preview-img"></div> <!-- wadah preview -->
          <input type="file" name="foto_360" accept="image/*" hidden>
        </label>
      </div>

      <!-- Tampilan Depan -->
      <div class="col-md-3">
        <label class="foto-dropzone w-100 text-center">
          <span class="dz-title">Tampilan Depan</span>
          <span class="dz-sub">Click to Upload</span>
          <div class="dz-preview-img"></div>
          <input type="file" name="foto_depan" accept="image/*" hidden>
        </label>
      </div>

      <!-- Tampilan Belakang -->
      <div class="col-md-3">
        <label class="foto-dropzone w-100 text-center">
          <span class="dz-title">Tampilan Belakang</span>
          <span class="dz-sub">Click to Upload</span>
          <div class="dz-preview-img"></div>
          <input type="file" name="foto_belakang" accept="image/*" hidden>
        </label>
      </div>

      <!-- Tampilan Samping -->
      <div class="col-md-3">
        <label class="foto-dropzone w-100 text-center">
          <span class="dz-title">Tampilan Samping</span>
          <span class="dz-sub">Click to Upload</span>
          <div class="dz-preview-img"></div>
          <input type="file" name="foto_samping" accept="image/*" hidden>
        </label>
      </div>
    </div>

    <!-- Foto Tambahan -->
    <div class="mt-4">
      <h6>Foto Tambahan</h6>
      <label class="foto-dropzone foto-tambahan w-100 text-center">
        <span class="dz-title">+ Add Photo</span>
        <span class="dz-sub">Bisa pilih lebih dari satu</span>
        <div class="dz-preview-img"></div>
        <input type="file" name="foto_tambahan[]" accept="image/*" multiple hidden>
      </label>
    </div>
  </div>

  <!-- ================= Informasi Mobil ================= -->
  <div class="card p-4 shadow-sm mb-4">
    <h5 class="section-title mb-3">Informasi Mobil</h5>

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nama Mobil *</label>
        <input type="text" class="form-control" name="nama_mobil" required placeholder="Masukkan nama mobil"
          value="<?= $isEdit ? htmlspecialchars($mobilData['nama_mobil']) : '' ?>">
      </div>

      <!-- Tahun -->
      <div class="col-md-3">
        <label class="form-label">Tahun *</label>
        <div class="year-picker" style="position:relative;">
          <div class="input-group">
            <input type="text" class="form-control" name="tahun" id="tahunInput" placeholder="YYYY" required readonly
              value="<?= $isEdit ? htmlspecialchars($mobilData['tahun_mobil']) : '' ?>">
            <button type="button" class="btn btn-outline-secondary" id="ypToggle">▾</button>
          </div>

          <div class="yp-panel shadow" id="ypPanel" hidden>
            <div class="yp-header d-flex justify-content-between align-items-center px-2 py-1">
              <button type="button" class="btn btn-sm btn-light" id="ypPrev">&laquo;</button>
              <span class="fw-semibold" id="ypRange">—</span>
              <button type="button" class="btn btn-sm btn-light" id="ypNext">&raquo;</button>
            </div>
            <div class="yp-grid p-2" id="ypGrid"></div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <label class="form-label">Jarak Tempuh *</label>
        <div class="input-group">
          <input type="number" class="form-control no-spin" placeholder="0" name="jarak_tempuh" id="jarak_tempuh"
            required value="<?= $isEdit ? htmlspecialchars($mobilData['jarak_tempuh']) : '' ?>">
          <span class="input-group-text">KM</span>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">Full Prize *</label>
        <div class="input-group">
          <input type="number" class="form-control no-spin" placeholder="0" name="full_prize" id="full_prize" required
            value="<?= $isEdit ? htmlspecialchars($mobilData['full_prize']) : '' ?>">
        </div>
      </div>


      <div class="col-md-6">
        <label class="form-label">Tipe Kendaraan *</label>
        <select class="form-select" name="tipe_kendaraan" required>
          <option value="">Pilih tipe Kendaraan</option>
          <option value="SUV" <?= $isEdit && $mobilData['jenis_kendaraan'] === 'SUV' ? 'selected' : '' ?>>SUV</option>
          <option value="MPV" <?= $isEdit && $mobilData['jenis_kendaraan'] === 'MPV' ? 'selected' : '' ?>>MPV</option>
          <option value="Sedan" <?= $isEdit && $mobilData['jenis_kendaraan'] === 'Sedan' ? 'selected' : '' ?>>Sedan
          </option>
          <option value="Sport" <?= $isEdit && $mobilData['jenis_kendaraan'] === 'Sport' ? 'selected' : '' ?>>Sport
          </option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Jenis Bahan Bakar *</label>
        <select class="form-select" name="bahan_bakar" required>
          <option value="">Pilih Jenis bahan bakar</option>
          <option value="Bensin" <?= $isEdit && $mobilData['tipe_bahan_bakar'] === 'Bensin' ? 'selected' : '' ?>>Bensin
          </option>
          <option value="Diesel" <?= $isEdit && $mobilData['tipe_bahan_bakar'] === 'Diesel' ? 'selected' : '' ?>>Diesel
          </option>
          <option value="Listrik" <?= $isEdit && $mobilData['tipe_bahan_bakar'] === 'Listrik' ? 'selected' : '' ?>>Listrik
          </option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Sistem Penggerak *</label>
        <select class="form-select" name="sistem_penggerak" required>
          <option value="">Pilih sistem penggerak</option>
          <option value="FWD" <?= $isEdit && $mobilData['sistem_penggerak'] === 'FWD' ? 'selected' : '' ?>>FWD (Front Wheel
            Drive)</option>
          <option value="RWD" <?= $isEdit && $mobilData['sistem_penggerak'] === 'RWD' ? 'selected' : '' ?>>RWD (Rear Wheel
            Drive)</option>
          <option value="AWD" <?= $isEdit && $mobilData['sistem_penggerak'] === 'AWD' ? 'selected' : '' ?>>AWD (All Wheel
            Drive)</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Warna Exterior *</label>
        <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" name="warna_exterior" required
          value="<?= $isEdit ? htmlspecialchars($mobilData['warna_exterior']) : '' ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Warna Interior *</label>
        <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" name="warna_interior" required
          value="<?= $isEdit ? htmlspecialchars($mobilData['warna_interior']) : '' ?>">
      </div>

      <div class=" col-6 d-flex gap-3 ">
        <!-- Angsuran × Tenor + Uang Muka -->
        <div class="col-md-12">
          <label class="form-label">Angsuran × Tenor *</label>
          <div class="d-flex align-items-end gap-2">

            <div class="flex-grow-1">
              <div class="input-group">
                <span class=" input-group-text">Rp</span>
                <input type="number" class="form-control no-spin" name="angsuran" required placeholder="2500"
                  value="<?= $isEdit ? htmlspecialchars($mobilData['angsuran']) : '' ?>">
              </div>
            </div>

            <div class="fw-bold fs-4 px-2">×</div>

            <div style="width:150px;">
              <input type="number" class="form-control" name="tenor" required placeholder="0" min="0"
                value="<?= $isEdit ? htmlspecialchars($mobilData['tenor']) : '' ?>">
            </div>

          </div>
        </div>

        <!-- uang muka -->
        <div class="col-md-6">
          <label class="form-label">Uang Muka *</label>
          <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" class="form-control no-spin" name="uang_muka" required placeholder="2000"
              value="<?= $isEdit ? htmlspecialchars($mobilData['uang_muka']) : '' ?>">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ================= CARD 2: Semua Fitur + Submit ================= -->
  <div class="card p-4 shadow-sm mb-4">
    <h5 class="section-title mb-3">Fitur & Spesifikasi</h5>

    <!-- Fitur Keselamatan -->
    <div class="mb-3">
      <h6>Fitur Keselamatan</h6>
      <div class="fitur-grid">
        <label class="form-check"><input type="checkbox" name="fitur[]" value="1" <?= $isEdit && in_array(1, $mobilFitur) ? 'checked' : '' ?>> Airbag Pengemudi</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="2" <?= $isEdit && in_array(2, $mobilFitur) ? 'checked' : '' ?>> Traction Control</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="3" <?= $isEdit && in_array(3, $mobilFitur) ? 'checked' : '' ?>> Blind Spot Monitoring</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="4" <?= $isEdit && in_array(4, $mobilFitur) ? 'checked' : '' ?>> Forward Collision Warning</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="5" <?= $isEdit && in_array(5, $mobilFitur) ? 'checked' : '' ?>> Rearview Camera</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="6" <?= $isEdit && in_array(6, $mobilFitur) ? 'checked' : '' ?>> ABS (Anti-lock Braking
          System)</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="7" <?= $isEdit && in_array(7, $mobilFitur) ? 'checked' : '' ?>> ESC (Electronic Stability
          Control)</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="8" <?= $isEdit && in_array(8, $mobilFitur) ? 'checked' : '' ?>> Lane Departure Warning</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="9" <?= $isEdit && in_array(9, $mobilFitur) ? 'checked' : '' ?>> Emergency Braking</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="10" <?= $isEdit && in_array(10, $mobilFitur) ? 'checked' : '' ?>> Parking Sensors</label>
      </div>
    </div>

    <!-- Fitur Kenyamanan & Hiburan -->
    <div class="mb-3">
      <h6>Fitur Kenyamanan & Hiburan</h6>
      <div class="fitur-grid">
        <label class="form-check"><input type="checkbox" name="fitur[]" value="11" <?= $isEdit && in_array(11, $mobilFitur) ? 'checked' : '' ?>> Air Conditioning</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="12" <?= $isEdit && in_array(12, $mobilFitur) ? 'checked' : '' ?>> Power Steering</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="13" <?= $isEdit && in_array(13, $mobilFitur) ? 'checked' : '' ?>> Central Locking</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="14" <?= $isEdit && in_array(14, $mobilFitur) ? 'checked' : '' ?>> Bluetooth</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="15" <?= $isEdit && in_array(15, $mobilFitur) ? 'checked' : '' ?>> Premium Audio System</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="16" <?= $isEdit && in_array(16, $mobilFitur) ? 'checked' : '' ?>> Heated Seats</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="17" <?= $isEdit && in_array(17, $mobilFitur) ? 'checked' : '' ?>> Climate Control</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="18" <?= $isEdit && in_array(18, $mobilFitur) ? 'checked' : '' ?>> Power Windows</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="19" <?= $isEdit && in_array(19, $mobilFitur) ? 'checked' : '' ?>> USB Port</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="20" <?= $isEdit && in_array(20, $mobilFitur) ? 'checked' : '' ?>> Wireless Charging</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="21" <?= $isEdit && in_array(21, $mobilFitur) ? 'checked' : '' ?>> Navigation Seats</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="22" <?= $isEdit && in_array(22, $mobilFitur) ? 'checked' : '' ?>> Ventilated Seats</label>
      </div>
    </div>

    <!-- Fitur Exterior -->
    <div class="mb-3">
      <h6>Fitur Exterior</h6>
      <div class="fitur-grid">
        <label class="form-check"><input type="checkbox" name="fitur[]" value="23" <?= $isEdit && in_array(23, $mobilFitur) ? 'checked' : '' ?>> LED Headlights</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="24" <?= $isEdit && in_array(24, $mobilFitur) ? 'checked' : '' ?>> Fog Lamps</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="25" <?= $isEdit && in_array(25, $mobilFitur) ? 'checked' : '' ?>> Panoramic Roof</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="26" <?= $isEdit && in_array(26, $mobilFitur) ? 'checked' : '' ?>> Roof Rails</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="27" <?= $isEdit && in_array(27, $mobilFitur) ? 'checked' : '' ?>> Alloy Wheels</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="28" <?= $isEdit && in_array(28, $mobilFitur) ? 'checked' : '' ?>> LED Taillights</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="29" <?= $isEdit && in_array(29, $mobilFitur) ? 'checked' : '' ?>> Sunroof</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="30" <?= $isEdit && in_array(30, $mobilFitur) ? 'checked' : '' ?>> Spoiler</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="31" <?= $isEdit && in_array(31, $mobilFitur) ? 'checked' : '' ?>> Chrome Trim</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="32" <?= $isEdit && in_array(32, $mobilFitur) ? 'checked' : '' ?>> Run-flat Tires</label>
      </div>
    </div>

    <!-- Fitur Tambahan -->
    <div class="mb-3">
      <h6>Fitur Tambahan</h6>
      <div class="fitur-grid">
        <label class="form-check"><input type="checkbox" name="fitur[]" value="33" <?= $isEdit && in_array(33, $mobilFitur) ? 'checked' : '' ?>> Engine Immobilizer</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="34" <?= $isEdit && in_array(34, $mobilFitur) ? 'checked' : '' ?>> Push Botton Start</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="35" <?= $isEdit && in_array(35, $mobilFitur) ? 'checked' : '' ?>> Rain Sensing Wipers</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="36" <?= $isEdit && in_array(36, $mobilFitur) ? 'checked' : '' ?>> Cruise Control</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="37" <?= $isEdit && in_array(37, $mobilFitur) ? 'checked' : '' ?>> Hill Start Assist</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="38" <?= $isEdit && in_array(38, $mobilFitur) ? 'checked' : '' ?>> Keyless Entry</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="39" <?= $isEdit && in_array(39, $mobilFitur) ? 'checked' : '' ?>> Auto Headlamps</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="40" <?= $isEdit && in_array(40, $mobilFitur) ? 'checked' : '' ?>> Parking Assist</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="41" <?= $isEdit && in_array(41, $mobilFitur) ? 'checked' : '' ?>> Adaptive Cruise Control</label>
        <label class="form-check"><input type="checkbox" name="fitur[]" value="42" <?= $isEdit && in_array(42, $mobilFitur) ? 'checked' : '' ?>> Tire Pressure Monitoring</label>
      </div>
    </div>

    <!-- ================= STATUS MOBIL ================= -->
    <div class="card p-4 shadow-sm mb-4">
      <h5 class="section-title mb-3">Status Mobil</h5>

      <div class="mb-3">
        <label class="form-label">Status Saat Ini</label>
        <select class="form-select" name="status" id="statusSelect" required>
          <option value="available" selected>
            Available</option>
          <option value="reserved" <?= $isEdit && $mobilData['status'] === 'reserved' ? 'selected' : '' ?>>Reserved
          </option>
          <option value="sold" <?= $isEdit && $mobilData['status'] === 'sold' ? 'selected' : '' ?>>Sold</option>
          <option value="shipping" <?= $isEdit && $mobilData['status'] === 'shipping' ? 'selected' : '' ?>>Shipping
          </option>
          <option value="delivered" <?= $isEdit && $mobilData['status'] === 'delivered' ? 'selected' : '' ?>>Delivered
          </option>
        </select>
      </div>

      <small class="text-muted d-block">
        <strong>Available:</strong> Mobil siap dijual<br>
        <strong>Reserved:</strong> Pelanggan telah memesan mobil<br>
        <strong>Sold:</strong> Mobil sudah terjual tapi belum dikirim<br>
        <strong>Shipping:</strong> Mobil sedang diantar ke pelanggan<br>
        <strong>Delivered:</strong> Mobil sudah dikirim ke pelanggan
      </small>
    </div>


    <!-- ================= CARD 3: Publish Mobil ================= -->
    <div class="card p-4 shadow-sm mb-5 text-center">
      <h5 class="section-title mb-3">Publish Mobil</h5>
      <p class="text-muted">Klik tombol di bawah ini untuk mempublikasikan mobil ke katalog showroom.</p>
      <button type="submit" class="btn btn-primary px-5 py-2">
        <i class='bx bx-upload me-1'></i> Publish Mobil
      </button>
    </div>
</form>
</div>

<?php
// Tutup layout kalau dibuka langsung
if ($is_direct) {
  echo '</main></section>';
  include 'partials/footer.php';
}
?>
<?php if ($isEdit): ?>
  <script data-page-script="true">
    window.existingMobilFoto = <?= json_encode($mobilFoto) ?>;
    console.log('[EDIT] existingMobilFoto dari PHP:', window.existingMobilFoto);
  </script>
<?php endif; ?>


<script src="../../assets/js/mobil.js"></script>

<!-- untuk tahun  -->
<script data-page-script="true">
  (function () {
    const input = document.getElementById('tahunInput');
    const toggle = document.getElementById('ypToggle');
    const panel = document.getElementById('ypPanel');
    const grid = document.getElementById('ypGrid');
    const rangeEl = document.getElementById('ypRange');
    const prevBtn = document.getElementById('ypPrev');
    const nextBtn = document.getElementById('ypNext');

    if (!input || !panel || !grid || !rangeEl || !prevBtn || !nextBtn || !toggle) {
      console.warn('[YearPicker] Elemen tidak lengkap, cek id di HTML.');
      return;
    }

    const now = new Date().getFullYear();
    let selected = /^\d{4}$/.test(input.value) ? parseInt(input.value, 10) : now;
    let decadeStart = Math.floor(selected / 10) * 10;

    function render() {
      const maxYear = 2025; // tahun maksimal yang boleh dipilih

      rangeEl.textContent = `${decadeStart} - ${decadeStart + 9}`;
      grid.innerHTML = '';

      for (let y = decadeStart - 1; y <= decadeStart + 10; y++) {
        const btn = document.createElement('button');
        btn.type = 'button';

        // default class
        btn.className = 'yp-year';

        // warna abu (muted) kalau di luar 1 dekade
        if (y < decadeStart || y > decadeStart + 9) {
          btn.classList.add('muted');
        }

        // blokir jika di atas max year
        if (y > maxYear) {
          btn.classList.add('muted');   // warna abu
          btn.classList.add('disabled'); // nanti CSS-nya kita buat
          btn.disabled = true;
        }

        // selected styling
        if (y === selected) {
          btn.classList.add('selected');
        }

        btn.textContent = y;

        // klik normal (hanya kalau y <= maxYear)
        if (y <= maxYear) {
          btn.addEventListener('click', () => {
            selected = y;
            input.value = String(y);
            hide();
          });
        }

        grid.appendChild(btn);
      }
    }

    function show() {
      // set dekade berdasar nilai saat ini / tahun sekarang
      if (/^\d{4}$/.test(input.value)) {
        selected = parseInt(input.value, 10);
        decadeStart = Math.floor(selected / 10) * 10;
      } else {
        selected = now;
        decadeStart = Math.floor(now / 10) * 10;
      }
      render();
      panel.hidden = false;

      // kalau mepet bawah layar, tampilkan ke atas
      const rect = panel.getBoundingClientRect();
      if (rect.bottom > window.innerHeight) {
        panel.style.top = 'auto';
        panel.style.bottom = '110%';
      }
    }

    function hide() {
      panel.hidden = true;
      panel.style.top = '110%';
      panel.style.bottom = 'auto';
    }

    // buka panel saat klik input atau tombol ▾
    input.addEventListener('click', function (e) { e.stopPropagation(); show(); });
    toggle.addEventListener('click', function (e) { e.stopPropagation(); panel.hidden ? show() : hide(); });

    prevBtn.addEventListener('click', function (e) { e.stopPropagation(); decadeStart -= 10; render(); });
    nextBtn.addEventListener('click', function (e) { e.stopPropagation(); decadeStart += 10; render(); });

    // klik di luar menutup panel
    document.addEventListener('click', function (e) {
      if (panel.hidden) return;
      if (!panel.contains(e.target) && e.target !== input && e.target !== toggle) { hide(); }
    });

    // keyboard
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') { e.preventDefault(); show(); }
      if (e.key === 'Escape') { hide(); }
    });
  })();
</script>


<!-- Foto -->
<script data-page-script="true">
  (function () {
    console.log('[previewFoto] script dijalankan');

    const dropzones = document.querySelectorAll('.foto-dropzone');
    console.log('[previewFoto] jumlah dropzone:', dropzones.length);

    dropzones.forEach((dz, idx) => {
      const input = dz.querySelector('input[type="file"]');
      const sub = dz.querySelector('.dz-sub');
      const preview = dz.querySelector('.dz-preview-img');

      console.log(`[previewFoto] setup #${idx}`, { dz, input, sub, preview });

      if (!input || !preview) return;



      input.addEventListener('change', () => {
        console.log('[previewFoto] change pada', input.name, 'jumlah file:', input.files.length);

        // kosongkan preview dulu
        preview.innerHTML = '';

        if (!input.files || input.files.length === 0) {
          // kalau nggak ada file, munculkan lagi subtitle
          if (sub) sub.style.display = '';
          return;
        }

        // kalau ada file, sembunyikan subtitle biar nggak ramai
        if (sub) sub.style.display = 'none';

        if (input.multiple) {
          // foto_tambahan[]: bisa banyak
          const maxThumb = 4; // contoh: tampilkan max 4 thumbnail
          const files = Array.from(input.files);

          files.slice(0, maxThumb).forEach(file => {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.alt = file.name;
            preview.appendChild(img);
          });

          if (files.length > maxThumb) {
            const more = document.createElement('span');
            more.textContent = `+${files.length - maxThumb} lagi`;
            more.style.fontSize = '0.8rem';
            more.style.color = '#6c757d';
            preview.appendChild(more);
          }
        } else {
          // single file: 360, depan, belakang, samping
          const file = input.files[0];
          if (!file) return;

          const img = document.createElement('img');
          img.src = URL.createObjectURL(file);
          img.alt = file.name;
          preview.appendChild(img);
        }
      });
    });
  })();
</script>

<!-- untuk input number supaya tidak bisa menginputkan text  -->
<script>
  document.querySelectorAll('input[type=number]').forEach(function (input) {
    input.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '');
    });
    input.addEventListener('paste', function (e) {
      e.preventDefault();
    });
  });
</script>