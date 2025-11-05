<?php
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

<style>
    .account-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 40px;
    }

    .account-header h1 {
        font-size: 3rem;
        font-weight: 700;
        color: #000;
        margin: 0 0 8px 0;
        line-height: 1;
    }

    .account-header p {
        color: #666;
        margin: 0;
        font-size: 1rem;
    }

    .btn-tambah-akun {
        background: #4169E1;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-tambah-akun:hover {
        background: #3154c4;
    }

    .account-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .account-card-top {
        display: flex;
        gap: 24px;
        margin-bottom: 24px;
    }

    .account-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .account-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .account-card .account-info .account-name {
        font-size: 1.6rem !important;
        font-weight: 800 !important;
        color: #111 !important;
        margin: 0 0 8px 0 !important;
        line-height: 1.3 !important;
        letter-spacing: -0.3px !important;
    }

    .account-card .account-info .account-email {
        font-size: 1rem !important;
        color: #555 !important;
        margin: 0 0 4px 0 !important;
    }

    .account-card .account-info .account-login {
        font-size: 0.9rem !important;
        color: #888 !important;
        margin: 0 !important;
    }

    .account-card-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .account-badges {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .badge-role {
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .badge-admin {
        background: #FFE5E5;
        color: #E74C3C;
    }

    .badge-owner {
        background: #E3F2FD;
        color: #2196F3;
    }

    .badge-status {
        min-width: 120px; 
        text-align: center;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .badge-aktif {
        background: #E8F5E9;
        color: #4CAF50;
    }

    .badge-nonaktif {
        background: #FFE5E5;
        color: #E74C3C;
    }

    .toggle-switch {
        position: relative;
        width: 64px;
        height: 32px;
        flex-shrink: 0;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #E74C3C; /* merah default */
        border-radius: 34px;
        transition: 0.3s;
    }

    .toggle-slider:before {
        content: "";
        position: absolute;
        height: 24px;
        width: 24px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        border-radius: 50%;
        transition: 0.3s;
    }

    .toggle-switch input:checked + .toggle-slider {
        background-color: #4CAF50; /* hijau aktif */
    }

    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(32px);
    }

    .btn-edit {
        color: #4169E1;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1rem;
        padding: 8px 12px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .btn-edit:hover {
        background: #f0f4ff;
    }

    .btn-edit i {
        font-size: 1.2rem;
    }
</style>

<div class="account-header">
    <div>
        <h1>Manajemen Akun</h1>
        <p>Edit dan Tambah akun di halaman ini</p>
    </div>
    <<button type="button" class="btn-tambah-akun" data-page="add_account.php">
    <i class='bx bx-plus' style="font-size: 1.3rem;"></i>
        Tambah Akun
    </button>

</div>

<main style="padding: 0 20px;">
    <div class="row g-4">
        <?php foreach ($accounts as $account): ?>
        <div class="col-lg-6 col-md-12">
            <div class="account-card">
                <div class="account-card-top">
                    <img src="<?= htmlspecialchars($account['avatar']) ?>" 
                         alt="<?= htmlspecialchars($account['name']) ?>" 
                         class="account-avatar">
                    
                    <div class="account-info">
                        <h1 class="account-name"><?= htmlspecialchars($account['name']) ?></h1>
                        <p class="account-email"><?= htmlspecialchars($account['email']) ?></p>
                        <p class="account-login"><?= htmlspecialchars($account['last_login']) ?></p>
                    </div>
                </div>
                
                <div class="account-card-bottom">
                    <div class="account-badges">
                        <span class="badge-role <?= $account['role'] == 'Admin' ? 'badge-admin' : 'badge-owner' ?>">
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
                    
                    <a href="edit_account.php" class="btn-edit" data-page="edit_account.php?id=<?= $account['id'] ?>">
                        <i class='bx bx-edit-alt'></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
function toggleStatus(accountId, isActive) {
    const statusBadge = document.getElementById(`status-badge-${accountId}`);
    if (isActive) {
        statusBadge.textContent = 'Aktif';
        statusBadge.className = 'badge-status badge-aktif';
    } else {
        statusBadge.textContent = 'NonAktif';
        statusBadge.className = 'badge-status badge-nonaktif';
    }
}

function loadPage(page) {
    const mainContent = document.getElementById("main-content");
    if (mainContent) {
        fetch(page)
            .then(response => {
                if (!response.ok) throw new Error("Halaman tidak ditemukan");
                return response.text();
            })
            .then(html => {
                mainContent.innerHTML = html;
                window.scrollTo({ top: 0, behavior: "smooth" });
            })
            .catch(err => {
                console.error("Gagal memuat halaman:", err);
                alert("Gagal membuka halaman: " + page);
            });
    } else {
        window.location.href = page;
    }
}

// Gunakan event delegation agar event tetap aktif meskipun konten berubah
document.addEventListener("click", function(e) {
    const target = e.target.closest("[data-page]");
    if (target) {
        e.preventDefault();
        const page = target.getAttribute("data-page");
        loadPage(page);
    }
});
</script>
