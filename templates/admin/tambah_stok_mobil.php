<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../../assets/css/admin/tambah_stok_mobil.css">
  <title>Tambah Stok Mobil</title>
</head>

<body>
  <div class="head-title d-flex justify-content-between align-items-center">
    <div class="left">
      <h1>Tambah Stok Mobil</h1>
      <ul class="breadcrumb">
        <li><a href="dashboard.html" data-page="dashboard.html">Dashboard</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a href="manajemen_mobil.php" data-page="manajemen_mobil.php">Manajemen Mobil</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a class="active" href="#">Tambah Stok Mobil</a></li>
      </ul>
    </div>
  </div>

  <main class="container my-4">
    <form method="POST" enctype="multipart/form-data">

      <!-- ================= Foto Mobil ================= -->
      <div class="card p-4 shadow-sm mb-4">
        <h5 class="section-title">Foto Mobil</h5>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 ">
          <?php
          $fotoLabels = ['360° View', 'Tampilan Depan', 'Tampilan Belakang', 'Tampilan Samping'];
          foreach ($fotoLabels as $i => $label): ?>
            <div class="col-md-3">
              <div class="photo-upload" onclick="document.getElementById('foto<?= $i ?>').click()">
                <i class='bx bx-camera'></i>
                <?= $label ?><br><small>Click to upload</small>
                <input type="file" name="foto[]" id="foto<?= $i ?>" accept="image/*" class="d-none"
                  onchange="previewImage(event, <?= $i ?>)">
                <img id="preview<?= $i ?>" class="photo-preview d-none" alt="Preview">
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="mt-3">
          <div class="photo-upload w-25" onclick="document.getElementById('fotoTambahan').click()">
            <i class='bx bx-plus'></i>Add Photo
            <input type="file" name="foto[]" id="fotoTambahan" multiple accept="image/*" class="d-none"
              onchange="previewMultiple(event)">
          </div>
          <div id="previewTambahan" class="d-flex flex-wrap gap-2 mt-2"></div>
        </div>
      </div>

      <!-- ================= Informasi Mobil ================= -->
      <div class="card p-4 shadow-sm mb-4">
        <h5 class="section-title">Informasi Mobil</h5>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama Mobil *</label>
            <input type="text" class="form-control" placeholder="Masukkan nama mobil" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Tahun *</label>
            <input type="number" class="form-control" placeholder="2025" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Jarak Tempuh *</label>
            <input type="text" class="form-control" placeholder="0 KM" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Tipe Kendaraan *</label>
            <select class="form-select" required>
              <option value="">Pilih tipe Kendaraan</option>
              <option value="SUV">SUV</option>
              <option value="MPV">MPV</option>
              <option value="Sedan">Sedan</option>
              <option value="Sport">Sport</option>
            </select>
          </div>

          <div class="col-md-5">
            <label class="form-label">Jenis Bahan Bakar *</label>
            <select class="form-select" required>
              <option value="">Pilih Jenis bahan bakar</option>
              <option value="Bensin">Bensin</option>
              <option value="Diesel">Diesel</option>
              <option value="Listrik">Listrik</option>
            </select>
          </div>

          <div class="col-md-5">
            <label class="form-label">Sistem Penggerak *</label>
            <select class="form-select" required>
              <option value="">Pilih sistem penggerak</option>
              <option value="FWD">FWD (Front Wheel Drive)</option>
              <option value="RWD">RWD (Rear Wheel Drive)</option>
              <option value="AWD">AWD (All Wheel Drive)</option>
            </select>
          </div>

          <div class="col-md-5">
            <label class="form-label">Warna Exterior *</label>
            <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" required>
          </div>
          <div class="col-md-5">
            <label class="form-label">Warna Exterior *</label>
            <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" required>
          </div>

          <div class="col-6 d-flex gap-3 ">
            <!-- Warna Exterior -->

            <!-- Angsuran × Tenor -->
            <div class="d-flex align-items-end gap-1" style="min-width: 100px;">
              <div class="flex-grow-1">
                <label class="form-label">Angsuran (Rp) *</label>
                <input type="number" class="form-control" placeholder="2500" required>
              </div>

              <div class="d-flex align-items-center px-2" style="font-weight:700; font-size:1.4rem;">X</div>

              <div style="width: 70px;">
                <label class="form-label">Tenor *</label>
                <input type="number" class="form-control" placeholder="0" required>
              </div>
            </div>

            <!-- Warna Interior -->
            <div class="flex-grow-1">
              <label class="form-label">Uang Muka (Rp) *</label>
              <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" required>
            </div>
          </div>
        </div>
      </div>

