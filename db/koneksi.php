<?php
$host = "localhost";    // nama host
$user = "root";         // username MySQL
$pass = "";             // password MySQL
$db = "kmjshowrooms";   // nama database kamu

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Mengecek koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

?>
