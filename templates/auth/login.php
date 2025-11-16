<?php
session_start();
require '../../db/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT kode_user, full_name, email, role, password FROM users WHERE email='$email'");
    $user  = mysqli_fetch_assoc($query);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['kode_user']  = $user['kode_user'];
            $_SESSION['full_name']  = $user['full_name'];
            $_SESSION['email']      = $user['email'];
            $_SESSION['role']       = $user['role'];

            $kode_user = $user['kode_user'];
            mysqli_query($conn, "UPDATE users SET last_login = NOW() WHERE kode_user = '$kode_user'");

            header("Location: ../../templates/index.php");
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.history.back();</script>";
    }
}
?>



