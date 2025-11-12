<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Kaliwates Mobil Jember</title>

  <!-- Boxicons -->
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/admin/admin.css">

   <!-- Custom CSS per Halaman -->
  <?php
    // Ambil nama file saat ini, contoh: transaksi.php, report.php, dst
    $currentPage = basename($_SERVER['PHP_SELF']);

    // Kalau halaman ini transaksi.php, tambahkan CSS khusus transaksi
    if ($currentPage === 'transaksi.php') {
        echo '<link rel="stylesheet" href="../../assets/css/admin/transaksi.css">';
    }

    if ($currentPage === 'tambah_transaksi.php') {
        echo '<link rel="stylesheet" href="../../assets/css/admin/tambah_transaksi.css">';
    }

    if ($currentPage === 'report.php') {
        echo '<link rel="stylesheet" href="../../assets/css/admin/report.css">';
    }

    if ($currentPage === 'index.php') {
        echo '<link rel="stylesheet" href="../../assets/css/admin/dashboard.css">';
    }

    if ($currentPage === 'setting1.php') {
        echo '<link rel="stylesheet" href="../../assets/css/admin/setting.css">';
    }

    

    
  ?>
  
</head>
<body>
  <div class="admin-wrapper">
