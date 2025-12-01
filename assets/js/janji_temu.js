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
        // step sudah lewat
        item.classList.add("done");
        item.classList.remove("active");
        circle.classList.add("step-circle--done");
        circle.classList.remove("step-circle--active");
        circle.innerHTML = '<i class="fa-solid fa-check"></i>';
      } else if (idx == step) {
        // step aktif
        item.classList.add("active");
        item.classList.remove("done");
        circle.classList.add("step-circle--active");
        circle.classList.remove("step-circle--done");
        circle.innerHTML = `<span>${idx}</span>`;
      } else {
        // step belum
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
      // initial state
      updateGroup();
    });

  // submit form (sementara cuma alert)
  const form = document.getElementById("appointmentForm");
  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      alert(
        "Untuk sekarang ini masih UI saja. Nanti bagian ini tinggal disambungkan ke API penyimpanan janji temu."
      );
    });
  }

  // tampilkan step 1 di awal
  showStep(1);
});
