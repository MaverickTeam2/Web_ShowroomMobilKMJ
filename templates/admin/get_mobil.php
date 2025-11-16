<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../db/koneksi.php';

// ambil kode mobil dari ?id=...
$kode = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($kode === '') {
  echo json_encode([
    'status'  => 'error',
    'message' => 'Kode mobil tidak dikirim'
  ]);
  exit;
}

// ambil data dari tabel mobil
$sql = "
  SELECT 
    kode_mobil,
    nama_mobil,
    tahun_mobil,
    jarak_tempuh,
    uang_muka,
    tenor,
    angsuran,
    jenis_kendaraan
  FROM mobil
  WHERE kode_mobil = ?
  LIMIT 1
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
  echo json_encode([
    'status'  => 'error',
    'message' => 'Gagal prepare query: ' . $conn->error
  ]);
  exit;
}

$stmt->bind_param('s', $kode);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if (!$row) {
  echo json_encode([
    'status'  => 'error',
    'message' => 'Mobil tidak ditemukan'
  ]);
  exit;
}

// hitung harga kasar (boleh kamu ubah rumusnya kalau mau)
$uang_muka = (int)($row['uang_muka'] ?? 0);
$angsuran  = (int)($row['angsuran'] ?? 0);
$tenor     = (int)($row['tenor'] ?? 0);
$harga     = $uang_muka + ($angsuran * $tenor);

// --- cari foto di tabel mobil_foto (optional) ---
$placeholderUrl = '../../assets/img/car-placeholder.jpeg'; // <-- bikin file ini sendiri ya

$fotoUrl = $placeholderUrl; // default abu-abu

$sqlFoto = "
  SELECT nama_file 
  FROM mobil_foto 
  WHERE kode_mobil = ?
  ORDER BY urutan ASC, id_foto ASC
  LIMIT 1
";
$stmt2 = $conn->prepare($sqlFoto);
if ($stmt2) {
  $stmt2->bind_param('s', $kode);
  $stmt2->execute();
  $resFoto = $stmt2->get_result();
  if ($fotoRow = $resFoto->fetch_assoc()) {
    // SESUAIKAN path upload-mu:
    $fotoUrl = '../../uploads/mobil/' . $fotoRow['nama_file'];
  }
  $stmt2->close();
}

// respon JSON ke JS
echo json_encode([
  'status'      => 'ok',
  'kode_mobil'  => $row['kode_mobil'],
  'nama_mobil'  => $row['nama_mobil'],
  'tahun'       => $row['tahun_mobil'],
  'km'          => (int)($row['jarak_tempuh'] ?? 0),
  'dp'          => $uang_muka,
  'tenor'       => $tenor,
  'angsuran'    => $angsuran,
  'harga'       => $harga,
  'tipe'        => $row['jenis_kendaraan'] ?? '-',
  'foto'        => $fotoUrl,
]);
exit;
