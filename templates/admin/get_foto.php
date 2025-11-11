<?php
require_once '../../db/koneksi.php';

$id = isset($_GET['id_mobil']) ? (int)$_GET['id_mobil'] : 0;
if ($id <= 0) { http_response_code(400); exit('Invalid ID'); }

// Ambil 1 foto (utamakan is_primary=1 kalau nanti dipakai)
$sql = "SELECT data_foto FROM mobil_foto WHERE id_mobil = ? ORDER BY is_primary DESC, id_foto ASC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) { http_response_code(404); exit('Foto tidak ditemukan'); }

$stmt->bind_result($blob);
$stmt->fetch();
$stmt->close();

// Deteksi mime secara aman
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime  = $finfo->buffer($blob) ?: 'image/jpeg';

header("Content-Type: $mime");
header("Cache-Control: public, max-age=86400"); // cache 1 hari
echo $blob;
