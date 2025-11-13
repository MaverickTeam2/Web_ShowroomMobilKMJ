<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../db/koneksi.php';

// Ambil kode_mobil dari GET (string)
$kode = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($kode === '') {
    echo json_encode(['status' => 'error', 'message' => 'kode_mobil tidak dikirim']);
    exit;
}

$sql = "
SELECT 
  kode_mobil,
  nama_mobil,
  tahun_mobil,
  jarak_tempuh,
  uang_muka,
  tenor,
  angsuran,
  (COALESCE(uang_muka,0) + (COALESCE(angsuran,0) * COALESCE(tenor,0))) AS harga
FROM mobil
WHERE kode_mobil = ?
LIMIT 1
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Query prepare gagal']);
    exit;
}

$stmt->bind_param("s", $kode);
$stmt->execute();
$res = $stmt->get_result();
$row = $res ? $res->fetch_assoc() : null;

if (!$row) {
    echo json_encode(['status' => 'error', 'message' => 'Mobil tidak ditemukan']);
    exit;
}

// URL foto pakai kode_mobil juga
$fotoUrl = "get_foto.php?kode_mobil=" . urlencode($kode);

$out = [
    'status'     => 'ok',
    'kode_mobil' => $row['kode_mobil'],
    'nama_mobil' => $row['nama_mobil'] ?? '-',
    'tahun'      => $row['tahun_mobil'] ?? null,
    'km'         => (int)($row['jarak_tempuh'] ?? 0),
    'dp'         => (int)($row['uang_muka'] ?? 0),
    'tenor'      => (int)($row['tenor'] ?? 0),
    'angsuran'   => (int)($row['angsuran'] ?? 0),
    'harga'      => (int)($row['harga'] ?? 0),
    'foto'       => $fotoUrl,
];

echo json_encode($out);
exit;
