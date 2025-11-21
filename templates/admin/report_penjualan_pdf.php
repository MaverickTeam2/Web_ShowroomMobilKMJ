<?php
require __DIR__ . '/../../vendor/autoload.php'; // path sudah benar

use Dompdf\Dompdf;

include '../../db/config_api.php';
include '../../db/api_client.php';

// Ambil data API
$apiResponse = api_get('admin/report_penjualan.php?status=all');

$laporan = [];
$ringkasan = [
  'total_laporan' => 0,
  'total_pendapatan' => 0,
  'total_transaksi' => 0,
  'rata_rata_transaksi' => 0,
];

if ($apiResponse && isset($apiResponse['status']) && $apiResponse['status'] === true) {
  $data = $apiResponse['data'] ?? [];
  $laporan = $data['items'] ?? [];

  if (isset($data['ringkasan'])) {
    $ringkasan = $data['ringkasan'];
  }
} else {
  die("Gagal mengambil data dari API");
}

// ====================== HTML UNTUK PDF ======================
ob_start();
?>

<style>
  body {
    font-family: Arial, sans-serif;
    font-size: 12px;
  }

  h1 {
    text-align: center;
    margin-bottom: 5px;
  }

  .info {
    text-align: center;
    margin-bottom: 20px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }

  table th,
  table td {
    border: 1px solid #555;
    padding: 6px;
  }

  table th {
    background: #efefef;
  }
</style>

<h1>Laporan Penjualan</h1>
<div class="info">Dicetak: <?= date('d-m-Y H:i') ?></div>

<h3>Ringkasan</h3>
<table>
  <tr>
    <th>Total Laporan</th>
    <td><?= $ringkasan['total_laporan'] ?></td>
  </tr>
  <tr>
    <th>Total Pendapatan</th>
    <td>Rp <?= number_format($ringkasan['total_pendapatan'], 0, ',', '.') ?></td>
  </tr>
  <tr>
    <th>Total Transaksi</th>
    <td><?= $ringkasan['total_transaksi'] ?></td>
  </tr>
  <tr>
    <th>Rata-rata Transaksi</th>
    <td>Rp <?= number_format($ringkasan['rata_rata_transaksi'], 0, ',', '.') ?></td>
  </tr>
</table>

<h3>Detail Laporan</h3>
<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Laporan</th>
      <th>Periode</th>
      <th>Total Transaksi</th>
      <th>Total Pendapatan</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($laporan)): ?>
      <tr>
        <td colspan="5" align="center">Tidak ada data</td>
      </tr>
    <?php else: ?>
      <?php $no = 1;
      foreach ($laporan as $row): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['nama_laporan']) ?></td>
          <td><?= htmlspecialchars($row['periode']) ?></td>
          <td><?= $row['total_transaksi'] ?></td>
          <td>Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<?php
$html = ob_get_clean();

// ============== GENERATE PDF ==============
$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();

// Auto download
$pdf->stream("laporan_penjualan.pdf", ["Attachment" => true]);
