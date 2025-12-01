(() => {
  console.log("📄 edit_transaksi.js aktif");

  const API_GET_TRANSAKSI  = `${BASE_API_URL}/admin/transaksi_get.php`;
  const API_GET_MOBIL      = `${BASE_API_URL}/admin/mobil_get.php`;
  const API_POST_TRANSAKSI = `${BASE_API_URL}/admin/transaksi_post.php`;

  const path = window.location.pathname;
  const page = path.split("/").pop();
  if (page !== "edit_transaksi.php") return;

  const params = new URLSearchParams(window.location.search);
  const kodeTransaksi = (params.get("id") || "").trim();
  if (!kodeTransaksi) {
    alert("Kode transaksi tidak ditemukan");
    window.location.href = "transaksi.php";
    return;
  }

  // elemen-elemen sama seperti di tambah_transaksi.js
  const jenisMobil      = document.getElementById("jenisMobil");
  const mobilPreview    = document.getElementById("mobilPreview");
  const mobilImage      = document.getElementById("mobilImage");
  const mobilNama       = document.getElementById("mobilNama");
  const mobilHarga      = document.getElementById("mobilHarga");
  const mobilDetail     = document.getElementById("mobilDetail");
  const mobilKm         = document.getElementById("mobilKm");
  const mobilTahun      = document.getElementById("mobilTahun");
  const tipeMobilInput  = document.getElementById("tipeMobil");

  const namaPembeli     = document.getElementById("namaPembeli");
  const noHp            = document.getElementById("noHp");
  const dealPrice       = document.getElementById("dealPrice");
  const fullPrice       = document.getElementById("fullPrice");
  const noteInput       = document.getElementById("note");
  const jenisPembayaran = document.getElementById("jenisPembayaran");
  const statusTransaksi = document.getElementById("statusTransaksi");
  const form            = document.querySelector(".tambah-transaksi-form");
  const namaKreditInput = document.getElementById("namaKredit");

  const cekKtp = document.getElementById("cekKtp");
  const cekKk  = document.getElementById("cekKk");
  const cekRek = document.getElementById("cekRekening");

  const toNumMobil  = (v) => Number(v || 0);
  const toIDRMobil  = (n) => "Rp " + toNumMobil(n).toLocaleString("id-ID");
  const showPrev    = () => mobilPreview && mobilPreview.classList.remove("d-none");
  const hidePrev    = () => mobilPreview && mobilPreview.classList.add("d-none");
  const buildFotoUrl = (path) => path ? `${BASE_API_URL}${path}` : "";

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

  async function handleMobilChange() {
    const idMobil = (jenisMobil && jenisMobil.value ? jenisMobil.value : "").trim();

    if (!idMobil) {
      hidePrev();
      setTipe("-");
      if (fullPrice) fullPrice.value = "";
      if (dealPrice) dealPrice.value = "";
      return;
    }

    try {
      const res = await fetch(`${API_GET_MOBIL}?id=${encodeURIComponent(idMobil)}`, {
        headers: { Accept: "application/json" },
      });
      const raw = await res.text();
      let data = JSON.parse(raw);

      if (!data || data.code !== "200") {
        hidePrev();
        setTipe("-");
        if (fullPrice) fullPrice.value = "";
        if (dealPrice) dealPrice.value = "";
        return;
      }

      if (mobilImage)  mobilImage.src         = buildFotoUrl(data.foto);
      if (mobilNama)   mobilNama.textContent  = data.nama_mobil || "-";
      if (mobilHarga) {
        if (data.angsuran && data.tenor) {
          mobilHarga.textContent = `${toIDRMobil(data.angsuran)} x ${data.tenor}`;
        } else {
          mobilHarga.textContent = "-";
        }
      }
      if (mobilDetail) mobilDetail.textContent = data.dp ? `Dp ${toIDRMobil(data.dp)}` : "-";
      if (mobilKm)     mobilKm.textContent     = `${toNumMobil(data.km).toLocaleString("id-ID")} Km`;
      if (mobilTahun)  mobilTahun.textContent  = data.tahun || "-";

      setTipe(data.tipe || "-");

      if (fullPrice) {
        fullPrice.value = data.full_price ? toIDRMobil(data.full_price) : "";
      }
      if (dealPrice) {
        dealPrice.value = data.full_price ? toIDRMobil(data.full_price) : "";
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

  async function loadMobilList(selectedKodeMobil = "") {
    if (!jenisMobil) return;

    jenisMobil.innerHTML = '<option value="" disabled selected>Memuat daftar mobil...</option>';

    try {
      const res = await fetch(`${API_GET_MOBIL}?action=list`, {
        headers: { Accept: "application/json" },
      });
      const raw = await res.text();
      let json = JSON.parse(raw);

      if (!json || json.code !== "200" || !Array.isArray(json.data)) {
        jenisMobil.innerHTML = '<option value="" disabled selected>Gagal memuat mobil</option>';
        return;
      }

      jenisMobil.innerHTML = '<option value="" disabled>Pilih jenis mobil</option>';

      json.data.forEach((m) => {
        const opt = document.createElement("option");
        opt.value = m.kode_mobil;
        opt.textContent = m.tahun
          ? `${m.nama_mobil} (${m.tahun})`
          : m.nama_mobil;
        jenisMobil.appendChild(opt);
      });

      if (selectedKodeMobil) {
        jenisMobil.value = selectedKodeMobil;
        await handleMobilChange(); // isi preview + fullPrice
      }

    } catch (err) {
      console.error("❌ Gagal load list mobil:", err);
      jenisMobil.innerHTML = '<option value="" disabled selected>Gagal memuat mobil</option>';
    }
  }

  if (jenisMobil) {
    jenisMobil.addEventListener("change", () => {
      handleMobilChange().catch((e) => console.warn(e));
    });
  }

  // ======================================================
  // 🧪 HELPER VALIDASI (reuse dengan tambah_transaksi)
  // ======================================================

  const toNumber = (str) =>
    Number(String(str || "0").replace(/\D/g, ""));

  function validateName(name) {
    if (!name || name.trim().length < 3) {
      return "Nama pembeli minimal 3 karakter.";
    }
    if (!/^[a-zA-Z\s'.-]+$/.test(name)) {
      return "Nama pembeli hanya boleh berisi huruf dan spasi.";
    }
    return null;
  }

  function validatePhone(phone) {
    if (!phone) return "Nomor HP wajib diisi.";

    if (!/^[0-9]+$/.test(phone)) {
      return "Nomor HP tidak boleh mengandung huruf atau simbol.";
    }
    if (!phone.startsWith("08")) {
      return "Nomor HP harus dimulai dengan 08 (bukan +62).";
    }
    if (phone.length < 10 || phone.length > 13) {
      return "Nomor HP harus 10–13 digit.";
    }
    return null;
  }

  function validatePrice(num, label) {
    if (isNaN(num) || num <= 0) {
      return `${label} harus berupa angka dan lebih dari 0.`;
    }
    return null;
  }

  function validateNote(note) {
    if (note.length > 255) {
      return "Catatan maksimal 255 karakter.";
    }
    return null;
  }

  // ============= LOAD DETAIL TRANSAKSI (prefill form) =============
  async function loadTransaksiDetail() {
    try {
      const res = await fetch(
        `${API_GET_TRANSAKSI}?action=detail&id=${encodeURIComponent(kodeTransaksi)}`,
        { headers: { Accept: "application/json" } }
      );
      const raw = await res.text();
      console.log("📥 RAW detail edit:", raw);
      const payload = JSON.parse(raw);
      if (!res.ok || payload.code === "400" || !payload.data) {
        throw new Error(payload.message || "Gagal ambil detail transaksi");
      }

      const d = payload.data;

      const jam = d.jaminan || { ktp: 0, kk: 0, rekening: 0 };

      if (cekKtp) cekKtp.checked = !!jam.ktp;
      if (cekKk)  cekKk.checked  = !!jam.kk;
      if (cekRek) cekRek.checked = !!jam.rekening;

      if (namaPembeli) namaPembeli.value = d.nama_pembeli ?? "";
      if (noHp)        noHp.value        = d.no_hp ?? "";
      if (noteInput)   noteInput.value   = d.note ?? "";
      if (namaKreditInput) namaKreditInput.value = d.nama_kredit ?? "";

      if (jenisPembayaran) {
        let jp = (d.tipe_pembayaran || "").toLowerCase();
        jenisPembayaran.value = jp || "cash";
      }

      if (statusTransaksi) statusTransaksi.value = d.status ?? "pending";

      if (dealPrice) {
        dealPrice.value = d.harga_akhir
          ? "Rp " + Number(d.harga_akhir).toLocaleString("id-ID")
          : "";
      }

      const initialKodeMobil = d.kode_mobil || "";
      await loadMobilList(initialKodeMobil);

    } catch (err) {
      console.error("❌ Gagal load detail transaksi:", err);
      alert("Gagal memuat data transaksi untuk edit.");
      window.location.href = "transaksi.php";
    }
  }

  // panggil saat halaman dibuka
  loadTransaksiDetail().catch((e) => console.error(e));

  // ======================================================
  // 🚀 SUBMIT UPDATE TRANSAKSI
  // ======================================================
  if (form) {
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const namaVal   = namaPembeli.value.trim();
      const noHpVal   = noHp.value.trim();
      const dealNum   = toNumber(dealPrice.value);
      const noteVal   = noteInput ? noteInput.value.trim() : "";
      const namaKred  = namaKreditInput ? namaKreditInput.value.trim() : "";
      const tipeBayar = (jenisPembayaran?.value || "").toLowerCase();

      const errName = validateName(namaVal);
      if (errName) {
        alert(errName);
        return;
      }

      const errPhone = validatePhone(noHpVal);
      if (errPhone) {
        alert(errPhone);
        return;
      }

      const errPrice = validatePrice(dealNum, "Deal Price");
      if (errPrice) {
        alert(errPrice);
        return;
      }

      if (!jenisMobil || !jenisMobil.value) {
        alert("Jenis mobil harus dipilih.");
        return;
      }

      const errNote = validateNote(noteVal);
      if (errNote) {
        alert(errNote);
        return;
      }

      if (tipeBayar === "kredit") {
        if (!cekKtp?.checked && !cekKk?.checked && !cekRek?.checked) {
          alert("Minimal pilih 1 jaminan untuk pembayaran kredit.");
          return;
        }
        if (!namaKred) {
          alert("Nama kredit wajib diisi untuk pembayaran kredit.");
          return;
        }
      }

      const payload = {
        action: "update",
        kode_transaksi: kodeTransaksi,
        nama_pembeli: namaVal,
        no_hp: noHpVal,
        tipe_pembayaran: jenisPembayaran.value.trim(),
        harga_akhir: dealNum,
        kode_mobil: jenisMobil.value.trim(),
        status: statusTransaksi.value.trim(),
        note: noteVal,
        // ambil dari PHP yang disuntik lewat window.CURRENT_USER
        kode_user: window.CURRENT_USER?.kode_user ?? null,
        nama_kredit: namaKred,
        jaminan_ktp:      cekKtp?.checked ? 1 : 0,
        jaminan_kk:       cekKk?.checked ? 1 : 0,
        jaminan_rekening: cekRek?.checked ? 1 : 0,
      };

      console.log("📤 Payload UPDATE:", payload);

      try {
        const res = await fetch(API_POST_TRANSAKSI, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json"
          },
          body: JSON.stringify(payload)
        });

        const text = await res.text();
        console.log("📥 RAW RESPONSE UPDATE:", text);

        let json;
        try {
          json = JSON.parse(text);
        } catch (err) {
          throw new Error("Response bukan JSON valid");
        }

        if (!res.ok || (json.code && json.code !== "200")) {
          alert(json.message || "Gagal update transaksi");
          return;
        }

        alert("Transaksi berhasil diperbarui!");
        window.location.href = "transaksi.php";
      } catch (err) {
        console.error("❌ ERROR UPDATE:", err);
        alert("Terjadi kesalahan saat update transaksi.");
      }
    });
  }
})();
