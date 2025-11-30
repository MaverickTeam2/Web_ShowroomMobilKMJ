// ========================================
// LOAD DATA GENERAL SETTINGS
// ========================================

function loadGeneralSettings() {
  fetch("http://localhost/API_kmj/admin/get_general_settings.php", {
    credentials: "include"
  })
    .then(res => res.json())
    .then(data => {
      console.log(" Loaded Settings:", data);

      if (data.success) {
        document.getElementById("showroomStatus").checked = data.data.showroom_status == 1;
        document.getElementById("sellCarStatus").checked = data.data.jual_mobil == 1;
        document.getElementById("scheduleStatus").checked = data.data.schedule_pelanggan == 1;
      }
    })
    .catch(err => console.error("Error:", err));
}



// ========================================
// SAVE DATA GENERAL SETTINGS
// ========================================

function saveGeneralSettings() {
  const formData = new FormData();
  formData.append("showroom_status", document.getElementById("showroomStatus").checked ? 1 : 0);
  formData.append("jual_mobil", document.getElementById("sellCarStatus").checked ? 1 : 0);
  formData.append("schedule_pelanggan", document.getElementById("scheduleStatus").checked ? 1 : 0);

  fetch("http://localhost/API_kmj/admin/save_general_settings.php", {
    method: "POST",
    credentials: "include",
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      console.log(" Save Response:", data);

      if (data.success) {
        showNotification("success", data.message);
      } else {
        showNotification("error", data.message);
      }
    })
    .catch(err => {
      showNotification("error", "Gagal menyimpan pengaturan");
      console.error(err);
    });
}

// ========================================
// ACCOUNT SETTINGS
// ========================================
function saveAccountSettings() {
  const formData = new FormData();

  formData.append('fullname', document.querySelector('input[name="fullname"]').value);
  formData.append('username', document.querySelector('input[name="username"]').value);
  formData.append('phone', document.querySelector('input[name="phone"]').value);
  formData.append('old_password', document.querySelector('input[name="old_password"]').value);
  formData.append('new_password', document.querySelector('input[name="new_password"]').value);
  formData.append('confirm_password', document.querySelector('input[name="confirm_password"]').value);
  formData.append('profile_image', document.getElementById('profile_image').value);

  fetch("http://localhost/API_kmj/admin/save_account_settings.php", {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showNotification('success', data.message);
        // Reset password fields
        document.querySelector('input[name="old_password"]').value = '';
        document.querySelector('input[name="new_password"]').value = '';
        document.querySelector('input[name="confirm_password"]').value = '';
      } else {
        showNotification('error', data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification('error', 'Terjadi kesalahan saat menyimpan data akun');
    });
}

// ========================================
// SCHEDULE SETTINGS
// ========================================
const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
let scheduleData = {};

function initSchedule() {
  days.forEach(day => {
    scheduleData[day] = [{ slot_index: 1, jam_buka: '08:00', jam_tutup: '17:00', is_active: true }];
  });
  renderSchedule();
}

function loadScheduleSettings() {
fetch("http://localhost/API_kmj/admin/get_schedule_settings.php")
    .then(response => response.json())
    .then(data => {
      if (data.success && data.data.length > 0) {
        scheduleData = {};
        data.data.forEach(schedule => {
          if (!scheduleData[schedule.hari]) {
            scheduleData[schedule.hari] = [];
          }
          scheduleData[schedule.hari].push({
            slot_index: schedule.slot_index,
            jam_buka: schedule.jam_buka,
            jam_tutup: schedule.jam_tutup,
            is_active: schedule.is_active == 1
          });
        });
        renderSchedule();
      } else {
        initSchedule();
      }
    })
    .catch(error => {
      console.error('Error loading schedule:', error);
      initSchedule();
    });
}

function renderSchedule() {
  const container = document.getElementById('scheduleContainer');
  if (!container) return;

  let html = '';

  days.forEach(day => {
    const daySchedules = scheduleData[day] || [];

    html += `
            <div class="schedule-day mb-4 p-3 border rounded">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">${day}</h6>
                    <button class="btn btn-sm btn-outline-primary" onclick="addScheduleSlot('${day}')">
                        <i class='bx bx-plus'></i> Tambah Slot
                    </button>
                </div>
                <div id="slots-${day}">`;

    daySchedules.forEach((slot, index) => {
      html += `
                <div class="schedule-slot d-flex gap-2 align-items-center mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               ${slot.is_active ? 'checked' : ''} 
                               onchange="toggleSlot('${day}', ${index})">
                    </div>
                    <input type="time" class="form-control" value="${slot.jam_buka}" 
                           onchange="updateSlot('${day}', ${index}, 'jam_buka', this.value)">
                    <span>-</span>
                    <input type="time" class="form-control" value="${slot.jam_tutup}" 
                           onchange="updateSlot('${day}', ${index}, 'jam_tutup', this.value)">
                    ${daySchedules.length > 1 ?
          `<button class="btn btn-sm btn-outline-danger" onclick="removeSlot('${day}', ${index})">
                            <i class='bx bx-trash'></i>
                        </button>` : ''}
                </div>`;
    });

    html += `</div></div>`;
  });

  container.innerHTML = html;
}

function addScheduleSlot(day) {
  if (!scheduleData[day]) scheduleData[day] = [];
  const newIndex = scheduleData[day].length + 1;
  scheduleData[day].push({
    slot_index: newIndex,
    jam_buka: '08:00',
    jam_tutup: '17:00',
    is_active: true
  });
  renderSchedule();
}

function removeSlot(day, index) {
  scheduleData[day].splice(index, 1);
  // Reindex
  scheduleData[day].forEach((slot, i) => {
    slot.slot_index = i + 1;
  });
  renderSchedule();
}

function toggleSlot(day, index) {
  scheduleData[day][index].is_active = !scheduleData[day][index].is_active;
}

function updateSlot(day, index, field, value) {
  scheduleData[day][index][field] = value;
}

function saveScheduleSettings() {
  const schedules = [];

  Object.keys(scheduleData).forEach(day => {
    scheduleData[day].forEach(slot => {
      schedules.push({
        hari: day,
        slot_index: slot.slot_index,
        jam_buka: slot.jam_buka,
        jam_tutup: slot.jam_tutup,
        is_active: slot.is_active
      });
    });
  });

  const formData = new FormData();
  formData.append('schedules', JSON.stringify(schedules));

  fetch("http://localhost/API_kmj/admin/save_schedule_settings.php", {
    method: 'POST',
    credentials: "include",
    body: formData
})
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showNotification('success', data.message);
      } else {
        showNotification('error', data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification('error', 'Terjadi kesalahan saat menyimpan jadwal');
    });
}

