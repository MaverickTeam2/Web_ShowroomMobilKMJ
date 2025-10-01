<?php
// Dummy data (simulasi data dari database)
// jangan komen kenapa 
$car = [
    "title" => "TOYOTA NEW YARISH 1.5 AT TRID 2024",
    "colors" => ["Black", "White", "Silver", "Red"],
    "down_payment" => "10.000.000",
    "installment" => "6.089.000",
    "tenor" => 60,
    "images" => [
        "../assets/img/fullbody.png",
        "../assets/img/kursi.png",
        "../assets/img/kursi2.png",
        "../assets/img/gatau.png",
        "../assets/img/setir.png",
        "../assets/img/samping.png",
        "../assets/img/belakang.png"
    ],
    
    "info" => [
        "fuel" => "23 city/30 hwy Miles per gallon",
        "engine" => "4-cyl, Gas, 2.4L",
        "drive" => "Front Wheel Drive"
    ],
    "features" => [
        "Apple CarPlay", "Cruise Control", "Bluetooth Technology",
        "Rear View Camera", "Rear Defroster", "Cloth Seats",
        "Apple CarPlay", "Lane Departure Warning", "Auxiliary Audio Input"
    ],
    "history" => "Mobil ini merupakan kendaraan bekas dengan kondisi masih layak pakai dan surat-surat lengkap. Mesin berjalan normal dan performa masih terjaga...",
    "warranty" => [
        "Jaminan Keaslian Dokumen",
        "Jaminan Tidak Dialihkan Tanpa Sepengetahuan Penjual (untuk kredit)",
        "Jaminan Kondisi Barang Setelah Serah Terima",
        "Jaminan Penyelesaian Biaya Tambahan",
        "Jaminan Finansial"
    ]
];

// Rekomendasi mobil lain
$recommendations = [
    [
      "name" => "ABT XGT Audi R8 Street-Legal Race Car",
      "price" => "7.998.000",
      "dp" => "39.000.000",
      "year" => 2017,
      "km" => "120000 Km",
      "image" => "https://media.audi.com/is/image/audi/nemo/models/r8/r8-coupe-v10-performance/my-2021/derivative-startpage/stage-large-image/1920x1080-audi-r8-coupe-performance-ar8_ae_2020_2438.jpg?width=768"
    ],
    [
      "name" => "BMW M8 Gran Coupe",
      "price" => "7.998.000",
      "dp" => "39.000.000",
      "year" => 2021,
      "km" => "120000 Km",
      "image" => "https://media.whichcar.com.au/uploads/2025/02/e518a1c2-2020-BMW-M8-Competition-performance-review-768x512.jpg"
    ],
    [
      "name" => "Mercedes-Maybach S 680 4MATIC Night Series",
      "price" => "7.998.000",
      "dp" => "39.000.000",
      "year" => 2021,
      "km" => "120000 Km",
      "image" => "https://www.edmunds.com/assets/m/cs/blt90f2f9c5b4c0f23f/666b200a46a037204da27736/2024_Mercedes-Benz_Maybach_S680_f34_05122024_01_edmunds_1600.jpg"
    ],
    [
      "name" => "Ferrari Monza SP2",
      "price" => "7.998.000",
      "dp" => "39.000.000",
      "year" => 2018,
      "km" => "120000 Km",
      "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7D7dLYnKB4SCudBqe4o75nmoWoUdelPXn3g&s"
    ]
];


?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mobil</title>
  <!--Import Bulma CSS-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif;
    }
    /* Gallery */
    .gallery-container {
      position: relative;
      margin-bottom: 30px;
    }
    .gallery-wrapper {
      display: flex;
      overflow-x: auto;
      gap: 10px;
      scroll-behavior: smooth;
      padding-bottom: 10px;
    }
    .gallery-wrapper::-webkit-scrollbar { height: 8px; }
    .gallery-wrapper::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.3); border-radius: 4px; }

    .hero {
      flex: 0 0 auto;
      width: 700px;
      height: 500px;
    }
    .hero img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 8px;
    }

    .sub-col {
      display: flex;
      flex-direction: column;
      gap: 10px;
      flex: 0 0 auto;
    }
    .sub-col img {
      width: 250px;
      height: 245px; /* setengah hero */
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
    }

    /* Tombol geser */
    .scroll-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0,0,0,0.5);
      color: #fff;
      border: none;
      padding: 5px 15px;
      cursor: pointer;
      border-radius: 50%;
      font-size: 20px;
      z-index: 10;
    }
    .scroll-btn.left { left: 10px; }
    .scroll-btn.right { right: 10px; }
  </style>
