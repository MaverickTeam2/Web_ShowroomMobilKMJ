<?php
// ====== PROFILE SETTING (DINAMIS) ======
session_start();

// 1. Pastikan user sudah login
if (!isset($_SESSION['kode_user'])) {
  header("Location: auth/auth.php");
  exit;
}

$kode_user = $_SESSION['kode_user'];

// 2. Koneksi ke DB (pakai koneksi web kamu)
require_once __DIR__ . "/../db/koneksi.php"; // pastikan file ini bener

// Variabel untuk pesan sukses/error
$success = "";
$error = "";

/**
 * Helper: upload + resize avatar (512x512, square crop)
 * Return: path relatif /images/user/xxxx.png atau null kalau gagal
 */
function handleAvatarUpload($kode_user)
{
  if (
    !isset($_FILES['avatar']) ||
    $_FILES['avatar']['error'] !== UPLOAD_ERR_OK
  ) {
    return null; // tidak ada file yang diupload
  }

  $fileTmp = $_FILES['avatar']['tmp_name'];
  $fileName = $_FILES['avatar']['name'];

  // Cek tipe mime (security basic)
  $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
  $mime = mime_content_type($fileTmp);
  if (!in_array($mime, $allowedTypes)) {
    return null;
  }

  // Folder simpan (samakan dengan pola di DB: /images/user/...)
  $dir = __DIR__ . "/../../API_KMJ/images/user/";
  if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
  }

  $newFileName = "USER_" . $kode_user . "_" . time() . ".png";
  $target = $dir . $newFileName;

  // Pindah dulu
  if (!move_uploaded_file($fileTmp, $target)) {
    return null;
  }

  // Resize + crop ke 512x512 pakai GD
  list($w, $h, $type) = getimagesize($target);

  if ($type == IMAGETYPE_JPEG) {
    $src = imagecreatefromjpeg($target);
  } elseif ($type == IMAGETYPE_PNG) {
    $src = imagecreatefrompng($target);
  } elseif ($type == IMAGETYPE_WEBP) {
    $src = imagecreatefromwebp($target);
  } else {
    return null;
  }

  $size = 512;
  $minSide = min($w, $h);
  $cropX = ($w - $minSide) / 2;
  $cropY = ($h - $minSide) / 2;

  $dst = imagecreatetruecolor($size, $size);
  imagecopyresampled($dst, $src, 0, 0, $cropX, $cropY, $size, $size, $minSide, $minSide);
  imagepng($dst, $target);

  imagedestroy($src);
  imagedestroy($dst);

  // path yang disimpan di DB (relatif dari root web)
  $avatar_url = "/API_KMJ/images/user/" . $newFileName;
  return $avatar_url;
}

// 3. Kalau form submit → update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim($_POST['full_name'] ?? '');
  $no_telp = trim($_POST['no_telp'] ?? '');
  $alamat = trim($_POST['alamat'] ?? '');

  if ($full_name === "") {
    $error = "Nama lengkap tidak boleh kosong.";
  } else {
    // Coba upload avatar (kalau ada)
    $avatar_url = handleAvatarUpload($kode_user);

    // Build query dinamis
    $fields = [];
    $params = [];
    $types = "";

    $fields[] = "full_name = ?";
    $params[] = $full_name;
    $types .= "s";

    $fields[] = "no_telp = ?";
    $params[] = $no_telp !== "" ? $no_telp : null;
    $types .= "s";

    $fields[] = "alamat = ?";
    $params[] = $alamat !== "" ? $alamat : null;
    $types .= "s";

    if ($avatar_url) {
      $fields[] = "avatar_url = ?";
      $params[] = $avatar_url;
      $types .= "s";
    }

    $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE kode_user = ?";
    $params[] = $kode_user;
    $types .= "s";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      $error = "Gagal prepare statement: " . $conn->error;
    } else {
      $stmt->bind_param($types, ...$params);
      if ($stmt->execute()) {
        $success = "Profil berhasil diperbarui.";
        // Update juga nama di session
        $_SESSION['full_name'] = $full_name;
      } else {
        $error = "Gagal update profile: " . $conn->error;
      }
      $stmt->close();
    }
  }
}

// 4. Ambil data user terbaru untuk ditampilkan
$stmt = $conn->prepare("SELECT full_name, email, no_telp, alamat, avatar_url FROM users WHERE kode_user = ?");
$stmt->bind_param("s", $kode_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
  // kalau aneh2 & data ga ada
  $error = "User tidak ditemukan di database.";
  $user = [
    "full_name" => $_SESSION['full_name'] ?? "",
    "email" => $_SESSION['email'] ?? "",
    "no_telp" => "",
    "alamat" => "",
    "avatar_url" => ""
  ];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Setting</title>

  <!-- Bulma & Bootstrap (kalau memang mau dipakai dua-duanya) -->
  <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- CSS custom (perbaiki path) -->
  <link rel="stylesheet" href="../assets/CSS/profileset.css">
  <link rel="stylesheet" href="../assets/CSS/style.css" />
</head>

<body>
  <!-- Navbar (kalau kamu pakai navbar.php) -->
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


      <!-- CARD 3: Hapus Akun (belum diimplementasi) -->
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
      <form class="modal-content" method="POST" action="delete_account.php">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Akun</h5>
          <button type="button" class="btn-close"></button>
        </div>

        <div class="modal-body">
          <p class="text-danger">Akun Anda akan terhapus PERMANEN!</p>

          <label>Masukkan Password Untuk Konfirmasi</label>
          <input type="password" name="password" class="form-control mb-3" required>

          <!-- Field ini sebenarnya tidak wajib, tapi boleh -->
          <input type="hidden" name="kode_user" value="<?php echo $kode_user; ?>">
        </div>

        <div class="modal-footer">
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
</body>

</html>