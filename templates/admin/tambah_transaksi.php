<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Transaksi</title>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/admin/tambah_transaksi.css">
</head>

<body>
  <div class="head-title d-flex justify-content-between align-items-center">
    <div class="left">
      <h1 class="h3 mb-1">Tambah Transaksi</h1>
      <ul class="breadcrumb mb-0">
        <li><a href="index.html">Dashboard</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a href="transaksi.php">Transaksi</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a class="active" href="#">Tambah Transaksi</a></li>
      </ul>
    </div>
  </div>

  <main class="main-content">
    <form class="tambah-transaksi-form">
      <!-- Informasi Pembelian -->
      <div class="card p-3 mb-4">
        <h5 class="section-title mb-3">Informasi Pembelian</h5>
        <div class="row g-3 align-items-center">
          <div class="col-md-4">
            <label class="form-label">Jenis Mobil</label>
            <select class="form-select">
              <option selected disabled>Pilih jenis mobil</option>
              <option>Bugatti Tourbillon</option>
              <option>Lamborghini Aventador</option>
              <option>Ferrari F8 Tributo</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tipe Mobil</label>
            <input type="text" class="form-control" placeholder="-" readonly>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" class="form-control">
          </div>
        </div>
      </div>

      <!-- Data Pembeli dan Pembayaran -->
      <div class="row g-4">
        <!-- Data Pembeli -->
        <div class="col-md-6">
          <div class="card p-3 h-100">
            <h5 class="section-title mb-3">Data Pembeli</h5>
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" placeholder="Masukkan nama pembeli">
            </div>
            <div class="mb-3">
              <label class="form-label">No HP</label>
              <input type="text" class="form-control" placeholder="Masukkan nomor HP">
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
              <input type="text" class="form-control" placeholder="Contoh: BRI Finance">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Full Price</label>
                <input type="text" class="form-control" placeholder="Rp 0">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Deal Price</label>
                <input type="text" class="form-control" placeholder="Rp 0">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Catatan</label>
              <textarea class="form-control" rows="2" placeholder="Tambahkan catatan jika ada..."></textarea>
            </div>
          </div>
        </div>
      </div>

      <div class="text-end mt-4">
        <button type="submit" class="btn btn-primary px-4">Submit</button>
      </div>
    </form>
  </main>

  <script>
    // Toggle kredit / tunai
    document.getElementById('jenisPembayaran').addEventListener('change', function() {
      const kreditField = document.getElementById('namaKreditField');
      kreditField.style.display = this.value === 'kredit' ? 'block' : 'none';
    });
  </script>
</body>
</html>