// ========================================
// SOCIAL SETTINGS
// ========================================
function loadSocialSettings() {
fetch("http://localhost/API_kmj/admin/get_social_settings.php")
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.getElementById('whatsappNumber').value = data.data.whatsapp_display || '';
        document.getElementById('instagramLink').value = data.data.instagram_url || '';
        document.getElementById('facebookLink').value = data.data.facebook_url || '';
        document.getElementById('tiktokLink').value = data.data.tiktok_url || '';
        document.getElementById('youtubeLink').value = data.data.youtube_url || '';
      }
    })
    .catch(error => console.error('Error loading social settings:', error));
}

function saveSocialSettings() {
  const formData = new FormData();

  formData.append('whatsapp', document.getElementById('whatsappNumber').value);
  formData.append('instagram_url', document.getElementById('instagramLink').value);
  formData.append('facebook_url', document.getElementById('facebookLink').value);
  formData.append('tiktok_url', document.getElementById('tiktokLink').value);
  formData.append('youtube_url', document.getElementById('youtubeLink').value);

  fetch("http://localhost/API_kmj/admin/save_social_settings.php", {
    method: 'POST',
    credentials: "include",
    body: formData
})

    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showNotification('success', data.message);
      } else {
        showNotification('error', data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification('error', 'Terjadi kesalahan saat menyimpan kontak & sosial');
    });
}

// ========================================
// BACKUP & RESTORE
// ========================================
function loadBackupInfo() {
fetch("http://localhost/API_kmj/admin/get_backup_info.php")
    .then(response => response.json())
    .then(data => {
      if (data.success && data.data) {
        document.querySelector('.bg-light .text-secondary').textContent = data.data.backup_time_formatted;
        document.querySelectorAll('.bg-light .text-secondary')[1].textContent = data.data.backup_size_mb + ' MB';
      }
    })
    .catch(error => console.error('Error loading backup info:', error));
}

// ========================================
// TOMBOL SAVE CHANGES
// ========================================
const saveChangesBtn = document.querySelector('.head-title .btn-primary');
if (saveChangesBtn) {
  saveChangesBtn.addEventListener('click', function (e) {
    e.preventDefault();

    const activeTab = document.querySelector('.tab-pane.active').id;

    switch (activeTab) {
      case 'general':
        saveGeneralSettings();
        break;
      case 'account':
        saveAccountSettings();
        break;
      case 'schedule':
        saveScheduleSettings();
        break;
      case 'social':
        saveSocialSettings();
        break;
      default:
        showNotification('info', 'Tidak ada perubahan untuk disimpan');
    }
  });
}

