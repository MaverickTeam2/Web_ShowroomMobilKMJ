<?php
$title = "Detail Laporan";
include 'partials/header.php';
include 'partials/sidebar.php';
include '../../db/koneksi.php';

$type  = $_GET['type'] ?? '';
$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$bulan_nama = [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
    7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];
?>

<section id="content">
  <nav><i class='bx bx-menu'></i></nav>

  <main id="main-content" class="p-4">

    <div class="d-flex gap-2 mb-3">
  <a href="report_detail_pdf.php?type=<?= $type ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>"
     target="_blank" class="btn btn-primary btn-sm">PDF</a>
  <a href="report_detail_excel.php?type=<?= $type ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>"
     class="btn btn-success btn-sm">Excel</a>
</div>

    <div class="head-title d-flex justify-content-between align-items-center mb-4">
      <div class="left">
        <h1 class="h3 mb-1">
          <?= ucwords(str_replace('_',' ',$type)) ?>
        </h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a href="report.php">Report</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li class="active">Detail</li>
        </ul>
      </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-body">

        <?php if ($type === 'daily'): ?>
          <!-- DAILY SALES SUMMARY -->
          <h5>Ringkasan Penjualan Harian – <?= $bulan_nama[$bulan] ?> <?= $tahun ?></h5>
          <div id="dailyChart" style="height:350px;"></div>

          <?php
          $q = "SELECT DAY(created_at) AS hari, COUNT(*) AS jml, SUM(harga_akhir) AS pendapatan
                FROM transaksi
                WHERE status='completed' AND MONTH(created_at)=? AND YEAR(created_at)=?
                GROUP BY DAY(created_at) ORDER BY hari";
          $st = $conn->prepare($q);
          $st->bind_param('ii',$bulan,$tahun);
          $st->execute();
          $res = $st->get_result();

          $days = []; $counts = []; $revenues = [];
          while($r=$res->fetch_assoc()){
              $days[] = $r['hari'];
              $counts[] = $r['jml'];
              $revenues[] = $r['pendapatan'];
          }
          ?>
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <script>
            new Chart(document.getElementById('dailyChart'), {
              type:'line',
              data:{
                labels:<?= json_encode($days) ?>,
                datasets:[
                  {label:'Transaksi', data:<?= json_encode($counts) ?>, borderColor:'#0d6efd', fill:false},
                  {label:'Pendapatan (Rp)', data:<?= json_encode($revenues) ?>, borderColor:'#198754', fill:false, yAxisID:'y1'}
                ]
              },
              options:{scales:{y:{beginAtZero:true}, y1:{position:'right', beginAtZero:true}}}
            });
          </script>
          <div class="action-buttons">
                <a href="javascript:history.back()" class="btn-primary me-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
          

        <?php elseif ($type === 'top_models'): ?>
          <!-- TOP SELLING MODELS -->
          <h5>Top 5 Model Terlaris</h5>
          <?php
          $q = "SELECT m.nama_mobil, m.tahun_mobil, COUNT(*) AS jml
                FROM transaksi t
                JOIN mobil m ON t.kode_mobil=m.kode_mobil
                WHERE t.status='completed' AND MONTH(t.created_at)=? AND YEAR(t.created_at)=?
                GROUP BY t.kode_mobil ORDER BY jml DESC LIMIT 5";
          $st = $conn->prepare($q);
          $st->bind_param('ii',$bulan,$tahun);
          $st->execute();
          $res = $st->get_result();
          ?>
          <table class="table table-hover">
            <thead class="table-light"><tr><th>#</th><th>Mobil</th><th>Terjual</th></tr></thead>
            <tbody>
            <?php $no=1; while($r=$res->fetch_assoc()): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['nama_mobil']).' ('.$r['tahun_mobil'].')' ?></td>
                <td><span class="badge bg-success"><?= $r['jml'] ?></span></td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
          
            <div class="action-buttons">
                <a href="javascript:history.back()" class="btn-primary me-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>

        <?php elseif ($type === 'team_performance'): ?>
          <!-- SALES TEAM PERFORMANCE -->
          <h5>Performa Tim Sales</h5>
          <?php
          $q = "SELECT u.full_name, COUNT(*) AS transaksi, SUM(t.harga_akhir) AS pendapatan
                FROM transaksi t
                JOIN users u ON t.kode_user=u.kode_user
                WHERE t.status='completed' AND MONTH(t.created_at)=? AND YEAR(t.created_at)=?
                GROUP BY t.kode_user ORDER BY pendapatan DESC";
          $st = $conn->prepare($q);
          $st->bind_param('ii',$bulan,$tahun);
          $st->execute();
          $res = $st->get_result();
          ?>
          <table class="table table-hover">
            <thead class="table-light"><tr><th>Admin</th><th>Transaksi</th><th>Pendapatan</th></tr></thead>
            <tbody>
            <?php while($r=$res->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($r['full_name']) ?></td>
                <td><span class="badge bg-primary"><?= $r['transaksi'] ?></span></td>
                <td class="fw-bold text-success">Rp <?= number_format($r['pendapatan'],0,',','.') ?></td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
          <div class="action-buttons">
                <a href="javascript:history.back()" class="btn-primary me-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>

        <?php else: ?>
          <div class="alert alert-info">
            Laporan <strong><?= ucwords(str_replace('_',' ',$type)) ?></strong> belum diimplementasikan.
          </div>
          <div class="action-buttons">
                <a href="javascript:history.back()" class="btn-primary me-2">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        <?php endif; ?>
        

      </div>
    </div>
  </main>
</section>

<?php include 'partials/footer.php'; ?>