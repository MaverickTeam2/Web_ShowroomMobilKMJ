console.log("🧩 [mobil.js] FILE BERHASIL DIMUAT oleh browser!");

// =========================
// KONFIGURASI URL API
// =========================
// ⚠️ JANGAN definisikan ulang BASE_API_URL di sini!
// Variabel ini sudah diberikan oleh PHP melalui include/header.php
// Contoh di header.php:
// <script> const BASE_API_URL = "https://api.domainmu.com"; </script>
// =========================

// ✅ Fungsi utama (dibuat global supaya bisa dipanggil dari manajemen_mobil.php)
function initMobilForm() {
  const formMobil = document.getElementById("formMobil");
  if (!formMobil) {
    console.warn("⚠️ [mobil.js] Form #formMobil belum ditemukan...");
    return;
  }

  // Cegah dipasang dobel
  if (formMobil.dataset.bound === "true") {
    console.log("ℹ️ [mobil.js] Event listener sudah terpasang, skip.");
    return;
  }
  formMobil.dataset.bound = "true";

  console.log("✅ [mobil.js] formMobil ditemukan, pasang event listener");

  let isSubmitting = false;

  formMobil.addEventListener("submit", async function (e) {
    console.log("🟡 [mobil.js] Submit formMobil terpicu!");
    e.preventDefault(); // 🚫 jangan reload halaman

    if (isSubmitting) {
      console.warn("⚠️ [mobil.js] Submit diabaikan, sedang proses...");
      return;
    }

    isSubmitting = true;

    const formData = new FormData(this);

    // (optional) debug: lihat apa saja yang dikirim
    console.log("📤 [mobil.js] Data siap dikirim:", Array.from(formData.entries()));

    try {
      const url = `${BASE_API_URL}/admin/mobil_tambah.php`;
      console.log("📡 [mobil.js] Mengirim ke URL:", url);

      const response = await fetch(url, {
        method: "POST",
        body: formData,
      });

      console.log("📡 [mobil.js] HTTP status:", response.status);

      const rawText = await response.text();
      console.log("📦 [mobil.js] Raw response dari server:", rawText);

      let result;
      try {
        result = JSON.parse(rawText);
      } catch (parseErr) {
        console.error("❌ [mobil.js] Gagal parse JSON:", parseErr);
        alert("API mengirim response yang tidak valid:\n" + rawText);
        return;
      }

      console.log("✅ [mobil.js] Hasil response (parsed):", result);

      alert(result.message || "Response dari server.");

      if (result.success) {
        console.log("✅ [mobil.js] Sukses tambah mobil, pindah ke manajemen_mobil.php");
        window.location.href = "manajemen_mobil.php";
      } else {
        console.warn("⚠️ [mobil.js] API success=false, data mungkin tidak tersimpan.");
      }
    } catch (err) {
      console.error("❌ [mobil.js] Gagal kirim data (network/JS error):", err);
      alert("Gagal menambah data mobil! (Network/JS error)");
    } finally {
      isSubmitting = false;
    }
  });
}

// Biar bisa dipanggil juga dari script lain
window.initMobilForm = initMobilForm;

// Langsung coba inisialisasi saat file ini dimuat
console.log("🕐 [mobil.js] Memanggil initMobilForm() saat script dimuat");
initMobilForm();
console.log("🖼 [mobil.js] Setup preview foto...");

const dropzones = document.querySelectorAll(".foto-dropzone");

dropzones.forEach((dz) => {
  const input = dz.querySelector('input[type="file"]');
  const preview = dz.querySelector(".dz-preview-img");
  const subtext = dz.querySelector(".dz-sub");

  if (!input || !preview) return;

  input.addEventListener("change", () => {
    preview.innerHTML = ""; // clear dulu

    if (!input.files || input.files.length === 0) {
      if (subtext) subtext.style.display = "";
      return;
    }

    if (subtext) subtext.style.display = "none";

    // Jika multiple
    if (input.multiple) {
      const files = Array.from(input.files);
      const maxShow = 4;

      files.slice(0, maxShow).forEach((file) => {
        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
      });

      if (files.length > maxShow) {
        const more = document.createElement("span");
        more.textContent = `+${files.length - maxShow} lagi`;
        preview.appendChild(more);
      }
    } else {
      const file = input.files[0];
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      preview.appendChild(img);
    }
  });
});

// =========================
// MODE EDIT
// =========================
// =========================
// MODE EDIT
// =========================
if (window.existingMobilFoto) {
  console.log("[mobil.js] Mode EDIT terdeteksi — load foto lama...");

  window.existingMobilFoto.forEach((f) => {
    let inputName = "";

    if (f.tipe_foto === "tambahan") {
      inputName = "foto_tambahan[]";
    } else {
      inputName = "foto_" + f.tipe_foto;
    }

    const dz = document.querySelector(`input[name="${inputName}"]`)?.closest(".foto-dropzone");
    if (!dz) return;

    const preview = dz.querySelector(".dz-preview-img");
    const subtext = dz.querySelector(".dz-sub");
    if (subtext) subtext.style.display = "none";

    const img = document.createElement("img");
    img.src = f.nama_file;
    img.alt = f.tipe_foto || "";
    preview.appendChild(img);
  });

  console.log("🟢 [mobil.js] Foto lama berhasil ditampilkan!");
  window.existingMobilFoto = null;
}
