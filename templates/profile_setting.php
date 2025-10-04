<?php
// Data dummy sementara (nanti bisa diganti dari database)
$user = [
  "nama" => "Saka",
  "email" => "sakainegypt@gmail.com",
  "telepon" => "(913) 489 - 7890"
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Setting</title>

  <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- CSS custom -->
  <link rel="stylesheet" href="../assets/profileset.css">
</head>
<body>
  <!--header/navbar-->
  <script src="../assets/js/navbar.js" defer></script>

  <div class="container py-4">
    <div class="d-flex align-items-center mb-3">
      <span class="me-2 fs-4">←</span>
      <a href="#" class="text-decoration-none">Back</a>
    </div>

    <h1 class="mb-4">Profile Setting</h1>

    <!-- CARD 1 -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <i class="fa-solid fa-circle-info me-2"></i>
          <h5 class="mb-0">Informasi Pribadi</h5>
        </div>
        <a href="#" class="btn btn-sm btn-outline-primary">EDIT</a>
      </div>
      <div class="card-body">
        <p class="mb-1 fw-bold"><?php echo $user['nama']; ?></p>
        <p class="mb-1"><a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></p>
        <p class="mb-0"><?php echo $user['telepon']; ?></p>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <i class="fa-solid fa-shield-halved me-2"></i>
          <h5 class="mb-0">Keamanan dan Manajemen Akun</h5>
        </div>
      </div>
      <div class="card-body">
        <p class="mb-2">Ganti Password</p>
        <p class="mb-2">Two-Factor Authentication</p>
        <p class="mb-2">Ubah alamat email</p>
        <p class="mb-0">Lupa kata sandi?</p>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="card mt-4 shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <i class="fa-solid fa-bell me-2"></i>
          <h5 class="mb-0">Hapus Account</h5>
        </div>
        <a href="#" class="btn btn-sm btn-outline-danger">DELETE</a>
      </div>
      <div class="card-body">
        <p class="mb-2">Ini akan menghapus secara permanen akun MyKMJ anda</p>
      </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Footer -->
<script src="../assets/js/footer.js" defer></script>
</body>
</html>
