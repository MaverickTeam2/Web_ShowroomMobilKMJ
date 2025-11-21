document.addEventListener('DOMContentLoaded', function () {
  const tabs = document.querySelectorAll('.inquire-tab');
  const cards = document.querySelectorAll('.inquire-card');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const filter = tab.getAttribute('data-filter');

      // ubah tab aktif
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      // filter card berdasarkan data-status
      cards.forEach(card => {
        const status = card.getAttribute('data-status');

        if (filter === 'all' || status === filter) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
});
