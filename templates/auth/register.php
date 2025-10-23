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

    // Hash pakai SHA-256 → simpan sebagai BINARY(32)
    $hashed = hash('sha256', $password, true);

    // Cek email
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar!'); window.history.back();</script>";
        exit;
    }

    $query = "INSERT INTO users (full_name, email, password, created_at, updated_at)
              VALUES ('$nama', '$email', ?, NOW(), NOW())";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $hashed); // string/binary
    if(mysqli_stmt_execute($stmt)){
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='auth.php';</script>";
    } else {
        echo "Error: ".mysqli_error($conn);
    }
}
?>