<!-- ================= Fitur & Spesifikasi ================= -->
<div class="card p-4 shadow-sm mb-4">
  <h5 class="section-title">Fitur & Spesifikasi</h5>

  <!-- Fitur Keselamatan -->
  <div class="mb-3">
    <h6>Fitur Keselamatan</h6>
    <div class="fitur-grid">
      <label class="form-check"><input type="checkbox" id="airbag"> Airbag Pengemudi</label>
      <label class="form-check"><input type="checkbox" id="traction"> Traction Control</label>
      <label class="form-check"><input type="checkbox" id="abs"> ABS</label>
      <label class="form-check"><input type="checkbox" id="esc"> ESC</label>
      <label class="form-check"><input type="checkbox" id="blindspot"> Blind Spot Monitoring</label>
      <label class="form-check"><input type="checkbox" id="ldw"> Lane Departure Warning</label>
      <label class="form-check"><input type="checkbox" id="fcw"> Forward Collision Warning</label>
      <label class="form-check"><input type="checkbox" id="eb"> Emergency Braking</label>
      <label class="form-check"><input type="checkbox" id="rearcam"> Rearview Camera</label>
      <label class="form-check"><input type="checkbox" id="parking"> Parking Sensors</label>
    </div>
  </div>

  <!-- Fitur Kenyamanan & Hiburan -->
  <div class="mb-3">
    <h6>Fitur Kenyamanan & Hiburan</h6>
    <div class="fitur-grid">
      <label class="form-check"><input type="checkbox" id="ac"> Air Conditioning</label>
      <label class="form-check"><input type="checkbox" id="climate"> Climate Control</label>
      <label class="form-check"><input type="checkbox" id="steering"> Power Steering</label>
      <label class="form-check"><input type="checkbox" id="windows"> Power Windows</label>
      <label class="form-check"><input type="checkbox" id="lock"> Central Locking</label>
      <label class="form-check"><input type="checkbox" id="usb"> USB Port</label>
      <label class="form-check"><input type="checkbox" id="bluetooth"> Bluetooth</label>
      <label class="form-check"><input type="checkbox" id="wireless"> Wireless Charging</label>
      <label class="form-check"><input type="checkbox" id="audio"> Premium Audio System</label>
      <label class="form-check"><input type="checkbox" id="nav"> Navigation System</label>
      <label class="form-check"><input type="checkbox" id="heated"> Heated Seats</label>
      <label class="form-check"><input type="checkbox" id="ventilated"> Ventilated Seats</label>
    </div>
  </div>

  <!-- Fitur Exterior -->
  <div class="mb-3">
    <h6>Fitur Exterior</h6>
    <div class="fitur-grid">
      <label class="form-check"><input type="checkbox" id="headlights"> LED Headlights</label>
      <label class="form-check"><input type="checkbox" id="taillights"> LED Taillights</label>
      <label class="form-check"><input type="checkbox" id="fog"> Fog Lamps</label>
      <label class="form-check"><input type="checkbox" id="sunroof"> Sunroof</label>
      <label class="form-check"><input type="checkbox" id="panoramic"> Panoramic Roof</label>
      <label class="form-check"><input type="checkbox" id="spoiler"> Spoiler</label>
      <label class="form-check"><input type="checkbox" id="rails"> Roof Rails</label>
      <label class="form-check"><input type="checkbox" id="trim"> Chrome Trim</label>
      <label class="form-check"><input type="checkbox" id="wheels"> Alloy Wheels</label>
      <label class="form-check"><input type="checkbox" id="runflat"> Run-flat Tires</label>
    </div>
  </div>

  <!-- Fitur Tambahan -->
  <div class="mb-3">
    <h6>Fitur Tambahan</h6>
    <div class="fitur-grid">
      <label class="form-check"><input type="checkbox" id="immobilizer"> Engine Immobilizer</label>
      <label class="form-check"><input type="checkbox" id="keyless"> Keyless Entry</label>
      <label class="form-check"><input type="checkbox" id="pushbutton"> Push Button Start</label>
      <label class="form-check"><input type="checkbox" id="autoheadlamps"> Auto Headlamps</label>
      <label class="form-check"><input type="checkbox" id="rainwipers"> Rain Sensing Wipers</label>
      <label class="form-check"><input type="checkbox" id="parkingassist"> Parking Assist</label>
      <label class="form-check"><input type="checkbox" id="cruiseextra"> Cruise Control</label>
      <label class="form-check"><input type="checkbox" id="adaptivecruise"> Adaptive Cruise Control</label>
      <label class="form-check"><input type="checkbox" id="hillstart"> Hill Start Assist</label>
      <label class="form-check"><input type="checkbox" id="tirepressure"> Tire Pressure Monitoring</label>
    </div>
  </div>
