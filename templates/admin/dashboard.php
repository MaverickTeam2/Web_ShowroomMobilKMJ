<?php
$total_mobil = 156;
$pendapatan_bulanan = 36000000;
$mobil_reserved = 6;
$total_penjualan = 24;

$recent_activity = [
	[
		"judul" => "Mobil ditambahkan",
		"deskripsi" => "Mobil BMW ATX R8 ditambahkan ke inventory",
		"waktu" => "7 menit yang lalu"
	],
	[
		"judul" => "Transaksi baru",
		"deskripsi" => "Pelanggan membeli mobil Avanza 2024",
		"waktu" => "12 menit yang lalu"
	],
	[
		"judul" => "Mobil dihapus",
		"deskripsi" => "Mobil Honda Civic dihapus dari data lama",
		"waktu" => "1 jam yang lalu"
	],
	[
		"judul" => "Mobil reserved",
		"deskripsi" => "Mobil Pajero Sport telah dipesan pelanggan",
		"waktu" => "2 jam yang lalu"
	],
	[
		"judul" => "Transaksi selesai",
		"deskripsi" => "Penjualan Toyota Rush berhasil diselesaikan",
		"waktu" => "3 jam yang lalu"
	]
];

$clicks = [50, 80, 120, 90, 150, 200, 180];
$days = ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"];

$merk_labels = ["Toyota", "Honda", "Suzuki", "Daihatsu", "Mitsubishi"];
$merk_values = [12, 9, 7, 5, 3];
?>

<div class="head-title">
	<div class="left">
		<h1>Dashboard</h1>
		<p>Pantau aktivitas penjualan mobil anda</p>
	</div>
</div>

<div class="row mt-4 mb-3 px-2">

	<div class="col-md-3 mb-3">
		<div class="stat-card">
			<img src="../../assets/img/total_mobil.jpg" alt="total_mobil">
			<div class="stat-info">
				<div class="stat-value text-green"><?= $total_mobil ?></div>
				<div class="stat-subtext">Total mobil</div>
			</div>
		</div>
	</div>

	<div class="col-md-3 mb-3">
		<div class="stat-card">
			<img src="../../assets/img/pendapatan_bulanan.jpg" alt="pendapatan_bulanan">
			<div class="stat-info">
				<div class="stat-value text-blue">Rp. <?= number_format($pendapatan_bulanan, 0, ',', '.') ?></div>
				<div class="stat-subtext">Pendapatan bulanan</div>
			</div>
		</div>
	</div>

	<div class="col-md-3 mb-3">
		<div class="stat-card">
			<img src="../../assets/img/mobil_reserved.jpg" alt="mobil_reserved">
			<div class="stat-info">
				<div class="stat-value text-purple"><?= $mobil_reserved ?></div>
				<div class="stat-subtext">Mobil Reserved</div>
			</div>
		</div>
	</div>

	<div class="col-md-3 mb-3">
		<div class="stat-card">
			<img src="../../assets/img/total_penjualan.png" alt="total_penjualan">
			<div class="stat-info">
				<div class="stat-value text-purple"><?= $total_penjualan ?></div>
				<div class="stat-subtext">Total penjualan</div>
			</div>
		</div>
	</div>
</div>
<h3 class="QA">Quick Action</h3>
<div class="btn-group">
	<button class="btn btn-blue"><i class="bx bx-plus"></i> Tambah mobil</button>
	<button class="btn btn-green"><i class="bx bx-dollar"></i> Transaksi baru</button>
	<button class="btn btn-purple"><i class="bx bx-printer"></i> Generate laporan</button>
</div>

<div>
	<h3 class="RA">Recent Activity</h3>
	<div class="table-data">
		<div class="order">
			<div class="head"></div>
			<table>
				<tbody>
					<?php foreach ($recent_activity as $r): ?>
						<tr>
							<td>
								<img src="../../assets/img/ic_recentacitivty.jpg" alt="activity">
								<div class="person-info">
									<p class="text"><?= $r['judul'] ?> <i class="fa-regular fa-clone"></i></p>
									<p class="comment text-muted"><?= $r['deskripsi'] ?></p>
								</div>
							</td>
							<td class="time"><?= $r['waktu'] ?></td>
							<!-- <td><i class="fa-solid fa-eye-slash"></i></td> -->
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="chart-container">
		<div class="chart-left">
			<h3>Total clicks: <span><?= array_sum($clicks) ?></span></h3>
			<canvas id="lineChart"></canvas>
			<div class="time-filter">
				<button>1d</button>
				<button class="active">1w</button>
				<button>1m</button>
				<button>6m</button>
				<button>1y</button>
			</div>
		</div>

		<div class="chart-right">
			<h3>Merk mobil</h3>
			<canvas id="barChart"></canvas>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	const ctxLine = document.getElementById('lineChart').getContext('2d');
	new Chart(ctxLine, {
		type: 'line',
		data: {
			labels: <?= json_encode($days) ?>,
			datasets: [{
				label: 'Clicks',
				data: <?= json_encode($clicks) ?>,
				borderColor: '#007bff',
				fill: false,
				tension: 0.3
			}]
		},
		options: {
			responsive: true,
			scales: { y: { beginAtZero: true } }
		}
	});

	const ctxBar = document.getElementById('barChart').getContext('2d');
	new Chart(ctxBar, {
		type: 'bar',
		data: {
			labels: <?= json_encode($merk_labels) ?>,
			datasets: [{
				label: 'Jumlah Mobil',
				data: <?= json_encode($merk_values) ?>,
				backgroundColor: '#8b5cf6'
			}]
		},
		options: {
			responsive: true,
			scales: { y: { beginAtZero: true } }
		}
	});
</script>