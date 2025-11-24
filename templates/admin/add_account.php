<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: manajemen_account.php');
    exit;
}
?>

<div class="container-fluid py-4 px-5">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Tambah Akun</h2>
            <p class="text-secondary">Tambahkan akun baru untuk admin</p>
        </div>
        <a href="manajemen_account.php" 
           class="text-primary text-decoration-none fw-medium d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white border rounded-4 shadow-sm p-5">
        <form method="POST" enctype="multipart/form-data">
            <!-- Foto Profil -->
            <div class="d-flex justify-content-center mb-5">
                <label for="photo" class="cursor-pointer">
                    <div id="photoPreview" 
                         class="rounded-circle border border-2 border-dashed border-secondary-subtle d-flex flex-column align-items-center justify-content-center bg-light overflow-hidden"
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-plus text-secondary mb-2" style="font-size: 32px;"></i>
                        <p class="text-muted mb-0">Tambah Foto</p>
                    </div>
                    <input type="file" id="photo" name="photo" accept="image/*" class="d-none">
                </label>
            </div>

            <!-- Input Data -->
            <div class="row g-4 px-5">
                <div class="col-md-6">
                    <label for="fullname" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname" 
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="Masukkan nama depan">
                </div>

                <div class="col-md-6">
                    <label for="username" class="form-label fw-semibold">Username</label>
                    <input type="text" id="username" name="username" 
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="Masukkan nama belakang">
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="text" id="password" name="password" 
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="Masukkan password">
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">No Telepon</label>
                    <input type="tel" id="phone" name="phone" 
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="+628123456789">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email" name="email" 
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="example@exc.com">
                </div>

                <div class="col-md-6">
                    <label for="address" class="form-label fw-semibold">Alamat</label>
                    <input type="text" id="address" name="address" 
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="Masukkan alamat">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-5 px-5">
                <a href="manajemen_account.php" 
                   class="btn btn-outline-secondary btn-lg px-4 py-2 rounded-3 d-flex align-items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
                <button type="submit" 
                        class="btn btn-primary btn-lg px-4 py-2 rounded-3 d-flex align-items-center gap-2 shadow-sm">
                    <i class="fas fa-save"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = '<img src="' + e.target.result + 
                '" class="w-100 h-100 object-fit-cover rounded-circle" />';
        }
        reader.readAsDataURL(file);
    }
});
</script>
