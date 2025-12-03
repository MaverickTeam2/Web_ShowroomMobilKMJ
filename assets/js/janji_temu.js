document.addEventListener("DOMContentLoaded", () => {
  const stepPanels = document.querySelectorAll(".appointment-step-panel");
  const stepItems = document.querySelectorAll(".appointment-step-item");

  function showStep(step) {
    stepPanels.forEach((p) => {
      p.classList.toggle("d-none", p.dataset.step !== String(step));
    });

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

  // NEXT
  document.querySelectorAll(".appointment-btn-next").forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = btn.dataset.targetStep;

      // sebelum ke step 3: isi ringkasan tanggal & jam
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

  // BACK (link yang punya data-target-step)
  document
    .querySelectorAll(".appointment-link-back[data-target-step]")
    .forEach((btn) => {
      btn.addEventListener("click", () => {
        const target = btn.dataset.targetStep;
        showStep(target);
      });
    });

  // Efek pilih card (radio)
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
      updateGroup();
    });

  // SUBMIT FORM -> PANGGIL API
  // SUBMIT FORM -> PANGGIL API
const form = document.getElementById("appointmentForm");
if (form) {
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    // ambil value dari form
    const caraRadio = document.querySelector(
      "input[name='tipe_cara']:checked"
    );
    const janjiRadio = document.querySelector(
      "input[name='tipe_janji']:checked"
    );

    // kamu bisa mapping lebih rapi, tapi sementara kita kasih default angka
    const uji_beli = caraRadio && caraRadio.value === "buy_online" ? 2 : 1;
    const jenis_janji =
      janjiRadio && janjiRadio.value === "all_cars" ? 2 : 1;

    const tanggal = document.getElementById("tanggal")?.value || "";
    const waktu = document.getElementById("waktu")?.value || "";
    const no_telp = document.getElementById("no_telp")?.value || "";
    const note = document.getElementById("note")?.value || "";

    if (!tanggal || !waktu || !no_telp) {
      alert("Tanggal, waktu, dan nomor telepon wajib diisi.");
      return;
    }

    try {
      const res = await fetch(BASE_API_URL + "/user/routes/inquire.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          kode_mobil: CURRENT_KODE_MOBIL,
          uji_beli,
          jenis_janji,
          tanggal,
          waktu,
          no_telp,
          note,
        }),
      });

      // kalau API kirim 401 -> user belum login → redirect ke login
      if (res.status === 401) {
        const currentUrl = window.location.pathname + window.location.search;
        window.location.href =
          "/web_showroommobilKMJ/templates/auth/auth.php?redirect=" +
          encodeURIComponent(currentUrl);
        return;
      }

      const data = await res.json();

      if (data.code === 200) {
        const id = data.data?.id_inquire || data.id_inquire || "-";
        const wa =
          data.whatsapp ||
          data.data?.whatsapp ||
          data.contact?.whatsapp ||
          "";

        // buka WhatsApp di tab baru kalau nomornya ada
        if (wa) {
          const pesan =
            "Halo KMJ, saya baru saja membuat janji temu (ID: " +
            id +
            ") untuk mobil " +
            CURRENT_NAMA_MOBIL +
            ".";
          const waUrl =
            "https://wa.me/" +
            encodeURIComponent(wa) +
            "?text=" +
            encodeURIComponent(pesan);

          window.open(waUrl, "_blank");
        }

        // lalu redirect tab sekarang ke keranjang
        window.location.href =
          "/web_showroommobilKMJ/templates/keranjang.php";
      } else {
        alert(data.message || "Gagal membuat janji temu.");
        console.error(data);
      }
    } catch (err) {
      console.error(err);
      alert("Terjadi kesalahan koneksi ke server.");
    }
  });
}

  // awal: tampilkan step 1
  showStep(1);
});
