<!--  -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/css/admin/tambah_stok_mobil.css">

  <title>Document</title>
</head>

<body>
  <div class="head-title d-flex justify-content-between align-items-center">
    <div class="left">
      <h1>Tambah Stok Mobil</h1>
      <ul class="breadcrumb">
        <li><a href="#" data-page="dashboard.html">Dashboard</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a href="#" data-page="manajemen_mobil.php">Manajemen Mobil</a></li>
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
          foreach ($fotoLabels as $i => $label): 
        ?>
        <div class="col-md-3">
          <div class="photo-upload" onclick="document.getElementById('foto<?= $i ?>').click()">
            <i class='bx bx-camera'></i>
            <?= $label ?><br><small>Click to upload</small>
            <input type="file" name="foto[]" id="foto<?= $i ?>" accept="image/*" class="d-none" onchange="previewImage(event, <?= $i ?>)">
            <img id="preview<?= $i ?>" class="photo-preview d-none" alt="">
          </div>
        </div>
        <?php endforeach; ?>

      </div>

      <!-- Foto Tambahan -->
      <div class="mt-3">
        <div class="photo-upload w-25" onclick="document.getElementById('fotoTambahan').click()">
          <i class='bx bx-plus'></i>Add Photo
          <input type="file" name="foto[]" id="fotoTambahan" multiple accept="image/*" class="d-none" onchange="previewMultiple(event)">
        </div>
        <div id="previewTambahan" class="d-flex flex-wrap gap-2 mt-2"></div>
      </div>
    </div>

    <div class="card p-4 shadow-sm mb-4">
      <h5 class="section-title">Informasi Mobil</h5>
      <form>
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
            <input type="text" class="form-control" placeholder="0 KM">
          </div>
          <div class="col-md-6">
            <label class="form-label">Tipe Kendaraan *</label>
            <select class="form-select" required>
              <option>Pilih Tipe Kendaraan</option>
              <option>SUV</option>
              <option>MPV</option>
              <option>Sport</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Jenis Bahan Bakar *</label>
            <select class="form-select" required>
              <option>Pilih Jenis Bahan Bakar</option>
              <option>Bensin</option>
              <option>Diesel</option>
              <option>Listrik</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Sistem Penggerak *</label>
            <select class="form-select" required>
              <option>Pilih Sistem Penggerak</option>
              <option>FWD</option>
              <option>RWD</option>
              <option>AWD</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Warna Eksterior *</label>
            <input type="text" class="form-control" placeholder="Gray, Black, Red, dll">
          </div>
          <div class="col-md-6">
            <label class="form-label">Warna Interior *</label>
            <input type="text" class="form-control" placeholder="Gray, Black, Red, dll">
          </div>
          <div class="col-md-3">
            <label class="form-label">Angsuran (Rp)</label>
            <input type="number" class="form-control" placeholder="2500">
          </div>
          <div class="col-md-3">
            <label class="form-label">Tenor</label>
            <input type="number" class="form-control" placeholder="12">
          </div>
          <div class="col-md-3">
            <label class="form-label">Uang Muka (Rp)</label>
            <input type="number" class="form-control" placeholder="2500">
          </div>
        </div>

        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-success px-4">Simpan</button>
          <button type="button" class="btn btn-secondary px-4" data-page="manajemen_mobil.php">Kembali</button>
        </div>
      </form>
    </div>

    <div class="card p-4 shadow-sm">
      <h5 class="section-title">Fitur & Spesifikasi</h5>
      <div class="row">
        <div class="col-md-4">
          <h6>Fitur Keselamatan</h6>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="airbag"><label
              class="form-check-label" for="airbag">Airbag Pengemudi</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="traction"><label
              class="form-check-label" for="traction">Traction Control</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="blindspot"><label
              class="form-check-label" for="blindspot">Blind Spot Monitoring</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="forward"><label
              class="form-check-label" for="forward">Forward Collision Warning</label></div>
        </div>
        <div class="col-md-4">
          <h6>&nbsp;</h6>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="abs"><label
              class="form-check-label" for="abs">ABS (Anti-lock Braking System)</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="esc"><label
              class="form-check-label" for="esc">ESC (Electronic Stability Control)</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="lane"><label
              class="form-check-label" for="lane">Lane Departure Warning</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="parking"><label
              class="form-check-label" for="parking">Parking Sensors</label></div>
        </div>
        <div class="col-md-4">
          <h6>Fitur Kenyamanan & Hiburan</h6>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="ac"><label
              class="form-check-label" for="ac">Air Conditioning</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="cruise"><label
              class="form-check-label" for="cruise">Cruise Control</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="usb"><label
              class="form-check-label" for="usb">USB Port</label></div>
          <div class="form-check"><input type="checkbox" class="form-check-input" id="wireless"><label
              class="form-check-label" for="wireless">Wireless Charging</label></div>
        </div>
      </div>
    </div>
  </main>

</body>

</html>