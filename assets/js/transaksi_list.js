(() => {
  console.log("✅ transaksi_list.js aktif");

  const API_GET_TRANSAKSI  = `${BASE_API_URL}/admin/transaksi_get.php`;
  const API_POST_TRANSAKSI = `${BASE_API_URL}/admin/transaksi_post.php`;

  const path = window.location.pathname;
  const page = path.split("/").pop();

  if (page !== "transaksi.php") return;

  console.log("Halaman transaksi.php terdeteksi");

  const btnTambah       = document.getElementById("btn-tambah-transaksi");
  const modalElement    = document.getElementById("modalDetailTransaksi");
  const tbodyTransaksi  = document.getElementById("tbody-transaksi");
  const filterStatus    = document.getElementById("filterStatus");    
  const searchTransaksi = document.getElementById("searchTransaksi"); 
  let allTransaksi      = [];                                         

  const statTotalRevenue    = document.getElementById("statTotalRevenue");
  const statAverageDeal     = document.getElementById("statAverageDeal");
  const statTotalTransaksi1 = document.getElementById("statTotalTransaksi1");
  const statTotalTransaksi2 = document.getElementById("statTotalTransaksi2");

  // ===== elemen-elemen detail di dalam modal =====

  // 3 card atas
  const elKode       = document.getElementById("dt-kode");
  const elNama       = document.getElementById("dt-nama");
  const elNoHp       = document.getElementById("dt-nohp");
  const elJenisBayar = document.getElementById("dt-jenis-bayar");
  const elNoteBayar  = document.getElementById("dt-note-bayar");
  const elNamaKredit = document.getElementById("dt-nama-kredit");
  const elTanggal    = document.getElementById("dt-tanggal");
  const elKasir      = document.getElementById("dt-kasir");
  const elStatusBadg = document.getElementById("dt-status-badge");

  // jaminan (KTP, KK, Rekening)
  const elJamKtp = document.getElementById("dt-jaminan-ktp");
  const elJamKk  = document.getElementById("dt-jaminan-kk");
  const elJamRek = document.getElementById("dt-jaminan-rek");

  // tabel mobil bawah
  const rowKode      = document.getElementById("dt-row-kode");
  const rowMobil     = document.getElementById("dt-row-mobil");
  const rowMerk      = document.getElementById("dt-row-merk");
  const rowTahun     = document.getElementById("dt-row-tahun");
  const rowFullPrice = document.getElementById("dt-row-fullprice");
  const rowDealPrice = document.getElementById("dt-row-dealprice");

  if (!modalElement) {
    console.error("❌ modalDetailTransaksi tidak ditemukan di DOM");
  }

  if (btnTambah) {
    btnTambah.addEventListener("click", (e) => {
      e.preventDefault();
      window.location.href = "tambah_transaksi.php";
    });
  }

  const toIDR = (n) => "Rp " + Number(n || 0).toLocaleString("id-ID");

  // ===================== LOAD LIST dari API =====================
  async function loadTransaksi() {
    if (!tbodyTransaksi) return;

    tbodyTransaksi.innerHTML = `
      <tr><td colspan="8" class="text-center text-muted">Memuat data...</td></tr>
    `;

    try {
      const res = await fetch(`${API_GET_TRANSAKSI}?action=list`, {
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

      // simpan semua transaksi ke variabel global ⬅️ BARU
      allTransaksi = rows;

      // hitung statistik dari SEMUA transaksi (bukan yang terfilter) ⬅️ BARU
      const totalRevenue   = rows.reduce((sum, r) => sum + Number(r.harga_akhir || 0), 0);
      const totalTransaksi = rows.length;
      const averageDeal    = totalTransaksi > 0 ? totalRevenue / totalTransaksi : 0;

      if (statTotalRevenue)    statTotalRevenue.textContent    = toIDR(totalRevenue);
      if (statAverageDeal)     statAverageDeal.textContent     = toIDR(averageDeal);
      if (statTotalTransaksi1) statTotalTransaksi1.textContent = `Dari ${totalTransaksi} transaksi`;
      if (statTotalTransaksi2) statTotalTransaksi2.textContent = totalTransaksi;

      // render tabel sesuai filter sekarang ⬅️ BARU
      renderTable();
    } catch (err) {
      console.error("❌ Gagal load list transaksi:", err);
      tbodyTransaksi.innerHTML = `
        <tr><td colspan="8" class="text-center text-danger">
          Gagal memuat data transaksi.
        </td></tr>
      `;
    }
  }

  // ===================== RENDER TABEL + FILTER ===================== ⬅️ BARU
  function renderTable() {
    if (!tbodyTransaksi) return;

    const statusFilter = (filterStatus?.value || "").toLowerCase().trim();
    const keyword      = (searchTransaksi?.value || "").toLowerCase().trim();

    // filter data berdasarkan dropdown status + search (kalau ada)
    let filtered = allTransaksi.filter((trx) => {
      // filter status
      let okStatus = true;
      if (statusFilter) {
        okStatus = (trx.status || "").toLowerCase().trim() === statusFilter;
      }

      // filter pencarian
      let okSearch = true;
      if (keyword) {
        const haystack = [
          trx.kode_transaksi,
          trx.nama_pembeli,
          trx.nama_mobil,
          trx.kasir,
        ]
          .join(" ")
          .toLowerCase();

        okSearch = haystack.includes(keyword);
      }

      return okStatus && okSearch;
    });

    if (filtered.length === 0) {
      tbodyTransaksi.innerHTML = `
        <tr>
          <td colspan="8" class="text-center text-muted">
            Tidak ada transaksi yang cocok dengan filter.
          </td>
        </tr>
      `;
      return;
    }

    tbodyTransaksi.innerHTML = filtered
      .map((trx) => {
        const statusRaw = (trx.status || "").toLowerCase().trim();
        let badgeClass, statusText;
        switch (statusRaw) {
          case "completed":
            badgeClass = "bg-success";
            statusText = "Completed";
            break;
          case "pending":
            badgeClass = "bg-warning text-dark";
            statusText = "Pending";
            break;
          case "cancelled":
          case "canceled":
            badgeClass = "bg-danger";
            statusText = "Cancelled";
            break;
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
                <button class="btn btn-outline-secondary btn-sm btn-edit"
                        data-id="${trx.kode_transaksi ?? ""}">
                  <i class="bx bx-edit"></i>
                </button>
              </div>
            </td>
          </tr>
        `;
      })
      .join("");

    // setelah tabel digenerate ulang, pasang lagi handler detail & edit
    attachDetailHandlers();
  }

  // ===================== DETAIL (MODAL) =====================
  function attachDetailHandlers() {
    const detailButtons = document.querySelectorAll(".btn-detail");
    const editButtons   = document.querySelectorAll(".btn-edit");

    detailButtons.forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        e.preventDefault();
        const id = (btn.dataset.id || "").trim();
        console.log("▶ Klik detail:", id);
        if (!id || !modalElement) return;

        if (typeof bootstrap === "undefined") {
          console.error("❌ bootstrap tidak terdefinisi. JS Bootstrap belum dimuat?");
          return;
        }

        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

        // reset isi (mode loading)
        if (elKode)       elKode.textContent       = id;
        if (elNama)       elNama.textContent       = "Memuat...";
        if (elNoHp)       elNoHp.textContent       = "-";
        if (elJenisBayar) elJenisBayar.textContent = "-";
        if (elNamaKredit) elNamaKredit.textContent = "-";
        if (elNoteBayar)  elNoteBayar.textContent  = "-";
        if (elTanggal)    elTanggal.textContent    = "-";
        if (elKasir)      elKasir.textContent      = "-";

        if (rowKode)      rowKode.textContent      = id;
        if (rowMobil)     rowMobil.textContent     = "-";
        if (rowMerk)      rowMerk.textContent      = "-";
        if (rowTahun)     rowTahun.textContent     = "-";
        if (rowFullPrice) rowFullPrice.textContent = "-";
        if (rowDealPrice) rowDealPrice.textContent = "-";

        if (elStatusBadg) {
          elStatusBadg.className = "badge bg-secondary";
          elStatusBadg.textContent = "Loading";
        }

        // buka modal setelah reset isi
        modal.show();

        try {
          const res = await fetch(
            `${API_GET_TRANSAKSI}?action=detail&id=${encodeURIComponent(id)}`,
            { headers: { Accept: "application/json" } }
          );

          const text = await res.text();
          console.log("📥 RAW detail:", text);

          let payload;
          try {
            payload = JSON.parse(text);
          } catch {
            throw new Error("Respons detail bukan JSON: " + text.slice(0, 200));
          }

          if (!res.ok || payload.status === "error" || !payload.data) {
            throw new Error(payload.message || "Gagal mengambil data");
          }

          const d = payload.data;

          // ====== JAMINAN (KTP, KK, Rekening) ======
          const jam = d.jaminan || { ktp: 0, kk: 0, rekening: 0 };

          if (elJamKtp) {
            elJamKtp.textContent =
              (jam.ktp ? "✅" : "❌") + " KTP";
          }
          if (elJamKk) {
            elJamKk.textContent =
              (jam.kk ? "✅" : "❌") + " KK";
          }
          if (elJamRek) {
            elJamRek.textContent =
              (jam.rekening ? "✅" : "❌") + " Rekening tabungan";
          }

          const status = (d.status || "").toLowerCase();
          let badgeClass = "bg-secondary";
          let statusText = "-";

          if (status === "completed") {
            badgeClass = "bg-success";
            statusText = "Completed";
          } else if (status === "pending") {
            badgeClass = "bg-warning text-dark";
            statusText = "Pending";
          } else if (status === "cancelled" || status === "canceled") {
            badgeClass = "bg-danger";
            statusText = "Cancelled";
          }

          // isi 3 card atas
          if (elKode)       elKode.textContent       = d.kode_transaksi || "-";
          if (elNama)       elNama.textContent       = d.nama_pembeli ?? "-";
          if (elNoHp)       elNoHp.textContent       = d.no_hp ?? "-";
          if (elJenisBayar) elJenisBayar.textContent = d.tipe_pembayaran ?? "-";
          if (elNamaKredit) elNamaKredit.textContent = d.nama_kredit ?? "-";
          if (elNoteBayar) {
            const note = (d.note || "").trim();
            elNoteBayar.textContent = note !== "" ? note : "-";
          }
          if (elTanggal)    elTanggal.textContent    = d.created_at ?? "-";
          if (elKasir)      elKasir.textContent      = d.kasir ?? "-";

          if (elStatusBadg) {
            elStatusBadg.className = "badge " + badgeClass;
            elStatusBadg.textContent = statusText;
          }

          // isi tabel mobil
          if (rowKode)      rowKode.textContent      = d.kode_transaksi || "-";
          if (rowMobil)     rowMobil.textContent     = d.nama_mobil ?? "-";
          if (rowMerk)      rowMerk.textContent      = d.tipe_mobil ?? d.jenis_kendaraan ?? "-";
          if (rowTahun)     rowTahun.textContent     = d.tahun_mobil ?? "-";
          if (rowFullPrice)
            rowFullPrice.textContent =
              d.full_price != null ? toIDR(d.full_price) : "-";
          if (rowDealPrice) rowDealPrice.textContent = toIDR(d.harga_akhir);
        } catch (err) {
          console.error("❌ Error mengambil data transaksi:", err);
          if (elNama) elNama.textContent = "Terjadi kesalahan saat mengambil data.";
          if (elStatusBadg) {
            elStatusBadg.className = "badge bg-danger";
            elStatusBadg.textContent = "Error";
          }
        }
      });
    });

    editButtons.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        const id = (btn.dataset.id || "").trim();
        if (!id) return;
        console.log("✏️ Klik edit:", id);
        window.location.href = `edit_transaksi.php?id=${encodeURIComponent(id)}`;
      });
    });
  }

  // ===================== EVENT FILTER & SEARCH ===================== ⬅️ BARU
  if (filterStatus) {
    filterStatus.addEventListener("change", () => {
      renderTable();
    });
  }

  if (searchTransaksi) {
    searchTransaksi.addEventListener("input", () => {
      renderTable();
    });
  }

  loadTransaksi();
})();
