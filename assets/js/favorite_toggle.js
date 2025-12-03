// assets/js/favorite_toggle.js

document.addEventListener('DOMContentLoaded', () => {
  // kalo variable global ga ada, langsung keluar
  if (typeof BASE_API_URL === 'undefined') {
    console.error('BASE_API_URL tidak terdefinisi');
    return;
  }

  // event delegation biar bisa dipakai di semua halaman
  document.addEventListener('click', async (event) => {
    const icon = event.target.closest('.icon-favorite');
    if (!icon) return; // klik bukan di icon-favorite

    event.preventDefault();
    event.stopPropagation();

    const kodeMobil = icon.dataset.kodeMobil;

    if (!kodeMobil) {
      console.error('data-kode-mobil tidak ada di icon', icon);
      return;
    }

    // Cek login
    if (typeof IS_LOGGED_IN === 'undefined' || !IS_LOGGED_IN) {
      const go = confirm('Kamu harus login untuk menambahkan ke favorit. Pergi ke halaman login?');
      if (go) {
        const currentUrl = window.location.pathname + window.location.search;
        window.location.href =
          '/web_showroommobilKMJ/templates/auth/auth.php?redirect=' +
          encodeURIComponent(currentUrl);
      }
      return;
    }

    if (typeof CURRENT_USER === 'undefined' || !CURRENT_USER.kode_user) {
      console.error('CURRENT_USER.kode_user tidak tersedia');
      alert('Data user tidak lengkap, silakan login ulang.');
      return;
    }

    const isActive = icon.classList.contains('active');
    const action = isActive ? 'remove' : 'add';

    try {
      const res = await fetch(BASE_API_URL + '/user/routes/favorites.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          kode_user: CURRENT_USER.kode_user,
          kode_mobil: kodeMobil,
          action: action
        })
      });

      const data = await res.json();
      console.log('FAVORITE RESPONSE:', data);

      if (data.success) {
        icon.classList.toggle('active');
      } else {
        alert(data.message || 'Gagal mengubah data favorit');
      }
    } catch (err) {
      console.error(err);
      alert('Terjadi kesalahan server saat mengubah favorit.');
    }
  });
});