// ========================================
// UPDATE BREADCRUMB
// ========================================
document.querySelectorAll('#settingsTab .nav-link').forEach(tab => {
  tab.addEventListener('shown.bs.tab', function (e) {
    const tabText = e.target.textContent.trim();
    document.getElementById('breadcrumb-current').textContent = tabText;

    // Load data sesuai tab
    const tabId = e.target.getAttribute('href').substring(1);
    if (tabId === 'schedule' && Object.keys(scheduleData).length === 0) {
      loadScheduleSettings();
    }
  });
});

// ========================================
// NOTIFICATION HELPER
// ========================================
function showNotification(type, message) {
  const notification = document.createElement('div');
  notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show position-fixed`;
  notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
  notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.remove();
  }, 5000);
}

// ========================================
// CROPPER.JS UNTUK FOTO PROFIL
// ========================================
let cropper;
const uploadLogo = document.getElementById('uploadLogo');
const imageToCrop = document.getElementById('imageToCrop');
const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));

if (uploadLogo) {
  uploadLogo.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
        imageToCrop.src = event.target.result;
        cropModal.show();

        if (cropper) {
          cropper.destroy();
        }

        cropper = new Cropper(imageToCrop, {
          aspectRatio: 1,
          viewMode: 2,
          autoCropArea: 1,
          responsive: true,
          background: false
        });
      };
      reader.readAsDataURL(file);
    }
  });
}

document.getElementById('cropButton')?.addEventListener('click', function () {
  if (cropper) {
    const canvas = cropper.getCroppedCanvas({
      width: 300,
      height: 300
    });

    canvas.toBlob(function (blob) {
      const reader = new FileReader();
      reader.onloadend = function () {
        const base64data = reader.result;
        document.getElementById('previewImage').src = base64data;
        document.getElementById('profile_image').value = base64data;
        cropModal.hide();
      };
      reader.readAsDataURL(blob);
    });
  }
});

// ========================================
// WHATSAPP TEST CHAT
// ========================================
document.getElementById('testChatBtn')?.addEventListener('click', function () {
  const waNumber = document.getElementById('whatsappNumber').value.trim();

  if (!waNumber) {
    showNotification('error', 'Masukkan nomor WhatsApp terlebih dahulu');
    return;
  }

  const cleanNumber = waNumber.replace(/\D/g, '');
  const fullNumber = '62' + cleanNumber;
  const waUrl = `https://wa.me/${fullNumber}`;

  window.open(waUrl, '_blank');
});

// ========================================
// BACKUP & RESTORE BUTTONS
// ========================================
document.getElementById('exportBtn')?.addEventListener('click', function () {
window.location.href = "http://localhost/API_kmj/admin/export_database.php";
  showNotification('success', 'Database sedang di-export...');
});

document.getElementById('importBtn')?.addEventListener('click', function () {
  const input = document.createElement('input');
  input.type = 'file';
  input.accept = '.sql';

  input.onchange = function (e) {
    const file = e.target.files[0];
    if (file) {
      const confirmModal = new bootstrap.Modal(document.getElementById('confirmRestoreModal'));
      confirmModal.show();

      window.selectedSQLFile = file;
    }
  };

  input.click();
});

document.getElementById('confirmImportBtn')?.addEventListener('click', function () {
  const password = document.getElementById('adminPassword').value;

  if (!password) {
    showNotification('error', 'Masukkan password terlebih dahulu');
    return;
  }

  if (!window.selectedSQLFile) {
    showNotification('error', 'File SQL tidak ditemukan');
    return;
  }

  const formData = new FormData();
  formData.append('password', password);
  formData.append('sql_file', window.selectedSQLFile);

  fetch("http://localhost/API_kmj/admin/import_database.php", {
    method: 'POST',
    credentials: "include",
    body: formData
})

    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showNotification('success', data.message);
        bootstrap.Modal.getInstance(document.getElementById('confirmRestoreModal')).hide();
        document.getElementById('adminPassword').value = '';

        setTimeout(() => {
          location.reload();
        }, 2000);
      } else {
        showNotification('error', data.message);
        document.getElementById('passwordError').style.display = 'block';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification('error', 'Terjadi kesalahan saat restore database');
    });
});

// ========================================
// LOAD DATA SAAT HALAMAN DIMUAT
// ========================================
document.addEventListener('DOMContentLoaded', function () {
  loadGeneralSettings();
  loadSocialSettings();
  loadBackupInfo();
});