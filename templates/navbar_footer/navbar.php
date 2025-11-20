<?php
session_start();
?>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php">
      <img src="../assets/img/Logo_KMJ_YB.png" alt="Logo KMJ" width="112" height="28">
    </a>
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarMenu" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="katalog.php">Shop</a>
      <a class="navbar-item" href="jual_mobil.php">Jual Mobil</a>
      <a class="navbar-item" href="finance.php">Pembiayaan</a>

      <div class="navbar-item has-dropdown" id="moreDropdown">
        <a class="navbar-link">More</a>
        <div class="navbar-dropdown">
          <a class="navbar-item" href="FAQ&Support.php">FAQ & Support</a>
          <a class="navbar-item" href="aboutkmj.php">About KMJ</a>
          <a class="navbar-item" href="beli_online.php">Beli Online</a>
          <a class="navbar-item" href="whyKMJ.php">Why KMJ</a>
        </div>
      </div>
    </div>

    <div class="navbar-end">
      <!-- Store Location -->
      <a class="navbar-item store-location" href="https://maps.app.goo.gl/qGcSdiQD9ELbNJwv7" target="_blank" aria-label="Store Location">
        <span class="icon is-medium"><i class="fa-solid fa-location-dot"></i></span>
        <span class="store-copy">
          <small>Store Location</small>
          <strong>Kaliwates, Jember</strong>
        </span>
      </a>

      <!-- Favorite -->
      <a class="navbar-item icon-only" href="wishlist.php" aria-label="Favorite">
        <span class="icon is-medium"><i class="fa-regular fa-heart"></i></span>
      </a>

      <!-- Account Dropdown -->
      <div class="navbar-item has-dropdown is-right" id="accountDropdown">
        <a class="navbar-link icon-only" aria-label="Account" style="display:flex; align-items:center;">
          <span class="icon is-medium"><i class="fa-regular fa-user"></i></span>
          <?php if(isset($_SESSION['full_name'])): ?>
            <span style="
              margin-left:8px;
              font-size:0.95rem;
              font-weight:600;
              color:#333;
              white-space:nowrap;
              overflow:hidden;
              text-overflow:ellipsis;
              max-width:160px;
              display:inline-block;
            ">
              <?php echo htmlspecialchars($_SESSION['full_name']); ?>
            </span>
          <?php endif; ?>
        </a>

        <div class="navbar-dropdown is-right">
          <?php if(isset($_SESSION['kode_user'])): ?>
            <a class="navbar-item" href="profile_setting.php">Profile</a>
            <a class="navbar-item" href="auth/logout.php">Logout</a>
          <?php else: ?>
            <a class="navbar-item" href="auth/auth.php">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Search Bar -->
<div class="nav-search-wrap">
  <input class="input is-rounded my-4 nav-search" type="text" placeholder="Ingin Mencari Mobil Apa?" />
</div>

<script>
// Burger menu
const burger = document.querySelector(".navbar-burger");
const menu = document.querySelector("#navbarMenu");
if (burger && menu) {
  burger.addEventListener("click", () => {
    burger.classList.toggle("is-active");
    menu.classList.toggle("is-active");
  });
}

// Account dropdown
const account = document.getElementById("accountDropdown");
if (account) {
  const link = account.querySelector(".navbar-link");
  link.addEventListener("click", e => {
    e.preventDefault();
    account.classList.toggle("is-active");
  });
}

// More dropdown
const more = document.getElementById("moreDropdown");
if (more) {
  const link = more.querySelector(".navbar-link");
  link.addEventListener("click", e => {
    e.preventDefault();
    more.classList.toggle("is-active");
  });
}
</script>