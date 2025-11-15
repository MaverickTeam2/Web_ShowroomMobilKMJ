(() => {
  console.log("✅ transaksi.js aktif");

  const path = window.location.pathname;
  const page = path.split("/").pop(); // nama file terakhir, mis: "transaksi.php" / "tambah_transaksi.php"

  if (page === "transaksi.php") {
  console.log("Halaman transaksi.php terdeteksi");

  const btnTambah      = document.getElementById("btn-tambah-transaksi");
  const modalElement   = document.getElementById("modalDetailTransaksi");
  const modalBody      = document.getElementById("modalDetailBody");
  const tbodyTransaksi = document.getElementById("tbody-transaksi");

  const statTotalRevenue    = document.getElementById("statTotalRevenue");
  const statAverageDeal     = document.getElementById("statAverageDeal");
  const statTotalTransaksi1 = document.getElementById("statTotalTransaksi1");
  const statTotalTransaksi2 = document.getElementById("statTotalTransaksi2");

  const API_URL = "http://localhost/API_kmj/admin/transaksi.php";

  // Tombol tambah transaksi
  if (btnTambah) {
    btnTambah.addEventListener("click", (e) => {
      e.preventDefault();
      window.location.href = "tambah_transaksi.php";
    });
  }

  // helper format rupiah
  const toIDR = (n) => "Rp " + Number(n || 0).toLocaleString("id-ID");

  // 🔹 LOAD LIST TRANSAKSI
  async function loadTransaksi() {
    if (!tbodyTransaksi) return;

    tbodyTransaksi.innerHTML = `
      <tr><td colspan="8" class="text-center text-muted">Memuat data...</td></tr>
    `;

    try {
      const res = await fetch(`${API_URL}?action=list`, {
        headers: { Accept: "application/json" },
      });

      const text = await res.text();
      console.log("📥 RAW list:", text);

      let payload;
      try {
        payload = JSON.parse(text);
      } catch {
        throw new Error("Respons list bukan JSON: " + text.slice(0, 200));
      }

      if (!res.ok || payload.status === "error") {
        throw new Error(payload.message || "Gagal mengambil list transaksi");
      }

      const rows = payload.data || [];

      if (rows.length === 0) {
        tbodyTransaksi.innerHTML = `
          <tr><td colspan="8" class="text-center text-muted">Belum ada transaksi</td></tr>
        `;
      } else {
        tbodyTransaksi.innerHTML = rows.map((trx) => {
          const statusRaw = (trx.status || "").toLowerCase().trim();
          let badgeClass, statusText;
          switch (statusRaw) {
            case "completed":
              badgeClass = "bg-success"; statusText = "Completed"; break;
            case "pending":
              badgeClass = "bg-warning text-dark"; statusText = "Pending"; break;
            case "cancelled":
            case "canceled":
              badgeClass = "bg-danger"; statusText = "Cancelled"; break;
            default:
              badgeClass = "bg-secondary";
              statusText = statusRaw ? statusRaw : "Unknown";
          }

          return `
            <tr>
              <td>${trx.kode_transaksi ?? "-"}</td>
              <td>${trx.nama_pembeli ?? "-"}</td>
              <td>${trx.nama_mobil ?? "-"}</td>
              <td>${trx.tanggal ?? "-"}</td>
              <td><span class="badge ${badgeClass}">${statusText}</span></td>
              <td>${toIDR(trx.harga_akhir)}</td>
              <td>${trx.kasir ?? "-"}</td>
              <td>
                <div class="d-flex gap-2">
                  <button class="btn btn-outline-primary btn-sm btn-detail"
                          data-id="${trx.kode_transaksi ?? ""}">
                    <i class="bx bx-detail"></i>
                  </button>
                  <button class="btn btn-outline-secondary btn-sm">
                    <i class="bx bx-download"></i>
                  </button>
                </div>
              </td>
            </tr>
          `;
        }).join("");
      }

      // 🔹 hitung statistik
      const totalRevenue   = rows.reduce((sum, r) => sum + Number(r.harga_akhir || 0), 0);
      const totalTransaksi = rows.length;
      const averageDeal    = totalTransaksi > 0 ? totalRevenue / totalTransaksi : 0;

      if (statTotalRevenue)   statTotalRevenue.textContent   = toIDR(totalRevenue);
      if (statAverageDeal)    statAverageDeal.textContent    = toIDR(averageDeal);
      if (statTotalTransaksi1)statTotalTransaksi1.textContent = `Dari ${totalTransaksi} transaksi`;
      if (statTotalTransaksi2)statTotalTransaksi2.textContent = totalTransaksi;

      // pasang handler tombol detail
      attachDetailHandlers();
    } catch (err) {
      console.error("❌ Gagal load list transaksi:", err);
      tbodyTransaksi.innerHTML = `
        <tr><td colspan="8" class="text-center text-danger">
          Gagal memuat data transaksi.
        </td></tr>
      `;
    }
  }

  // 🔹 DETAIL (pakai API action=detail yang tadi sudah jalan)
  function attachDetailHandlers() {
    const detailButtons = document.querySelectorAll(".btn-detail");
    detailButtons.forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        e.preventDefault();
        const id = (btn.dataset.id || "").trim();
        if (!id) return;

        if (modalBody) {
          modalBody.innerHTML = `
            <div class="text-center my-3">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="mt-2 text-muted">Memuat data transaksi...</p>
            </div>
          `;
        }

        try {
          const res = await fetch(
            `${API_URL}?action=detail&id=${encodeURIComponent(id)}`,
            { headers: { Accept: "application/json" } }
          );

          const text = await res.text();
          console.log("📥 RAW detail:", text);

          let payload;
          try { payload = JSON.parse(text); }
          catch { throw new Error("Respons detail bukan JSON: " + text.slice(0, 200)); }

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
                  <p><b>Harga Akhir:</b> ${toIDR(d.harga_akhir)}</p>
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

  // 🚀 jalankan saat halaman load
  loadTransaksi();
}


  // ======================================================
  // 📄 HALAMAN: tambah_transaksi.php
  // ======================================================
  if (page === "tambah_transaksi.php"){
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

    const toNumMobil  = (v) => Number(v || 0);
    const toIDRMobil  = (n) => "Rp " + toNumMobil(n).toLocaleString("id-ID");
    const showPrev = () => mobilPreview && mobilPreview.classList.remove("d-none");
    const hidePrev = () => mobilPreview && mobilPreview.classList.add("d-none");

    // toggle kredit/tunai
    if (jenisPembayaran && fieldNamaKredit) {
      const apply = () => {
        const isKredit = (jenisPembayaran.value || "").toLowerCase() === "kredit";
        fieldNamaKredit.style.display = isKredit ? "block" : "none";
      };
      apply();
      jenisPembayaran.addEventListener("change", apply);
    }

    // preview mobil saat dipilih
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
        if (mobilHarga)   mobilHarga.textContent  = data.harga ? toIDRMobil(data.harga) : "-";
        if (mobilDetail)  mobilDetail.textContent = data.dp ? `DP ${toIDRMobil(data.dp)}` : "-";
        if (mobilKm)      mobilKm.textContent     = `${toNumMobil(data.km).toLocaleString("id-ID")} Km`;
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
    const namaPembeli = document.getElementById("namaPembeli");
    const noHp        = document.getElementById("noHp");
    const dealPrice   = document.getElementById("dealPrice");

    const KODE_USER = "USR001"; // TODO: ambil dari session PHP

    const toNumber = (str) =>
      Number(String(str || "0").replace(/\D/g, ""));

    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const payload = {
        action: "create",
        nama_pembeli: namaPembeli.value.trim(),
        no_hp: noHp.value.trim(),
        tipe_pembayaran: jenisPembayaran.value,
        harga_akhir: toNumber(dealPrice.value),
        kode_mobil: jenisMobil.value,
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

        const text = await res.text();
        console.log("📥 RAW response:", text);

        let json;
        try {
          json = JSON.parse(text);
        } catch (e) {
          throw new Error("Response bukan JSON valid");
        }

        console.log("📥 Parsed JSON:", json);

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

})();
