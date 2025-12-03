console.log('add_account.js LOADED');

const API_CREATE_ACCOUNT = `${BASE_API_URL}/admin/create_manage_acc.php`;

// helper pesan
function showAddAccountMessage(text, type) {
  const msgBox = document.getElementById('addAccountMessage');
  if (!msgBox) return;

  if (!text) {
    msgBox.innerHTML = '';
    return;
  }

  const cls =
    type === 'success' ? 'alert alert-success' :
    type === 'danger'  ? 'alert alert-danger'  :
                         'alert alert-secondary';

  msgBox.innerHTML = `<div class="${cls}" role="alert">${text}</div>`;
}

// ========== SUBMIT FORM (delegasi) ==========
document.addEventListener('submit', async (e) => {
  const form = e.target;
  if (!(form instanceof HTMLFormElement)) return;
  if (form.id !== 'formAddAccount') return; // cuma form tambah akun

  console.log('SUBMIT KE TANGKAP add_account.js', e.target);

  e.preventDefault(); // cegah submit default

  const fullnameEl = document.getElementById('fullname');
  const usernameEl = document.getElementById('username');
  const passwordEl = document.getElementById('password');
  const phoneEl    = document.getElementById('phone');
  const emailEl    = document.getElementById('email');
  const addressEl  = document.getElementById('address');
  const btnSubmit  = document.getElementById('btnSubmitAdd');

  const full_name = fullnameEl.value.trim();
  const username  = usernameEl.value.trim();
  const password  = passwordEl.value;
  const no_telp   = phoneEl.value.trim();
  const email     = emailEl.value.trim();
  const alamat    = addressEl.value.trim();

  if (!full_name || !username || !password || !no_telp || !email || !alamat) {
    showAddAccountMessage('Semua field wajib diisi.', 'danger');
    return;
  }

  if (typeof BASE_API_URL === 'undefined') {
    console.error('BASE_API_URL belum didefinisikan');
    showAddAccountMessage(
      'Konfigurasi API belum benar (BASE_API_URL tidak ditemukan).',
      'danger'
    );
    return;
  }

  // kirim sebagai FormData karena register/create_manage_acc awalnya pakai itu
  const fd = new FormData();
  fd.append('full_name', full_name);
  fd.append('username', username);
  fd.append('password', password);
  fd.append('no_telp', no_telp);
  fd.append('email', email);
  fd.append('alamat', alamat);
  fd.append('role', 'admin');
  fd.append('provider_type', 'local');
  // TIDAK ada avatar_file -> backend akan pakai avatar default

  if (btnSubmit) {
    btnSubmit.disabled = true;
    btnSubmit.innerText = 'Menyimpan...';
  }
  showAddAccountMessage('', '');

  try {
    const res  = await fetch(API_CREATE_ACCOUNT, { method: 'POST', body: fd });
    const raw  = await res.text();
    let json   = {};
    try { json = JSON.parse(raw); } catch (_) {}

    console.log('REGISTER status:', res.status);
    console.log('REGISTER raw:', raw);

    const code = json.kode ?? json.code;
    if (!res.ok || (code !== 200 && code !== 201)) {
      const msg = json.message || `Gagal menambah akun (status ${res.status}).`;
      throw new Error(msg);
    }

    showAddAccountMessage('Akun admin berhasil dibuat.', 'success');

    setTimeout(() => {
      if (typeof loadPage === 'function') {
        loadPage('manajemen_account.php');
      } else {
        window.location.href = 'manajemen_account.php';
      }
    }, 1000);

  } catch (err) {
    console.error('REGISTER error:', err);
    showAddAccountMessage(
      err.message || 'Terjadi kesalahan saat menyimpan akun.',
      'danger'
    );
  } finally {
    if (btnSubmit) {
      btnSubmit.disabled = false;
      btnSubmit.innerText = 'Simpan';
    }
  }
});
