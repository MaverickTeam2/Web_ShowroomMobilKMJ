<?php
include '../../db/koneksi.php';

$kode = isset($_GET['kode']) ? $_GET['kode'] : '';

if (empty($kode)) {
    echo '<div class="alert alert-danger">Kode transaksi tidak valid</div>';
    exit;
}

$query = "
    SELECT
        t.*,
        m.nama_mobil,
        m.tahun_mobil,
        m.jenis_kendaraan,
        m.warna_exterior,
        m.warna_interior,
        u.full_name as admin_name,
        u.email as admin_email
    FROM transaksi t
    LEFT JOIN mobil m ON t.kode_mobil = m.kode_mobil
    LEFT JOIN users u ON t.kode_user = u.kode_user
    WHERE t.kode_transaksi = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $kode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo '<div class="alert alert-warning">Transaksi tidak ditemukan</div>';
    exit;
}

$data = $result->fetch_assoc();

$query_jaminan = "
    SELECT j.nama_jaminan, dj.keterangan
    FROM detail_jaminan dj
    JOIN jaminan j ON dj.id_jaminan = j.id_jaminan
    WHERE dj.kode_transaksi = ?
";
$stmt_jaminan = $conn->prepare($query_jaminan);
$stmt_jaminan->bind_param("s", $kode);
$stmt_jaminan->execute();
$result_jaminan = $stmt_jaminan->get_result();
?>

