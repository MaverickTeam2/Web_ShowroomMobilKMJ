<?php
require_once '../../db/koneksi.php';

$kode = isset($_GET['kode_mobil']) ? trim($_GET['kode_mobil']) : '';
if ($kode === '') { http_response_code(400); exit('kode_mobil tidak dikirim'); }

$sql = "
  SELECT data_foto 
  FROM mobil_foto 
  WHERE kode_mobil = ? 
  ORDER BY is_primary DESC, id_foto ASC 
  LIMIT 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kode);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) { http_response_code(404); exit('Foto tidak ditemukan'); }

$stmt->bind_result($blob);
$stmt->fetch();
$stmt->close();

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->buffer($blob) ?: 'image/jpeg';

header("Content-Type: $mime");
header("Cache-Control: public, max-age=86400"); // cache 1 hari
echo $blob;
exit("");