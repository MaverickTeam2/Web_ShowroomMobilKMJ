// === SWITCH ANTAR TAB ===
const tabHow = document.getElementById("tabHow");
const tabKalkulator = document.getElementById("tabKalkulator");
const howItWorks = document.getElementById("howItWorks");
const kalkulator = document.getElementById("kalkulator");

tabHow.addEventListener("click", (e) => {
  e.preventDefault();
  howItWorks.classList.add("active");
  kalkulator.classList.remove("active");
  tabHow.classList.add("active");
  tabKalkulator.classList.remove("active");
});

tabKalkulator.addEventListener("click", (e) => {
  e.preventDefault();
  kalkulator.classList.add("active");
  howItWorks.classList.remove("active");
  tabKalkulator.classList.add("active");
  tabHow.classList.remove("active");
});

// === LOGIKA HITUNG CICILAN ===
const btnHitung = document.getElementById("btnHitung");
if (btnHitung) {
  btnHitung.addEventListener("click", () => {
    const harga = parseFloat(document.getElementById("hargaKendaraan").value) || 0;
    const dp = parseFloat(document.getElementById("uangMuka").value) || 0;
    const tenor = parseFloat(document.getElementById("lamaCicilan").value) || 1;
    const bunga = parseFloat(document.getElementById("bunga").value) || 0;

    const pinjaman = harga - dp;
    const bungaPerBulan = bunga / 100 / 12;
    const cicilan = (pinjaman * bungaPerBulan) / (1 - Math.pow(1 + bungaPerBulan, -tenor));

    document.getElementById("summaryHarga").innerText = "Rp. " + harga.toLocaleString();
    document.getElementById("summaryDP").innerText = "Rp. " + dp.toLocaleString();
    document.getElementById("summaryBunga").innerText = bunga + "%";
    document.getElementById("hasilPembayaran").innerText = "Rp. " + Math.round(cicilan).toLocaleString();
  });
}
