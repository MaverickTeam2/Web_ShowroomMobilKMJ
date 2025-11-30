<?php
$title = "Manajemen Akun";
require_once 'partials/header.php';
require_once 'partials/sidebar.php';

require_once '../../include/header.php';
// kalau memang BUTUH langsung, pakai require_once juga:
require_once '../../db/config_api.php';

$currentUserRoleRaw = 'guest';

// 1) Coba beberapa kemungkinan umum
if (isset($_SESSION['role'])) {
    $currentUserRoleRaw = $_SESSION['role'];
} elseif (isset($_SESSION['user']['role'])) {
    $currentUserRoleRaw = $_SESSION['user']['role'];
} elseif (isset($_SESSION['data_login']['role'])) {
    // contoh lain kalau kamu simpan di sini
    $currentUserRoleRaw = $_SESSION['data_login']['role'];
}

// 2) Normalisasi ke lowercase
$currentUserRole = strtolower($currentUserRoleRaw);
$isOwner = ($currentUserRole === 'owner');

?>

<!-- CSS khusus halaman ini -->
<link rel="stylesheet" href="../../assets/css/admin/manajemen_account.css">

<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <!-- Simpan role di data-attribute untuk bisa dibaca JS kalau perlu -->
  <main id="main-content" class="p-4" data-role="<?= htmlspecialchars($currentUserRole) ?>">
    <!-- Head & Breadcrumb -->
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Manajemen Akun</h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Akun</a></li>
        </ul>
      </div>

      <!-- Tambah Akun: hanya owner yang boleh klik -->
      <button
        type="button"
        id="btnAddAccount"
      class="btn btn-primary d-flex align-items-center gap-2 <?= !$isOwner ? 'btn-disabled' : '' ?>"
      data-page="<?= $isOwner ? 'add_account.php' : '' ?>"
      <?= !$isOwner ? 'disabled' : '' ?>
    >
        <i class='bx bx-plus' style="font-size:1.1rem;"></i>
        Tambah Akun
      </button>
    </div>

    <!-- Card container utk list akun -->
       <div class="card border-0 shadow-sm mt-4">
  <div class="card-body">
    <p class="text-muted mb-4">Edit dan tambah akun di halaman ini</p>

    <!-- kontainer untuk list akun, diisi via JS -->
    <div class="row g-4" id="account-list">
      <!-- akan diisi manajemen_account.js -> loadAccounts() -->
    </div>
  </div>
</div>


    <p class="text-muted text-center my-4">© 2024 Showroom Mobil KMJ</p>
  </main>
</section>

<!-- JS khusus halaman ini -->
<script src="/web_showroommobilkmj/assets/js/manajemen_account.js?v=1"></script>
<script src="/web_showroommobilkmj/assets/js/add_account.js?v=1"></script>
<script src="/web_showroommobilkmj/assets/js/edit_account.js?v=1"></script>

<?php include 'partials/footer.php'; ?>
