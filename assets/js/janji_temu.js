document.addEventListener("DOMContentLoaded", () => {
  const stepPanels = document.querySelectorAll(".appointment-step-panel");
  const stepItems = document.querySelectorAll(".appointment-step-item");

  function showStep(step) {
    // tampil/hidden panel
    stepPanels.forEach((p) => {
      p.classList.toggle("d-none", p.dataset.step !== String(step));
    });

    // update stepper kiri
    stepItems.forEach((item) => {
      const idx = item.dataset.stepIndex;
      const circle = item.querySelector(".step-circle");

      if (idx < step) {
        item.classList.add("done");
        item.classList.remove("active");
        circle.classList.add("step-circle--done");
        circle.classList.remove("step-circle--active");
        circle.innerHTML = '<i class="fa-solid fa-check"></i>';
      } else if (idx == step) {
        item.classList.add("active");
        item.classList.remove("done");
        circle.classList.add("step-circle--active");
        circle.classList.remove("step-circle--done");
        circle.innerHTML = `<span>${idx}</span>`;
      } else {
        item.classList.remove("active", "done");
        circle.classList.remove("step-circle--active", "step-circle--done");
        circle.innerHTML = `<span>${idx}</span>`;
      }
    });
  }

  // tombol NEXT
  document.querySelectorAll(".appointment-btn-next").forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = btn.dataset.targetStep;

      // sebelum masuk step 3, isi ringkasan tanggal & waktu
      if (target === "3") {
        const tglInput = document.getElementById("tanggal");
        const jamInput = document.getElementById("waktu");
        const reviewEl = document.getElementById("reviewDatetime");

        if (!tglInput || !jamInput || !reviewEl) {
          showStep(target);
          return;
        }

        const tgl = tglInput.value;
        const jam = jamInput.value;

        if (!tgl || !jam) {
          alert("Pilih tanggal dan waktu terlebih dahulu.");
          return;
        }

        const dt = new Date(`${tgl}T${jam}`);
        reviewEl.textContent = dt.toLocaleString("id-ID", {
          weekday: "long",
          day: "numeric",
          month: "long",
          year: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        });
      }

      showStep(target);
    });
  });

  // tombol BACK (yang pakai data-target-step)
  document
    .querySelectorAll(".appointment-link-back[data-target-step]")
    .forEach((btn) => {
      btn.addEventListener("click", () => {
        const target = btn.dataset.targetStep;
        showStep(target);
      });
    });

  // efek pilihan card (radio → .choice-card--active)
  document
    .querySelectorAll(".choice-card input[type='radio']")
    .forEach((input) => {
      const updateGroup = () => {
        const group = input.name;
        document
          .querySelectorAll(`.choice-card input[name='${group}']`)
          .forEach((r) => {
            const card = r.closest(".choice-card");
            if (!card) return;
            card.classList.toggle("choice-card--active", r.checked);
          });
      };

      input.addEventListener("change", updateGroup);
      updateGroup(); // initial
    });

  // === SUBMIT FORM: KIRIM KE API ===
  const form = document.getElementById("appointmentForm");

  if (form) {
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      if (!IS_LOGGED_IN || !CURRENT_USER || !CURRENT_USER.kode_user) {
        alert("Kamu harus login untuk membuat janji temu.");
        return;
      }

      const formData = new FormData(form);

      const payload = {
        // backend bisa ambil dari session, tapi sekalian kirim juga
        kode_user: CURRENT_USER.kode_user,
        kode_mobil: form.dataset.kodeMobil || formData.get("kode_mobil"),

        // pastikan name radio di HTML: name="uji_beli" dan name="jenis_janji"
        uji_beli: parseInt(formData.get("uji_beli") || "0", 10),
        jenis_janji: parseInt(formData.get("jenis_janji") || "0", 10),

        tanggal: formData.get("tanggal") || "",
        waktu: formData.get("waktu") || "",
        no_telp: formData.get("no_telp") || "",
        note: formData.get("note") || null,
      };

      if (!payload.kode_mobil || !payload.tanggal || !payload.waktu || !payload.no_telp) {
        alert("Kode mobil, tanggal, waktu, dan nomor telepon wajib diisi.");
        return;
      }

      try {
        const res = await fetch(BASE_API_URL + "/user/routes/inquire.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload),
        });

        const data = await res.json();

        if (data.code === 200) {
          // sukses simpan janji temu
          alert("Janji temu berhasil dibuat. ID: " + (data.data?.id_inquire ?? "-"));
          // TODO: kalau mau, redirect ke halaman riwayat janji temu:
          // window.location.href = "keranjang.php"; // atau halaman lain
        } else {
          alert(data.message || "Gagal membuat janji temu.");
          console.error("API error:", data);
        }
      } catch (err) {
        console.error(err);
        alert("Terjadi kesalahan koneksi ke server.");
      }
    });
  }

  // tampilkan step 1 di awal
  showStep(1);
});