</head>
<body>

<!-- navbar -->
  <script src="../assets/js/navbar.js" defer></script>
<div class="container mt-4">
  <a href="#" class="text-decoration-none mb-3 d-inline-block">← Back</a>

  <!-- Judul -->
  <h3 class="fw-bold"><?= $car["title"]; ?></h3>

  <!-- Warna & Harga -->
  <div class="mb-3">
    <?php foreach($car["colors"] as $color): ?>
      <span class="badge bg-light text-dark border me-2"><?= $color; ?></span>
    <?php endforeach; ?>
  </div>
  <div class="d-flex gap-3 mb-4">
    <div><b>DP:</b> Rp. <?= $car["down_payment"]; ?></div>
    <div><b>Angsuran:</b> Rp. <?= $car["installment"]; ?> x <?= $car["tenor"]; ?></div>
  </div>

  <!-- Gallery -->
  <div class="gallery-container">
    <button class="scroll-btn left">❮</button>
    <div class="gallery-wrapper" id="gallery">
      <!-- Foto besar -->
      <div class="hero">
        <img src="<?= $car['images'][0]; ?>" alt="Hero Foto">
      </div>
      <!-- Sub foto (2 per kolom) -->
      <?php for($i=1; $i<count($car["images"]); $i+=2): ?>
        <div class="sub-col">
          <?php if(isset($car["images"][$i])): ?>
            <img src="<?= $car["images"][$i]; ?>" alt="Sub Foto">
          <?php endif; ?>
          <?php if(isset($car["images"][$i+1])): ?>
            <img src="<?= $car["images"][$i+1]; ?>" alt="Sub Foto">
          <?php endif; ?>
        </div>
      <?php endfor; ?>
    </div>
    <button class="scroll-btn right">❯</button>
  </div>

  <!-- Navigasi Scroll -->
  <ul class="nav nav-pills mt-4 justify-content-center sticky-top bg-white shadow-sm" id="scrollNav">
    <li class="nav-item"><a class="nav-link active" href="#info">Informasi</a></li>
    <li class="nav-item"><a class="nav-link" href="#features">Fitur & Spesifikasi</a></li>
    <li class="nav-item"><a class="nav-link" href="#history">Sejarah & Inspeksi</a></li>
    <li class="nav-item"><a class="nav-link" href="#warranty">Jaminan</a></li>
  </ul>

  <!-- Konten Scroll -->
  <div id="info" class="py-4">
    <h4><b>Informasi</b></h4>
    <p><?= $car["info"]["fuel"]; ?></p>
    <p><?= $car["info"]["engine"]; ?></p>
    <p><?= $car["info"]["drive"]; ?></p>
  </div>

  <div id="features" class="py-4">
  <h4><b>Fitur & Spesifikasi</b></h4>
  <div class="row">
    <?php
    // Mapping fitur ke icon FontAwesome
      $featureIcons = [
        "Apple CarPlay" => "fa-solid fa-car",
        "Cruise Control" => "fa-gauge-high",
        "Bluetooth Technology" => "fa-bluetooth-b",
        "Rear View Camera" => "fa-camera",
        "Rear Defroster" => "fa-snowflake",
        "Cloth Seats" => "fa-chair",
        "Lane Departure Warning" => "fa-road",
        "Auxiliary Audio Input" => "fa-headphones"
      ];
    ?>
    <?php foreach($car["features"] as $f): ?>
      <div class="col-md-4 mb-3">
        <div class="d-flex align-items-center">
          <i class="fa-solid <?= $featureIcons[$f] ?? 'fa-circle-info' ?> fa-lg me-2"></i>
          <span><?= $f; ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


  <div id="history" class="py-4">
  <h4><b>Sejarah & Inspeksi</b></h4>
  <p><?= $car["history"]; ?></p>

  <!-- Tambahan card inspeksi -->
  <div class="row mt-3">
    <div class="col-md-6">
      <div class="border rounded-lg divide-y">
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-check text-success"></i>
            <span>1 Pemilik</span>
          </div>
          <i class="fa-regular fa-circle-info text-primary"></i>
        </div>
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-check text-success"></i>
            <span>Tidak ada kerusakan dalam kerangka</span>
          </div>
          <i class="fa-regular fa-circle-info text-primary"></i>
        </div>
        <div class="d-flex align-items-center justify-content-between p-3">
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-check text-success"></i>
            <span>Tidak ada masalah odometer</span>
          </div>
          <i class="fa-regular fa-circle-info text-primary"></i>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="border rounded-lg divide-y">
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-check text-success"></i>
            <span>1 Pemilik</span>
          </div>
          <i class="fa-regular fa-circle-info text-primary"></i>
        </div>
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-check text-success"></i>
            <span>Ban & roda diperiksa dengan 15 cara</span>
          </div>
          <i class="fa-regular fa-circle-info text-primary"></i>
        </div>
        <div class="d-flex align-items-center justify-content-between p-3">
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-check text-success"></i>
            <span>Interior dibersihkan secara mendalam</span>
          </div>
          <i class="fa-regular fa-circle-info text-primary"></i>
        </div>
      </div>
    </div>
  </div>
