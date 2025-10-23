<?php
// Start session kalau mau deteksi login nanti
session_start();
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

        <form action="login.php" method="POST">
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
            <img src="https://img.icons8.com/color/20/000000/google-logo.png" alt="Google" />
            <span>Continue with Google</span>
          </button>
        </div>

        <div class="has-text-centered mt-3">
          <p class="is-size-7">
            Belum punya akun?
            <span class="switch-link" id="showRegister">Daftar</span>
          </p>
        </div>
      </div>

      <!-- ===== REGISTER FORM ===== -->
      <div id="registerForm" class="form-box hidden">
        <div class="logo has-text-centered mb-4">
          <img src="../../assets/img/Logo_KMJ_YB.png" alt="Logo" />
          <h2 class="title is-4 has-text-weight-bold">REGISTER</h2>
        </div>

        <form action="register.php" method="POST">
          <div class="field">
            <input class="floating-input" type="text" name="nama" placeholder=" " required />
            <label class="floating-label">Full Name</label>
          </div>
          <div class="field">
            <input class="floating-input" type="email" name="email" placeholder=" " required />
            <label class="floating-label">Email</label>
          </div>
          <div class="field password-wrapper">
            <input class="floating-input" type="password" name="password" id="password1" placeholder=" " required />
            <label class="floating-label">Password</label>
          </div>
          <div class="field password-wrapper">
            <input class="floating-input" type="password" name="confirm" id="password2" placeholder=" " required />
            <label class="floating-label">Confirm Password</label>
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

        <div class="has-text-centered mt-3">
          <p class="is-size-7">
            Sudah punya akun?
            <span class="switch-link" id="showLogin">Login</span>
          </p>
        </div>
      </div>
    </div>
  </section>

  <script src="../../assets/js/auth.js"></script>
  <!-- Popup Modal -->
  <div id="popupModal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card" style="max-width: 400px;">
      <header class="modal-card-head" style="justify-content: center; border-bottom: none;">
        <span id="popupIcon" class="icon is-large"></span>
      </header>
      <section class="modal-card-body has-text-centered">
        <p id="popupTitle" class="title is-5"></p>
        <p id="popupMessage" class="subtitle is-6"></p>
      </section>
      <footer class="modal-card-foot" style="justify-content: center; border-top: none;">
        <button class="button is-link is-rounded" onclick="closePopup()">OK</button>
      </footer>
    </div>
  </div>
</body>

</html>