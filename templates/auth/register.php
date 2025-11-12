<?php
session_start();
require '../../db/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        echo "<script>alert('Password dan konfirmasi tidak cocok!'); window.history.back();</script>";
        exit;
    }

    // Hash password aman
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Cek email
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar!'); window.history.back();</script>";
        exit;
    }

    // Panggil fungsi generate_kode_users() langsung dari MySQL
    $query = "INSERT INTO users (kode_user, full_name, email, password, role, created_at, updated_at)
              VALUES (generate_kode_users(), ?, ?, ?, 'customer', NOW(), NOW())";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $hashed);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='auth.php';</script>";
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>
