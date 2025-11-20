<?php
// ===== WAJIB DI BARIS PALING ATAS =====
// Tangkap SEMUA warning supaya tidak bocor ke JSON
ob_start();
error_reporting(E_ERROR | E_PARSE);

header("Content-Type: application/json");

include '../../db/config_api.php';
include '../../db/api_client.php';

$kode = $_GET['kode_mobil'] ?? '';

if (!$kode) {
    $extra = ob_get_clean();
    echo json_encode([
        'success' => false,
        'message' => 'kode_mobil wajib dikirim',
        // 'debug' => $extra  // opsional
    ]);
    exit;
}

// panggil API yang asli
$result = api_get("admin/web_mobil_detail.php?kode_mobil=" . urlencode($kode));

// bersihkan warning/notice
$extra = ob_get_clean();

// kalau hasil adalah string JSON
if (is_string($result)) {
    $decoded = json_decode($result, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        // aman
        echo json_encode($decoded);
        exit;
    } else {
        // JSON rusak
        echo json_encode([
            'success' => false,
            'message' => 'API mengembalikan data bukan JSON',
            'raw' => $result,
        ]);
        exit;
    }
}

// kalau hasil sudah array
echo json_encode($result);
exit;
?>
