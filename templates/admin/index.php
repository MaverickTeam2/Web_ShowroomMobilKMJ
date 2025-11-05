<?php

include 'partials/header.php';
include 'partials/sidebar.php';
?>

<!-- ================= CONTENT ================= -->
<section id="content">
  <!-- NAVBAR -->
  <nav>
    <i class='bx bx-menu'></i>
    <!-- kamu bisa tambahkan search bar, notif, atau profile di sini -->
  </nav>

  <!-- MAIN CONTENT -->
  <main id="main-content" class="p-4">
    <h2 class="fw-bold mb-3">Selamat Datang di Dashboard Admin KMJ</h2>
    <p class="text-muted mb-4">Gunakan menu di sebelah kiri untuk mengelola data aplikasi showroom.</p>

    <!-- Ringkasan / Statistik -->
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Total Transaksi</h5>
            <p class="card-text fs-4 fw-semibold text-primary">0</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Mobil Tersedia</h5>
            <p class="card-text fs-4 fw-semibold text-success">0</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Akun Terdaftar</h5>
            <p class="card-text fs-4 fw-semibold text-warning">0</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Seksi tambahan -->
    <div class="card mt-5 shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title">Informasi</h5>
        <p class="card-text">
          Selamat datang di sistem manajemen showroom <strong>Kaliwates Mobil Jember</strong>.
          Gunakan fitur di sidebar untuk menambahkan transaksi, mengelola mobil, atau melihat laporan penjualan.
        </p>
      </div>
    </div>
  </main>
</section>

<?php include 'partials/footer.php'; ?>
