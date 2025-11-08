// =========================
// SETTINGS PAGE SCRIPTS (NON-SPA, PHP NATIVE)
// File: assets/js/setting_admin.js
// =========================

document.addEventListener('DOMContentLoaded', function () {

  // -------------------------------------------------------------------
  // 1) CROP AVATAR / LOGO (CropperJS)
  // -------------------------------------------------------------------
  let cropper;
  const uploadLogo   = document.getElementById('uploadLogo');
  const imageToCrop  = document.getElementById('imageToCrop');
  const previewImage = document.getElementById('previewImage');
  const cropModalEl  = document.getElementById('cropModal');
  const cropButton   = document.getElementById('cropButton');
  const profileInput = document.getElementById('profile_image');

  // Guard: hanya jalan kalau elemen ada
  if (uploadLogo && imageToCrop && cropModalEl && cropButton && profileInput) {
    const cropModal = new bootstrap.Modal(cropModalEl);

    uploadLogo.addEventListener('change', (e) => {
      const file = e.target.files?.[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = () => {
        imageToCrop.src = reader.result;

        imageToCrop.onload = () => {
          cropModal.show();

          if (cropper) cropper.destroy();

          cropper = new Cropper(imageToCrop, {
            aspectRatio: 1,
            viewMode: 2,
            autoCropArea: 1,
            responsive: true,
            background: false,
            movable: true,
            zoomable: true,
            dragMode: 'move',
            minContainerWidth: 450,
            minContainerHeight: 450,
            ready() {
              const containerData = cropper.getContainerData();
              const imageData = cropper.getImageData();
              const scaleX = containerData.width / imageData.naturalWidth;
              const scaleY = containerData.height / imageData.naturalHeight;
              const scale = Math.min(scaleX, scaleY);

              cropper.zoomTo(scale);
              cropper.setCropBoxData({
                left:   (containerData.width  - 350) / 2,
                top:    (containerData.height - 350) / 2,
                width:  350,
                height: 350
              });
            }
          });
        };
      };
      reader.readAsDataURL(file);
    });

    cropButton.addEventListener('click', () => {
      if (!cropper) return;

      const canvas = cropper.getCroppedCanvas({ width: 150, height: 150 });
      const croppedImage = canvas.toDataURL('image/png');

      previewImage.src = croppedImage;
      profileInput.value = croppedImage;

      cropModal.hide();
      cropper.destroy();
      cropper = null;
    });

    cropModalEl.addEventListener('hidden.bs.modal', () => {
      if (cropper) {
        cropper.destroy();
        cropper = null;
      }
    });
  }

  // -------------------------------------------------------------------
  // 2) TAB -> BREADCRUMB (sinkron judul breadcrumb dengan tab aktif)
  // -------------------------------------------------------------------
  (function setupTabBreadcrumb() {
    const navLinks = document.querySelectorAll('.settings-menu .nav-link, #settingsTab [data-bs-toggle="pill"]');
    const breadcrumbCurrent = document.getElementById('breadcrumb-current');
    if (!breadcrumbCurrent || !navLinks.length) return;

    navLinks.forEach(link => {
      link.addEventListener('shown.bs.tab', function () {
        const menuText = (this.textContent || this.innerText || '').trim();
        if (menuText) breadcrumbCurrent.textContent = menuText;
      });
    });
  })();

  // -------------------------------------------------------------------
  // 3) TEST WHATSAPP CHAT
  // -------------------------------------------------------------------
  (function setupWhatsAppTest() {
    const btn   = document.getElementById('testChatBtn');
    const input = document.getElementById('whatsappNumber');
    if (!btn || !input) return;

    btn.addEventListener('click', function () {
      const number = input.value.trim();
      if (!number) {
        alert('Masukkan nomor WhatsApp terlebih dahulu.');
        return;
      }
      // Bersihkan karakter non-digit lalu asumsikan input TANPA kode negara
      const cleanNumber = number.replace(/\D/g, '');
      // Jika kamu ingin user bisa input "62..." langsung, silakan deteksi:
      // const finalNumber = cleanNumber.startsWith('62') ? cleanNumber : `62${cleanNumber}`;
      const finalNumber = `62${cleanNumber}`;
      window.open(`https://wa.me/${finalNumber}`, '_blank');
    });
  })();

  // -------------------------------------------------------------------
  // 4) IMPORT / RESTORE DATABASE (Modal konfirmasi)
  //    - Tambahan dari mainadmin.js: tombol #importBtn untuk buka modal
  // -------------------------------------------------------------------
  (function setupRestoreModal() {
    const importBtn         = document.getElementById('importBtn');            // tombol untuk menampilkan modal
    const confirmModalEl    = document.getElementById('confirmRestoreModal');  // elemen modal
    const confirmImportBtn  = document.getElementById('confirmImportBtn');     // tombol konfirmasi di modal
    const adminPasswordInput= document.getElementById('adminPassword');
    const passwordError     = document.getElementById('passwordError');

    if (!confirmModalEl) return;
    const confirmModal = new bootstrap.Modal(confirmModalEl);

    // Tambahan: buka modal saat klik "Restore" (jika ada tombolnya)
    if (importBtn) {
      importBtn.addEventListener('click', () => confirmModal.show());
    }

    if (confirmImportBtn && adminPasswordInput && passwordError) {
      confirmImportBtn.addEventListener('click', () => {
        const enteredPassword = adminPasswordInput.value.trim();

        if (enteredPassword === '') {
          passwordError.textContent = 'Password tidak boleh kosong.';
          passwordError.style.display = 'block';
          return;
        }

        // TODO: Ganti validasi hardcode ke AJAX ke PHP (production)
        if (enteredPassword === 'admin123') {
          passwordError.style.display = 'none';
          confirmModal.hide();
          // Lanjut ke proses import (server-side)
          window.location.href = 'import_database.php';
        } else {
          passwordError.textContent = 'Password salah. Coba lagi.';
          passwordError.style.display = 'block';
        }
      });
    }
  })();

  // -------------------------------------------------------------------
  // 5) SCHEDULE BUILDER (pindahan dari mainadmin.js)
  //    - Container target: #scheduleContainer (tab "Schedule")
  // -------------------------------------------------------------------
  (function setupSchedule() {
    const container = document.getElementById('scheduleContainer');
    if (!container) return;

    // Hari dalam bahasa Indonesia (Senin-Minggu)
    const days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
    container.innerHTML = '';

    // Render baris per hari
    days.forEach(day => {
      const row = document.createElement('div');
      row.className = 'day-row d-flex align-items-start justify-content-between border-bottom py-3';
      row.innerHTML = `
        <div class="d-flex align-items-center gap-3">
          <div class="form-check form-switch">
            <input class="form-check-input schedule-toggle" type="checkbox" id="toggle-${day}" ${['Jumat','Sabtu','Minggu'].includes(day) ? '' : 'checked'}>
          </div>
          <label for="toggle-${day}" class="fw-semibold" style="width:80px;">${day}</label>
        </div>
        <div class="flex-fill ms-3" id="slots-${day}"></div>
      `;
      container.appendChild(row);
    });

    function createTimeDropdown(defaultValue = '09.00') {
      const select = document.createElement('select');
      select.className = 'form-select form-select-sm d-inline-block w-auto mx-1';
      const times = [];
      for (let h = 0; h < 24; h++) {
        for (let m = 0; m < 60; m += 30) {
          const time = `${String(h).padStart(2,'0')}.${String(m).padStart(2,'0')}`;
          times.push(time);
        }
      }
      times.forEach(t => {
        const opt = document.createElement('option');
        opt.value = t; opt.textContent = t;
        if (t === defaultValue) opt.selected = true;
        select.appendChild(opt);
      });
      return select;
    }

    function addSlot(day, start='09.00', end='12.00') {
      const slots = document.getElementById(`slots-${day}`);
      if (!slots) return;

      const slotDiv = document.createElement('div');
      slotDiv.className = 'slot d-flex align-items-center gap-2 mb-2 flex-wrap';

      const startSelect = createTimeDropdown(start);
      const endSelect   = createTimeDropdown(end);

      const dash = document.createElement('span');
      dash.textContent = '—';

      const del = document.createElement('i');
      del.className = 'bx bx-trash text-danger fs-5 ms-2 delete-slot';
      del.style.cursor = 'pointer';

      slotDiv.appendChild(startSelect);
      slotDiv.appendChild(dash);
      slotDiv.appendChild(endSelect);
      slotDiv.appendChild(del);

      // sisipkan sebelum tombol add (kalau ada)
      const addBtn = slots.querySelector('.add-slot-btn');
      if (addBtn) slots.insertBefore(slotDiv, addBtn);
      else slots.appendChild(slotDiv);

      del.addEventListener('click', () => slotDiv.remove());
    }

    // Init toggle + state awal
    document.querySelectorAll('.schedule-toggle').forEach(toggle => {
      const day = toggle.id.replace('toggle-','');
      const slotsWrap = document.getElementById(`slots-${day}`);

      function renderState() {
        if (!slotsWrap) return;
        slotsWrap.innerHTML = '';

        if (toggle.checked) {
          // default 1 slot
          addSlot(day);

          // tombol tambah slot
          const addBtn = document.createElement('a');
          addBtn.href = '#';
          addBtn.className = 'text-primary small fw-semibold add-slot-btn d-block mt-1';
          addBtn.textContent = '+ Add slot';
          addBtn.addEventListener('click', (e) => {
            e.preventDefault();
            addSlot(day);
          });
          slotsWrap.appendChild(addBtn);
        } else {
          const unavailable = document.createElement('div');
          unavailable.className = 'text-muted small mt-1';
          unavailable.textContent = 'Unavailable';
          slotsWrap.appendChild(unavailable);
        }
      }

      toggle.addEventListener('change', renderState);
      renderState();
    });

    // OPTIONAL: fungsi serialize kalau mau submit ke server
    // window.getScheduleData = function () {
    //   const result = {};
    //   days.forEach(day => {
    //     const enabled = document.getElementById(`toggle-${day}`)?.checked;
    //     if (!enabled) { result[day] = []; return; }
    //     const slots = [];
    //     document.querySelectorAll(`#slots-${day} .slot`).forEach(slot => {
    //       const selects = slot.querySelectorAll('select');
    //       if (selects.length === 2) {
    //         slots.push({ start: selects[0].value, end: selects[1].value });
    //       }
    //     });
    //     result[day] = slots;
    //   });
    //   return result;
    // };
  })();

});
