// Base URL untuk API
const API_BASE_URL = 'http://localhost/API_KMJ/admin';

// ========================================
// GENERAL SETTINGS
// ========================================
function loadGeneralSettings() {
    fetch(`${API_BASE_URL}/get_general_settings.php`)
        .then(response => response.json())
        .then(data => {
            console.log('Loaded Settings:', data);
            if (data.success) {
                document.getElementById('showroomStatus').checked = data.data.showroom_status == 1;
                document.getElementById('sellCarStatus').checked = data.data.jual_mobil == 1;
                document.getElementById('scheduleStatus').checked = data.data.schedule_pelanggan == 1;
            }
        })
        .catch(error => console.error('Error loading general settings:', error));
}

function saveGeneralSettings() {
    const formData = new FormData();
    
    if (document.getElementById('showroomStatus').checked) {
        formData.append('showroom_status', '1');
    }
    if (document.getElementById('sellCarStatus').checked) {
        formData.append('jual_mobil', '1');
    }
    if (document.getElementById('scheduleStatus').checked) {
        formData.append('schedule_pelanggan', '1');
    }

    fetch(`${API_BASE_URL}/save_general_settings.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Save Response:', data);
        if (data.success) {
            showNotification('success', data.message);
        } else {
            showNotification('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Terjadi kesalahan saat menyimpan pengaturan');
    });
}

// ========================================
// ACCOUNT SETTINGS - UPDATE FOTO PROFIL
// ========================================
function saveAccountSettings() {
    const formData = new FormData();
    
    formData.append('fullname', document.querySelector('input[name="fullname"]').value);
    formData.append('username', document.querySelector('input[name="username"]').value);
    formData.append('phone', document.querySelector('input[name="phone"]').value);
    formData.append('old_password', document.querySelector('input[name="old_password"]').value);
    formData.append('new_password', document.querySelector('input[name="new_password"]').value);
    formData.append('confirm_password', document.querySelector('input[name="confirm_password"]').value);
    
    // Ambil base64 foto dari hidden input
    const profileImage = document.getElementById('profile_image').value;
    if (profileImage) {
        formData.append('profile_image', profileImage);
    }

    fetch(`${API_BASE_URL}/save_account_settings.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', data.message);
            
            // Update foto profil di halaman jika ada
            if (data.avatar_url) {
                // Update preview image dengan URL dari API_KMJ
                const previewImg = document.getElementById('previewImage');
                if (previewImg) {
                    previewImg.src = 'http://localhost/API_KMJ' + data.avatar_url + '?t=' + new Date().getTime();
                }
            }
            
            // Reset password fields
            document.querySelector('input[name="old_password"]').value = '';
            document.querySelector('input[name="new_password"]').value = '';
            document.querySelector('input[name="confirm_password"]').value = '';
            
            // Clear profile_image hidden input
            document.getElementById('profile_image').value = '';
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
    fetch(`${API_BASE_URL}/get_schedule_settings.php`)
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

    fetch(`${API_BASE_URL}/save_schedule_settings.php`, {
        method: 'POST',
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
    fetch(`${API_BASE_URL}/get_social_settings.php`)
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

    fetch(`${API_BASE_URL}/save_social_settings.php`, {
        method: 'POST',
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
    fetch(`${API_BASE_URL}/get_backup_info.php`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const timeElements = document.querySelectorAll('.bg-light .text-secondary');
                if (timeElements[0]) timeElements[0].textContent = data.data.backup_time_formatted;
                if (timeElements[1]) timeElements[1].textContent = data.data.backup_size_mb + ' MB';
            }
        })
        .catch(error => console.error('Error loading backup info:', error));
}

// ========================================
// TOMBOL SAVE CHANGES
// ========================================
const saveChangesBtn = document.querySelector('.head-title .btn-primary');
if (saveChangesBtn) {
    saveChangesBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const activeTab = document.querySelector('.tab-pane.active');
        if (!activeTab) {
            showNotification('error', 'Tab tidak ditemukan');
            return;
        }
        
        const activeTabId = activeTab.id;
        
        switch(activeTabId) {
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
    tab.addEventListener('shown.bs.tab', function(e) {
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
    // Hapus notifikasi lama jika ada
    const oldNotification = document.querySelector('.alert.position-fixed');
    if (oldNotification) {
        oldNotification.remove();
    }

    const notification = document.createElement('div');
    const alertClass = type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info';
    notification.className = `alert alert-${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove setelah 5 detik
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
const cropModalElement = document.getElementById('cropModal');

// Gunakan Bootstrap jika tersedia
let cropModal = null;
if (typeof bootstrap !== 'undefined' && cropModalElement) {
    cropModal = new bootstrap.Modal(cropModalElement);
}

if (uploadLogo) {
    uploadLogo.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validasi ukuran file (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                showNotification('error', 'Ukuran file terlalu besar! Maksimal 5MB');
                return;
            }

            // Validasi tipe file
            if (!file.type.match('image.*')) {
                showNotification('error', 'File harus berupa gambar!');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imageToCrop.src = event.target.result;
                
                if (cropModal) {
                    cropModal.show();
                } else if (cropModalElement) {
                    cropModalElement.style.display = 'block';
                    cropModalElement.classList.add('show');
                }
                
                if (cropper) {
                    cropper.destroy();
                }
                
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                    minCropBoxWidth: 100,
                    minCropBoxHeight: 100
                });
            };
            reader.readAsDataURL(file);
        }
    });
}

const cropButton = document.getElementById('cropButton');
if (cropButton) {
    cropButton.addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
            
            canvas.toBlob(function(blob) {
                const reader = new FileReader();
                reader.onloadend = function() {
                    const base64data = reader.result;
                    
                    // Update preview image
                    document.getElementById('previewImage').src = base64data;
                    
                    // Simpan base64 ke hidden input
                    document.getElementById('profile_image').value = base64data;
                    
                    // Hide modal
                    if (cropModal) {
                        cropModal.hide();
                    } else if (cropModalElement) {
                        cropModalElement.style.display = 'none';
                        cropModalElement.classList.remove('show');
                    }

                    showNotification('success', 'Foto berhasil di-crop! Klik "Save Changes" untuk menyimpan.');
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg', 0.9);
        }
    });
}

// ========================================
// WHATSAPP TEST CHAT
// ========================================
const testChatBtn = document.getElementById('testChatBtn');
if (testChatBtn) {
    testChatBtn.addEventListener('click', function() {
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
}

// ========================================
// BACKUP & RESTORE BUTTONS
// ========================================
const exportBtn = document.getElementById('exportBtn');
if (exportBtn) {
    exportBtn.addEventListener('click', function() {
        window.location.href = `${API_BASE_URL}/export_database.php`;
        showNotification('success', 'Database sedang di-export...');
    });
}

const importBtn = document.getElementById('importBtn');
if (importBtn) {
    importBtn.addEventListener('click', function() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = '.sql';
        
        input.onchange = function(e) {
            const file = e.target.files[0];
            if (file) {
                const confirmModalElement = document.getElementById('confirmRestoreModal');
                
                if (typeof bootstrap !== 'undefined' && confirmModalElement) {
                    const confirmModal = new bootstrap.Modal(confirmModalElement);
                    confirmModal.show();
                } else if (confirmModalElement) {
                    confirmModalElement.style.display = 'block';
                    confirmModalElement.classList.add('show');
                }
                
                window.selectedSQLFile = file;
            }
        };
        
        input.click();
    });
}

const confirmImportBtn = document.getElementById('confirmImportBtn');
if (confirmImportBtn) {
    confirmImportBtn.addEventListener('click', function() {
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
        
        fetch(`${API_BASE_URL}/import_database.php`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('success', data.message);
                
                const confirmModalElement = document.getElementById('confirmRestoreModal');
                if (typeof bootstrap !== 'undefined' && confirmModalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(confirmModalElement);
                    if (modalInstance) modalInstance.hide();
                } else if (confirmModalElement) {
                    confirmModalElement.style.display = 'none';
                    confirmModalElement.classList.remove('show');
                }
                
                document.getElementById('adminPassword').value = '';
                
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                showNotification('error', data.message);
                const passwordError = document.getElementById('passwordError');
                if (passwordError) passwordError.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat restore database');
        });
    });
}

// ========================================
// LOAD DATA SAAT HALAMAN DIMUAT
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded! API Base URL:', API_BASE_URL);
    loadGeneralSettings();
    loadSocialSettings();
    loadBackupInfo();
});