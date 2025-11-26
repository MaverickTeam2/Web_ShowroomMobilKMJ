<?php
// Ambil kode_user dari query string
$kodeUser = $_GET['kode_user'] ?? '';
?>

<div class="container-fluid py-4 px-5">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Edit Akun</h2>
            <p class="text-secondary">Edit informasi akun admin</p>
        </div>
        <a href="manajemen_account.php"
           data-page="manajemen_account.php"
           class="text-primary text-decoration-none fw-medium d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white border rounded-4 shadow-sm p-5">
        <!-- kode_user untuk JS -->
        <input type="hidden" id="edit_kode_user" value="<?= htmlspecialchars($kodeUser) ?>">

        <form id="formEditAccount" enctype="multipart/form-data">
            <!-- Foto Profil -->
            <div class="d-flex justify-content-center mb-5">
                <label for="photo_edit" class="cursor-pointer">
                    <div id="photoPreviewEdit"
                         class="rounded-circle border border-2 border-dashed border-secondary-subtle d-flex flex-column align-items-center justify-content-center bg-light overflow-hidden"
                         style="width: 150px; height: 150px;">
                        <!-- Akan diganti JS -->
                        <i class="fas fa-user text-secondary mb-2" style="font-size: 32px;"></i>
                    </div>
                    <input type="file" id="photo_edit" name="photo_edit" accept="image/*" class="d-none">
                </label>
            </div>

            <!-- Input Data (mirip add_account) -->
            <div class="row g-4 px-5">
                <div class="col-md-6">
                    <label for="fullname_edit" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" id="fullname_edit" name="fullname_edit"
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="Masukkan nama lengkap">
                </div>

                <div class="col-md-6">
                    <label for="username_edit" class="form-label fw-semibold">Username</label>
                    <input type="text" id="username_edit" name="username_edit"
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="Username" disabled>
                </div>

                <div class="col-md-6">
                    <label for="password_edit" class="form-label fw-semibold">Password</label>
                    <input type="password" id="password_edit" name="password_edit"
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="••••••••" disabled>
                </div>

                <div class="col-md-6">
                    <label for="phone_edit" class="form-label fw-semibold">No Telepon</label>
                    <input type="tel" id="phone_edit" name="phone_edit"
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="+628123456789">
                </div>

                <div class="col-md-6">
                    <label for="email_edit" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email_edit" name="email_edit"
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="example@exc.com" disabled>
                </div>

                <div class="col-md-6">
                    <label for="address_edit" class="form-label fw-semibold">Alamat</label>
                    <input type="text" id="address_edit" name="address_edit"
                           class="form-control form-control-lg rounded-3 border-secondary-subtle"
                           placeholder="Masukkan alamat">
                </div>
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-end gap-3 mt-5 px-5">
                <button type="button"
                        data-page="manajemen_account.php"
                        class="btn btn-outline-secondary btn-lg px-4 py-2 rounded-3 d-flex align-items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </button>
                <button type="submit"
                        id="btnSubmitEdit"
                        class="btn btn-primary btn-lg px-4 py-2 rounded-3 d-flex align-items-center gap-2 shadow-sm">
                    <i class="fas fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

        <div id="editAccountMessage" class="mt-3"></div>
    </div>
</div>
