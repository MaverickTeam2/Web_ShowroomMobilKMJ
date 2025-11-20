<?php
session_start();
require '../../db/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Cek password dan konfirmasi
    if ($password !== $confirm) {
        header("Location: auth.php?error=confirm");
        exit;
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Cek email sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: auth.php?error=email");
        exit;
    }

    // Insert user baru
    $query = "INSERT INTO users (kode_user, full_name, email, password, role, created_at, updated_at)
              VALUES (generate_kode_users(), ?, ?, ?, 'customer', NOW(), NOW())";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $hashed);

    if (mysqli_stmt_execute($stmt)) {
        // Berhasil → langsung redirect ke login
        header("Location: auth.php?registered=success");
        exit;
    } else {
        header("Location: auth.php?error=server");
        exit;
    }
}
?>
