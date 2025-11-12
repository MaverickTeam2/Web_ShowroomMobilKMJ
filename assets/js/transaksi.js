(() => {
  console.log("✅ transaksi.js aktif");

  const path = window.location.pathname;

  // ======================================================
  // 📄 HALAMAN: transaksi.php (list & modal detail)
  // ======================================================
  if (path.includes("transaksi.php")) {
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

        const id = (btn.dataset.id || "").trim(); // <- harus berisi kode_transaksi
        if (!id) {
          console.warn("❗ data-id kosong pada tombol detail");
          return;
        }

        console.log("🔍 Lihat detail transaksi ID:", id);

        // tampilkan loading di modal
        if (modalBody) {
          modalBody.innerHTML = `
            <div class="text-center my-3">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 text-muted">Memuat data transaksi...</p>
            </div>
          `;
        }

        try {
          // 🔗 PAKAI API BARU (BUKAN detail_transaksi.php lokal)
          const API_BASE = "http://localhost/API_kmj/user/routes";
          const res = await fetch(
            `${API_BASE}/transaksi.php?action=detail&id=${encodeURIComponent(id)}`,
            { headers: { Accept: "application/json" } }
          );

          const text = await res.text(); // jaga-jaga kalau API balas HTML/error
          let data;
          try {
            data = JSON.parse(text);
          } catch (e) {
            throw new Error("Respons bukan JSON: " + text.slice(0, 200));
          }

          if (!data || data.status === "error") {
            modalBody.innerHTML = `
              <p class="text-center text-danger my-3">
                ${data?.message || "Data tidak ditemukan."}
              </p>`;
          } else {
            // ⚠️ pakai field yg ADA di API/DB kamu:
            // kode_transaksi, nama_pembeli, no_hp, tipe_pembayaran, harga_akhir,
            // created_at, kasir, nama_mobil, tahun_mobil
            modalBody.innerHTML = `
              <div>
                <h5 class="fw-bold mb-3">Detail Transaksi #${data.kode_transaksi}</h5>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <p><b>Nama Pembeli:</b> ${data.nama_pembeli ?? "-"}</p>
                    <p><b>No HP:</b> ${data.no_hp ?? "-"}</p>
                    <p><b>Tipe Pembayaran:</b> ${data.tipe_pembayaran ?? "-"}</p>
                    <p><b>Harga Akhir:</b> Rp ${Number(data.harga_akhir || 0).toLocaleString("id-ID")}</p>
                  </div>
                  <div class="col-md-6">
                    <p><b>Tanggal:</b> ${data.created_at ?? "-"}</p>
                    <p><b>Kasir:</b> ${data.kasir ?? "-"}</p>
                  </div>
                </div>
                <hr>
                <h6 class="fw-bold mt-3">Detail Mobil</h6>
                <ul class="mb-0">
                  <li><b>Nama Mobil:</b> ${data.nama_mobil ?? "-"}</li>
                  <li><b>Tahun:</b> ${data.tahun_mobil ?? "-"}</li>
                </ul>
              </div>
            `;
          }

          if (modalElement) new bootstrap.Modal(modalElement).show();
        } catch (err) {
          console.error("❌ Error mengambil data transaksi:", err);
          if (modalBody) {
            modalBody.innerHTML = `
              <p class="text-center text-danger my-3">
                Terjadi kesalahan saat mengambil data transaksi.
              </p>`;
          }
          if (modalElement) new bootstrap.Modal(modalElement).show();
        }
      });
    });
  }

  // ======================================================
  // 📄 HALAMAN: tambah_transaksi.php
  // ======================================================
  if (path.includes("tambah_transaksi.php")) {
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
  }
})();
