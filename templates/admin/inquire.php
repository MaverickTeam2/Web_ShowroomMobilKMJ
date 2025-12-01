<?php
$title = "Inquire";
require_once 'partials/header.php';
require_once 'partials/sidebar.php';
require_once '../../include/header.php';
require_once '../../db/config_api.php'; // kalau belum dipakai, tetap boleh
?>

<link rel="stylesheet" href="../../assets/css/admin/inquire.css?v=1">


<section id="content">
  <!-- NAVBAR / HEADER ATAS -->
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <main id="main-content" class="p-4">
    <!-- TITLE + BREADCRUMB (MIRIP TRANSAKSI) -->
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Permintaan Janji Temu</h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Inquire</a></li>
        </ul>
      </div>
    </div>

    <!-- TABS -->
    <div class="inquire-tabs mb-4">
      <button class="inquire-tab active" data-filter="all">All (4)</button>
      <button class="inquire-tab" data-filter="pending">Pending (0)</button>
      <button class="inquire-tab" data-filter="responded">Responded (1)</button>
      <button class="inquire-tab" data-filter="closed">Closed (3)</button>
    </div>

       <!-- LIST CARD INQUIRE (DIISI VIA JS) -->
    <div class="inquire-list"></div>

  </main>
</section>

<?php include 'partials/footer.php'; ?>

<script src="../../assets/js/inquire.js?v=3"></script>

