<?php
// ===== Page meta & layout includes (sama seperti transaksi.php) =====
$title = "Manajemen Akun";
include 'partials/header.php';
include 'partials/sidebar.php';

// ---- Dummy data (sementara) ----
$accounts = [
    [
        'id' => 1,
        'name' => 'Muhammad Thoriq Firdaus',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Last login: 1 mount ago',
        'role' => 'Admin',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=12'
    ],
    [
        'id' => 2,
        'name' => 'M Ghani Gazali',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Login: 1 bulan lalu',
        'role' => 'Admin',
        'is_active' => false,
        'avatar' => 'https://i.pravatar.cc/150?img=45'
    ],
    [
        'id' => 3,
        'name' => 'Herdiansyah Hidayatullah',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Login: 1 bulan lalu',
        'role' => 'Owner',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=33'
    ],
    [
        'id' => 4,
        'name' => 'Nuril Aisyahroni',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Last login: 1 mount ago',
        'role' => 'Admin',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=27'
    ],
    [
        'id' => 5,
        'name' => 'Ananda Rafael',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Login: 1 bulan lalu',
        'role' => 'Owner',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=33'
    ],
    [
        'id' => 6,
        'name' => 'Ananta Wldayani',
        'email' => 'Bugatti456@gmail.com',
        'last_login' => 'Last login: 1 mount ago',
        'role' => 'Admin',
        'is_active' => true,
        'avatar' => 'https://i.pravatar.cc/150?img=27'
    ]
];
?>

<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <main id="main-content" class="p-4">
    <!-- Head & Breadcrumb (match transaksi.php) -->
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Manajemen Akun</h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Dashboard</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" href="#">Akun</a></li>
        </ul>
      </div>

      <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-page="add_account.php">
        <i class='bx bx-plus' style="font-size:1.1rem;"></i>
        Tambah Akun
      </button>
    </div>

    <!-- Card container utk list akun -->
    <div class="card border-0 shadow-sm mt-4">
      <div class="card-body">
        <p class="text-muted mb-4">Edit dan tambah akun di halaman ini</p>

        <div class="row g-4">
          <?php foreach ($accounts as $account): ?>
            <div class="col-lg-6 col-md-12">
              <div class="account-card h-100">
                <div class="account-card-top">
                  <img src="<?= htmlspecialchars($account['avatar']) ?>"
                       alt="<?= htmlspecialchars($account['name']) ?>"
                       class="account-avatar">

                  <div class="account-info">
                    <h2 class="account-name"><?= htmlspecialchars($account['name']) ?></h2>
                    <p class="account-email mb-1"><?= htmlspecialchars($account['email']) ?></p>
                    <p class="account-login mb-0"><?= htmlspecialchars($account['last_login']) ?></p>
                  </div>
                </div>

                <div class="account-card-bottom">
                  <div class="account-badges">
                    <span class="badge-role <?= $account['role'] === 'Admin' ? 'badge-admin' : 'badge-owner' ?>">
                      <?= htmlspecialchars($account['role']) ?>
                    </span>

                    <span id="status-badge-<?= $account['id'] ?>"
                          class="badge-status <?= $account['is_active'] ? 'badge-aktif' : 'badge-nonaktif' ?>">
                      <?= $account['is_active'] ? 'Aktif' : 'NonAktif' ?>
                    </span>

                    <label class="toggle-switch">
                      <input type="checkbox"
                             id="toggle-<?= $account['id'] ?>"
                             <?= $account['is_active'] ? 'checked' : '' ?>
                             onchange="toggleStatus(<?= $account['id'] ?>, this.checked)">
                      <span class="toggle-slider"></span>
                    </label>
                  </div>

                  <a href="edit_account.php"
                     class="btn-edit"
                     data-page="edit_account.php?id=<?= $account['id'] ?>">
                    <i class='bx bx-edit-alt'></i>
                    Edit
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <p class="text-muted text-center my-4">© 2024 Showroom Mobil KMJ</p>
  </main>
</section>

<?php include 'partials/footer.php'; ?>

<style>
  .account-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
  }
  .account-card-top { display:flex; gap:24px; margin-bottom:16px; }
  .account-avatar { width:96px; height:96px; border-radius:50%; object-fit:cover; flex-shrink:0; }
  .account-name { font-size:1.25rem; font-weight:800; margin:0 0 6px 0; }
  .account-email { color:#555; }
  .account-login { color:#888; font-size:.95rem; }
  .account-card-bottom { display:flex; justify-content:space-between; align-items:center; margin-top:auto; }
  .account-badges { display:flex; align-items:center; gap:12px; flex-wrap:wrap; }

  .badge-role { padding:8px 16px; border-radius:25px; font-size:.9rem; font-weight:600; }
  .badge-admin { background:#FFE5E5; color:#E74C3C; }
  .badge-owner { background:#E3F2FD; color:#2196F3; }

  .badge-status { min-width:110px; text-align:center; padding:8px 16px; border-radius:25px; font-weight:600; }
  .badge-aktif { background:#E8F5E9; color:#4CAF50; }
  .badge-nonaktif { background:#FFE5E5; color:#E74C3C; }

  .toggle-switch { position:relative; width:64px; height:32px; flex-shrink:0; }
  .toggle-switch input { opacity:0; width:0; height:0; }
  .toggle-slider { position:absolute; inset:0; border-radius:34px; background:#E74C3C; cursor:pointer; transition:.25s; }
  .toggle-slider:before { content:""; position:absolute; height:24px; width:24px; left:4px; bottom:4px; background:#fff; border-radius:50%; transition:.25s; }
  .toggle-switch input:checked + .toggle-slider { background:#4CAF50; }
  .toggle-switch input:checked + .toggle-slider:before { transform: translateX(32px); }

  .btn-edit { color:#4169E1; text-decoration:none; font-weight:600; display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; transition:background .2s; }
  .btn-edit:hover { background:#f0f4ff; }
</style>

<script>
// toggle status badge
function toggleStatus(accountId, isActive) {
  const el = document.getElementById(`status-badge-${accountId}`);
  if (!el) return;
  el.textContent = isActive ? 'Aktif' : 'NonAktif';
  el.className = 'badge-status ' + (isActive ? 'badge-aktif' : 'badge-nonaktif');
}

function loadPage(page) {
  const mainContent = document.getElementById("main-content");
  if (mainContent) {
    fetch(page).then(r => {
      if (!r.ok) throw new Error("Halaman tidak ditemukan");
      return r.text();
    }).then(html => {
      mainContent.innerHTML = html;
      window.scrollTo({ top: 0, behavior: "smooth" });
    }).catch(err => {
      console.error("Gagal memuat halaman:", err);
      alert("Gagal membuka halaman: " + page);
    });
  } else {
    window.location.href = page;
  }
}

// delegation utk tombol data-page (termasuk Tambah Akun & Edit)
document.addEventListener("click", function(e) {
  const target = e.target.closest("[data-page]");
  if (target) {
    e.preventDefault();
    loadPage(target.getAttribute("data-page"));
  }
});
</script>
