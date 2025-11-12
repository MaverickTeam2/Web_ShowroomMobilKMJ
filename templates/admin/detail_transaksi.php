<?php
header('Content-Type: application/json');
require_once '../../db/koneksi.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ID transaksi tidak dikirim']);
    exit;
}

$query = "SELECT 
            t.id_transaksi,
            t.nama_pembeli,
            t.no_hp,
            t.tipe_pembayaran,
            t.harga_akhir,
            t.created_at,
            t.status,
            m.nama_mobil,
            m.merk,
            m.tahun,
            u.full_name AS kasir
          FROM transaksi t
          LEFT JOIN mobil m ON t.id_mobil = m.id_mobil
          LEFT JOIN users u ON t.user_id = u.id
          WHERE t.id_transaksi = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
  echo json_encode([
    'status' => 'error',
    'message' => 'Data tidak ditemukan atau kolom tidak cocok',
    'debug_sql' => $query,
    'debug_id' => $id
  ]);
  exit;
}


echo json_encode($data ?: ['status' => 'error', 'message' => 'Data tidak ditemukan']);
exit;
