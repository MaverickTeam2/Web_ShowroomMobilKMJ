console.log("🧩 [mobil.js] FILE BERHASIL DIMUAT oleh browser!");

// =========================
// KONFIGURASI URL API
// (ganti sesuai lokasi API kamu)
// =========================
const BASE_API_URL = "http://localhost/API_kmj"; // folder API

// ✅ Fungsi utama
function initMobilForm() {
  const formMobil = document.getElementById("formMobil");
  if (!formMobil) {
    console.warn("⚠️ [mobil.js] Form #formMobil belum ditemukan, akan dicek ulang nanti...");
    // Coba lagi setelah 500ms kalau DOM belum siap
    setTimeout(initMobilForm, 500);
    return;
  }

  console.log("✅ [mobil.js] formMobil ditemukan, pasang event listener");

  let isSubmitting = false;

  // Bersihkan event listener lama (cara aman)
  formMobil.replaceWith(formMobil.cloneNode(true));
  const newForm = document.getElementById("formMobil");

  newForm.addEventListener("submit", async function (e) {
    console.log("🟡 [mobil.js] Submit formMobil terpicu!");
    e.preventDefault();

    if (isSubmitting) {
      console.warn("⚠️ [mobil.js] Submit diabaikan, sedang proses...");
      return;
    }

    isSubmitting = true;

    const formData = new FormData(this);

    // 🔧 Jika file kosong, hapus dari FormData
    const fileInput = this.querySelector('input[type="file"][name="gambar_mobil"]');
    if (fileInput && fileInput.files.length === 0) {
      console.log("🖼️ [mobil.js] Tidak ada gambar dipilih, hapus field dari FormData");
      formData.delete("gambar_mobil");
    }

    console.log("📤 [mobil.js] Data siap dikirim:", Array.from(formData.entries()));

    try {
      // 🔁 Kirim ke API terpisah (bukan lagi di folder web)
      const response = await fetch("../../API_kmj/admin/mobil_tambah.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();
      console.log("✅ [mobil.js] Hasil response:", result);

      alert(result.message);

      if (result.success) {
        console.log("✅ [mobil.js] Sukses tambah mobil, reload halaman manajemen_mobil.php");
        loadPage("templates/admin/manajemen_mobil.php");
      }
    } catch (err) {
      console.error("❌ [mobil.js] Gagal kirim data:", err);
      alert("Gagal menambah data mobil!");
    } finally {
      isSubmitting = false;
    }
  });
}

// ✅ Jalankan langsung setelah file dimuat
document.addEventListener("DOMContentLoaded", () => {
  console.log("🕐 [mobil.js] DOM siap, memanggil initMobilForm()");
  initMobilForm();
});
