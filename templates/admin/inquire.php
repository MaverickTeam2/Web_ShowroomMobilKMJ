<?php
$title = "Inquire";
require_once 'partials/header.php';
require_once 'partials/sidebar.php';
require_once '../../db/config_api.php'; // kalau belum dipakai, tetap boleh
?>

<link rel="stylesheet" href="../../assets/css/inquire.css?v=1">

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

    <!-- LIST CARD INQUIRE -->
    <div class="inquire-list">

      <!-- CARD 1 - CLOSED -->
      <article class="inquire-card" data-status="closed">
        <div class="inquire-card-header">
          <div>
            <div class="name-row">
              <span class="customer-name">Asmal</span>
              <span class="badge badge-type">Test Drive</span>
            </div>
            <span class="inquire-time">2 hours ago</span>
          </div>
          <span class="badge badge-status badge-closed">Closed</span>
        </div>

        <div class="inquire-card-body">
          <p><span class="meta-label">Email:</span> asmaltkd@gmail.com</p>
          <p><span class="meta-label">Phone:</span> +62 857 4539 0417</p>
          <p><span class="meta-label">Vehicle:</span> Toyota R8 2024</p>

          <div class="inquire-message">
            Saya ingin mencoba mengendarai motor tersebut
          </div>
        </div>
      </article>

      <!-- CARD 2 - PENDING -->
      <article class="inquire-card" data-status="pending">
        <div class="inquire-card-header">
          <div>
            <div class="name-row">
              <span class="customer-name">Winda</span>
              <span class="badge badge-type">Test Drive</span>
            </div>
            <span class="inquire-time">2 hours ago</span>
          </div>
          <span class="badge badge-status badge-pending">Pending</span>
        </div>

        <div class="inquire-card-body">
          <p><span class="meta-label">Email:</span> asmaltkd@gmail.com</p>
          <p><span class="meta-label">Phone:</span> +62 857 4539 0417</p>
          <p><span class="meta-label">Vehicle:</span> Toyota R8 2024</p>

          <div class="inquire-message">
            Saya ingin mencoba mengendarai motor tersebut
          </div>

          <div class="inquire-card-footer">
            <button class="btn-respond">Respond</button>
            <button class="btn-icon btn-cancel" title="Tolak">
              ✕
            </button>
          </div>
        </div>
      </article>

      <!-- CARD 3 - RESPONDED -->
      <article class="inquire-card" data-status="responded">
        <div class="inquire-card-header">
          <div>
            <div class="name-row">
              <span class="customer-name">Daffa</span>
              <span class="badge badge-type">Test Drive</span>
            </div>
            <span class="inquire-time">2 hours ago</span>
          </div>
          <span class="badge badge-status badge-responded">Responded</span>
        </div>

        <div class="inquire-card-body">
          <p><span class="meta-label">Email:</span> asmaltkd@gmail.com</p>
          <p><span class="meta-label">Phone:</span> +62 857 4539 0417</p>
          <p><span class="meta-label">Vehicle:</span> Toyota R8 2024</p>

          <div class="inquire-message">
            Saya ingin mencoba mengendarai motor tersebut
          </div>

          <div class="inquire-card-footer">
            <button class="btn-mark-closed">Mark as Closed</button>
          </div>
        </div>
      </article>

    </div><!-- /.inquire-list -->

  </main>
</section>

<?php include 'partials/footer.php'; ?>

<script src="../../assets/js/inquire.js?v=1"></script>
