<?php
// Cek apakah file ini dibuka langsung di browser (bukan via fetch)
$is_direct = (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__));

// Kalau dibuka langsung, tampilkan layout lengkap
if ($is_direct) {
  include '../../db/koneksi.php';
  include 'partials/header.php';
  include 'partials/sidebar.php';
  echo '<section id="content"><nav><i class="bx bx-menu"></i></nav><main id="main-content" class="p-4">';
}
?>

<!-- ======================== KONTEN HALAMAN ======================== -->
<div class="head-title d-flex justify-content-between align-items-center">
  <div class="left">
    <h1>Tambah Stok Mobil</h1>
    <ul class="breadcrumb">
      <li><a href="manajemen_mobil.php" data-page="manajemen_mobil.php">Manajemen Mobil</a></li>
      <li><i class='bx bx-chevron-right'></i></li>
      <li><a class="active" href="#">Tambah Stok Mobil</a></li>
    </ul>
  </div>
</div>

<div class="card p-4 shadow-sm mt-4" style="max-width:1100px; margin:auto;">
 <form id="formMobil" method="POST" enctype="multipart/form-data">


    <!-- ================= Informasi Mobil ================= -->
    <div class="card p-4 shadow-sm mb-4">
      <h5 class="section-title">Informasi Mobil</h5>

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Mobil *</label>
          <input type="text" class="form-control" placeholder="Masukkan nama mobil" name="nama_mobil" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Tahun *</label>
          <input type="number" class="form-control" placeholder="2025" name="tahun" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Jarak Tempuh *</label>
          <input type="text" class="form-control" placeholder="0 KM" name="jarak_tempuh" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Tipe Kendaraan *</label>
          <select class="form-select" name="tipe_kendaraan" required>
            <option value="">Pilih tipe Kendaraan</option>
            <option value="SUV">SUV</option>
            <option value="MPV">MPV</option>
            <option value="Sedan">Sedan</option>
            <option value="Sport">Sport</option>
          </select>
        </div>

        <div class="col-md-5">
          <label class="form-label">Jenis Bahan Bakar *</label>
          <select class="form-select" name="bahan_bakar" required>
            <option value="">Pilih Jenis bahan bakar</option>
            <option value="Bensin">Bensin</option>
            <option value="Diesel">Diesel</option>
            <option value="Listrik">Listrik</option>
          </select>
        </div>

        <div class="col-md-5">
          <label class="form-label">Sistem Penggerak *</label>
          <select class="form-select" name="sistem_penggerak" required>
            <option value="">Pilih sistem penggerak</option>
            <option value="FWD">FWD (Front Wheel Drive)</option>
            <option value="RWD">RWD (Rear Wheel Drive)</option>
            <option value="AWD">AWD (All Wheel Drive)</option>
          </select>
        </div>

        <div class="col-md-5">
          <label class="form-label">Warna Exterior *</label>
          <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" name="warna_exterior" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Warna Exterior *</label>
          <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" name="warna_interior" required>
        </div>

        <div class="col-6 d-flex gap-3 ">
          <!-- Warna Exterior -->

          <!-- Angsuran × Tenor -->
          <div class="d-flex align-items-end gap-1" style="min-width: 100px;">
            <div class="flex-grow-1">
              <label class="form-label">Angsuran (Rp) *</label>
              <input type="number" class="form-control" placeholder="2500" name="angsuran" required>
            </div>

            <div class="d-flex align-items-center px-2" style="font-weight:700; font-size:1.4rem;">X</div>

            <div style="width: 70px;">
              <label class="form-label">Tenor *</label>
              <input type="number" class="form-control" placeholder="0" name="tenor" required>
            </div>
          </div>

          <!-- Warna Interior -->
          <div class="flex-grow-1">
            <label class="form-label">Uang Muka (Rp) *</label>
            <input type="number" class="form-control" placeholder="2000" name="uang_muka" required>
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
          <label class="form-check"><input type="checkbox" name="fitur[]" value="1"> Airbag Pengemudi</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="2"> Traction Control</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="3"> Blind Spot Monitoring</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="4"> Forward Collision Warning</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="5"> Rearview Camera</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="6"> ABS (Anti-lock Braking
            System)</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="7"> ESC (Electronic Stability
            Control)</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="8"> Lane Departure Warning</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="9"> Emergency Braking</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="10"> Parking Sensors</label>
        </div>
      </div>

      <!-- Fitur Kenyamanan & Hiburan -->
      <div class="mb-3">
        <h6>Fitur Kenyamanan & Hiburan</h6>
        <div class="fitur-grid">
          <label class="form-check"><input type="checkbox" name="fitur[]" value="11"> Air Conditioning</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="12"> Power Steering</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="13"> Central Locking</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="14"> Bluetooth</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="15"> Premium Audio System</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="16"> Heated Seats</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="17"> Climate Control</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="18"> Power Windows</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="19"> USB Port</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="20"> Wireless Charging</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="21"> Navigation Seats</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="22"> Ventilated Seats</label>
        </div>
      </div>

      <!-- Fitur Exterior -->
      <div class="mb-3">
        <h6>Fitur Exterior</h6>
        <div class="fitur-grid">
          <label class="form-check"><input type="checkbox" name="fitur[]" value="23"> LED Headlights</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="24"> Fog Lamps</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="25"> Panoramic Roof</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="26"> Roof Rails</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="27"> Alloy Wheels</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="28"> LED Taillights</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="29"> Sunroof</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="30"> Spoiler</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="31"> Chrome Trim</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="32"> Run-flat Tires</label>
        </div>
      </div>

      <!-- Fitur Tambahan -->
      <div class="mb-3">
        <h6>Fitur Tambahan</h6>
        <div class="fitur-grid">
          <label class="form-check"><input type="checkbox" name="fitur[]" value="33"> Engine Immobilizer</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="34"> Push Botton Start</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="35"> Rain Sensing Wipers</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="36"> Cruise Control</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="37"> Hill Start Assist</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="38"> Keyless Entry</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="39"> Auto Headlamps</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="40"> Parking Assist</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="41"> Adaptive Cruise Control</label>
          <label class="form-check"><input type="checkbox" name="fitur[]" value="42"> Tire Pressure Monitoring</label>
        </div>
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

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const formMobil = document.getElementById("formMobil");
      if (!formMobil) return;

      formMobil.addEventListener("submit", async function (e) {
        e.preventDefault(); // cegah reload

        const formData = new FormData(formMobil);

        try {
          // ✅ path fix sesuai struktur kamu
          const response = await fetch("api/mobil_tambah.php", {
            method: "POST",
            body: formData
          });

          if (!response.ok) throw new Error("Gagal mengirim data ke server");

          const result = await response.json();
          console.log("Response:", result);

          if (result.success) {
            alert(result.message || "Mobil berhasil ditambahkan!");
            window.location.href = "manajemen_mobil.php";
          } else {
            alert(result.message || "Gagal menambahkan mobil.");
          }
        } catch (err) {
          console.error("❌ Error:", err);
          alert("Terjadi kesalahan: " + err.message);
        }
      });
    });
  </script>
</div>

<?php
// Tutup layout kalau dibuka langsung
if ($is_direct) {
  echo '</main></section>';
  include 'partials/footer.php';
}
?>

<link rel="stylesheet" href="../../assets/css/admin/tambah_stok_mobil.css">