<?php
// Start session kalau mau deteksi login nanti
session_start();
require_once __DIR__ . '/../../include/header.php';
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KMJ</title>

  <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css" />
  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet" />
  <!-- BoxIcons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" />
  <!-- CSS Auth -->
  <link rel="stylesheet" href="../../assets/css/auth.css" />
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../../assets/img/Logo_KMJ_YB2.ico " />
</head>

<body>
  <section class="auth-container" id="authContainer">
    <!-- Left Side Background -->
    <div class="left-side"></div>

    <!-- Right Side -->
    <div class="right-side">
      <!-- ===== LOGIN FORM ===== -->
      <div id="loginForm" class="form-box active">
        <div class="logo has-text-centered mb-4">
          <img src="../../assets/img/Logo_KMJ_YB.png" alt="Logo" />
          <h2 class="title is-4 has-text-weight-bold">LOGIN</h2>
        </div>

        <form id="loginFormElement">
          <div class="field">
            <input class="floating-input" type="email" name="email" placeholder=" " required />
            <label class="floating-label">Email</label>
          </div>
          <div class="field password-wrapper">
            <input class="floating-input" type="password" name="password" id="password-login" placeholder=" "
              required />
            <label class="floating-label">Password</label>
          </div>
          <div class="field mt-5">
            <button type="submit" class="button is-link is-fullwidth is-rounded has-text-weight-semibold">LOGIN</button>
          </div>
        </form>


        <div class="has-text-centered my-4">
          <span class="is-size-7 has-text-grey">OR</span>
        </div>

        <div class="field">
          <button class="button is-light is-fullwidth is-rounded mb-4">
            <img width="24" height="24" src="https://img.icons8.com/color/48/google-logo.png" alt="google-logo" />
            <span>Continue with Google</span>
          </button>
        </div>

        <div class="field">
          <button class="button is-light is-fullwidth is-rounded mb-4">
            <img width="24" height="24" src="https://img.icons8.com/ios-filled/50/mac-os.png" alt="mac-os" />
            <span>Continue with Apple</span>
          </button>
        </div>

        <div class="has-text-centered mt-3">
          <p class="is-size-7">
            Belum punya akun?
            <span class="switch-link" id="showRegister">Daftar</span>
          </p>
        </div>
      </div>

      <!-- Back ke Beranda -->
      <a href="../../templates/index.php"
        style="position: absolute; top: 20px; right: 20px; z-index: 1000; text-decoration: none; color: #000000; font-weight: 600;">
        <span class="icon"><i class='bx bx-arrow-back'></i></span>
        <span>Back</span>
      </a>


      <!-- ===== REGISTER FORM ===== -->
      <div id="registerForm" class="form-box hidden">
        <div class="logo has-text-centered mb-4">
          <img src="../../assets/img/Logo_KMJ_YB.png" alt="Logo" />
          <h2 class="title is-4 has-text-weight-bold">REGISTER</h2>
        </div>

        <form id="registerFormElement">
          <div class="field">
            <input class="floating-input" type="text" name="nama" placeholder=" " required />
            <label class="floating-label">Nama Lengkap</label>
          </div>
          <div class="field">
            <input class="floating-input" type="email" name="email" placeholder=" " required />
            <label class="floating-label">Email</label>
          </div>
          <div class="field">
            <input class="floating-input" type="text" name="no_telp" placeholder=" " required />
            <label class="floating-label">No Telepon</label>
          </div>
          <div class="field password-wrapper">
            <input class="floating-input" type="password" name="password" id="password1" placeholder=" " required />
            <label class="floating-label">Password</label>
          </div>
          <div class="field password-wrapper">
            <input class="floating-input" type="password" name="confirm" id="password2" placeholder=" " required />
            <label class="floating-label">Konfirmasi Password</label>
          </div>
          <div class="field mt-5">
            <button type="submit"
              class="button is-link is-fullwidth is-rounded has-text-weight-semibold">REGISTER</button>
          </div>
        </form>


        <div class="has-text-centered my-4">
          <span class="is-size-7 has-text-grey">OR</span>
        </div>

        <div class="field">
          <button class="button is-light is-fullwidth is-rounded mb-4">
            <img src="https://img.icons8.com/color/20/000000/google-logo.png" alt="Google" />
            <span>Register with Google</span>
          </button>
        </div>

        <div class="field">
          <button class="button is-light is-fullwidth is-rounded mb-4">
            <img width="24" height="24" src="https://img.icons8.com/ios-filled/50/mac-os.png" alt="mac-os" />
            <span>Register with Apple</span>
          </button>
        </div>

        <div class="has-text-centered mt-3">
          <p class="is-size-7">
            Sudah punya akun?
            <span class="switch-link" id="showLogin">Login</span>
          </p>
        </div>
      </div>

      <!-- ===== VERIFY FORM ===== -->
      <div id="verifyForm" class="form-box hidden">
        <div class="logo has-text-centered mb-4">
          <img src="../../assets/img/Logo_KMJ_YB.png" alt="Logo" />
          <h2 class="title is-4 has-text-weight-bold">VERIFIKASI EMAIL</h2>
        </div>

        <form id="verifyFormElement">

          <!-- HARUS KODE USER, BUKAN EMAIL -->
          <input type="hidden" id="verifyKodeUser" name="kode_user">

          <div class="field">
            <input class="floating-input" type="text" name="kode_verifikasi" placeholder=" " required />
            <label class="floating-label">Kode Verifikasi</label>
          </div>

          <div class="field mt-5">
            <button type="submit" class="button is-link is-fullwidth is-rounded has-text-weight-semibold">
              VERIFIKASI
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>

  <script src="../../assets/js/auth.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>