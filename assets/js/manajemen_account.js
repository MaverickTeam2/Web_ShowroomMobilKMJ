// =========================
// KONFIG API
// =========================
const API_LIST_ACCOUNT  = `${BASE_API_URL}/admin/get_manage_acc_list.php`;
const API_UPDATE_STATUS = `${BASE_API_URL}/admin/update_status_manage_acc.php`;


// =========================
// Helper: format teks last login
// =========================
function buildLastLoginText(item) {
  if (item.last_login) return `Last login: ${item.last_login}`;
  if (item.updated_at) return `Update: ${item.updated_at}`;
  if (item.created_at) return `Dibuat: ${item.created_at}`;
  return '';
}


// =========================
// Render 1 kartu akun
// =========================
function renderAccountCard(item) {
  const kodeUser   = item.kode_user;
  const fullName   = item.full_name || '-';
  const email      = item.email || '-';
  const role       = (item.role || '').toLowerCase();
  const roleLabel  = role.charAt(0).toUpperCase() + role.slice(1);
  const isActive   = String(item.status) === '1';
  const avatar = `${BASE_API_URL}${item.avatar_url}`;
  const lastLogin  = buildLastLoginText(item);
  const badgeRoleClass = role === 'admin' ? 'badge-admin' : 'badge-owner';
  const statusClass    = isActive ? 'badge-aktif' : 'badge-nonaktif';
  const statusText     = isActive ? 'Aktif' : 'NonAktif';
  const checkedAttr    = isActive ? 'checked' : '';

  return `
    <div class="col-lg-6 col-md-12">
      <div class="account-card h-100">
        <div class="account-card-top">
          <img
            src="${avatar}"
            alt="${fullName}"
            class="account-avatar"
          />

          <div class="account-info">
            <h2 class="account-name">${fullName}</h2>
            <p class="account-email mb-1">${email}</p>
            <p class="account-login mb-0">${lastLogin}</p>
          </div>
        </div>

        <div class="account-card-bottom">
          <div class="account-badges">
            <span class="badge-role ${badgeRoleClass}">
              ${roleLabel}
            </span>

            <span
              id="status-badge-${kodeUser}"
              class="badge-status ${statusClass}"
            >
              ${statusText}
            </span>

            <label class="toggle-switch">
              <input
                type="checkbox"
                id="toggle-${kodeUser}"
                ${checkedAttr}
                onchange="toggleStatus('${kodeUser}', this.checked)"
              />
              <span class="toggle-slider"></span>
            </label>
          </div>

          <a
            href="edit_account.php?kode_user=${encodeURIComponent(kodeUser)}"
            class="btn-edit"
            data-page="edit_account.php?kode_user=${encodeURIComponent(kodeUser)}"
          >
            <i class='bx bx-edit-alt'></i>
            Edit
          </a>
        </div>
      </div>
    </div>
  `;
}


// =========================
// Ambil list akun dari API
// =========================
async function loadAccounts() {
  const container = document.getElementById('account-list');
  if (!container) {
    console.warn('#account-list tidak ditemukan');
    return;
  }

  container.innerHTML = `<p class="text-muted">Memuat data akun...</p>`;

  if (typeof BASE_API_URL === 'undefined') {
    console.error('BASE_API_URL belum didefinisikan');
    container.innerHTML = `<p class="text-danger">Konfigurasi API belum benar (BASE_API_URL tidak ada).</p>`;
    return;
  }

  try {
    const res  = await fetch(API_LIST_ACCOUNT);
    const text = await res.text();
    let json   = {};
    try { json = JSON.parse(text); } catch (_) {}

    console.log('LIST response status:', res.status);
    console.log('LIST raw:', text);

    const kode = json.kode ?? json.code;

    if (!res.ok || kode !== 200) {
      throw new Error(json.message || `Gagal mengambil data akun (status ${res.status}).`);
    }

    const list = json.data || [];

    if (!Array.isArray(list) || list.length === 0) {
      container.innerHTML = `<p class="text-muted">Belum ada data admin / owner.</p>`;
      return;
    }

    container.innerHTML = '';

    list.forEach(item => {
      const r = String(item.role || '').toLowerCase();
      if (!['admin', 'owner'].includes(r)) return;
      container.insertAdjacentHTML('beforeend', renderAccountCard(item));
    });

  } catch (err) {
    console.error('LIST error:', err);
    container.innerHTML = `<p class="text-danger">Terjadi kesalahan saat memuat data akun.</p>`;
  }
}


