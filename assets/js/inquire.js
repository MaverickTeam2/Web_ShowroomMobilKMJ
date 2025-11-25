document.addEventListener('DOMContentLoaded', function () {
  console.log('Inquire JS loaded');

  // === SESUAIKAN nama file API di sini ===
  const API_URL = "http://localhost/API_kmj/admin/inquire_get_test.php";
  // kalau nanti sudah fix nama filenya:
  // const API_URL = "http://localhost/API_kmj/admin/inquire_get.php";

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
      .then(r => r.text())           // ambil sebagai text dulu buat debug
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
          list.innerHTML = `<div class="text-muted">Belum ada inquiry</div>`;
          updateTabCounts(data);
          return;
        }

        updateTabCounts(data);

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
    wrapper.className = 'inquire-card';
    wrapper.dataset.status = row.status; // pending / responded / closed / canceled

    // kalau dari DB masih 'canceled', tampilin sebagai 'Closed'
    let status = row.status;
    if (status === 'canceled') status = 'closed';

    const statusText = status.charAt(0).toUpperCase() + status.slice(1);

    let badgeClass = 'badge-closed';
    if (status === 'pending') badgeClass = 'badge-pending';
    else if (status === 'responded') badgeClass = 'badge-responded';

    const waktuPendek = (row.waktu || '').slice(0, 5);
    const waktuTampil =
      row.tanggal && waktuPendek ? `${row.tanggal} ${waktuPendek}` : (row.tanggal || '');

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
        <p><span class="meta-label">Vehicle:</span> ${row.nama_mobil || row.kode_mobil || '-'}</p>

        <div class="inquire-message">-</div>

        <div class="inquire-card-footer">
          ${
            status === 'pending'
              ? `<button class="btn-respond">Respond</button>`
              : status === 'responded'
              ? `<button class="btn-mark-closed">Mark as Closed</button>`
              : ``
          }
        </div>
      </div>
    `;

    return wrapper;
  }

  function updateTabCounts(data) {
    // mapping 'canceled' jadi 'closed'
    const norm = data.map(d => ({
      ...d,
      status: d.status === 'canceled' ? 'closed' : d.status
    }));

    const counts = {
      all: norm.length,
      pending: norm.filter(x => x.status === 'pending').length,
      responded: norm.filter(x => x.status === 'responded').length,
      closed: norm.filter(x => x.status === 'closed').length,
    };

    const tabAll = document.querySelector('.inquire-tab[data-filter="all"]');
    const tabPending = document.querySelector('.inquire-tab[data-filter="pending"]');
    const tabResp = document.querySelector('.inquire-tab[data-filter="responded"]');
    const tabClosed = document.querySelector('.inquire-tab[data-filter="closed"]');

    if (tabAll) tabAll.textContent = `All (${counts.all})`;
    if (tabPending) tabPending.textContent = `Pending (${counts.pending})`;
    if (tabResp) tabResp.textContent = `Responded (${counts.responded})`;
    if (tabClosed) tabClosed.textContent = `Closed (${counts.closed})`;
  }

});
