(() => {
  console.log("📄 edit_transaksi.js aktif");

  const API_POST_TRANSAKSI = `${BASE_API_URL}/admin/transaksi_post.php`;
  const API_GET_TRANSAKSI  = `${BASE_API_URL}/admin/transaksi_get.php`;
  const API_GET_MOBIL      = `${BASE_API_URL}/admin/mobil_get.php`;

  const path = window.location.pathname;
  const page = path.split("/").pop();

  if (page !== "edit_transaksi.php") return;

  console.log("📄 Mode: edit transaksi aktif");

  // ===== ambil kode_transaksi dari URL =====
  const params = new URLSearchParams(window.location.search);
  const kodeTransaksi = (params.get("id") || "").trim();
  if (!kodeTransaksi) {
    alert("Kode transaksi tidak ditemukan di URL");
    window.location.href = "transaksi.php";
    return;
  }

  // --- ambil elemen yang sama seperti tambah_transaksi.js ---
  const jenisMobil      = document.getElementById("jenisMobil");
  const jenisPembayaran = document.getElementById("jenisPembayaran");
  const fieldNamaKredit = document.getElementById("field-nama-kredit");
  const namaPembeli     = document.getElementById("namaPembeli");
  const noHp            = document.getElementById("noHp");
  const dealPrice       = document.getElementById("dealPrice");
  const fullPrice       = document.getElementById("fullPrice");
  const noteInput       = document.getElementById("note");
  const statusTransaksi = document.getElementById("statusTransaksi");

  const form            = document.querySelector(".tambah-transaksi-form");

  const toNumber = (str) =>
    Number(String(str || "0").replace(/\D/g, ""));

  // TODO: kalau kamu punya fungsi loadMobilList & handleMobilChange di tambah_transaksi.js,
  // kamu bisa copy ke sini juga (atau nanti kita refactor biar bisa dipakai bareng).

  // ===================== LOAD DATA TRANSAKSI =====================
  async function loadTransaksiDetail() {
    try {
      const res = await fetch(
        `${API_GET_TRANSAKSI}?action=detail&id=${encodeURIComponent(kodeTransaksi)}`,
        { headers: { Accept: "application/json" } }
      );

      const text = await res.text();
      console.log("📥 RAW detail edit:", text);

      let payload = JSON.parse(text);
      if (!res.ok || payload.status === "error" || !payload.data) {
        throw new Error(payload.message || "Gagal mengambil data transaksi");
      }

      const d = payload.data;

      // isi form
      if (namaPembeli) namaPembeli.value = d.nama_pembeli ?? "";
      if (noHp)        noHp.value        = d.no_hp ?? "";
      if (noteInput)   noteInput.value   = d.note ?? "";

      if (jenisPembayaran) {
        jenisPembayaran.value = d.tipe_pembayaran ?? "cash";
      }

      if (statusTransaksi) {
        statusTransaksi.value = d.status ?? "pending";
      }

      if (dealPrice) {
        dealPrice.value = d.harga_akhir ? "Rp " + Number(d.harga_akhir).toLocaleString("id-ID") : "";
      }

      // IMPORTANT: pastikan API detail juga mengirim kode_mobil
      // supaya kita bisa pilih option yang sesuai di dropdown jenisMobil.
      if (jenisMobil && d.kode_mobil) {
        jenisMobil.value = d.kode_mobil;
      }

      // kalau kamu mau, bisa panggil handleMobilChange() di sini
      // untuk isi preview + fullPrice otomatis sesuai mobil.
    } catch (err) {
      console.error("❌ Gagal load detail transaksi:", err);
      alert("Gagal memuat data transaksi untuk edit.");
      window.location.href = "transaksi.php";
    }
  }

  // ===================== SUBMIT UPDATE =====================
  if (form) {
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const payload = {
        action: "update",
        kode_transaksi: kodeTransaksi,
        nama_pembeli: namaPembeli.value.trim(),
        no_hp: noHp.value.trim(),
        tipe_pembayaran: jenisPembayaran.value,
        harga_akhir: toNumber(dealPrice.value),
        kode_mobil: jenisMobil.value,
        kode_user: "US001", // nanti ganti pakai session
        status: statusTransaksi.value,
        note: (noteInput?.value || "").trim(),
      };

      console.log("📤 Payload UPDATE:", payload);

      try {
        const res = await fetch(API_POST_TRANSAKSI, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(payload),
        });

        const text = await res.text();
        console.log("📥 RAW response UPDATE:", text);

        let json = JSON.parse(text);

        if (!res.ok || json.status === "error") {
          alert(json.message || "Gagal mengupdate transaksi");
          return;
        }

        alert("Transaksi berhasil diupdate!");
        window.location.href = "transaksi.php";
      } catch (err) {
        console.error("❌ ERROR saat update:", err);
        alert("Terjadi kesalahan jaringan saat update.");
      }
    });
  }

  // mulai: load data detail
  loadTransaksiDetail().catch((e) => console.error(e));
})();