</div>




      <!-- ================= Status Mobil ================= -->
      <div class="card p-4 shadow-sm mt-4 mb-5">
        <h5 class="section-title mb-3">Status Mobil</h5>

        <div class="row align-items-center mb-3">
          <div class="col-md-4">
            <label class="form-label">Status Saat Ini</label>
            <select class="form-select" id="statusMobil" onchange="updateStatusDisplay()">
              <option value="Available" selected>Available</option>
              <option value="Reserved">Reserved</option>
              <option value="Sold">Sold</option>
              <option value="Shipping">Shipping</option>
              <option value="Delivered">Delivered</option>
            </select>
          </div>

          <div class="col-md-4 mt-3 mt-md-0 d-flex align-items-center">
            <span id="statusBadge" class="status-badge badge-available"></span>
            <span id="statusText" class="status-label available">Available</span>
          </div>
        </div>

        <div class="status-description text-muted">
          <p><strong>Available:</strong> Mobil siap dijual</p>
          <p><strong>Reserved:</strong> Pelanggan telah memesan mobil</p>
          <p><strong>Sold:</strong> Mobil sudah terjual tapi belum dikirim</p>
          <p><strong>Shipping:</strong> Mobil sedang diantar ke pelanggan</p>
          <p><strong>Delivered:</strong> Mobil sudah dikirim ke pelanggan</p>
        </div>

        <hr>

        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
          <div class="text-muted small">
            <p class="mb-1"><strong>Save Draft:</strong> Simpan progress anda tanpa membuat mobil terlihat oleh
              pelanggan</p>
            <p class="mb-0"><strong>Publish Mobil:</strong> Jadikan mobil tersedia untuk dilihat dan dibeli pelanggan
            </p>
          </div>
          <div class="mt-3 mt-md-0">
            <button type="button" class="btn btn-outline-secondary me-2"><i class='bx bx-save me-1'></i> Save
              Draft</button>
            <button type="submit" class="btn btn-primary"><i class='bx bx-upload me-1'></i> Publish Mobil</button>
          </div>
        </div>
      </div>

    </form>
  </main>

  <script>
    function updateStatusDisplay() {
      const status = document.getElementById("statusMobil").value.toLowerCase();
      const text = document.getElementById("statusText");
      const badge = document.getElementById("statusBadge");

      text.className = "status-label";
      badge.className = "status-badge";

      text.classList.add(status);
      badge.classList.add(`badge-${status}`);

      text.textContent = status.charAt(0).toUpperCase() + status.slice(1);
    }

    window.addEventListener("DOMContentLoaded", updateStatusDisplay);
  </script>
</body>

</html>