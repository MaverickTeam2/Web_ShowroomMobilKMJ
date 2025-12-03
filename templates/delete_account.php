<?php
// templates/delete_account.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan user login
if (!isset($_SESSION['kode_user'])) {
    header("Location: auth/auth.php");
    exit;
}

$kode_user = $_SESSION['kode_user'];

// Pakai config_api & api_client dari /db (SAMA seperti detail_mobil.php)
require_once __DIR__ . '/../db/config_api.php';
require_once __DIR__ . '/../db/api_client.php';

// Default pesan
$error = '';
$success = '';

// Form dikirim via POST dari modal di profile_setting
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Jangan percaya hidden input, pakai session
    $password = $_POST['password'] ?? '';

    if ($password === '') {
        $error = 'Password wajib diisi.';
    } else {
        // Kirim ke API_KMJ/user/routes/delete_account.php
        $resp = api_post('user/routes/delete_account.php', [
            'kode_user' => $kode_user,
            'password' => $password,
        ]);

        if (!isset($resp['status']) || !$resp['status']) {
            $error = $resp['message'] ?? 'Gagal menghapus akun.';
        } else {
            $success = $resp['message'] ?? 'Akun berhasil dihapus.';

            // Hapus session & redirect ke halaman login / landing
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

            // Redirect setelah hapus akun
            header("Location: auth/auth.php?deleted=1");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hapus Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Hapus Akun</h5>
                    </div>
                    <div class="card-body">

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                        <?php endif; ?>

                        <p class="text-danger mb-3">
                            Akun Anda akan terhapus <b>PERMANEN</b>. Tindakan ini tidak bisa dibatalkan.
                        </p>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="password" class="form-label">Masukkan Password Anda</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="profile_setting.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-danger">Hapus Akun</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>