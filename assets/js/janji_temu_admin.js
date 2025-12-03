document.addEventListener('DOMContentLoaded', function () {
  console.log('Inquire JS loaded');

  const API_URL = `${BASE_API_URL}/admin/inquire_get_test.php`;
  const STATUS_API_URL = `${BASE_API_URL}/admin/inquire_update_status.php`;

  const tabs = document.querySelectorAll('.inquire-tab');
  const list = document.querySelector('.inquire-list');

  if (!list) {
    console.error('Element .inquire-list tidak ditemukan');
    return;
  }

  // Load pertama
  loadCards('all');

  // Ganti tab
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const filter = tab.getAttribute('data-filter'); // all | pending | responded | closed

      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      loadCards(filter);
    });
  });

  function loadCards(filter) {
    list.innerHTML = `<div class="text-center text-muted">Loading...</div>`;

    let url = API_URL;
    if (filter && filter !== 'all') {
      url += `?status=${encodeURIComponent(filter)}`;
    }

    console.log('FETCH:', url);

    fetch(url)
      .then(r => r.text())
      .then(txt => {
        console.log('RAW RESPONSE:', txt);

        let res;
        try {
          res = JSON.parse(txt);
        } catch (e) {
          list.innerHTML = `<div class="text-danger">Response bukan JSON valid</div>`;
          console.error('JSON parse error', e);
          return;
        }

        if (res.code !== 200) {
          list.innerHTML = `<div class="text-danger">${res.message}</div>`;
          return;
        }

        const data = res.data || [];

        if (!data.length) {
          list.innerHTML = `<div class="text-muted">Belum ada janji temu</div>`;
          if (filter === 'all') {
            updateTabCounts(data);
          }
          return;
        }

        if (filter === 'all') {
          updateTabCounts(data);
        }

        list.innerHTML = '';
        data.forEach(row => {
          list.appendChild(createCard(row));
        });
      })
      .catch(err => {
        console.error(err);
        list.innerHTML = `<div class="text-danger">Terjadi kesalahan saat memuat data</div>`;
      });
  }

  function createCard(row) {
    const wrapper = document.createElement('article');

    // status dari DB: pending | responded | closed | canceled
    let status = row.status;
    wrapper.className = 'inquire-card';
    wrapper.dataset.status = status;

    // label & badge per status
    let badgeClass = 'badge-closed';
    let statusText = 'Closed';

    if (status === 'pending') {
      badgeClass = 'badge-pending';
      statusText = 'Pending';
    } else if (status === 'responded') {
      badgeClass = 'badge-responded';
      statusText = 'Responded';
    } else if (status === 'canceled') {
      badgeClass = 'badge-canceled'; // kalau belum punya CSS-nya, bisa pakai badge-closed dulu
      statusText = 'Canceled';
    }

    const waktuPendek = (row.waktu || '').slice(0, 5);
    const waktuTampil = row.tanggal && waktuPendek
      ? `${row.tanggal} ${waktuPendek}`
      : (row.tanggal || '');

    // footer berbeda tergantung status
    let footerHtml = '';
    if (status === 'pending') {
      footerHtml = `
        <div class="inquire-card-footer">
          <button class="btn-respond" data-id="${row.id_inquire}">Respond</button>
          <button class="btn-icon btn-cancel" data-id="${row.id_inquire}" title="Tolak">✕</button>
        </div>
      `;
    } else if (status === 'responded') {
      footerHtml = `
        <div class="inquire-card-footer">
          <button class="btn-mark-closed" data-id="${row.id_inquire}">Mark as Closed</button>
        </div>
      `;
    }

    wrapper.innerHTML = `
      <div class="inquire-card-header">
        <div>
          <div class="name-row">
            <span class="customer-name">${row.nama_user || row.kode_user || '-'}</span>
            <span class="badge badge-type">Test Drive</span>
          </div>
          <span class="inquire-time">${waktuTampil}</span>
        </div>
        <span class="badge badge-status ${badgeClass}">${statusText}</span>
      </div>

      <div class="inquire-card-body">
        <p><span class="meta-label">Email:</span> ${row.email_user || '-'}</p>
        <p><span class="meta-label">Phone:</span> ${row.no_telp || '-'}</p>
        <p><span class="meta-label">Mobil:</span> ${row.nama_mobil || '-'}</p>

        <div class="inquire-message">
          ${row.note || '-'}
        </div>

        ${footerHtml}
      </div>
    `;

    // tombol Respond -> status responded
    const btnRespond = wrapper.querySelector('.btn-respond');
    if (btnRespond) {
      btnRespond.addEventListener('click', () => {
        updateStatus(row.id_inquire, 'responded');
      });
    }

    // tombol X (tolak) -> status canceled
    const btnCancel = wrapper.querySelector('.btn-cancel');
    if (btnCancel) {
      btnCancel.addEventListener('click', () => {
        updateStatus(row.id_inquire, 'canceled');
      });
    }

    // tombol Mark as Closed -> status closed (selesai)
    const btnMarkClosed = wrapper.querySelector('.btn-mark-closed');
    if (btnMarkClosed) {
      btnMarkClosed.addEventListener('click', () => {
        updateStatus(row.id_inquire, 'closed');
      });
    }

    return wrapper;
  }

  function updateStatus(id, newStatus) {
    if (!confirm(`Ubah status menjadi ${newStatus}?`)) return;

    fetch(STATUS_API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        id_inquire: id,
        status: newStatus
      })
    })
      .then(r => r.json())
      .then(res => {
        if (res.code !== 200) {
          alert(res.message || 'Gagal mengubah status');
          return;
        }

        // reload list sesuai tab aktif
        const activeTab = document.querySelector('.inquire-tab.active');
        const filter = activeTab ? activeTab.getAttribute('data-filter') : 'all';
        loadCards(filter);
      })
      .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan saat mengubah status');
      });
  }

  function updateTabCounts(data) {
    // TIDAK lagi mapping canceled -> closed
    const counts = {
      all: data.length,
      pending: data.filter(x => x.status === 'pending').length,
      responded: data.filter(x => x.status === 'responded').length,
      closed: data.filter(x => x.status === 'closed').length,
      canceled:  data.filter(x => x.status === 'canceled').length,
      // canceled: data.filter(x => x.status === 'canceled').length, // kalau nanti bikin tab baru
    };


    const tabAll = document.querySelector('.inquire-tab[data-filter="all"]');
    const tabPending = document.querySelector('.inquire-tab[data-filter="pending"]');
    const tabResp = document.querySelector('.inquire-tab[data-filter="responded"]');
    const tabClosed = document.querySelector('.inquire-tab[data-filter="closed"]');
    const tabCanceled = document.querySelector('.inquire-tab[data-filter="canceled"]');

    if (tabAll) tabAll.textContent = `All (${counts.all})`;
    if (tabPending) tabPending.textContent = `Pending (${counts.pending})`;
    if (tabResp) tabResp.textContent = `Responded (${counts.responded})`;
    if (tabClosed) tabClosed.textContent = `Closed (${counts.closed})`;
    if (tabCanceled) tabCanceled.textContent = `Canceled (${counts.canceled})`;
  }

});