</div>


  <div id="warranty" class="py-4">
  <h4><b>Jaminan</b></h4>

  <div class="accordion" id="warrantyAccordion">
    <?php 
    // contoh tambahan deskripsi jaminan (dummy)
    $warrantyDetails = [
      "Jaminan Keaslian Dokumen" => "Semua dokumen kendaraan dijamin asli dan sah menurut hukum yang berlaku.",
      "Jaminan Tidak Dialihkan Tanpa Sepengetahuan Penjual (untuk kredit)" => "Kendaraan tidak dapat dialihkan atau dijual kembali tanpa persetujuan penjual selama masa kredit.",
      "Jaminan Kondisi Barang Setelah Serah Terima" => "Kendaraan dalam kondisi baik sesuai pemeriksaan saat serah terima.",
      "Jaminan Penyelesaian Biaya Tambahan" => "Semua biaya tambahan yang timbul akibat transaksi akan diselesaikan sesuai perjanjian.",
      "Jaminan Finansial" => "Pembeli dengan ini menyatakan sanggup dan berkomitmen penuh untuk menanggung kewajiban finansial sesuai kesepakatan."
    ];

    $i = 0;
    foreach($car["warranty"] as $w): 
      $id = "collapse".$i;
    ?>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading<?= $i; ?>">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $id; ?>" aria-expanded="false" aria-controls="<?= $id; ?>">
            <i class="fa-solid fa-check text-success me-2"></i> <?= $w; ?>
          </button>
        </h2>
        <div id="<?= $id; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $i; ?>" data-bs-parent="#warrantyAccordion">
          <div class="accordion-body">
            <?= $warrantyDetails[$w] ?? "Detail jaminan ini akan ditambahkan nanti."; ?>
          </div>
        </div>
      </div>
    <?php 
      $i++;
    endforeach; 
    ?>
  </div>
</div>


  <!-- Rekomendasi -->
  <h5 class="mt-4"><b>Direkomendasikan</b></h5>
  <div class="row">
    <?php foreach($recommendations as $rec): ?>
    <div class="col-md-3">
      <div class="card mb-3">
        <img src="<?= $rec['image']; ?>" class="card-img-top" alt="<?= $rec['name']; ?>">>
        <div class="card-body">
          <h6><?= $rec["name"]; ?></h6>
          <p>Rp. <?= $rec["price"]; ?> x 60<br>
            DP Rp. <?= $rec["dp"]; ?><br>
            <?= $rec["km"]; ?> | <?= $rec["year"]; ?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  // ScrollSpy Nav
  const sections = document.querySelectorAll("div[id]");
  const navLinks = document.querySelectorAll("#scrollNav .nav-link");

  window.addEventListener("scroll", () => {
    let current = "";
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 100;
      if (pageYOffset >= sectionTop) current = section.getAttribute("id");
    });
    navLinks.forEach(link => {
      link.classList.remove("active");
      if (link.getAttribute("href") === "#" + current) link.classList.add("active");
    });
  });

  // Gallery scroll buttons
  const gallery = document.getElementById("gallery");
  document.querySelector(".scroll-btn.left").addEventListener("click", () => {
    gallery.scrollBy({ left: -400, behavior: "smooth" });
  });
  document.querySelector(".scroll-btn.right").addEventListener("click", () => {
    gallery.scrollBy({ left: 400, behavior: "smooth" });
  });
});
</script>
<!-- footer -->
  <script src="../assets/js/footer.js" defer></script>
</body>
</html>
