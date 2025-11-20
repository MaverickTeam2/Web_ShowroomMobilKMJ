<section id="sidebar">
  <a href="index.php" class="brand d-flex align-items-center">
    <img src="../../assets/img/Logo_KMJ_YB2.ico" alt="KMJ Logo" style="width:70px; height:90px; margin-left:15px;">
    <div class="brand-text ms-2">
      <h2>Kaliwates Mobil Jember</h2>
      <p>Admin Dashboard</p>
    </div>
  </a>

  <ul class="side-menu top">
    <li><a href="index.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
    <li><a href="transaksi.php"><i class='bx bxs-shopping-bag-alt'></i><span class="text">Transaksi</span></a></li>
    <li>
      <a href="manajemen_mobil.php"
        class="<?= (isset($title) && ($title === 'manajemen_mobil' || $title === 'tambah_stok_mobil')) ? 'active' : '' ?>">
        <i class="bx bx-car"></i>
        <span>Manajemen Mobil</span>
      </a>
    </li>

    <li><a href="report.php"><i class='bx bxs-bar-chart-alt-2'></i><span class="text">Report</span></a></li>
    <li><a href="manajemen_account.php"><i class='bx bxs-user'></i><span class="text">Manajemen Akun</span></a></li>

  </ul>

  <ul class="side-menu bottom">
    <li><a href="setting1.php"><i class='bx bxs-cog'></i><span class="text">Settings</span></a></li>
    <li><a href="help.php" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Help Center</span></a>
    </li>
  </ul>
</section>