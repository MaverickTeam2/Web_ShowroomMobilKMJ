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

    // ✅ CEK: minimal 1 fitur dipilih
    const fiturCheckboxes = document.querySelectorAll('input[name="fitur[]"]');
    const fiturError = document.getElementById("fiturError");

    const anyChecked = Array.from(fiturCheckboxes).some((cb) => cb.checked);

    if (!anyChecked) {
      // kalau belum ada yang dipilih, jangan kirim ke API
      if (fiturError) {
        fiturError.textContent = "Pilih minimal 1 fitur atau spesifikasi mobil.";
      }
      if (fiturCheckboxes[0]) {
        fiturCheckboxes[0].focus();
      }
      return; // ⛔ stop di sini
    } else {
      // kalau valid, bersihkan pesan error
      if (fiturError) {
        fiturError.textContent = "";
      }
    }

    // ✅ CEK: User sudah login atau belum
    // ✅ CEK: User sudah login atau belum
    let kodeUser = null;

    // 1) Pakai variabel global dari PHP (diisi di manajemen_mobil.php / tambah_stok_mobil.php)
    if (typeof window !== "undefined" && window.KMJ_KODE_USER) {
      kodeUser = window.KMJ_KODE_USER;
    }

    // ❌ JANGAN fallback ke storage lagi di kasus ini
    // (supaya nggak ketarik US001 dari localStorage lama)

    // kalau tetap kosong → anggap belum login
    if (!kodeUser) {
      alert("⚠️ Session login tidak ditemukan. Silakan login ulang.");
      console.error("❌ [mobil.js] kode_user tidak ditemukan (KMJ_KODE_USER kosong)");
      window.location.href = "../../auth/auth.php"; // atau login.php, sesuaikan
      return;
    }

    console.log("✅ [mobil.js] kode_user ditemukan dari PHP:", kodeUser);


    // kalau sudah lolos validasi, baru lanjut submit
    isSubmitting = true;

    const formData = new FormData(this);

    // ✅ TAMBAHKAN kode_user ke FormData
    formData.append('kode_user', kodeUser);
    console.log("📦 [mobil.js] kode_user ditambahkan ke FormData:", kodeUser);

    // ✅ ========== HANDLER FOTO TAMBAHAN (WEB) ==========
    const fotoTambahanInput = document.querySelector('input[name="foto_tambahan[]"]');

    if (fotoTambahanInput && fotoTambahanInput.files.length > 0) {
      console.log("📸 [mobil.js] Foto tambahan detected:", fotoTambahanInput.files.length);

      // Hapus entry lama foto_tambahan[] (karena backend tidak support array)
      formData.delete('foto_tambahan[]');

      const files = Array.from(fotoTambahanInput.files);
      const maxFiles = 6; // Maksimal 6 foto tambahan

      // Batasi hanya 6 foto
      const filesToUpload = files.slice(0, maxFiles);

      if (files.length > maxFiles) {
        alert(`⚠️ Maksimal ${maxFiles} foto tambahan. Hanya ${maxFiles} foto pertama yang akan diupload.`);
      }

      // Convert ke format slot (sama seperti Android)
      // foto_tambahan_slot_0, foto_tambahan_slot_1, dst
      filesToUpload.forEach((file, index) => {
        formData.append(`foto_tambahan_slot_${index}`, file);
        console.log(`✅ [mobil.js] Added foto_tambahan_slot_${index}:`, file.name);
      });
    } else {
      console.log("ℹ[mobil.js] No foto tambahan uploaded");
    }
    // ✅ ========== END HANDLER FOTO TAMBAHAN ==========

    // Debug: lihat apa saja yang dikirim
    console.log("[mobil.js] Data siap dikirim:");
    for (let pair of formData.entries()) {
      if (pair[1] instanceof File) {
        console.log(`  ${pair[0]}: [FILE] ${pair[1].name}`);
      } else {
        console.log(`  ${pair[0]}: ${pair[1]}`);
      }
    }

    try {
      const url = `${BASE_API_URL}/admin/mobil_tambah.php`;

      Swal.fire({
        title: "Uploading...",
        text: "Mohon tunggu",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      const response = await fetch(url, {
        method: "POST",
        body: formData,
        credentials: "include",
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
        isSubmitting = false;
        return;
      }

      console.log("✅ [mobil.js] Hasil response (parsed):", result);

      alert(result.message || "Response dari server.");

      if (result.success) {
        console.log("✅ [mobil.js] Sukses, pindah ke manajemen_mobil.php");

        // Cek apakah ada loadPage function (untuk SPA)
        if (typeof loadPage === 'function') {
          loadPage('manajemen_mobil.php');
        } else {
          window.location.href = "manajemen_mobil.php";
        }
      } else {
        console.warn("⚠️ [mobil.js] API success=false:", result.message);
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

// =========================
// PREVIEW FOTO
// =========================
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

    // Jika multiple (foto tambahan)
    if (input.multiple) {
      const files = Array.from(input.files);
      const maxShow = 6; // Tampilkan max 6 thumbnail
      const maxFiles = 6; // Max upload 6 foto

      // Warning jika lebih dari 6
      if (files.length > maxFiles) {
        const warning = document.createElement("div");
        warning.style.color = "#e74c3c";
        warning.style.fontWeight = "600";
        warning.style.marginBottom = "10px";
        warning.style.fontSize = "0.9rem";
        warning.textContent = `⚠️ Maksimal ${maxFiles} foto. Hanya ${maxFiles} foto pertama yang akan diupload.`;
        preview.appendChild(warning);
      }

      // Buat grid container
      const grid = document.createElement("div");
      grid.style.display = "grid";
      grid.style.gridTemplateColumns = "repeat(auto-fill, minmax(100px, 1fr))";
      grid.style.gap = "10px";
      grid.style.marginTop = "10px";

      files.slice(0, maxShow).forEach((file, index) => {
        const wrapper = document.createElement("div");
        wrapper.style.position = "relative";
        wrapper.style.paddingBottom = "100%";
        wrapper.style.overflow = "hidden";
        wrapper.style.borderRadius = "8px";
        wrapper.style.border = "2px solid #e0e0e0";

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.style.position = "absolute";
        img.style.top = "0";
        img.style.left = "0";
        img.style.width = "100%";
        img.style.height = "100%";
        img.style.objectFit = "cover";

        // Badge nomor
        const badge = document.createElement("span");
        badge.textContent = index + 1;
        badge.style.position = "absolute";
        badge.style.top = "5px";
        badge.style.right = "5px";
        badge.style.background = "#4169E1";
        badge.style.color = "white";
        badge.style.borderRadius = "50%";
        badge.style.width = "24px";
        badge.style.height = "24px";
        badge.style.display = "flex";
        badge.style.alignItems = "center";
        badge.style.justifyContent = "center";
        badge.style.fontSize = "12px";
        badge.style.fontWeight = "bold";

        wrapper.appendChild(img);
        wrapper.appendChild(badge);
        grid.appendChild(wrapper);
      });

      preview.appendChild(grid);

      if (files.length > maxShow) {
        const more = document.createElement("span");
        more.textContent = `+${files.length - maxShow} lagi`;
        more.style.display = "block";
        more.style.marginTop = "10px";
        more.style.fontSize = "0.85rem";
        more.style.color = "#666";
        preview.appendChild(more);
      }
    } else {
      // Single file (360, depan, belakang, samping)
      const file = input.files[0];
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      preview.appendChild(img);
    }
  });
});

// =========================
// MODE EDIT - Load Foto Lama
// =========================
if (window.existingMobilFoto) {
  console.log("📄 [mobil.js] Mode EDIT terdeteksi — load foto lama...");
  console.log("📷 [mobil.js] Foto existing:", window.existingMobilFoto);

  window.existingMobilFoto.forEach((f) => {
    let inputName = "";

    if (f.tipe_foto === "tambahan") {
      inputName = "foto_tambahan[]";
    } else {
      inputName = "foto_" + f.tipe_foto;
    }

    const dz = document.querySelector(`input[name="${inputName}"]`)?.closest(".foto-dropzone");
    if (!dz) {
      console.warn(`⚠️ [mobil.js] Dropzone tidak ditemukan untuk: ${inputName}`);
      return;
    }

    const preview = dz.querySelector(".dz-preview-img");
    const subtext = dz.querySelector(".dz-sub");

    if (subtext) subtext.style.display = "none";

    // Jika foto tambahan (multiple), buat grid
    if (f.tipe_foto === "tambahan") {
      if (!preview.querySelector(".foto-grid")) {
        const grid = document.createElement("div");
        grid.className = "foto-grid";
        grid.style.display = "grid";
        grid.style.gridTemplateColumns = "repeat(auto-fill, minmax(100px, 1fr))";
        grid.style.gap = "10px";
        grid.style.marginTop = "10px";
        preview.appendChild(grid);
      }

      const grid = preview.querySelector(".foto-grid");
      const wrapper = document.createElement("div");
      wrapper.style.position = "relative";
      wrapper.style.paddingBottom = "100%";
      wrapper.style.overflow = "hidden";
      wrapper.style.borderRadius = "8px";
      wrapper.style.border = "2px solid #4169E1";

      const img = document.createElement("img");
      img.src = f.nama_file;
      img.style.position = "absolute";
      img.style.top = "0";
      img.style.left = "0";
      img.style.width = "100%";
      img.style.height = "100%";
      img.style.objectFit = "cover";

      wrapper.appendChild(img);
      grid.appendChild(wrapper);
    } else {
      // Foto utama (single)
      const img = document.createElement("img");
      img.src = f.nama_file;
      img.alt = f.tipe_foto || "";
      preview.appendChild(img);
    }
  });

  console.log("🟢 [mobil.js] Foto lama berhasil ditampilkan!");
  window.existingMobilFoto = null;
}