<?php
$title = "manajemen_mobil";
include '../../db/koneksi.php';
include 'partials/header.php';
include 'partials/sidebar.php';

// Ambil data mobil beserta 1 foto utamanya (jika ada)
$query = "
  SELECT 
    m.*, 
    f.nama_file AS gambar
  FROM mobil m
  LEFT JOIN mobil_foto f 
    ON m.kode_mobil = f.kode_mobil 
    AND f.urutan = 1
  ORDER BY m.created_at DESC
";
$result = $conn->query($query);
$mobils = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <main id="main-content" class="p-4">
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1>Manajemen Mobil</h1>
        <ul class="breadcrumb">
          <li><a href="#">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Manajemen Mobil</a></li>
        </ul>
      </div>

      <!-- Tombol Tambah Mobil -->
      <!-- <button id="btn-tambah-mobil" class="btn btn-primary d-flex align-items-center" data-page="tambah_stok_mobil.php">
        <i class="bx bx-plus me-2"></i> Tambah Mobil
      </button>
    </div> -->
      <a href="tambah_stok_mobil.php" class="btn btn-primary d-flex align-items-center">
        <i class="bx bx-plus me-2"></i> Tambah Mobil
      </a>


      <!-- Search dan Filter -->
      <div class="d-flex flex-wrap align-items-center gap-2 mb-4 mt-3">
        <div class="input-group" style="max-width: 1000px;">
          <span class="input-group-text bg-white border-end-0"><i class="bx bx-search"></i></span>
          <input type="text" class="form-control border-start-0" placeholder="Cari mobil, model, atau tahun...">
        </div>
      </div>

      <!-- Grid Card Mobil -->
      <div class="row g-4">
        <?php if (empty($mobils)): ?>
          <div class="text-center py-5 text-muted">Belum ada data mobil.</div>
        <?php else: ?>
          <?php foreach ($mobils as $mobil): ?>
            <div class="col-md-4 col-sm-6">
              <div class="card shadow-sm border-0 h-100">
                <img src="<?= htmlspecialchars($mobil['gambar'] ?? '../../assets/img/no-image.jpg') ?>" class="card-img-top"
                  alt="<?= htmlspecialchars($mobil['nama_mobil'] ?? 'Mobil Tanpa Nama') ?>">

                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title fw-bold mb-0">
                      <?= htmlspecialchars($mobil['nama_mobil'] ?? 'Tanpa Nama') ?>
                    </h5>

                    <?php
                    // ambil status dari database, fallback ke 'available'
                    $status = $mobil['status'] ?? 'available';

                    // mapping status → label + warna badge
                    $statusMap = [
                      'available' => ['label' => 'Available', 'class' => 'bg-success'],
                      'reserved' => ['label' => 'Reserved', 'class' => 'bg-warning text-dark'],
                      'sold' => ['label' => 'Sold', 'class' => 'bg-secondary'],
                      'shipping' => ['label' => 'Shipping', 'class' => 'bg-info text-dark'],
                      'delivered' => ['label' => 'Delivered', 'class' => 'bg-primary'],
                    ];

                    $statusCfg = $statusMap[$status] ?? $statusMap['available'];
                    ?>

                    <span class="badge <?= $statusCfg['class'] ?>">
                      <?= htmlspecialchars($statusCfg['label']) ?>
                    </span>
                  </div>

                  <!-- sisanya tetap, jangan diubah -->
                  <p class="text-muted mb-1">Tahun: <?= htmlspecialchars($mobil['tahun_mobil'] ?? '-') ?></p>
                  <p class="text-muted mb-1">
                    Warna: <?= htmlspecialchars($mobil['warna_exterior'] ?? '-') ?> /
                    <?= htmlspecialchars($mobil['warna_interior'] ?? '-') ?>
                  </p>
                  <p class="text-muted mb-1">Jarak Tempuh: <?= number_format($mobil['jarak_tempuh'] ?? 0) ?> KM</p>
                  <p class="text-muted mb-1">Jenis: <?= htmlspecialchars($mobil['jenis_kendaraan'] ?? '-') ?></p>
                  <p class="text-muted mb-1">Bahan Bakar: <?= htmlspecialchars($mobil['tipe_bahan_bakar'] ?? '-') ?></p>
                  <p class="text-muted mb-2">Tenor: <?= htmlspecialchars($mobil['tenor'] ?? '-') ?> bulan</p>

                  <h6 class="fw-bold text-primary mb-3">
                    Rp. <?= number_format($mobil['angsuran'] ?? 0, 0, ',', '.') ?> / bulan
                  </h6>

                  <div class="d-flex justify-content-end gap-2">
                    <a href="tambah_stok_mobil.php?kode=<?= $mobil['kode_mobil'] ?>" class="btn btn-outline-primary btn-sm">
                      <i class="bx bx-edit-alt"></i>
                    </a>

                    <button class="btn btn-danger btn-sm btnDeleteMobil" data-kode="<?= $mobil['kode_mobil'] ?>">
                      <i class="bx bx-trash"></i>
                    </button>
                  </div>

                </div>

              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
  </main>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const btnTambah = document.getElementById("btn-tambah-mobil");

    if (!btnTambah) return;
  });
</script>
<!-- // hapus -->
<script>
  document.addEventListener("click", async function (e) {
    if (!e.target.closest(".btnDeleteMobil")) return;

    const btn = e.target.closest(".btnDeleteMobil");
    const kode = btn.dataset.kode;

    if (!confirm(`Yakin hapus mobil ${kode}?`)) return;

    const res = await fetch(window.location.origin + "/API_KMJ/admin/mobil_tambah.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        delete: 1,
        kode_mobil: kode
      }),
    });

    const json = await res.json();
    console.log(json);

    if (json.success) {
      alert("Berhasil dihapus!");
      location.reload();
    } else {
      alert("Gagal: " + json.message);
    }
  });
</script>


<?php include 'partials/footer.php'; ?>
<link rel="stylesheet" href="../../assets/css/admin/manajemen_mobil.css">