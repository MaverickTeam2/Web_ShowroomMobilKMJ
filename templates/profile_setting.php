<?php
// ====== PROFILE SETTING (via API) ======
session_start();

// 1. Pastikan user sudah login
if (!isset($_SESSION['kode_user'])) {
  header("Location: auth/auth.php");
  exit;
}

$kode_user = $_SESSION['kode_user'];

// 2. Load config API & client
require_once __DIR__ . "/../db/config_api.php";
require_once __DIR__ . "/../db/api_client.php";

// Variabel untuk pesan sukses/error
$success = "";
$error = "";
$delete_error = ""; // khusus error hapus akun

// 3. Fungsi untuk ambil data user dari API
function fetch_user_profile($kode_user)
{
  $resp = api_get("user/routes/profile.php?kode_user=" . urlencode($kode_user));

  if (!isset($resp['status']) || !$resp['status']) {
    return [
      'error' => $resp['message'] ?? 'Gagal mengambil data profil dari API.',
      'user' => null
    ];
  }

  return [
    'error' => null,
    'user' => $resp['data'] ?? null
  ];
}

// 4. HANDLE POST: dibedakan by "action"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? 'update_profile';

  // 4A. HAPUS AKUN
  if ($action === 'delete_account') {
    $password = $_POST['password'] ?? '';

    if ($password === '') {
      $delete_error = 'Password wajib diisi.';
    } else {
      // Panggil API hapus akun
      $resp = api_post('user/routes/delete_account.php', [
        'kode_user' => $kode_user,
        'password' => $password,
      ]);

      if (!isset($resp['status']) || !$resp['status']) {
        $delete_error = $resp['message'] ?? 'Gagal menghapus akun.';
      } else {
        // Sukses hapus akun → kill session dan redirect ke login
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
          $params = session_get_cookie_params();
          setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
          );
        }
        session_destroy();

        header("Location: auth/auth.php?deleted=1");
        exit;
      }
    }
  }

  // 4B. UPDATE PROFILE (form utama)
  elseif ($action === 'update_profile') {
    $full_name = trim($_POST['full_name'] ?? '');
    $no_telp = trim($_POST['no_telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if ($full_name === "") {
      $error = "Nama lengkap tidak boleh kosong.";
    } else {
      // Data yang dikirim ke API
      $postData = [
        'kode_user' => $kode_user,
        'full_name' => $full_name,
        'no_telp' => $no_telp,
        'alamat' => $alamat,
      ];

      // Kalau ada file avatar, kirim dalam bentuk base64
      if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['avatar']['tmp_name'];
        $name = $_FILES['avatar']['name'];

        $binary = file_get_contents($tmpPath);
        if ($binary !== false) {
          $postData['avatar_base64'] = base64_encode($binary);
          $postData['avatar_name'] = $name;
        }
      }

      // Panggil API update (pakai api_post biasa)
      $resp = api_post("user/routes/profile.php", $postData);

      if (!isset($resp['status']) || !$resp['status']) {
        $error = $resp['message'] ?? 'Gagal mengupdate profil via API.';
      } else {
        $success = $resp['message'] ?? 'Profil berhasil diperbarui.';
        // Update juga nama di session
        $_SESSION['full_name'] = $full_name;
      }
    }
  }
}

// 5. Ambil data user terbaru untuk ditampilkan
$apiResult = fetch_user_profile($kode_user);
if ($apiResult['error']) {
  $error = $error ?: $apiResult['error']; // jangan timpa kalau sudah ada error lain
}

