const API_PERBANDINGAN_BASE = (window.BASE_API_URL || '/API_kmj');
const API_GET_PERBANDINGAN = `${API_PERBANDINGAN_BASE}/user/routes/perbandingan.php`;

document.addEventListener('DOMContentLoaded', () => {
  const sectionEl = document.querySelector('.compare-section');
  const car1Code = sectionEl?.dataset.car1 || '';
  const car2Code = sectionEl?.dataset.car2 || '';

  const highlightGroup = document.getElementById('highlight-group');
  const similaritiesGroup = document.getElementById('similarities-group');
  const differencesGroup = document.getElementById('differences-group');
  const specsGroup = document.getElementById('specs-group');

  const car1TitleEl = document.getElementById('car1-title');
  const car2TitleEl = document.getElementById('car2-title');
  const car1SubtitleEl = document.getElementById('car1-subtitle');
  const car2SubtitleEl = document.getElementById('car2-subtitle');
  const car1PhotoEl = document.getElementById('car1-photo');
  const car2PhotoEl = document.getElementById('car2-photo');

  const tabsContainer = document.getElementById('comparisonTabs');
  const tabItems = tabsContainer ? tabsContainer.querySelectorAll('li[data-tab]') : [];
  const sections = Array.from(document.querySelectorAll('.comparison-section'));
  const backToTop = document.getElementById('backToTop');
  const stickyHeader = document.querySelector('.compare-header-sticky');

  // =========================
  // Helper
  // =========================
  const safeValue = (v) => {
    if (v === null || v === undefined || v === '') return '-';
    return v;
  };

  const formatRupiah = (n) => {
    if (n === null || n === undefined || n === '') return '-';
    const num = Number(n);
    if (Number.isNaN(num)) return n;
    return 'Rp ' + num.toLocaleString('id-ID');
  };

  const formatAngsuranTenor = (car) => {
    if (!car) return '-';
    const { angsuran, tenor } = car;
    if (!angsuran && !tenor) return '-';
    const angs = formatRupiah(angsuran || 0);
    const tnr = tenor || '-';
    return `${angs} × ${tnr}`;
  };

  // bikin 1 row compare biasa (label + 2 box)
  const createCompareRow = (label, value1, value2) => {
    const row = document.createElement('div');
    row.className = 'compare-feature-row';

    const nameDiv = document.createElement('div');
    nameDiv.className = 'compare-feature-name';
    nameDiv.textContent = label;

    const box1 = document.createElement('div');
    box1.className = 'compare-feature-box';
    box1.textContent = safeValue(value1);

    const box2 = document.createElement('div');
    box2.className = 'compare-feature-box';
    box2.textContent = safeValue(value2);

    row.appendChild(nameDiv);
    row.appendChild(box1);
    row.appendChild(box2);
    return row;
  };

  // row untuk fitur boolean (✓ / ✗)
  const createBooleanRow = (label, has1, has2) => {
    const row = document.createElement('div');
    row.className = 'compare-feature-row';

    const nameDiv = document.createElement('div');
    nameDiv.className = 'compare-feature-name';
    nameDiv.textContent = label;

    const box1 = document.createElement('div');
    box1.className = 'compare-feature-box';
    box1.innerHTML = has1
      ? `<span class="compare-feature-check">✓</span><span>Ya</span>`
      : `<span class="compare-feature-cross">✗</span><span>Tidak</span>`;

    const box2 = document.createElement('div');
    box2.className = 'compare-feature-box';
    box2.innerHTML = has2
      ? `<span class="compare-feature-check">✓</span><span>Ya</span>`
      : `<span class="compare-feature-cross">✗</span><span>Tidak</span>`;

    row.appendChild(nameDiv);
    row.appendChild(box1);
    row.appendChild(box2);
    return row;
  };

  // =========================
  // Panggil API & render
  // =========================
  const loadComparisonData = async () => {
    if (!car1Code || !car2Code) {
      console.warn('Kode mobil (car1 & car2) belum lengkap di URL');
      return;
    }

    try {
       const url = `${API_GET_PERBANDINGAN}?car1=${encodeURIComponent(
      car1Code
    )}&car2=${encodeURIComponent(car2Code)}`;


      const res = await fetch(url);
      const json = await res.json();

      if (!json.status) {
        console.error('API perbandingan error:', json.message);
        return;
      }

      const data = json.data || {};
      const cars = data.cars || [];
      const car1 = cars[0] || {};
      const car2 = cars[1] || {};
      const features = data.features || {};
      const similarities = features.similarities || [];
      const differences = features.differences || [];

      // ----- header + foto -----
      if (car1TitleEl) car1TitleEl.textContent = safeValue(car1.nama_mobil || 'Mobil 1');
      if (car2TitleEl) car2TitleEl.textContent = safeValue(car2.nama_mobil || 'Mobil 2');

      if (car1SubtitleEl) {
        const tipe1 = safeValue(car1.jenis_kendaraan);
        const tahun1 = safeValue(car1.tahun_mobil);
        car1SubtitleEl.textContent = `${tipe1} • ${tahun1}`;
      }
      if (car2SubtitleEl) {
        const tipe2 = safeValue(car2.jenis_kendaraan);
        const tahun2 = safeValue(car2.tahun_mobil);
        car2SubtitleEl.textContent = `${tipe2} • ${tahun2}`;
      }

      if (car1PhotoEl && car1.foto_depan) {
        car1PhotoEl.src = car1.foto_depan;
      }
      if (car2PhotoEl && car2.foto_depan) {
        car2PhotoEl.src = car2.foto_depan;
      }

      // ----- HIGHLIGHT (row fixed) -----
      if (highlightGroup) {
        highlightGroup.innerHTML = '';

        highlightGroup.appendChild(
          createCompareRow('Warna exterior', car1.warna_exterior, car2.warna_exterior)
        );
        highlightGroup.appendChild(
          createCompareRow('Warna interior', car1.warna_interior, car2.warna_interior)
        );
        highlightGroup.appendChild(
          createCompareRow('Angsuran × Tenor', formatAngsuranTenor(car1), formatAngsuranTenor(car2))
        );
        highlightGroup.appendChild(
          createCompareRow('Harga Full', formatRupiah(car1.full_prize), formatRupiah(car2.full_prize))
        );
      }

      // ----- KESAMAAN (fitur boolean dari API) -----
      if (similaritiesGroup) {
        similaritiesGroup.innerHTML = '';
        if (similarities.length === 0) {
          similaritiesGroup.appendChild(
            createCompareRow('Data fitur', 'Belum ada data kesamaan fitur', '-')
          );
        } else {
          similarities.forEach((f) => {
            similaritiesGroup.appendChild(
              createBooleanRow(f.label, !!f.car1, !!f.car2)
            );
          });
        }
      }

      // ----- PERBEDAAN (fitur boolean dari API) -----
      if (differencesGroup) {
        differencesGroup.innerHTML = '';
        if (differences.length === 0) {
          differencesGroup.appendChild(
            createCompareRow('Data fitur', 'Belum ada data perbedaan fitur', '-')
          );
        } else {
          differences.forEach((f) => {
            differencesGroup.appendChild(
              createBooleanRow(f.label, !!f.car1, !!f.car2)
            );
          });
        }
      }

      // ----- SPESIFIKASI (row fixed) -----
      if (specsGroup) {
        specsGroup.innerHTML = '';

        specsGroup.appendChild(
          createCompareRow('Tahun', car1.tahun_mobil, car2.tahun_mobil)
        );
        specsGroup.appendChild(
          createCompareRow('Jarak tempuh (KM)', car1.jarak_tempuh, car2.jarak_tempuh)
        );
        specsGroup.appendChild(
          createCompareRow('Jenis kendaraan', car1.jenis_kendaraan, car2.jenis_kendaraan)
        );
        specsGroup.appendChild(
          createCompareRow('Sistem penggerak', car1.sistem_penggerak, car2.sistem_penggerak)
        );
        specsGroup.appendChild(
          createCompareRow('Jenis bahan bakar', car1.tipe_bahan_bakar, car2.tipe_bahan_bakar)
        );
        specsGroup.appendChild(
          createCompareRow('Harga Full', formatRupiah(car1.full_prize), formatRupiah(car2.full_prize))
        );
        specsGroup.appendChild(
          createCompareRow('Angsuran', formatRupiah(car1.angsuran), formatRupiah(car2.angsuran))
        );
        specsGroup.appendChild(
          createCompareRow('Tenor', car1.tenor, car2.tenor)
        );
      }
    } catch (err) {
      console.error('Gagal load data perbandingan:', err);
    }
  };

  // =========================
  // Behaviour tab + scroll
  // =========================
  tabItems.forEach((li) => {
    li.addEventListener('click', () => {
      const targetId = li.getAttribute('data-tab');
      const targetEl = document.getElementById(`tab-${targetId}`);
      if (!targetEl) return;

      const headerOffset = stickyHeader ? stickyHeader.offsetHeight + 16 : 140;

      window.scrollTo({
        top: targetEl.offsetTop - headerOffset,
        behavior: 'smooth',
      });
    });
  });

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const id = entry.target.id.replace('tab-', '');
        tabItems.forEach((li) => {
          li.classList.toggle('is-active', li.getAttribute('data-tab') === id);
        });
      });
    },
    {
      root: null,
      threshold: 0.25,
      rootMargin: '-160px 0px -60%',
    }
  );

  sections.forEach((sec) => observer.observe(sec));

  window.addEventListener('scroll', () => {
    if (backToTop) {
      backToTop.style.display = window.scrollY > 300 ? 'block' : 'none';
    }
  });

  if (backToTop) {
    backToTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // terakhir: load data dari API
  loadComparisonData();
});
