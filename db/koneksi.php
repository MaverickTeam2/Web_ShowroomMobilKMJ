<?php
$host = '127.0.0.1';
$user = 'admin';
$pass = '1234';
$db   = 'maverick_kmj';
$port = 8889;

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
  http_response_code(500);
  // Jangan echo ke output JSON/gambar
  error_log("DB connect error: " . $conn->connect_error);
  exit;
}
mysqli_set_charset($conn, 'utf8mb4');
// tidak ada echo apa pun
