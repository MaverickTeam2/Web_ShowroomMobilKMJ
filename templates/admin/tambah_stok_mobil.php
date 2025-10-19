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
        <div class="row g-3">
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

          <div class="col-md-6">
            <label class="form-label">Jenis Bahan Bakar *</label>
            <select class="form-select" required>
              <option value="">Pilih Jenis bahan bakar</option>
              <option value="Bensin">Bensin</option>
              <option value="Diesel">Diesel</option>
              <option value="Listrik">Listrik</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Sistem Penggerak *</label>
            <select class="form-select" required>
              <option value="">Pilih sistem penggerak</option>
              <option value="FWD">FWD (Front Wheel Drive)</option>
              <option value="RWD">RWD (Rear Wheel Drive)</option>
              <option value="AWD">AWD (All Wheel Drive)</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Warna Exterior *</label>
            <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" required>
          </div>

          <div class="col-12 d-flex gap-3 align-items-end">
            <!-- Warna Exterior -->
            <div class="flex-grow-1">
              <label class="form-label">Warna Exterior *</label>
              <input type="text" class="form-control" placeholder="Gray, Black, Red, dll" required>
            </div>

            <!-- Angsuran × Tenor -->
            <div class="d-flex align-items-end gap-2" style="min-width: 220px;">
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
    <br>
    <div class="row g-3">
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="airbag">
          <label class="form-check-label" for="airbag">Airbag Pengemudi</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="traction">
          <label class="form-check-label" for="traction">Traction Control</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="abs">
          <label class="form-check-label" for="abs">ABS</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="esc">
          <label class="form-check-label" for="esc">ESC</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="blindspot">
          <label class="form-check-label" for="blindspot">Blind Spot Monitoring</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="ldw">
          <label class="form-check-label" for="ldw">Lane Departure Warning</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="fcw">
          <label class="form-check-label" for="fcw">Forward Collision Warning</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="eb">
          <label class="form-check-label" for="eb">Emergency Braking</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="rearcam">
          <label class="form-check-label" for="rearcam">Rearview Camera</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="parking">
          <label class="form-check-label" for="parking">Parking Sensors</label>
        </div>
      </div>
    </div>
  </div>
  <br>

  <!-- Fitur Kenyamanan & Hiburan -->
  <div class="mb-3">
    <h6>Fitur Kenyamanan & Hiburan</h6>
    <br>
    <div class="row g-3">
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="ac">
          <label class="form-check-label" for="ac">Air Conditioning</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="climate">
          <label class="form-check-label" for="climate">Climate Control</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="steering">
          <label class="form-check-label" for="steering">Power Steering</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="windows">
          <label class="form-check-label" for="windows">Power Windows</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="lock">
          <label class="form-check-label" for="lock">Central Locking</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="usb">
          <label class="form-check-label" for="usb">USB Port</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="bluetooth">
          <label class="form-check-label" for="bluetooth">Bluetooth</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="wireless">
          <label class="form-check-label" for="wireless">Wireless Charging</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="audio">
          <label class="form-check-label" for="audio">Premium Audio System</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="nav">
          <label class="form-check-label" for="nav">Navigation Seats</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="heated">
          <label class="form-check-label" for="heated">Heated Seats</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="ventilated">
          <label class="form-check-label" for="ventilated">Ventilated Seats</label>
        </div>
      </div>
    </div>
  </div>
  <br>

  <!-- Fitur Exterior -->
  <div class="mb-3">
    <h6>Fitur Exterior</h6>
    <br>
    <div class="row g-3">
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="headlights">
          <label class="form-check-label" for="headlights">LED Headlights</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="taillights">
          <label class="form-check-label" for="taillights">LED Taillights</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="fog">
          <label class="form-check-label" for="fog">Fog Lamps</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="sunroof">
          <label class="form-check-label" for="sunroof">Sunroof</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="panoramic">
          <label class="form-check-label" for="panoramic">Panoramic Roof</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="spoiler">
          <label class="form-check-label" for="spoiler">Spoiler</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="rails">
          <label class="form-check-label" for="rails">Roof Rails</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="trim">
          <label class="form-check-label" for="trim">Chrome Trim</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="wheels">
          <label class="form-check-label" for="wheels">Alloy Wheels</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="runflat">
          <label class="form-check-label" for="runflat">Run-flat Tires</label>
        </div>
      </div>
    </div>
  </div>
  <br>

  <!-- Fitur Tambahan / Keamanan -->
  <div class="mb-3">
    <h6>Fitur Tambahan</h6>
    <br>
    <div class="row g-3">
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="immobilizer">
          <label class="form-check-label" for="immobilizer">Engine Immobilizer</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="keyless">
          <label class="form-check-label" for="keyless">Keyless Entry</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="pushbutton">
          <label class="form-check-label" for="pushbutton">Push Button Start</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="autoheadlamps">
          <label class="form-check-label" for="autoheadlamps">Auto Headlamps</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="rainwipers">
          <label class="form-check-label" for="rainwipers">Rain Sensing Wipers</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="parkingassist">
          <label class="form-check-label" for="parkingassist">Parking Assist</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="cruiseextra">
          <label class="form-check-label" for="cruiseextra">Cruise Control</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="adaptivecruise">
          <label class="form-check-label" for="adaptivecruise">Adaptive Cruise Control</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="hillstart">
          <label class="form-check-label" for="hillstart">Hill Start Assist</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="tirepressure">
          <label class="form-check-label" for="tirepressure">Tire Pressure Monitoring</label>
        </div>
      </div>
    </div>
  </div>
</div>
<br>


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