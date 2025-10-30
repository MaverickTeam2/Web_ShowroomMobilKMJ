<?php
session_start();
require '../../db/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT id, full_name, email, role, password FROM users WHERE email='$email'");
    $user  = mysqli_fetch_assoc($query);

    if($user){
        // Hash input user dengan SHA-256
        $hashed = hash('sha256', $password, true);

        if($hashed === $user['password']) { // bandingkan BINARY langsung
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email']     = $user['email'];
            $_SESSION['role']      = $user['role'];

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
