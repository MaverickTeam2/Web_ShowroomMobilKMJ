<?php
// ===============================
// auth_session.php
// ===============================

session_start();

// Hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Method Not Allowed"
    ]);
    exit();
}

// Ambil JSON dari fetch
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// Jika data kosong
if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid or empty request body"
    ]);
    exit();
}

// ===============================
// Simpan data user ke SESSION
// ===============================

$_SESSION['user_id']     = $data['kode_user'] ?? null;
$_SESSION['full_name']   = $data['full_name'] ?? null;
$_SESSION['email']       = $data['email'] ?? null;
$_SESSION['role']        = $data['role'] ?? "customer";  
$_SESSION['provider']    = $data['provider_type'] ?? "local";
$_SESSION['login_time']  = time();

// ===============================
// Kirim respons sukses
// ===============================

echo json_encode([
    "status" => "success",
    "message" => "Session created successfully",
    "session_data" => [
        "user_id" => $_SESSION['user_id'],
        "full_name" => $_SESSION['full_name'],
        "email" => $_SESSION['email'],
        "role" => $_SESSION['role'],
        "provider" => $_SESSION['provider']
    ]
]);
exit();
