document.addEventListener("DOMContentLoaded", () => {
  const jenisMobil = document.getElementById("jenisMobil");
  const tipeMobil = document.getElementById("tipeMobil");
  const mobilPreview = document.getElementById("mobilPreview");
  const metodePembayaran = document.getElementById("metodePembayaran");
  const detailPembayaran = document.getElementById("detailPembayaran");

  const mobilData = {
    r8: {
      tipe: "Sport",
      nama: "ABT XGT Audi R8 Street-Legal Race Car",
      harga: "Rp. 7.998.000 x 60",
      dp: "Rp. 39.000.000",
      km: "120000 Km",
      tahun: "2017",
      foto: "asset/img/audi-r8.jpg"
    },
    civic: {
      tipe: "Sedan",
      nama: "Honda Civic Type R 2020",
      harga: "Rp. 6.250.000 x 48",
      dp: "Rp. 25.000.000",
      km: "85000 Km",
      tahun: "2020",
      foto: "asset/img/civic.jpg"
    },
    supra: {
      tipe: "Sport",
      nama: "Toyota Supra GR 2021",
      harga: "Rp. 8.750.000 x 60",
      dp: "Rp. 45.000.000",
      km: "45000 Km",
      tahun: "2021",
      foto: "asset/img/supra.jpg"
    }
  };

  jenisMobil.addEventListener("change", () => {
    const value = jenisMobil.value;
    if (!value) {
      mobilPreview.style.display = "none";
      tipeMobil.value = "";
      mobilPreview.innerHTML = "";
      return;
    }

    const data = mobilData[value];
    tipeMobil.value = data.tipe;

    mobilPreview.innerHTML = `
      <img src="${data.foto}" alt="${data.nama}">
      <div class="mobil-info">
        <h4>${data.nama}</h4>
        <p class="price">${data.harga}</p>
        <p>Dp: ${data.dp}</p>
        <p>📍 ${data.km} | 📅 ${data.tahun}</p>
      </div>
    `;
    mobilPreview.style.display = "block";
  });

  metodePembayaran.addEventListener("change", () => {
    const metode = metodePembayaran.value;
    if (metode === "kredit") {
      detailPembayaran.innerHTML = `
        <label>Tenor (bulan)</label>
        <input type="number" placeholder="Masukkan tenor kredit">
        <label>Nama Kreditur</label>
        <input type="text" placeholder="Nama lembaga kredit">
      `;
    } else if (metode === "tunai") {
      detailPembayaran.innerHTML = `
        <label>Deal Price</label>
        <input type="text" placeholder="Masukkan harga akhir">
      `;
    } else {
      detailPembayaran.innerHTML = "";
    }
  });
});
