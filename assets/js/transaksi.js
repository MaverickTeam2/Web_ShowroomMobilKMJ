(() => {
  console.log("✅ transaksi.js aktif");

  const path = window.location.pathname;

  // ======================================================
  // 📄 HALAMAN: transaksi.php (list & modal detail)
  // ======================================================
  if (path.endsWith("transaksi.php")) {
    console.log("Halaman transaksi.php terdeteksi");

    const btnTambah    = document.getElementById("btn-tambah-transaksi");
    const modalElement = document.getElementById("modalDetailTransaksi");
    const modalBody    = document.getElementById("modalDetailBody");

    // Tombol tambah transaksi
    if (btnTambah) {
      btnTambah.addEventListener("click", (e) => {
        e.preventDefault();
        console.log("🟢 Tambah transaksi diklik");
        window.location.href = "tambah_transaksi.php";
      });
    }

   // Tombol detail transaksi
const detailButtons = document.querySelectorAll(".btn-detail");
detailButtons.forEach((btn) => {
  btn.addEventListener("click", async (e) => {
    e.preventDefault();

    const id = (btn.dataset.id || "").trim();
    if (!id) {
      console.warn("❗ data-id kosong pada tombol detail");
      return;
    }

    console.log("🔍 Lihat detail transaksi ID:", id);

    if (modalBody) {
      modalBody.innerHTML = `
        <div class="text-center my-3">
          <div class="spinner-border text-primary" role="status"></div>
          <p class="mt-2 text-muted">Memuat data transaksi...</p>
        </div>
      `;
    }

    try {
      const API_URL = "http://localhost/API_kmj/admin/transaksi.php";

      const res = await fetch(
        `${API_URL}?action=detail&id=${encodeURIComponent(id)}`,
        { method: "GET", headers: { Accept: "application/json" } }
      );

      const text = await res.text();
      let payload;
      try {
        payload = JSON.parse(text);
      } catch {
        throw new Error("Respons bukan JSON: " + text.slice(0, 200));
      }

      if (!res.ok || payload.status === "error" || !payload.data) {
        throw new Error(payload.message || "Gagal mengambil data");
      }

      const d = payload.data;
      const status = (d.status || "").toLowerCase();
      const badge =
        status === "completed" ? "bg-success" :
        status === "pending"   ? "bg-warning text-dark" :
        "bg-danger";

      modalBody.innerHTML = `
        <div>
          <h5 class="fw-bold mb-3">Detail Transaksi #${d.kode_transaksi || "-"}</h5>
          <div class="row mb-3">
            <div class="col-md-6">
              <p><b>Nama Pembeli:</b> ${d.nama_pembeli ?? "-"}</p>
              <p><b>No HP:</b> ${d.no_hp ?? "-"}</p>
              <p><b>Tipe Pembayaran:</b> ${d.tipe_pembayaran ?? "-"}</p>
              <p><b>Harga Akhir:</b> Rp ${Number(d.harga_akhir || 0).toLocaleString("id-ID")}</p>
            </div>
            <div class="col-md-6">
              <p><b>Tanggal:</b> ${d.created_at ?? "-"}</p>
              <p><b>Kasir:</b> ${d.kasir ?? "-"}</p>
              <p><b>Status:</b> <span class="badge ${badge}">${status ? status[0].toUpperCase()+status.slice(1) : "-"}</span></p>
            </div>
          </div>
          <hr>
          <h6 class="fw-bold mt-3">Detail Mobil</h6>
          <ul class="mb-0">
            <li><b>Nama Mobil:</b> ${d.nama_mobil ?? "-"}</li>
            <li><b>Tahun:</b> ${d.tahun_mobil ?? "-"}</li>
          </ul>
        </div>
      `;

      // ✅ show modal di sini untuk kasus sukses
      if (modalElement) new bootstrap.Modal(modalElement).show();

    } catch (err) {
      console.error("❌ Error mengambil data transaksi:", err);
      if (modalBody) {
        modalBody.innerHTML = `
          <p class="text-center text-danger my-3">
            Terjadi kesalahan saat mengambil data transaksi.
          </p>`;
      }
      // ✅ dan show modal juga saat error
      if (modalElement) new bootstrap.Modal(modalElement).show();
    }
  });
});


  // ======================================================
  // 📄 HALAMAN: tambah_transaksi.php
  // ======================================================
  if (path.endsWith("tambah_transaksi.php")) {
    console.log("📄 Mode: tambah transaksi aktif");

    // --- elemen preview & form ---
    const jenisMobil      = document.getElementById("jenisMobil");
    const mobilPreview    = document.getElementById("mobilPreview");
    const mobilImage      = document.getElementById("mobilImage");
    const mobilNama       = document.getElementById("mobilNama");
    const mobilHarga      = document.getElementById("mobilHarga");
    const mobilDetail     = document.getElementById("mobilDetail");
    const mobilKm         = document.getElementById("mobilKm");
    const mobilTahun      = document.getElementById("mobilTahun");
    const tipeMobilInput  = document.getElementById("tipeMobil");
    const jenisPembayaran = document.getElementById("jenisPembayaran");
    const fieldNamaKredit = document.getElementById("field-nama-kredit");

    // --- helpers ---
    const toNum  = (v) => Number(v || 0);
    const toIDR  = (n) => "Rp " + toNum(n).toLocaleString("id-ID");
    const showPrev = () => mobilPreview && mobilPreview.classList.remove("d-none");
    const hidePrev = () => mobilPreview && mobilPreview.classList.add("d-none");

    // --- toggle kredit/tunai ---
    if (jenisPembayaran && fieldNamaKredit) {
      const apply = () => {
        const isKredit = (jenisPembayaran.value || "").toLowerCase() === "kredit";
        fieldNamaKredit.style.display = isKredit ? "block" : "none";
      };
      apply();
      jenisPembayaran.addEventListener("change", apply);
    }

    // --- preview mobil saat dipilih ---
    if (jenisMobil) {
      jenisMobil.addEventListener("change", handleMobilChange);
      if (jenisMobil.value && jenisMobil.value !== "") {
        handleMobilChange().catch((e) => console.warn(e));
      }
    }

    async function handleMobilChange() {
      const idMobil = (jenisMobil.value || "").trim();
      if (!idMobil) { hidePrev(); setTipe("-"); return; }

      try {
        const res = await fetch(`get_mobil.php?id=${encodeURIComponent(idMobil)}`, {
          headers: { Accept: "application/json" },
        });
        const raw = await res.text();

        let data;
        try {
          data = JSON.parse(raw);
        } catch (e) {
          throw new Error("Response bukan JSON valid: " + raw.slice(0, 120));
        }

        if (!data || data.status !== "ok") {
          hidePrev(); setTipe("-"); return;
        }

        if (mobilImage)   mobilImage.src          = data.foto || "";
        if (mobilNama)    mobilNama.textContent   = data.nama_mobil || "-";
        if (mobilHarga)   mobilHarga.textContent  = data.harga ? toIDR(data.harga) : "-";
        if (mobilDetail)  mobilDetail.textContent = data.dp ? `DP ${toIDR(data.dp)}` : "-";
        if (mobilKm)      mobilKm.textContent     = `${toNum(data.km).toLocaleString("id-ID")} Km`;
        if (mobilTahun)   mobilTahun.textContent  = data.tahun || "-";

        setTipe(data.tipe || "-");
        showPrev();
      } catch (err) {
        console.error("❌ Gagal ambil data mobil:", err);
        hidePrev(); setTipe("-");
      }
    }

    function setTipe(v) {
      if (!tipeMobilInput) return;
      if (tipeMobilInput.tagName === "SELECT") {
        tipeMobilInput.innerHTML = "";
        const opt = document.createElement("option");
        opt.value = v; opt.textContent = v; opt.selected = true;
        tipeMobilInput.appendChild(opt);
      } else {
        tipeMobilInput.value = v;
      }
    }

        // ======================================================
    // 🚀 SUBMIT FORM → API create transaksi
    // ======================================================

    const form = document.querySelector(".tambah-transaksi-form");

    // Ambil elemen input utama (ingat, kamu sudah kasih id di PHP)
    const namaPembeli = document.getElementById("namaPembeli");
    const noHp = document.getElementById("noHp");
    const dealPrice = document.getElementById("dealPrice");

    // NOTE: kode_user HARUS dari session, sementara hardcode dulu
    const KODE_USER = "USR001";

    const toNumber = (str) =>
      Number(String(str || "0").replace(/\D/g, "")); // hapus Rp, titik, koma dll

    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const payload = {
        action: "create",
        nama_pembeli: namaPembeli.value.trim(),
        no_hp: noHp.value.trim(),
        tipe_pembayaran: jenisPembayaran.value,
        harga_akhir: toNumber(dealPrice.value),
        kode_mobil: jenisMobil.value, // sudah value kode_mobil karena kamu ganti di PHP
        kode_user: KODE_USER,
        status: "pending"
      };

      console.log("📤 Payload kirim:", payload);

      try {
        const res = await fetch(
          "http://localhost/API_kmj/admin/transaksi.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
            body: JSON.stringify(payload),
          }
        );

        const json = await res.json();
        console.log("📥 Response API:", json);

        if (!res.ok || json.status === "error") {
          alert(json.message || "Gagal membuat transaksi");
          return;
        }

        alert("Transaksi berhasil dibuat!");
        window.location.href = "transaksi.php";
      } catch (err) {
        console.error("❌ ERROR saat kirim:", err);
        alert("Terjadi kesalahan jaringan.");
      }
    });
  }
}
})();

