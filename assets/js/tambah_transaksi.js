(() => {
  console.log("📄 tambah_transaksi.js aktif");

  const API_POST_TRANSAKSI = `${BASE_API_URL}/admin/transaksi_post.php`;
  const API_GET_MOBIL      = `${BASE_API_URL}/admin/mobil_get.php`;

  const path = window.location.pathname;
  const page = path.split("/").pop();

  if (page !== "tambah_transaksi.php") return; // safety

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
  const namaKreditInput = document.getElementById("namaKredit");


  const toNumMobil  = (v) => Number(v || 0);
  const toIDRMobil  = (n) => "Rp " + toNumMobil(n).toLocaleString("id-ID");
  const showPrev    = () => mobilPreview && mobilPreview.classList.remove("d-none");
  const hidePrev    = () => mobilPreview && mobilPreview.classList.add("d-none");

  // 🖼 helper: bentuk URL foto dari path yang dikirim API (contoh: /images/mobil/xxx.jpg)
  const buildFotoUrl = (path) => {
    if (!path) return "";
    return `${BASE_API_URL}${path}`;
  };

  // ======================================================
  // 🔽 LOAD LIST MOBIL UNTUK DROPDOWN (via API, bukan DB)
  // ======================================================
  async function loadMobilList() {
    if (!jenisMobil) return;

    jenisMobil.innerHTML = '<option value="" disabled selected>Memuat daftar mobil...</option>';

    try {
      const res = await fetch(`${API_GET_MOBIL}?action=list&status=available`, {
        headers: { Accept: "application/json" },
      });
      const raw = await res.text();

      let json;
      try {
        json = JSON.parse(raw);
      } catch (e) {
        throw new Error("Response list mobil bukan JSON: " + raw.slice(0, 150));
      }

      if (!json || json.code !== "200" || !Array.isArray(json.data)) {
        console.warn("List mobil tidak valid:", json);
        jenisMobil.innerHTML = '<option value="" disabled selected>Gagal memuat mobil</option>';
        return;
      }

      // isi ulang option
      jenisMobil.innerHTML = '<option value="" disabled selected>Pilih jenis mobil</option>';

      json.data.forEach((m) => {
        const opt = document.createElement("option");
        opt.value = m.kode_mobil;
        opt.textContent = m.tahun
          ? `${m.nama_mobil} (${m.tahun})`
          : m.nama_mobil;
        jenisMobil.appendChild(opt);
      });

      console.log("✅ List mobil ter-load:", json.data.length, "item");
    } catch (err) {
      console.error("❌ Gagal load list mobil:", err);
      jenisMobil.innerHTML = '<option value="" disabled selected>Gagal memuat mobil</option>';
    }
  }

  // toggle kredit/tunai
  if (jenisPembayaran && fieldNamaKredit) {
    const apply = () => {
      const isKredit = (jenisPembayaran.value || "").toLowerCase() === "kredit";
      fieldNamaKredit.style.display = isKredit ? "block" : "none";
    };
    apply();
    jenisPembayaran.addEventListener("change", apply);
  }

  // saat halaman aktif, load list mobil & pasang handler change
  if (jenisMobil) {
    loadMobilList().catch((e) => console.warn(e));

    jenisMobil.addEventListener("change", () => {
      handleMobilChange().catch((e) => console.warn(e));
    });
  }

  // ======================================================
  // 🔍 AMBIL DETAIL MOBIL + FOTO UNTUK PREVIEW
  // ======================================================
  async function handleMobilChange() {
  const idMobil = (jenisMobil && jenisMobil.value ? jenisMobil.value : "").trim();

  // kalau belum pilih apa-apa
  if (!idMobil) {
    hidePrev();
    setTipe("-");
    if (fullPrice) fullPrice.value = "";
    if (dealPrice) dealPrice.value = "";
    return;
  }

  try {
    const res = await fetch(
      `${API_GET_MOBIL}?id=${encodeURIComponent(idMobil)}`,
      { headers: { Accept: "application/json" } }
    );

    const raw = await res.text();
    let data;

    try {
      data = JSON.parse(raw);
    } catch (e) {
      console.error("❌ Detail mobil bukan JSON valid:", raw);
      throw new Error("Response detail mobil bukan JSON valid: " + raw.slice(0, 150));
    }

    console.log("📦 Data mobil:", data);

    // kalau status bukan ok
    if (!data || data.code !== "200") {
      hidePrev();
      setTipe("-");
      if (fullPrice) fullPrice.value = "";
      if (dealPrice) dealPrice.value = "";
      return;
    }

    // ==== SET PREVIEW MOBIL ====
    if (mobilImage)   mobilImage.src          = buildFotoUrl(data.foto);
    if (mobilNama)    mobilNama.textContent   = data.nama_mobil || "-";

    // Rp. 7.998.000 x 60
    if (mobilHarga) {
      if (data.angsuran && data.tenor) {
        mobilHarga.textContent = `${toIDRMobil(data.angsuran)} x ${data.tenor}`;
      } else {
        mobilHarga.textContent = "-";
      }
    }

    // Dp Rp. 39.000.000
    if (mobilDetail) {
      mobilDetail.textContent = data.dp
        ? `Dp ${toIDRMobil(data.dp)}`
        : "-";
    }

    if (mobilKm)      mobilKm.textContent     = `${toNumMobil(data.km).toLocaleString("id-ID")} Km`;
    if (mobilTahun)   mobilTahun.textContent  = data.tahun || "-";

    setTipe(data.tipe || "-");

    // ==== ISI OTOMATIS FULL PRICE & DEAL PRICE ====
    if (fullPrice) {
      fullPrice.value = data.full_price
        ? toIDRMobil(data.full_price)
        : "";
    }

    // kalau mau deal price default = full price
    if (dealPrice) {
      dealPrice.value = data.full_price
        ? toIDRMobil(data.full_price)
        : "";
    }

    showPrev();
  } catch (err) {
    console.error("❌ Gagal ambil data mobil:", err);
    hidePrev();
    setTipe("-");
    if (fullPrice) fullPrice.value = "";
    if (dealPrice) dealPrice.value = "";
  }
}


  function setTipe(v) {
    if (!tipeMobilInput) return;
    if (tipeMobilInput.tagName === "SELECT") {
      tipeMobilInput.innerHTML = "";
      const opt = document.createElement("option");
      opt.value = v;
      opt.textContent = v;
      opt.selected = true;
      tipeMobilInput.appendChild(opt);
    } else {
      tipeMobilInput.value = v;
    }
  }

  // ======================================================
  // 🚀 SUBMIT FORM → API create transaksi (POST)
  // ======================================================

  const form        = document.querySelector(".tambah-transaksi-form");
  const namaPembeli = document.getElementById("namaPembeli");
  const noHp        = document.getElementById("noHp");
  const dealPrice   = document.getElementById("dealPrice");
  const fullPrice = document.getElementById("fullPrice");
  const noteInput   = document.getElementById("catatan"); 
  const statusTransaksi = document.getElementById("statusTransaksi");
  const cekKtp      = document.getElementById("cekKtp");
  const cekKk       = document.getElementById("cekKk");
  const cekRek      = document.getElementById("cekRek");
  const namaKredit  = document.getElementById("namaKredit");



  const toNumber = (str) =>
    Number(String(str || "0").replace(/\D/g, ""));

  if (form) {
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const note = (noteInput?.value || "").trim();
      const namaKredit = (namaKreditInput?.value || "").trim();


      const payload = {
        action: "create",
        nama_pembeli: namaPembeli.value.trim(),
        no_hp: noHp.value.trim(),
        tipe_pembayaran: jenisPembayaran.value,
        harga_akhir: toNumber(dealPrice.value),
        kode_mobil: jenisMobil.value,
        kode_user: "US001", //kalau ada session, ganti ini
        status: statusTransaksi.value, 
        note: note,
        nama_kredit: namaKredit,

        jaminan_ktp:      cekKtp?.checked ? 1 : 0,
        jaminan_kk:       cekKk?.checked ? 1 : 0,
        jaminan_rekening: cekRek?.checked ? 1 : 0,
      };

      console.log("📤 Payload kirim:", payload);

      try {
        const res = await fetch(
          API_POST_TRANSAKSI,
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

        if (!res.ok || json.code === "400") {
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
