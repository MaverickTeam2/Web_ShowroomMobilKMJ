<?php
session_start();
require '../../db/koneksi.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$email    = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

$query = mysqli_query($conn, 
    "SELECT kode_user, full_name, email, role, password 
     FROM users WHERE email='$email'"
);

$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo json_encode([
        "status" => "error",
        "message" => "Email tidak ditemukan"
    ]);
    exit;
}

if (!password_verify($password, $user['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Password salah"
    ]);
    exit;
}

// Simpan session
$_SESSION['kode_user'] = $user['kode_user'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['email']     = $user['email'];
$_SESSION['role']      = $user['role'];

// Tentukan redirect berdasarkan role
$redirect = ($user['role'] === "admin" || $user['role'] === "owner")
    ? "../admin/index.php"
    : "../../templates/index.php";

echo json_encode([
    "status"   => "success",
    "message"  => "Login berhasil",
    "redirect" => $redirect
]);
exit;
?>
