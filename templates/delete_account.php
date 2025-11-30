<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['kode_user'])) {
    header("Location: ../auth/auth.php");
    exit;
}

// Hanya menerima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: profile_setting.php");
    exit;
}

require_once __DIR__ . "/../db/koneksi.php";

$kode_user = $_SESSION['kode_user'];
$password  = $_POST['password'] ?? '';

if ($password === '') {
    echo "<script>alert('Password wajib diisi'); history.back();</script>";
    exit;
}

// Ambil password hash dari database
$stmt = $conn->prepare("SELECT password FROM users WHERE kode_user = ?");
$stmt->bind_param("s", $kode_user);
$stmt->execute();
$stmt->bind_result($hash);

if (!$stmt->fetch()) {
    $stmt->close();
    echo "<script>alert('User tidak ditemukan'); window.location.href='../index.php';</script>";
    exit;
}
$stmt->close();

// Cek password benar
if (!password_verify($password, $hash)) {
    echo "<script>alert('Password salah! Mohon coba lagi.'); history.back();</script>";
    exit;
}

// Hapus akun dari database
$del = $conn->prepare("DELETE FROM users WHERE kode_user = ?");
$del->bind_param("s", $kode_user);

if (!$del->execute()) {
    echo "<script>alert('Gagal menghapus akun: " . addslashes($conn->error) . "'); history.back();</script>";
    exit;
}
$del->close();

// Hapus SESSION → user dianggap belum login
session_unset();
session_destroy();

// Redirect ke halaman index (tampilan non-login)
echo "<script>
alert('Akun berhasil dihapus. Anda sekarang keluar dari MyKMJ.');
window.location.href = '../index.php';
</script>";
exit;
