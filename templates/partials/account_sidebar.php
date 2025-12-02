<?php
// Kalau halaman pemanggil belum set $activeMenu, kasih default kosong
if (!isset($activeMenu)) {
  $activeMenu = '';
}
?>

<aside class="col-12 col-md-3 col-lg-2 account-sidebar">
  <div class="account-menu">

    <div class="account-section-title">Belanja</div>

    <!-- Keranjang -->
    <a href="keranjang.php"
      class="account-menu-item <?= ($activeMenu === 'cart') ? 'account-menu-item--active' : '' ?>">
      <span class="account-menu-indicator"></span>
      <i class="fa-solid fa-cart-shopping me-2"></i>
      <span>Keranjang saya</span>
    </a>

    <!-- Favorit -->
    <a href="wishlist.php"
      class="account-menu-item <?= ($activeMenu === 'favorite') ? 'account-menu-item--active' : '' ?>">
      <span class="account-menu-indicator"></span>
      <i class="fa-solid fa-heart me-2"></i>
      <span>Favorit</span>
    </a>

    <hr class="account-divider">

    <div class="account-section-title">Akun</div>

    <a href="profil.php" class="account-menu-item">
      <span class="account-menu-indicator"></span>
      <i class="fa-solid fa-user me-2"></i>
      <span>Pengaturan Profil</span>
    </a>

    <hr class="account-divider">

    <a href="../admin/auth/logout.php" class="account-menu-item account-menu-item--logout">
      <span class="account-menu-indicator"></span>
      <i class="fa-solid fa-arrow-left me-2"></i>
      <span>Keluar</span>
    </a>

  </div>
</aside>
