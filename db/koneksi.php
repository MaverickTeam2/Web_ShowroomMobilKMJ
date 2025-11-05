<?php
$host = "localhost";    // nama host (biasanya: localhost)
$user = "root";         // username MySQL (default: root)
$pass = "";              // password MySQL (kosong jika default di XAMPP)
$db = "kmjshowrooms"; // ganti dengan nama database kamu

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Mengecek koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
} else {
  echo "Koneksi berhasil!";
}
?>