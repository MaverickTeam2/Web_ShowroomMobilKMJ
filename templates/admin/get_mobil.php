<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../db/koneksi.php';

// --- Validasi & casting ID ---
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  echo json_encode(['status' => 'error', 'message' => 'ID mobil tidak dikirim / tidak valid']);
  exit;
}

/*
  Struktur tabel kamu:
  - mobil: id_mobil, nama_mobil, tahun_mobil, jarak_tempuh, uang_muka, tenor, angsuran, ...
  - mobil_foto: id_foto, id_mobil, data_foto (longblob), is_primary, created_at
*/

$sql = "
SELECT 
  m.id_mobil,
  m.nama_mobil,
  m.tahun_mobil,
  m.jarak_tempuh,
  m.uang_muka,
  m.tenor,
  m.angsuran,
  -- Estimasi harga kalau tidak ada kolom harga khusus
  (COALESCE(m.uang_muka,0) + (COALESCE(m.angsuran,0) * COALESCE(m.tenor,0))) AS harga
FROM mobil m
WHERE m.id_mobil = ?
LIMIT 1
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
  echo json_encode(['status' => 'error', 'message' => 'Query prepare gagal']);
  exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res ? $res->fetch_assoc() : null;

if (!$row) {
  echo json_encode(['status' => 'error', 'message' => 'Mobil tidak ditemukan']);
  exit;
}

// URL endpoint untuk ambil foto dari tabel mobil_foto
$fotoUrl = "get_foto.php?id_mobil=" . $id;

// Normalisasi nama field agar mudah dipakai di front-end
$out = [
  'status'     => 'ok',
  'id_mobil'   => (int)$row['id_mobil'],
  'nama_mobil' => $row['nama_mobil'] ?? '-',
  'tahun'      => $row['tahun_mobil'] ?? null,
  'km'         => isset($row['jarak_tempuh']) ? (int)$row['jarak_tempuh'] : 0,
  'dp'         => isset($row['uang_muka']) ? (int)$row['uang_muka'] : 0,
  'tenor'      => isset($row['tenor']) ? (int)$row['tenor'] : 0,
  'angsuran'   => isset($row['angsuran']) ? (int)$row['angsuran'] : 0,
  'harga'      => isset($row['harga']) ? (int)$row['harga'] : 0,
  'foto'       => $fotoUrl,  // 🔥 sekarang kirim URL ke get_foto.php
];

echo json_encode($out);
exit;
?>
