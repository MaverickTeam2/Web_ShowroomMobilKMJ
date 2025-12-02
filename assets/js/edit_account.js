// SESUAIKAN dengan nama file API kamu
const API_GET_ACCOUNT_DETAIL = `${BASE_API_URL}/admin/get_manage_acc_detail.php`;
const API_UPDATE_ACCOUNT     = `${BASE_API_URL}/admin/update_user_manage_acc.php`;

// helper pesan
function showEditAccountMessage(text, type) {
  const box = document.getElementById('editAccountMessage');
  if (!box) return;

  if (!text) {
    box.innerHTML = '';
    return;
  }

  const cls =
    type === 'success' ? 'alert alert-success' :
    type === 'danger'  ? 'alert alert-danger'  :
                         'alert alert-secondary';

  box.innerHTML = `<div class="${cls}" role="alert">${text}</div>`;
}

// ============= Inisialisasi EDIT (dipanggil dari manajemen_account.js) =============
async function initEditAccount(kodeUser) {
  if (!kodeUser) {
    console.error('initEditAccount: kodeUser kosong');
    return;
  }

  const hidden = document.getElementById('edit_kode_user');
  if (hidden) hidden.value = kodeUser;

  await loadEditAccountDetail(kodeUser);
}

// ambil detail user untuk isi form
async function loadEditAccountDetail(kodeUser) {
  const url = `${API_GET_ACCOUNT_DETAIL}?kode_user=${encodeURIComponent(kodeUser)}`;

  try {
    const res  = await fetch(url);
    const text = await res.text();
    let json   = {};
    try { json = JSON.parse(text); } catch (_) {}

    console.log('EDIT DETAIL status:', res.status);
    console.log('EDIT DETAIL raw:', text);

    const kode = json.kode ?? json.code;
    if (!res.ok || kode !== 200) {
      throw new Error(json.message || 'Gagal mengambil data user');
    }

    const data = json.data || {};
    console.log('EDIT DETAIL data object:', data);
    fillEditFormFromData(data);

  } catch (err) {
    console.error('EDIT DETAIL error:', err);
    showEditAccountMessage('Gagal memuat data akun.', 'danger');
  }
}

// isi field form dari data API
function fillEditFormFromData(data) {
  const fullName = data.full_name || '';

  const fullnameEl = document.getElementById('fullname_edit');
  const usernameEl = document.getElementById('username_edit');
  const phoneEl    = document.getElementById('phone_edit');
  const emailEl    = document.getElementById('email_edit');
  const addressEl  = document.getElementById('address_edit');

  if (fullnameEl) fullnameEl.value = fullName;
  if (usernameEl) usernameEl.value = data.username || '';
  if (phoneEl)    phoneEl.value    = data.no_telp || '';
  if (emailEl)    emailEl.value    = data.email || '';
  if (addressEl)  addressEl.value  = data.alamat || '';
}

// ============= Submit update (delegasi) =============
document.addEventListener('submit', async (e) => {
  const form = e.target;
  if (!(form instanceof HTMLFormElement)) return;
  if (form.id !== 'formEditAccount') return;

  e.preventDefault();

  const kodeUserEl  = document.getElementById('edit_kode_user');
  const fullnameEl  = document.getElementById('fullname_edit');
  const phoneEl     = document.getElementById('phone_edit');
  const addressEl   = document.getElementById('address_edit');
  const btnSubmit   = document.getElementById('btnSubmitEdit');

  const kode_user = kodeUserEl ? kodeUserEl.value.trim() : '';
  const full_name = fullnameEl ? fullnameEl.value.trim() : '';
  const no_telp   = phoneEl ? phoneEl.value.trim() : '';
  const alamat    = addressEl ? addressEl.value.trim() : '';

  if (!kode_user) {
    showEditAccountMessage('Kode user tidak ditemukan.', 'danger');
    return;
  }
  if (!full_name || !no_telp || !alamat) {
    showEditAccountMessage('Nama lengkap, telepon, dan alamat wajib diisi.', 'danger');
    return;
  }

  const payload = {
    kode_user,
    full_name,
    no_telp,
    alamat
  };

  if (btnSubmit) {
    btnSubmit.disabled = true;
    btnSubmit.innerText = 'Menyimpan...';
  }
  showEditAccountMessage('', '');

  try {
    const res  = await fetch(API_UPDATE_ACCOUNT, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });

    const text = await res.text();
    let json   = {};
    try { json = JSON.parse(text); } catch (_) {}

    console.log('EDIT UPDATE status:', res.status);
    console.log('EDIT UPDATE raw:', text);

    const kode = json.kode ?? json.code;
    if (!res.ok || (kode !== 200 && kode !== 201)) {
      const msg = json.message || `Gagal memperbarui user (status ${res.status}).`;
      throw new Error(msg);
    }

    showEditAccountMessage('Akun berhasil diperbarui.', 'success');

    setTimeout(() => {
      if (typeof loadPage === 'function') {
        loadPage('manajemen_account.php');
      } else {
        window.location.href = 'manajemen_account.php';
      }
    }, 800);

  } catch (err) {
    console.error('EDIT UPDATE error:', err);
    showEditAccountMessage(
      err.message || 'Terjadi kesalahan saat menyimpan perubahan.',
      'danger'
    );
  } finally {
    if (btnSubmit) {
      btnSubmit.disabled = false;
      btnSubmit.innerText = 'Simpan Perubahan';
    }
  }
});

// expose init ke global supaya bisa dipanggil dari manajemen_account.js
window.initEditAccount = initEditAccount;
