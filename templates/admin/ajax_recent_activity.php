<?php
// ajax_recent_activity.php
header('Content-Type: application/json');

// load config + api_client (SAMA seperti di index.php)
require __DIR__ . '/../../db/config_api.php';
require __DIR__ . '/../../db/api_client.php';

$allowed_filters = ['all', 'mobil', 'transaksi'];

$limit  = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
$filter = isset($_GET['filter']) && in_array($_GET['filter'], $allowed_filters)
  ? $_GET['filter']
  : 'all';

// panggil API backend (folder API_kmj) lewat api_get (bukan langsung dari JS)
$result = api_get(
  'admin/get_recent_activity.php?limit=' . $limit . '&filter=' . urlencode($filter)
);

// kalau $result kosong → kasih error standar
if (!$result) {
  echo json_encode([
    'code' => 500,
    'message' => 'Gagal memanggil API get_recent_activity'
  ]);
  exit;
}

// kirim balik JSON apa adanya
echo json_encode($result);
