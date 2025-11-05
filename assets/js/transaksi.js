(() => {
  console.log("✅ transaksi.js aktif");

  const path = window.location.pathname;

  if(path.includes("transaksi.php")) {
    console.log("Halaman transaksi.php terdeteksi");

    const btnTambah = document.getElementById("btn-tambah-transaksi");
    const modalElement = document.getElementById("modalDetailTransaksi");
    const modalBody = document.getElementById("modalDetailBody");

    // Tombol tambah transaksi
    if (btnTambah) {
      btnTambah.addEventListener("click", e => {
        e.preventDefault();
        console.log("🟢 Tambah transaksi diklik");
        window.location.href = "tambah_transaksi.php";
      });
    }

    // Tombol detail transaksi
    const detailButtons = document.querySelectorAll(".btn-detail");
    detailButtons.forEach(btn => {
      btn.addEventListener("click", async e => {
        e.preventDefault();

        const id = btn.dataset.id;
        if (!id) return;

        console.log("🔍 Lihat detail transaksi ID:", id);

        // tampilkan loading di modal
        modalBody.innerHTML = `
          <div class="text-center my-3">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Memuat data transaksi...</p>
          </div>
        `;

        try {
          // Ambil data dari API detail_transaksi.php
          const response = await fetch(`detail_transaksi.php?id=${id}`);
          const data = await response.json();

          if (!data || data.status === "error") {
            modalBody.innerHTML = `
              <p class="text-center text-danger my-3">
                ${data.message || "Data tidak ditemukan."}
              </p>`;
          } else {
            modalBody.innerHTML = `
              <div>
                <h5 class="fw-bold mb-3">Detail Transaksi #${data.id_transaksi}</h5>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <p><b>Nama Pembeli:</b> ${data.nama_pembeli}</p>
                    <p><b>No HP:</b> ${data.no_hp}</p>
                    <p><b>Tipe Pembayaran:</b> ${data.tipe_pembayaran}</p>
                    <p><b>Harga Akhir:</b> Rp ${parseInt(data.harga_akhir).toLocaleString("id-ID")}</p>
                  </div>
                  <div class="col-md-6">
                    <p><b>Tanggal:</b> ${data.created_at}</p>
                    <p><b>Kasir:</b> ${data.kasir || "-"}</p>
                    <p><b>Status Pengiriman:</b> ${data.status_pengiriman || "-"}</p>
                  </div>
                </div>
                <hr>
                <h6 class="fw-bold mt-3">Detail Mobil</h6>
                <ul>
                  <li><b>Nama Mobil:</b> ${data.nama_mobil || "-"}</li>
                  <li><b>Merk:</b> ${data.merk || "-"}</li>
                  <li><b>Tahun:</b> ${data.tahun || "-"}</li>
                </ul>
              </div>
            `;
          }

          const modal = new bootstrap.Modal(modalElement);
          modal.show();
        } catch (err) {
          console.error("❌ Error mengambil data transaksi:", err);
          modalBody.innerHTML = `
            <p class="text-center text-danger my-3">
              Terjadi kesalahan saat mengambil data transaksi.
            </p>`;
          const modal = new bootstrap.Modal(modalElement);
          modal.show();
        }
      });
    });
  }

  // ======================================================
  // 📄 HALAMAN: tambah_transaksi.php
  // ======================================================
  if (path.includes("tambah_transaksi.php")) {
    console.log("📄 Mode: tambah transaksi aktif");

    const jenisMobil = document.getElementById("jenisMobil");
    const mobilPreview = document.getElementById("mobilPreview");
    const mobilImage = document.getElementById("mobilImage");
    const mobilNama = document.getElementById("mobilNama");
    const mobilHarga = document.getElementById("mobilHarga");
    const mobilDetail = document.getElementById("mobilDetail");
    const mobilKm = document.getElementById("mobilKm");
    const mobilTahun = document.getElementById("mobilTahun");
    const metodePembayaran = document.getElementById("jenisPembayaran");
    const kreditField = document.getElementById("field-nama-kredit");

    // Ambil data mobil dari database lewat API get_mobil.php
    jenisMobil.addEventListener("change", async () => {
      const idMobil = jenisMobil.value;
      if (!idMobil) {
        mobilPreview.classList.add("d-none");
        return;
      }

      try {
        const res = await fetch(`get_mobil.php?id=${idMobil}`);
        const data = await res.json();

        if (!data || data.status === "error") {
          mobilPreview.classList.add("d-none");
          return;
        }

        mobilImage.src = `../../assets/img/${data.foto}`;
        mobilNama.textContent = data.nama_mobil;
        mobilHarga.textContent = `Rp ${parseInt(data.harga).toLocaleString("id-ID")}`;
        mobilDetail.textContent = `DP Rp ${parseInt(data.dp).toLocaleString("id-ID")}`;
        mobilKm.textContent = `${data.km || 0} Km`;
        mobilTahun.textContent = data.tahun;
        mobilPreview.classList.remove("d-none");
      } catch (err) {
        console.error("❌ Gagal ambil data mobil:", err);
        mobilPreview.classList.add("d-none");
      }
    });

     metodePembayaran.addEventListener("change", () => {
      const isKredit = metodePembayaran.value === "kredit";
      kreditField.style.display = isKredit ? "block" : "none";
    });
  }
})();