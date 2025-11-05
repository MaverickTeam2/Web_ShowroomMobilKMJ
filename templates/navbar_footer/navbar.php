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
      <!-- Google Maps -->
      <a class="navbar-item" href="https://maps.app.goo.gl/qGcSdiQD9ELbNJwv7" target="_blank">
        <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
        <span>Showroom KMJ</span>
      </a>

      <!-- Favorite -->
      <a class="navbar-item" href="favorite.php">
        <span class="icon"><i class="fa-solid fa-heart"></i></span>
        <span>Favorite</span>
      </a>

      <!-- Account Dropdown -->
      <div class="navbar-item has-dropdown" id="accountDropdown">
        <a class="navbar-link">
          <span class="icon"><i class="fa-solid fa-user"></i></span>
          <span>
            <?php 
            if(isset($_SESSION['user_id'])) {
              echo htmlspecialchars($_SESSION['full_name']);
            } else {
              echo 'Account';
            }
            ?>
          </span>
        </a>

        <div class="navbar-dropdown is-right">
          <?php if(isset($_SESSION['user_id'])): ?>
            <a class="navbar-item" href="profile_setting.php">Profile</a>
            <a class="navbar-item" href="auth/logout.php">Logout</a>
          <?php else: ?>
            <a class="navbar-item" href="auth/auth.php"> Login </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Search Bar -->
<input class="input is-rounded my-4 mx-1" type="text" placeholder="Ingin Mencari Mobil Apa?" />

<script>
// Burger menu
const burger = document.querySelector(".navbar-burger");
const menu = document.querySelector("#navbarMenu");
if(burger && menu){
    burger.addEventListener("click", ()=>{
        burger.classList.toggle("is-active");
        menu.classList.toggle("is-active");
    });
}

// Dropdown toggle
const account = document.getElementById("accountDropdown");
if(account){
    const link = account.querySelector(".navbar-link");
    link.addEventListener("click", e=>{
        e.preventDefault();
        account.classList.toggle("is-active");
    });
}

const more = document.getElementById("moreDropdown");
if(more){
    const link = more.querySelector(".navbar-link");
    link.addEventListener("click", e=>{
        e.preventDefault();
        more.classList.toggle("is-active");
    });
}
</script>
