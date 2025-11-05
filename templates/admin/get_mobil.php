<?php
header('Content-Type: application/json');
require_once '../../db/koneksi.php';

$id = $_GET['id'] ?? '';
if (!$id) {
  echo json_encode(['status' => 'error', 'message' => 'ID mobil tidak dikirim']);
  exit;
}

$stmt = $conn->prepare("SELECT id_mobil, nama_mobil, merk, tahun, harga, dp, km, foto FROM mobil WHERE id_mobil = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if ($data) {
  echo json_encode($data);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Mobil tidak ditemukan']);
}
exit;
?>