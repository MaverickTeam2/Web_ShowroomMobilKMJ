<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'showroom_kmj';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
  http_response_code(500);
  // Jangan echo ke output JSON/gambar
  error_log("DB connect error: " . $conn->connect_error);
  exit;
}
mysqli_set_charset($conn, 'utf8mb4');
