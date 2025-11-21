<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;

include '../../db/config_api.php';
include '../../db/api_client.php';

// ==== Ambil data mobil dari API ====
$mobilList = [];
$mobilStats = [
  'total_mobil'    => 0,
  'mobil_tersedia' => 0,
  'mobil_terjual'  => 0,
];

$apiMobilResponse = api_get('admin/web_mobil_list.php');

if ($apiMobilResponse && isset($apiMobilResponse['success']) && $apiMobilResponse['success'] === true) {
    $mobilList = $apiMobilResponse['data'] ?? [];

    $mobilStats['total_mobil'] = count($mobilList);

    foreach ($mobilList as $m) {
        $status = strtolower(trim($m['status'] ?? ''));

        if ($status === 'available') {
            $mobilStats['mobil_tersedia']++;
        }

        if ($status === 'sold') {
            $mobilStats['mobil_terjual']++;
        }
    }
} else {
    die('Gagal mengambil data mobil dari API');
}

// ==== Bangun HTML untuk PDF ====
ob_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Data Mobil</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11px;
    }
    h1, h2, h3 {
      margin: 0;
      padding: 0;
    }
    .header {
      text-align: center;
      margin-bottom: 15px;
    }
    .header h1 {
      font-size: 18px;
      margin-bottom: 4px;
    }
    .header p {
      font-size: 11px;
      color: #555;
    }

    .ringkasan {
      margin-bottom: 15px;
    }
    .ringkasan table {
      width: 100%;
      border-collapse: collapse;
    }
    .ringkasan th,
    .ringkasan td {
      text-align: left;
      padding: 4px 6px;
      font-size: 11px;
    }
    .ringkasan th {
      width: 150px;
      background: #f2f2f2;
    }

    .table-mobil {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 10px;
    }
    .table-mobil th,
    .table-mobil td {
      border: 1px solid #999;
      padding: 4px 5px;
    }
    .table-mobil th {
      background: #f0f0f0;
    }

    .text-right { text-align: right; }
    .text-center { text-align: center; }
  </style>
</head>
<body>

  <div class="header">
    <h1>Laporan Data Mobil</h1>
    <p>Dicetak: <?= date('d-m-Y H:i') ?></p>
  </div>

  <div class="ringkasan">
    <h3>Ringkasan</h3>
    <table>
      <tr>
        <th>Total Mobil</th>
        <td>: <?= number_format($mobilStats['total_mobil'], 0, ',', '.') ?></td>
      </tr>
      <tr>
        <th>Mobil Tersedia (Available)</th>
        <td>: <?= number_format($mobilStats['mobil_tersedia'], 0, ',', '.') ?></td>
      </tr>
      <tr>
        <th>Mobil Terjual (Sold)</th>
        <td>: <?= number_format($mobilStats['mobil_terjual'], 0, ',', '.') ?></td>
      </tr>
    </table>
  </div>

  <h3>Detail Data Mobil</h3>
  <table class="table-mobil">
    <thead>
      <tr>
        <th class="text-center" style="width: 25px;">No</th>
        <th>Kode</th>
        <th>Nama Mobil</th>
        <th>Tahun</th>
        <th>Status</th>
        <th class="text-right">Harga (Full Price)</th>
        <th class="text-right">DP</th>
        <th class="text-right">Angsuran</th>
        <th class="text-center">Tenor</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($mobilList)): ?>
        <tr>
          <td colspan="9" class="text-center">Tidak ada data mobil.</td>
        </tr>
      <?php else: ?>
        <?php $no = 1; ?>
        <?php foreach ($mobilList as $m): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($m['kode_mobil']) ?></td>
            <td><?= htmlspecialchars($m['nama_mobil']) ?></td>
            <td class="text-center"><?= htmlspecialchars($m['tahun_mobil']) ?></td>
            <td><?= htmlspecialchars($m['status']) ?></td>
            <td class="text-right">
              Rp <?= number_format($m['full_prize'], 0, ',', '.') ?>
            </td>
            <td class="text-right">
              Rp <?= number_format($m['dp'] ?? 0, 0, ',', '.') ?>
            </td>
            <td class="text-right">
              Rp <?= number_format($m['angsuran'] ?? 0, 0, ',', '.') ?>
            </td>
            <td class="text-center">
              <?= htmlspecialchars($m['tenor'] ?? '-') ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>

<?php
$html = ob_get_clean();

// ==== Generate PDF ====
$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'landscape'); // landscape biar muat banyak kolom
$pdf->render();

$filename = 'laporan_mobil_' . date('Ymd_His') . '.pdf';
$pdf->stream($filename, ['Attachment' => true]);
exit;
