<?php
$title = "Settings";
include 'partials/header.php';
include 'partials/sidebar.php';

// Ambil data settings dari database
require_once '../../db/koneksi.php';

// Ambil data general settings
$generalSettings = [
    'showroom_status' => 0,
    'jual_mobil' => 0,
    'schedule_pelanggan' => 1
];

$query = "SELECT showroom_status, jual_mobil, schedule_pelanggan FROM showroom_general LIMIT 1";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    $generalSettings = $result->fetch_assoc();
}

// Ambil data user untuk account settings
$userData = [];
if (isset($_SESSION['kode_user'])) {
    $kode_user = $_SESSION['kode_user'];
    $userQuery = "SELECT username, email, full_name, no_telp, avatar_url FROM users WHERE kode_user = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param('s', $kode_user);
    $stmt->execute();
    $userResult = $stmt->get_result();
    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
    }
}

// Default foto profil
$fotoProfil = !empty($userData['avatar_url']) ? $userData['avatar_url'] : "../../assets/img/default-photo.png";
?>

<!-- CSS khusus halaman ini -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<link rel="stylesheet" href="../../assets/css/admin/setting.css">

<section id="content">
  <nav>
    <i class='bx bx-menu'></i>
  </nav>

  <main class="p-4">

    <!-- HEADER TITLE / BREADCRUMB -->
    <div class="head-title d-flex justify-content-between align-items-center">
      <div class="left">
        <h1 class="h3 mb-1">Settings</h1>
        <ul class="breadcrumb mb-0">
          <li><a href="index.php">Settings</a></li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li><a class="active" id="breadcrumb-current" href="#">General</a></li>
        </ul>
      </div>
      <a href="#" class="btn btn-primary">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Save Changes</span>
      </a>
    </div>

    <!-- ===================== KONTEN SETTINGS ===================== -->
    <div class="settings-container d-flex gap-3 p-3">
      <!-- MENU SAMPING -->
      <div class="settings-menu bg-white rounded shadow-sm p-3">
        <ul class="nav flex-column nav-pills" id="settingsTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="tab-general" data-bs-toggle="pill" href="#general" role="tab">
              <i class='bx bx-home'></i> General
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-account" data-bs-toggle="pill" href="#account" role="tab">
              <i class='bx bx-user'></i> Account
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-schedule" data-bs-toggle="pill" href="#schedule" role="tab">
              <i class='bx bx-time'></i> Schedule
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-social" data-bs-toggle="pill" href="#social" role="tab">
              <i class='bx bx-link'></i> Kontak & Sosial
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-backup" data-bs-toggle="pill" href="#backup" role="tab">
              <i class='bx bx-hdd'></i> Backup & Restore
            </a>
          </li>
        </ul>
      </div>

      <!-- ISI TAB -->
      <div class="settings-content flex-fill bg-white rounded shadow-sm p-4 tab-content" id="settingsTabContent">
        <!-- General -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
          <div class="setting-header mb-4">
            <div class="setting-title">General</div>
            <div class="setting-desc text-secondary">Kelola informasi dasar dan preferensi toko Anda</div>
          </div>

          <div class="setting-item">
            <div class="setting-text">
              <h6>Showroom Status</h6>
              <p>Manual buka atau tutup showroom online anda untuk pelanggan</p>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="showroomStatus" 
                     <?php echo $generalSettings['showroom_status'] == 1 ? 'checked' : ''; ?>>
            </div>
          </div>

          <div class="setting-item">
            <div class="setting-text">
              <h6>Jual mobil</h6>
              <p>Manual buka atau tutup untuk pelanggan menjual mobil</p>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="sellCarStatus" 
                     <?php echo $generalSettings['jual_mobil'] == 1 ? 'checked' : ''; ?>>
            </div>
          </div>

          <div class="setting-item">
            <div class="setting-text">
              <h6>Schedule pelanggan</h6>
              <p>Manual buka atau tutup untuk pelanggan membuat Schedule</p>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="scheduleStatus" 
                     <?php echo $generalSettings['schedule_pelanggan'] == 1 ? 'checked' : ''; ?>>
            </div>
          </div>
        </div>

        <!-- Account -->
        <div class="tab-pane fade" id="account" role="tabpanel">
          <div class="setting-header mb-4">
            <div class="setting-title">Account</div>
            <div class="setting-desc text-secondary">Kelola profil akun dan ubah password di sini.</div>
          </div>

          <form id="accountForm">
            <input type="hidden" name="profile_image" id="profile_image">

            <!-- PROFIL PICTURE -->
            <div class="mb-4">
              <label class="form-label fw-semibold d-block mb-2">Profil Picture</label>
              <div class="d-flex align-items-center gap-3">
                <img id="previewImage" src="<?php echo $fotoProfil; ?>" alt="Profile Picture" class="profile-pic" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                <div>
                  <button class="btn btn-outline-secondary btn-sm upload-btn" type="button"
                          onclick="document.getElementById('uploadLogo').click()">
                    <i class='bx bx-upload'></i> Upload new logo
                  </button>
                  <input type="file" id="uploadLogo" accept="image/*" hidden>
                  <p class="text-muted mt-2 mb-0" style="font-size: 0.9rem;">
                    Upload logo Showroom anda (disarankan: 150×150px)
                  </p>
                </div>
              </div>
            </div>

            <!-- FULL NAME -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">Full Name</label>
              <input type="text" class="form-control" name="fullname" 
                     value="<?php echo htmlspecialchars($userData['full_name'] ?? ''); ?>" 
                     placeholder="Masukkan nama lengkap">
            </div>

            <!-- USERNAME -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">Username</label>
              <input type="text" class="form-control" name="username" 
                     value="<?php echo htmlspecialchars($userData['username'] ?? ''); ?>" 
                     placeholder="Masukkan username">
            </div>

            <!-- NO TELEPHONE -->
            <div class="mb-4">
              <label class="form-label fw-semibold d-block mb-2">No Telephone</label>
              <input type="text" class="form-control" name="phone" 
                     value="<?php echo htmlspecialchars($userData['no_telp'] ?? ''); ?>" 
                     placeholder="Masukkan nomor telepon">
            </div>

            <hr class="my-4">

            <!-- UBAH PASSWORD -->
            <div class="setting-header mb-4">
              <div class="setting-title">Ubah Password</div>
              <div class="setting-desc text-secondary">Isi bagian ini jika ingin mengganti password akun Anda.</div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">Password Sebelumnya</label>
              <input type="password" class="form-control" name="old_password" placeholder="Masukkan password lama">
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">Password Baru</label>
              <input type="password" class="form-control" name="new_password" placeholder="Masukkan password baru">
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold d-block mb-2">Konfirmasi Password</label>
              <input type="password" class="form-control" name="confirm_password" placeholder="Ulangi password baru">
            </div>
          </form>
        </div>

        <!-- Schedule -->
        <div class="tab-pane fade" id="schedule" role="tabpanel">
          <div class="setting-header mb-4">
            <div class="setting-title">Schedule</div>
            <div class="setting-desc text-secondary">Kelola otomatis buka/tutup showroom.</div>
          </div>

          <div id="scheduleContainer"></div>
        </div>

        <!-- Social -->
        <div class="tab-pane fade" id="social" role="tabpanel">
          <div class="setting-header mb-4">
            <div class="setting-title">Kontak & Tautan Sosial</div>
            <div class="setting-desc text-secondary">Masukkan tautan media sosial showroom Anda.</div>
          </div>

          <form>
            <!-- WHATSAPP -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">Whatsapp</label>
              <div class="input-group">
                <span class="input-group-text">+62</span>
                <input type="text" class="form-control" id="whatsappNumber"
                       placeholder="Isi langsung tanpa 62 atau 0 (e.g., 85123456789)">
                <button class="btn btn-success d-flex align-items-center gap-1" type="button" id="testChatBtn">
                  <i class="bx bxl-whatsapp"></i> Test Chat
                </button>
              </div>
              <small class="text-muted">Isi langsung tanpa 62 atau 0 (e.g., 85123456789)</small>
            </div>

            <!-- INSTAGRAM -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">Instagram Profil</label>
              <input type="text" class="form-control" id="instagramLink" placeholder="URL Instagram profil showroom">
            </div>

            <!-- FACEBOOK -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">Facebook Profil</label>
              <input type="text" class="form-control" id="facebookLink" placeholder="URL Facebook profil showroom">
            </div>

            <!-- TIKTOK -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">Tik Tok Profil</label>
              <input type="text" class="form-control" id="tiktokLink" placeholder="URL Tik Tok profil showroom">
            </div>

            <!-- YOUTUBE -->
            <div class="mb-3">
              <label class="form-label fw-semibold d-block mb-2">YouTube Profil</label>
              <input type="text" class="form-control" id="youtubeLink" placeholder="URL YouTube profil showroom">
            </div>
          </form>
        </div>

        <!-- Backup -->
        <div class="tab-pane fade" id="backup" role="tabpanel">
          <div class="setting-header mb-4">
            <div class="setting-title">Backup & Restore</div>
            <div class="setting-desc text-secondary">Kelola pencadangan dan pemulihan data.</div>
          </div>

          <!-- Automatic Backups -->
          <div class="setting-item d-flex justify-content-between align-items-center mb-4">
            <div>
              <h6 class="mb-1">Automatic Backups</h6>
              <p class="text-muted mb-0" style="font-size: 14px;">
                Jadwalkan pencadangan otomatis harian data showroom anda
              </p>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="autoBackup" checked>
            </div>
          </div>

          <!-- Backup Info -->
          <div class="bg-light rounded-3 p-3 mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div class="d-flex align-items-center gap-2">
                <i class="bx bx-time text-primary fs-4"></i>
                <div>
                  <div class="fw-semibold">Last Backup</div>
                  <div class="text-secondary" style="font-size: 14px;">Belum ada backup</div>
                </div>
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center gap-2">
                <i class="bx bx-hdd text-primary fs-4"></i>
                <div>
                  <div class="fw-semibold">Backup Size</div>
                  <div class="text-secondary" style="font-size: 14px;">0 MB</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Manual Backup & Restore -->
          <div class="mb-3">
            <h6 class="fw-semibold mb-2">Manual Backup & Restore</h6>
            <p class="text-secondary" style="font-size: 14px;">
              Ekspor akan membuat berkas cadangan yang dapat diunduh. Impor akan memulihkan data dari cadangan sebelumnya.
            </p>
            <div class="d-flex gap-2 flex-wrap">
              <button class="btn btn-success d-flex align-items-center gap-2" id="exportBtn">
                <i class='bx bx-cloud-download'></i> Export Database
              </button>
              <button class="btn btn-outline-secondary d-flex align-items-center gap-2" id="importBtn">
                <i class='bx bx-cloud-upload'></i> Import Database
              </button>
            </div>
          </div>

          <!-- Warning -->
          <div class="alert alert-warning mt-3" style="font-size: 14px;">
            <strong>Warning:</strong> Mengimpor database akan menimpa semua data yang ada.
            Pastikan untuk mengekspor data anda saat ini sebelum mengimpor.
          </div>

          <!-- Modal Konfirmasi Restore -->
          <div class="modal fade" id="confirmRestoreModal" tabindex="-1" aria-labelledby="confirmRestoreLabel"
               aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning">
                  <h5 class="modal-title fw-bold text-dark" id="confirmRestoreLabel">
                    <i class='bx bx-error-circle me-2'></i> Konfirmasi Restore Database
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                  <p>
                    Mengimpor database akan <strong>menimpa semua data yang ada saat ini</strong>.
                    Pastikan Anda sudah melakukan backup terlebih dahulu sebelum melanjutkan.
                  </p>
                  <hr>
                  <div class="mb-3">
                    <label for="adminPassword" class="form-label fw-semibold">Masukkan Password Admin</label>
                    <input type="password" class="form-control" id="adminPassword" placeholder="••••••••" required>
                    <div id="passwordError" class="text-danger mt-2" style="display: none; font-size: 0.9rem;">
                      Password salah. Coba lagi.
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-danger" id="confirmImportBtn">
                    <i class='bx bx-refresh'></i> Ya, Lanjutkan Restore
                  </button>
                </div>
              </div>
            </div>
          </div>

        </div> <!-- end #backup -->
      </div>  <!-- end .settings-content -->
    </div>    <!-- end .settings-container -->

    <!-- Modal Cropper (untuk upload foto) -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Sesuaikan Foto Profil</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body d-flex flex-column align-items-center justify-content-center">
            <div class="cropper-container-wrapper" style="max-width: 100%; max-height: 400px;">
              <img id="imageToCrop" alt="Image to crop" style="max-width: 100%;">
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="cropButton">Simpan</button>
          </div>
        </div>
      </div>
    </div>

  </main>
</section>

<!-- JS khusus halaman ini -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/setting_admin.js"></script>

<?php 
$conn->close();
include 'partials/footer.php'; 
?>