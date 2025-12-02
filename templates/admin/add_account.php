<?php
// Halaman TAMBAH akun (bukan edit)
?>

<div class="container-fluid py-4 px-5">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Tambah Akun</h2>
            <p class="text-secondary">Tambahkan akun baru untuk admin</p>
        </div>
        <a href="manajemen_account.php" data-page="manajemen_account.php"
            class="text-primary text-decoration-none fw-medium d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white border rounded-4 shadow-sm p-5">
        <form id="formAddAccount" enctype="multipart/form-data">

            <!-- Input Data -->
            <div class="row g-4 px-5">
                <div class="col-md-6">
                    <label for="fullname" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname"
                        class="form-control form-control-lg rounded-3 border-secondary-subtle"
                        placeholder="Masukkan nama lengkap">
                </div>

                <div class="col-md-6">
                    <label for="username" class="form-label fw-semibold">Username</label>
                    <input type="text" id="username" name="username"
                        class="form-control form-control-lg rounded-3 border-secondary-subtle"
                        placeholder="Masukkan username">
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" id="password" name="password"
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
                <button type="button" data-page="manajemen_account.php" class="btn btn-outline-secondary ...">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </button>
                <button type="submit" id="btnSubmitAdd"
                    class="btn btn-primary btn-lg px-4 py-2 rounded-3 d-flex align-items-center gap-2 shadow-sm">
                    <i class="fas fa-save"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>

        <div id="addAccountMessage" class="mt-3"></div>
    </div>
</div>