// =========================
// Toggle status Aktif / NonAktif
// =========================
async function toggleStatus(kodeUser, isActive) {
  const badgeEl  = document.getElementById(`status-badge-${kodeUser}`);
  const checkbox = document.getElementById(`toggle-${kodeUser}`);

  if (!badgeEl || !checkbox) return;

  const prevText    = badgeEl.textContent;
  const prevClass   = badgeEl.className;
  const prevChecked = !isActive;

  // Optimistic UI
  badgeEl.textContent = isActive ? 'Aktif' : 'NonAktif';
  badgeEl.className   = 'badge-status ' + (isActive ? 'badge-aktif' : 'badge-nonaktif');

  try {
    const res  = await fetch(API_UPDATE_STATUS, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        kode_user: kodeUser,
        status: isActive ? 1 : 0
      })
    });

    const text = await res.text();
    let json   = {};
    try { json = JSON.parse(text); } catch (_) {}

    console.log('STATUS response status:', res.status);
    console.log('STATUS raw:', text);

    const kode = json.kode ?? json.code;

    if (!res.ok || (kode !== 200 && kode !== 201)) {
      throw new Error(json.message || `Gagal update status user (status ${res.status}).`);
    }

  } catch (err) {
    console.error('STATUS error:', err);
    alert('Gagal mengubah status. Silakan coba lagi.');

    checkbox.checked    = prevChecked;
    badgeEl.textContent = prevText;
    badgeEl.className   = prevClass;
  }
}


// =========================
// Helper: ambil kode_user dari query string
// =========================
function getKodeUserFromPage(page) {
  try {
    const parts = page.split("?");
    if (parts.length < 2) return null;
    const params = new URLSearchParams(parts[1]);
    return params.get("kode_user");
  } catch (e) {
    console.error("Gagal parse kode_user dari page:", page, e);
    return null;
  }
}


// =========================
// loadPage (SPA) & delegasi
// =========================
function loadPage(page) {
  const mainContent = document.getElementById("main-content");
  if (mainContent && page) {
    fetch(page)
      .then(r => {
        console.log("LOAD PAGE", page, "status:", r.status);
        if (!r.ok) throw new Error("Halaman tidak ditemukan");
        return r.text();
      })
      .then(html => {
        mainContent.innerHTML = html;
        window.scrollTo({ top: 0, behavior: "smooth" });

        // Kalau edit_account.php → panggil initEditAccount kalau ada
        if (page.startsWith("edit_account.php")) {
          const kode = getKodeUserFromPage(page);
          console.log("Kode user untuk edit:", kode);
          if (kode && typeof window.initEditAccount === "function") {
            try {
              window.initEditAccount(kode);
            } catch (e) {
              console.error("initEditAccount error:", e);
              // jangan lempar error lagi, supaya nggak masuk ke catch fetch
            }
          }
        } else if (page.startsWith("manajemen_account.php")) {
          // balik ke halaman list -> reload data akun
          loadAccounts();
        }
      })
      .catch(err => {
        console.error("Gagal memuat halaman:", err);
        alert("Gagal membuka halaman: " + page);
      });
  } else if (page) {
    window.location.href = page;
  }
}

// Delegasi klik untuk semua data-page
document.addEventListener("click", function(e) {
  const target = e.target.closest("[data-page]");
  if (target) {
    const page = target.getAttribute("data-page");
    if (page) {
      e.preventDefault();
      loadPage(page);
    }
  }
});

document.addEventListener('DOMContentLoaded', () => {
  loadAccounts();
});

// expose ke global (dipakai di HTML inline)
window.toggleStatus = toggleStatus;
window.loadPage     = loadPage;
