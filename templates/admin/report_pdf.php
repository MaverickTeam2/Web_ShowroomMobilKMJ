<?php
require_once '../../vendor/autoload.php';
include '../../db/koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVuSans');

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$bulan_names = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];

$query_stats = "
    SELECT
        COUNT(*) as total_transaksi,
        COALESCE(SUM(harga_akhir), 0) as total_pendapatan,
        COALESCE(AVG(harga_akhir), 0) as rata_pendapatan,
        SUM(CASE WHEN tipe_pembayaran = 'cash' THEN 1 ELSE 0 END) as transaksi_cash,
        SUM(CASE WHEN tipe_pembayaran = 'kredit' THEN 1 ELSE 0 END) as transaksi_kredit
    FROM transaksi
    WHERE status = 'completed'
    AND MONTH(created_at) = ? AND YEAR(created_at) = ?
";

$stmt = $conn->prepare($query_stats);
$stmt->bind_param("ii", $bulan, $tahun);
$stmt->execute();

$stmt->bind_result(
    $total_transaksi,
    $total_pendapatan,
    $rata_pendapatan,
    $transaksi_cash,
    $transaksi_kredit
);
$stmt->fetch();
$stmt->close();

$stats = [
    'total_transaksi' => $total_transaksi ?? 0,
    'total_pendapatan' => $total_pendapatan ?? 0,
    'rata_pendapatan' => $rata_pendapatan ?? 0,
    'transaksi_cash' => $transaksi_cash ?? 0,
    'transaksi_kredit' => $transaksi_kredit ?? 0
];

$query_transaksi = "
    SELECT
        t.kode_transaksi, t.nama_pembeli, t.no_hp, t.tipe_pembayaran, t.harga_akhir, t.created_at,
        m.nama_mobil, m.tahun_mobil, u.full_name as admin_name
    FROM transaksi t
    LEFT JOIN mobil m ON t.kode_mobil = m.kode_mobil
    LEFT JOIN users u ON t.kode_user = u.kode_user
    WHERE t.status = 'completed'
    AND MONTH(t.created_at) = ? AND YEAR(t.created_at) = ?
    ORDER BY t.created_at ASC
";

$stmt_transaksi = $conn->prepare($query_transaksi);
$stmt_transaksi->bind_param("ii", $bulan, $tahun);
$stmt_transaksi->execute();
$result = $stmt_transaksi->get_result(); 

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan <?= $bulan_names[$bulan] ?> <?= $tahun ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
        .title { font-size: 20px; font-weight: bold; text-align: center; margin-bottom: 5px; }
        .subtitle { font-size: 14px; text-align: center; margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; font-size: 11px; }
        th { background-color: #007bff; color: white; text-align: center; }
        .summary th { background-color: #28a745; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bg-light { background-color: #f8f9fa; }
        .bg-yellow { background-color: #fff3cd; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 10px; text-align: left; }
    </style>
</head>
<body>

    <div class="title">LAPORAN PENJUALAN</div>
    <div class="subtitle">Kaliwates Mobil Jember</div>
    <div class="subtitle"><strong>Periode: <?= $bulan_names[$bulan] ?> <?= $tahun ?></strong></div>

    <table class="summary">
        <tr><th colspan="2">RINGKASAN STATISTIK</th></tr>
        <tr class="bg-light"><td><strong>Total Transaksi</strong></td><td class="text-right"><?= $stats['total_transaksi'] ?> transaksi</td></tr>
        <tr><td><strong>Total Pendapatan</strong></td><td class="text-right">Rp <?= number_format($stats['total_pendapatan'], 0, ',', '.') ?></td></tr>
        <tr class="bg-light"><td><strong>Rata-rata</strong></td><td class="text-right">Rp <?= number_format($stats['rata_pendapatan'], 0, ',', '.') ?></td></tr>
        <tr><td><strong>Cash</strong></td><td class="text-right"><?= $stats['transaksi_cash'] ?> transaksi</td></tr>
        <tr class="bg-light"><td><strong>Kredit</strong></td><td class="text-right"><?= $stats['transaksi_kredit'] ?> transaksi</td></tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Pembeli</th>
                <th width="25%">Mobil</th>
                <th width="10%">Tipe</th>
                <th width="18%">Harga (Rp)</th>
                <th width="10%">Admin</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    $total += $row['harga_akhir'];
            ?>
                <tr class="<?= $no % 2 == 0 ? 'bg-light' : '' ?>">
                    <td class="text-center"><?= $no ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                    <td><?= htmlspecialchars($row['nama_pembeli']) ?></td>
                    <td><?= htmlspecialchars($row['nama_mobil']) ?> (<?= $row['tahun_mobil'] ?>)</td>
                    <td class="text-center"><?= strtoupper($row['tipe_pembayaran']) ?></td>
                    <td class="text-right"><?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['admin_name']) ?></td>
                </tr>
            <?php
                $no++;
                endwhile;
            else:
            ?>
                <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
            <?php endif; ?>
            <tr class="bg-yellow">
                <td colspan="5" class="text-center"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d F Y H:i:s') ?> WIB
    </div>

</body>
</html>
<?php
$html = ob_get_clean();
$stmt_transaksi->close();

// === BUAT PDF ===
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$filename = 'Laporan_Penjualan_' . $bulan_names[$bulan] . '_' . $tahun . '.pdf';
$dompdf->stream($filename, ['Attachment' => true]);
?>