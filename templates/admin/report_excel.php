<?php
include '../../db/koneksi.php';

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

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
    AND MONTH(created_at) = ?
    AND YEAR(created_at) = ?
";
$stmt = $conn->prepare($query_stats);
$stmt->bind_param("ii", $bulan, $tahun);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

// Query transaksi detail
$query_transaksi = "
    SELECT
        t.kode_transaksi,
        t.nama_pembeli,
        t.no_hp,
        t.tipe_pembayaran,
        t.harga_akhir,
        t.created_at,
        m.nama_mobil,
        m.tahun_mobil,
        m.jenis_kendaraan,
        u.full_name as admin_name
    FROM transaksi t
    LEFT JOIN mobil m ON t.kode_mobil = m.kode_mobil
    LEFT JOIN users u ON t.kode_user = u.kode_user
    WHERE t.status = 'completed'
    AND MONTH(t.created_at) = ?
    AND YEAR(t.created_at) = ?
    ORDER BY t.created_at ASC
";
$stmt_transaksi = $conn->prepare($query_transaksi);
$stmt_transaksi->bind_param("ii", $bulan, $tahun);
$stmt_transaksi->execute();
$result_transaksi = $stmt_transaksi->get_result();

$filename = 'Laporan_Penjualan_' . $bulan_names[$bulan] . '_' . $tahun . '.xls';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; font-weight: bold; }
        .title { font-size: 18px; font-weight: bold; text-align: center; }
        .subtitle { font-size: 14px; text-align: center; margin-bottom: 20px; }
        .summary-header { background-color: #007bff; color: white; font-weight: bold; }
        .summary-row { background-color: #f8f9fa; }
        .number { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="10" class="title">LAPORAN PENJUALAN</td>
        </tr>
        <tr>
            <td colspan="10" class="subtitle">Kaliwates Mobil Jember</td>
        </tr>
        <tr>
            <td colspan="10" class="subtitle"><strong>Periode: <?= $bulan_names[$bulan] ?> <?= $tahun ?></strong></td>
        </tr>
        <tr><td colspan="10">&nbsp;</td></tr>
    </table>

    <table>
        <tr>
            <td colspan="2" class="summary-header">RINGKASAN STATISTIK</td>
        </tr>
        <tr class="summary-row">
            <td width="35%"><strong>Total Transaksi</strong></td>
            <td><?= $stats['total_transaksi'] ?> transaksi</td>
        </tr>
        <tr>
            <td><strong>Total Pendapatan</strong></td>
            <td>Rp <?= number_format($stats['total_pendapatan'], 0, ',', '.') ?></td>
        </tr>
        <tr class="summary-row">
            <td><strong>Rata-rata Transaksi</strong></td>
            <td>Rp <?= number_format($stats['rata_pendapatan'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><strong>Transaksi Cash</strong></td>
            <td><?= $stats['transaksi_cash'] ?> transaksi</td>
        </tr>
        <tr class="summary-row">
            <td><strong>Transaksi Kredit</strong></td>
            <td><?= $stats['transaksi_kredit'] ?> transaksi</td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
    </table>

    <table>
        <tr>
            <td colspan="10" class="summary-header">DETAIL TRANSAKSI</td>
        </tr>
        <tr>
            <th class="center">No</th>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th>Pembeli</th>
            <th>No. HP</th>
            <th>Mobil</th>
            <th>Jenis Kendaraan</th>
            <th class="center">Pembayaran</th>
            <th class="number">Harga (Rp)</th>
            <th>Admin</th>
        </tr>
        <?php
        $no = 1;
        $total_harga = 0;
        if ($result_transaksi->num_rows > 0) {
            while ($row = $result_transaksi->fetch_assoc()) {
                $total_harga += $row['harga_akhir'];
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td><?= htmlspecialchars($row['kode_transaksi']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                    <td><?= htmlspecialchars($row['nama_pembeli']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td><?= htmlspecialchars($row['nama_mobil']) ?> (<?= $row['tahun_mobil'] ?>)</td>
                    <td><?= htmlspecialchars($row['jenis_kendaraan']) ?></td>
                    <td class="center"><?= strtoupper($row['tipe_pembayaran']) ?></td>
                    <td class="number"><?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['admin_name']) ?></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="10" class="center">Tidak ada transaksi pada periode ini</td>
            </tr>
            <?php
        }
        ?>
        <tr style="background-color: #ffeb3b; font-weight: bold;">
            <td colspan="8" class="number"><strong>TOTAL:</strong></td>
            <td class="number"><strong>Rp <?= number_format($total_harga, 0, ',', '.') ?></strong></td>
            <td></td>
        </tr>
        <tr><td colspan="10">&nbsp;</td></tr>
        <tr>
            <td colspan="10"><em>Dicetak pada: <?= date('d F Y H:i:s') ?></em></td>
        </tr>
    </table>
</body>
</html>