<style>
.btn-action {
    padding: 12px 28px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-action i {
    font-size: 18px;
}

.btn-back {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    color: white;
}

.btn-back:hover {
    background: linear-gradient(135deg, #5a6268 0%, #4e555b 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(108, 117, 125, 0.3);
    color: white;
}

.btn-print {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
}

.btn-print:hover {
    background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(231, 76, 60, 0.3);
}

.action-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

@media print {
    .action-buttons,
    .btn-action {
        display: none !important;
    }
}

.detail-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 32px;
    margin-bottom: 24px;
    border: 1px solid #e3e6e8;
    transition: all 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.card-header-custom {
    border-bottom: 3px solid #e8ecef;
    padding-bottom: 16px;
    margin-bottom: 24px;
    background: linear-gradient(90deg, rgba(52, 152, 219, 0.05) 0%, transparent 100%);
    padding: 12px 16px;
    border-radius: 8px;
    margin: -10px -10px 24px -10px;
}

.card-header-custom h6 {
    color: #1a2332;
    font-size: 20px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-header-custom h6 i {
    margin-right: 12px;
    color: #3498db;
    font-size: 22px;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(52, 152, 219, 0.1);
    border-radius: 8px;
}

.info-table {
    width: 100%;
}

.info-table tr {
    border-bottom: 1px solid #f0f2f5;
}

.info-table tr:last-child {
    border-bottom: none;
}

.info-table td {
    padding: 16px 0;
    vertical-align: middle;
}

.info-label {
    color: #6c757d;
    font-size: 16px;
    font-weight: 600;
    width: 45%;
}

.info-value {
    color: #212529;
    font-size: 17px;
    font-weight: 600;
}

.badge-custom {
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-block;
}

.badge-success-custom {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    box-shadow: 0 2px 8px rgba(21, 87, 36, 0.2);
}

.badge-warning-custom {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    color: #856404;
    box-shadow: 0 2px 8px rgba(133, 100, 4, 0.2);
}

.badge-info-custom {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
    box-shadow: 0 2px 8px rgba(12, 84, 96, 0.2);
}

.price-highlight {
    color: #27ae60;
    font-size: 28px;
    font-weight: 800;
    text-shadow: 0 2px 4px rgba(39, 174, 96, 0.1);
}

.table-jaminan {
    width: 100%;
    border-collapse: collapse;
    margin-top: 16px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.table-jaminan thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.table-jaminan th {
    padding: 16px;
    text-align: left;
    font-size: 16px;
    font-weight: 700;
    color: #ffffff;
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-jaminan td {
    padding: 16px;
    font-size: 16px;
    color: #495057;
    border: 1px solid #e9ecef;
    background: #fff;
}

.table-jaminan tbody tr {
    transition: all 0.2s ease;
}

.table-jaminan tbody tr:hover {
    background: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.section-divider {
    height: 2px;
    background: linear-gradient(to right, transparent, #3498db, transparent);
    margin: 28px 0;
}

.header-badge-section {
    display: flex;
    align-items: center;
    gap: 12px;
}

@media print {
    .detail-card {
        box-shadow: none;
        border: 1px solid #ddd;
    }
    .detail-card:hover {
        transform: none;
    }
}
</style>

    <div class="row mb-4">
        <div class="col-12">
            <div class="detail-card" style="background: linear-gradient(135deg, #1c1c1fff 0%, #437c5dff 100%); color: white; padding: 40px;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h3 class="mb-2" style="font-weight: 800; font-size: 32px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            <i class="fas fa-file-invoice" style="margin-right: 12px;"></i>
                            Detail Transaksi
                        </h3>
                        <p class="mb-0" style="font-size: 18px; opacity: 0.95; font-weight: 500;">
                            <i class="fas fa-hashtag" style="margin-right: 6px;"></i>
                            <?= htmlspecialchars($data['kode_transaksi']) ?>
                        </p>
                        <p class="mb-0 mt-1" style="font-size: 16px; opacity: 0.9;">
                            <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>
                            <?= date('d F Y, H:i', strtotime($data['created_at'])) ?> WIB
                        </p>
                    </div>
                    <div class="header-badge-section">
                        <span class="badge-custom badge-<?= $data['status'] == 'completed' ? 'success' : 'warning' ?>-custom" style="font-size: 16px;">
                            <i class="fas fa-check-circle" style="margin-right: 6px;"></i>
                            <?= strtoupper($data['status']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="detail-card">
                <div class="card-header-custom">
                    <h6><i class="fas fa-file-invoice"></i> Informasi Transaksi</h6>
                </div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">
                            <i class="fas fa-barcode" style="margin-right: 8px; color: #3498db;"></i>
                            Kode Transaksi
                        </td>
                        <td class="info-value"><?= htmlspecialchars($data['kode_transaksi']) ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">
                            <i class="fas fa-calendar-day" style="margin-right: 8px; color: #3498db;"></i>
                            Tanggal Transaksi
                        </td>
                        <td class="info-value"><?= date('d F Y, H:i', strtotime($data['created_at'])) ?> WIB</td>
                    </tr>
                    <tr>
                        <td class="info-label">
                            <i class="fas fa-info-circle" style="margin-right: 8px; color: #3498db;"></i>
                            Status
                        </td>
                        <td>
                            <span class="badge-custom badge-<?= $data['status'] == 'completed' ? 'success' : 'warning' ?>-custom">
                                <i class="fas fa-check-circle" style="margin-right: 4px;"></i>
                                <?= strtoupper($data['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">
                            <i class="fas fa-credit-card" style="margin-right: 8px; color: #3498db;"></i>
                            Tipe Pembayaran
                        </td>
                        <td>
                            <span class="badge-custom badge-<?= $data['tipe_pembayaran'] == 'cash' ? 'success' : 'info' ?>-custom">
                                <i class="fas fa-<?= $data['tipe_pembayaran'] == 'cash' ? 'money-bill-wave' : 'credit-card' ?>" style="margin-right: 4px;"></i>
                                <?= strtoupper($data['tipe_pembayaran']) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">
                            <i class="fas fa-money-bill-wave" style="margin-right: 8px; color: #27ae60;"></i>
                            Harga Akhir
                        </td>
                        <td class="price-highlight">
                            <i class="fas fa-rupiah-sign" style="margin-right: 4px;"></i>
                            Rp <?= number_format($data['harga_akhir'], 0, ',', '.') ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Informasi Pembeli -->
        <div class="col-md-6">
            <div class="detail-card">
                <div class="card-header-custom">
                    <h6><i class="fas fa-user"></i> Informasi Pembeli</h6>
                </div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">
                            <i class="fas fa-user-circle" style="margin-right: 8px; color: #3498db;"></i>
                            Nama Pembeli
                        </td>
                        <td class="info-value"><?= htmlspecialchars($data['nama_pembeli']) ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">
                            <i class="fas fa-mobile-alt" style="margin-right: 8px; color: #3498db;"></i>
                            No. Handphone
                        </td>
                        <td class="info-value">
                            <a href="tel:<?= htmlspecialchars($data['no_hp']) ?>" style="color: #3498db; text-decoration: none; font-weight: 600;">
                                <?= htmlspecialchars($data['no_hp']) ?>
                            </a>
                        </td>
                    </tr>
                </table>

                <div class="section-divider"></div>

                <div class="card-header-custom" style="border: none; padding-bottom: 8px;">
                    <h6><i class="fas fa-user-tie"></i> Admin Penanggungjawab</h6>
                </div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">Nama Admin</td>
                        <td class="info-value"><?= htmlspecialchars($data['admin_name']) ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Email</td>
                        <td class="info-value">
                            <i class="fas fa-envelope" style="color: #3498db; margin-right: 5px;"></i>
                            <?= htmlspecialchars($data['admin_email']) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="detail-card">
                <div class="card-header-custom">
                    <h6><i class="fas fa-car"></i> Informasi Mobil</h6>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="info-table">
                            <tr>
                                <td class="info-label">Kode Mobil</td>
                                <td class="info-value"><?= htmlspecialchars($data['kode_mobil']) ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Nama Mobil</td>
                                <td class="info-value"><?= htmlspecialchars($data['nama_mobil']) ?> (<?= $data['tahun_mobil'] ?>)</td>
                            </tr>
                            <tr>
                                <td class="info-label">Jenis Kendaraan</td>
                                <td class="info-value"><?= htmlspecialchars($data['jenis_kendaraan']) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="info-table">
                            <tr>
                                <td class="info-label">Warna Exterior</td>
                                <td class="info-value">
                                    <span style="display: inline-block; width: 16px; height: 16px; border-radius: 3px; background: #<?= htmlspecialchars($data['warna_exterior']) ?>; border: 1px solid #ddd; margin-right: 8px; vertical-align: middle;"></span>
                                    <?= htmlspecialchars($data['warna_exterior']) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="info-label">Warna Interior</td>
                                <td class="info-value">
                                    <span style="display: inline-block; width: 16px; height: 16px; border-radius: 3px; background: #<?= htmlspecialchars($data['warna_interior']) ?>; border: 1px solid #ddd; margin-right: 8px; vertical-align: middle;"></span>
                                    <?= htmlspecialchars($data['warna_interior']) ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($result_jaminan->num_rows > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="detail-card">
                <div class="card-header-custom">
                    <h6><i class="fas fa-shield-alt"></i> Jaminan</h6>
                </div>
                <table class="table-jaminan">
                    <thead>
                        <tr>
                            <th width="30%">Jenis Jaminan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($jaminan = $result_jaminan->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($jaminan['nama_jaminan']) ?></strong></td>
                            <td><?= htmlspecialchars($jaminan['keterangan']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<div class="container-fluid">
    <div class="action-buttons">
        <a href="javascript:history.back()" class="btn-action btn-back">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        <button onclick="cetakPDF()" class="btn-action btn-print">
            <i class="fas fa-file-pdf"></i>
            Cetak PDF
        </button>
    </div>

<script>
function cetakPDF() {
    const originalTitle = document.title;

    document.title = 'Detail_Transaksi_<?= htmlspecialchars($data['kode_transaksi']) ?>';

    const printStyle = document.createElement('style');
    printStyle.textContent = `
        @media print {
            body {
                margin: 0;
                padding: 20px;
            }
            .container-fluid {
                width: 100%;
                max-width: 100%;
            }
            .detail-card {
                page-break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #ddd;
                margin-bottom: 15px;
            }
            .detail-card:hover {
                transform: none !important;
            }
            .action-buttons,
            .btn-action {
                display: none !important;
            }
            .table-jaminan {
                page-break-inside: avoid;
            }
        }
    `;
    document.head.appendChild(printStyle);

    window.print();

    document.title = originalTitle;

    setTimeout(() => {
        document.head.removeChild(printStyle);
    }, 1000);
}

document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        cetakPDF();
    }
});
</script>