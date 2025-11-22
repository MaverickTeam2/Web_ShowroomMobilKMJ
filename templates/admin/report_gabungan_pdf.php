<?php
// web/report_gabungan_pdf.php

require __DIR__ . '/../../vendor/autoload.php'; // sesuaikan path ke vendor

use Dompdf\Dompdf;
use Dompdf\Options;

// ========== 1. Ambil data dari API get_laporan_gabungan ==========
$apiUrl = 'http://localhost/API_kmj/admin/get_laporan_gabungan.php';
// sesuaikan base URL kamu, misal http://localhost/showroom/API_kmj/admin/get_laporan_gabungan.php

$json = file_get_contents($apiUrl);
$data = json_decode($json, true);

$transaksi = $data['data']['transaksi'] ?? [];
$mobil = $data['data']['mobil'] ?? [];

// ========== 2. Bangun HTML untuk dimasukkan ke PDF ==========
ob_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan Gabungan</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 10pt;
    }

    h1,
    h2 {
      text-align: center;
      margin-bottom: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 4px;
    }

    th {
      background: #eee;
    }
  </style>
</head>

<body>

  <h1>Laporan Gabungan</h1>
  <p style="text-align:center; margin-bottom:20px;">Showroom Mobil KMJ</p>

  <!-- Tabel Transaksi -->
  <h2>Data Transaksi</h2>
  <table>
    <thead>
      <tr>
        <th>Kode</th>
        <th>Nama Pembeli</th>
        <th>Mobil</th>
        <th>Tipe Pembayaran</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Harga Akhir</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($transaksi)): ?>
        <tr>
          <td colspan="7" style="text-align:center;">Belum ada transaksi</td>
        </tr>
      <?php else: ?>
        <?php foreach ($transaksi as $t): ?>
          <tr>
            <td><?= htmlspecialchars($t['kode_transaksi']) ?></td>
            <td><?= htmlspecialchars($t['nama_pembeli']) ?></td>
            <td><?= htmlspecialchars($t['nama_mobil']) ?></td>
            <td><?= htmlspecialchars($t['tipe_pembayaran']) ?></td>
            <td><?= htmlspecialchars($t['status']) ?></td>
            <td><?= htmlspecialchars($t['tanggal']) ?></td>
            <td>Rp <?= number_format($t['harga_akhir'], 0, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Tabel Mobil -->
  <h2>Data Mobil</h2>
  <table>
    <thead>
      <tr>
        <th>Kode</th>
        <th>Nama Mobil</th>
        <th>Tahun</th>
        <th>Jenis</th>
        <th>Status</th>
        <th>Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($mobil)): ?>
        <tr>
          <td colspan="6" style="text-align:center;">Belum ada data mobil</td>
        </tr>
      <?php else: ?>
        <?php foreach ($mobil as $m): ?>
          <tr>
            <td><?= htmlspecialchars($m['kode_mobil']) ?></td>
            <td><?= htmlspecialchars($m['nama_mobil']) ?></td>
            <td><?= htmlspecialchars($m['tahun_mobil']) ?></td>
            <td><?= htmlspecialchars($m['jenis_kendaraan']) ?></td>
            <td><?= htmlspecialchars($m['status']) ?></td>
            <td>Rp <?= number_format($m['full_prize'], 0, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

</body>

</html>

<?php
$html = ob_get_clean();

// ========== 3. Render HTML jadi PDF pakai Dompdf ==========
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Inline di browser (supaya kebuka tab baru, nggak langsung download)
$dompdf->stream('laporan_gabungan.pdf', ['Attachment' => true]);