$user = $apiResult['user'] ?? [
  "full_name" => $_SESSION['full_name'] ?? "",
  "email" => $_SESSION['email'] ?? "",
  "no_telp" => "",
  "alamat" => "",
  "avatar_url" => ""
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Setting</title>

  <!-- Bulma & Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS custom -->
  <link rel="stylesheet" href="../assets/CSS/profileset.css">
  <link rel="stylesheet" href="../assets/CSS/style.css" />
</head>

<body>
  <!-- Navbar -->
  <?php include __DIR__ . "/navbar_footer/navbar.php"; ?>

  <div class="container py-4">
    <div class="d-flex align-items-center mb-3">
      <a href="index.php" class="text-decoration-none d-flex align-items-center">
        <span class="me-2 fs-4">←</span>Back
      </a>
    </div>

    <h1 class="mb-4">Profile Setting</h1>

    <?php if ($success): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <!-- FORM UPDATE PROFILE -->
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="action" value="update_profile">
      <!-- CARD 1: Info Pribadi -->
      <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <i class="fa-solid fa-circle-info me-2"></i>
            <h5 class="mb-0">Informasi Pribadi</h5>
          </div>
        </div>
        <div class="card-body row">
          <div class="col-md-8">
            <div class="mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="full_name" class="form-control"
                value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email (tidak bisa diubah di sini)</label>
              <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">No Telepon</label>
              <input type="text" name="no_telp" class="form-control"
                value="<?php echo htmlspecialchars($user['no_telp'] ?? ''); ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <textarea name="alamat" class="form-control" rows="3"><?php
              echo htmlspecialchars($user['alamat'] ?? '');
              ?></textarea>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <p class="fw-bold mb-2">Foto Profil</p>
            <?php if (!empty($user['avatar_url'])): ?>
              <img src="<?php echo htmlspecialchars($user['avatar_url']); ?>" alt="Avatar" class="rounded-circle mb-3"
                style="width: 120px; height: 120px; object-fit: cover;">
            <?php else: ?>
              <div class="rounded-circle bg-secondary mb-3 d-flex align-items-center justify-content-center"
                style="width: 120px; height:120px; color:white;">
                <span class="fs-1">
                  <?php echo strtoupper(substr($user['full_name'] ?? 'U', 0, 1)); ?>
                </span>
              </div>
            <?php endif; ?>

            <div class="mb-3">
              <input type="file" name="avatar" accept="image/*" class="form-control">
              <small class="text-muted">Format: JPG/PNG/WEBP, otomatis dipotong 1:1</small>
            </div>
          </div>
        </div>
      </div>

      <!-- CARD 3: Hapus Akun (masih sama) -->
      <div class="card mt-4 shadow-sm mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <i class="fa-solid fa-bell me-2"></i>
            <h5 class="mb-0">Hapus Akun</h5>
          </div>
          <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
            data-bs-target="#modalDelete">
            DELETE
          </button>
        </div>
        <div class="card-body">
          <p class="mb-2">Ini akan menghapus secara permanen akun MyKMJ anda (fitur belum diaktifkan).</p>
        </div>
      </div>

      <div class="d-flex justify-content-end mb-5">
        <button type="submit" class="btn btn-primary px-4">SIMPAN PERUBAHAN</button>
      </div>
    </form>
  </div>

  <!-- Modal Hapus Akun -->
  <div class="modal fade" id="modalDelete">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="">
        <input type="hidden" name="action" value="delete_account">

        <div class="modal-header">
          <h5 class="modal-title">Hapus Akun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <p class="text-danger">Akun Anda akan terhapus PERMANEN!</p>

          <?php if (!empty($delete_error)): ?>
            <div class="alert alert-danger py-2">
              <?php echo htmlspecialchars($delete_error); ?>
            </div>
          <?php endif; ?>

          <label>Masukkan Password Untuk Konfirmasi</label>
          <input type="password" name="password" class="form-control mb-3" required>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus Sekarang</button>
        </div>
      </form>
    </div>
  </div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script Profile Setting -->
  <script src="../assets/js/profile_setting.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Footer -->
  <?php include __DIR__ . "/navbar_footer/footer.php"; ?>

  <?php if (!empty($delete_error)): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('modalDelete'));
        modal.show();
      });
    </script>
  <?php endif; ?>

</body>

</html>