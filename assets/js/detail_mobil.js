

document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll("#detailTabs .nav-link");
  const sections = [...navLinks].map(link => document.querySelector(link.getAttribute("href")));

  window.addEventListener("scroll", () => {
    let current = "";
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 100; // biar pas gak ketutup nav
      if (window.scrollY >= sectionTop) {
        current = section.getAttribute("id");
      }
    });

    navLinks.forEach(link => {
      link.classList.remove("active");
      if (link.getAttribute("href") === "#" + current) {
        link.classList.add("active");
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const wrapper = document.querySelector('.gallery-wrapper');
  const btnLeft = document.querySelector('.scroll-btn.left');
  const btnRight = document.querySelector('.scroll-btn.right');

  if (wrapper && btnLeft && btnRight) {
    btnLeft.addEventListener('click', () => {
      wrapper.scrollBy({ left: -800, behavior: 'smooth' });
    });
    btnRight.addEventListener('click', () => {
      wrapper.scrollBy({ left: 800, behavior: 'smooth' });
    });
  }
});

// Efek shadow saat discroll
window.addEventListener("scroll", function() {
  const tabs = document.querySelector(".sticky-tabs");
  if (window.scrollY > 200) {
    tabs.classList.add("stuck");
  } else {
    tabs.classList.remove("stuck");
  }
});

// Scroll ke section + ubah warna aktif
const tabButtons = document.querySelectorAll(".tab-item");

tabButtons.forEach(btn => {
  btn.addEventListener("click", function() {
    // hapus active dari semua
    tabButtons.forEach(b => b.classList.remove("active"));
    this.classList.add("active");

    // ambil target id
    const target = document.querySelector(this.dataset.target);
    if (target) {
      window.scrollTo({
        top: target.offsetTop - 70, // biar gak ketutupan sticky
        behavior: "smooth"
      });
    }
  });
});
