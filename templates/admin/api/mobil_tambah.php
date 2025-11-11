<?php
ob_clean();
header('Content-Type: application/json');
include("../../../db/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Metode tidak valid']);
  exit;
}

try {
  // =========================
  // Ambil data mobil dari form
  // =========================
  $nama_mobil = $_POST['nama_mobil'] ?? '';
  $tahun_mobil = (int) ($_POST['tahun'] ?? 0);
  $jarak_tempuh = (int) ($_POST['jarak_tempuh'] ?? 0);
  $uang_muka = (int) ($_POST['uang_muka'] ?? 0);
  $tenor = (int) ($_POST['tenor'] ?? 0);
  $angsuran = (int) ($_POST['angsuran'] ?? 0);
  $jenis_kendaraan = $_POST['tipe_kendaraan'] ?? '';
  $sistem_penggerak = $_POST['sistem_penggerak'] ?? '';
  $tipe_bahan_bakar = $_POST['bahan_bakar'] ?? '';
  $warna_interior = $_POST['warna_interior'] ?? '';
  $warna_exterior = $_POST['warna_exterior'] ?? '';
  $kode_user = 'US00000001'; // nanti bisa ambil dari $_SESSION['kode_user']

  // =========================
  // Ambil fitur yang dicentang (id_fitur)
  // =========================
  $fitur = $_POST['fitur'] ?? []; // array id_fitur

  // =========================
  // Ambil kode mobil otomatis
  // =========================
  $kodeQuery = $conn->query("SELECT generate_kode_mobil() AS kode");
  $kodeMobil = $kodeQuery->fetch_assoc()['kode'];

  // =========================
  // Insert data ke tabel mobil
  // =========================
  $sql = "INSERT INTO mobil (
      kode_mobil, kode_user, nama_mobil, tahun_mobil, jarak_tempuh,
      uang_muka, tenor, angsuran, jenis_kendaraan, sistem_penggerak,
      tipe_bahan_bakar, warna_interior, warna_exterior
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "sssiiiissssss",
    $kodeMobil,
    $kode_user,
    $nama_mobil,
    $tahun_mobil,
    $jarak_tempuh,
    $uang_muka,
    $tenor,
    $angsuran,
    $jenis_kendaraan,
    $sistem_penggerak,
    $tipe_bahan_bakar,
    $warna_interior,
    $warna_exterior
  );

  if (!$stmt->execute()) {
    throw new Exception("❌ Gagal insert mobil: " . $stmt->error);
  }

  // =========================
  // BAGIAN MOBIL_FITUR
  // Insert fitur yang dipilih ke tabel mobil_fitur
  // Dengan Id_detail_fitur otomatis IDF01, IDF02, dst.
  // =========================
  $kodeMobilBaru = $kodeMobil;

  if (!empty($fitur)) {
    // Ambil kode terakhir dari mobil_fitur
    $result = $conn->query("SELECT Id_detail_fitur FROM mobil_fitur ORDER BY Id_detail_fitur DESC LIMIT 1");
    $row = $result->fetch_assoc();

    if ($row) {
      $newNum = (int) $row['Id_detail_fitur'] + 1;
    } else {
      $newNum = 1;
    }

    $stmtFitur = $conn->prepare("INSERT INTO mobil_fitur (Id_detail_fitur, kode_mobil, id_fitur) VALUES (?, ?, ?)");
    foreach ($fitur as $id_fitur) {
      $id_detail_fitur = $newNum; // langsung angka
      $stmtFitur->bind_param("isi", $id_detail_fitur, $kodeMobilBaru, $id_fitur);
      $stmtFitur->execute();
      $newNum++; // naikkan untuk fitur berikutnya
    }
    $stmtFitur->close();
  }

  $stmt->close();
  $conn->close();

  echo json_encode(['success' => true, 'message' => '✅ Mobil & Fitur berhasil ditambahkan!']);

} catch (Exception $e) {
  echo json_encode(['success' => false, 'message' => '⚠️ Error: ' . $e->getMessage()]);
}
