<?php
// === Dummy data (sementara) ===
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
        "../assets/img/depan.png",
        "../assets/img/mesin.png",
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
        "Lane Departure Warning", "Auxiliary Audio Input"
    ],
    "history" => "Mobil ini merupakan kendaraan bekas dengan kondisi masih layak pakai...",
    "warranty" => [
        "Jaminan Keaslian Dokumen",
        "Jaminan Tidak Dialihkan Tanpa Sepengetahuan Penjual (untuk kredit)",
        "Jaminan Kondisi Barang Setelah Serah Terima",
        "Jaminan Penyelesaian Biaya Tambahan",
        "Jaminan Finansial"
    ]
];

// === Rekomendasi dummy ===
$recommendations = [
    [
        "name" => "ABT XGT Audi R8 Street-Legal Race Car",
        "price" => "7.998.000",
        "dp" => "39.000.000",
        "year" => 2017,
        "km" => "120000 Km",
        "image" => "https://media.audi.com/is/image/audi/nemo/models/r8.jpg"
    ],
    [
        "name" => "BMW M8 Gran Coupe",
        "price" => "7.998.000",
        "dp" => "39.000.000",
        "year" => 2021,
        "km" => "120000 Km",
        "image" => "https://media.whichcar.com.au/uploads/2025/02/bmw-m8.jpg"
    ]
];
?>

<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $car["title"]; ?></title>
  
  <!-- Bootstrap, Bulma, FontAwesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS custom -->
  <link rel="stylesheet" href="../assets/css/detailmob.css">

</head>
<body>


<!-- Header/Navbar -->
<?php include '../templates/navbar_footer/navbar.php'; ?>

<div class="container mt-4">
  <a href="../templates/katalog.php" class="text-decoration-none mb-3 d-inline-block">← Back</a>
  <h3 class="fw-bold"><?= $car["title"]; ?></h3>

  <!-- Warna -->
  <div class="mb-3">
    <?php foreach($car["colors"] as $color): ?>
      <span class="badge bg-light text-dark border me-2"><?= $color; ?></span>
    <?php endforeach; ?>
  </div>

  <!-- Harga -->
  <div class="d-flex gap-3 mb-4">
    <div><b>DP:</b> Rp. <?= $car["down_payment"]; ?></div>
    <div><b>Angsuran:</b> Rp. <?= $car["installment"]; ?> x <?= $car["tenor"]; ?></div>
  </div>

<!-- GALERI -->
 <div class="gallery-container">
   <!-- Tombol kiri -->
  <button class="scroll-btn left">❮</button>

  <div class="gallery-wrapper">
    <div class="gallery-item">
      
      <!-- Foto besar -->
      <div class="hero-image">
        <img src="<?= $car['images'][0]; ?>" alt="">
         <!-- Tab navigasi (kayak contoh gambar) -->
          <div class="gallery-tabs">
            <button class="tab active">Exterior 360°</button>
            <button class="tab">Interior 360°</button>
            <button class="tab">Key features</button>
          </div>
      </div>

      <!-- Foto kecil (2 baris) -->
      <div class="sub-col">
        <?php if(isset($car["images"][1])): ?>
          <img src="<?= $car["images"][1]; ?>" alt="">
        <?php endif; ?>
        <?php if(isset($car["images"][2])): ?>
          <img src="<?= $car["images"][2]; ?>" alt="">
        <?php endif; ?>
      </div>


      <!-- Kolom kanan -->
      <div class="sub-col">
        <?php if(isset($car["images"][3])): ?>
          <img src="<?= $car["images"][3]; ?>" alt="">
        <?php endif; ?>
        <?php if(isset($car["images"][4])): ?>
          <img src="<?= $car["images"][4]; ?>" alt="">
        <?php endif; ?>
        </div>
    </div>
    
  </div>
    <!-- Tombol kanan -->
  <button class="scroll-btn right">❯</button>
</div>
  

<!-- ======= STICKY NAVBAR / TABS ======= -->
<div class="sticky-tabs">
  <div class="tabs-wrapper">
    <button class="tab-item active" data-target="#info">Informasi</button>
    <button class="tab-item" data-target="#features">Features & specs</button>
    <button class="tab-item" data-target="#history">History & Inspection</button>
    <button class="tab-item" data-target="#warranty">Warranty</button>
  </div>
</div>


 <!-- Informasi -->
  <section id="info" class="container px-0 mt-4">
  <h4 class="mt-4"><b>Informasi</b></h4>
  <div class="row">
    <div class="col-md-4">
      <p><b>Bahan Bakar:</b> <?= $car["info"]["fuel"]; ?></p>
    </div>
    <div class="col-md-4">
      <p><b>Mesin:</b> <?= $car["info"]["engine"]; ?></p>
    </div>
    <div class="col-md-4">
      <p><b>Penggerak:</b> <?= $car["info"]["drive"]; ?></p>
    </div>
  </div>
</section>

    
  <!-- Fitur & Spesifikasi -->
  <section id="features" class="container px-0 mt-4">
  <h4 class="fw-bold mb-3">Fitur & spesifikasi</h4>
  <div class="row">
    <div class="col-md-4">
      <div class="d-flex align-items-center mb-2">
        <i class="fa-brands fa-apple fa-lg me-2"></i>
        <span>Apple CarPlay</span>
      </div>
      <div class="d-flex align-items-center mb-2">
        <i class="fa-solid fa-camera fa-lg me-2"></i>
        <span>Rear View Camera</span>
      </div>
    </div>

    <div class="col-md-4">
      <div class="d-flex align-items-center mb-2">
        <i class="fa-solid fa-gauge-high fa-lg me-2"></i>
        <span>Cruise Control</span>
      </div>
      <div class="d-flex align-items-center mb-2">
        <i class="fa-solid fa-temperature-low fa-lg me-2"></i>
        <span>Rear Defroster</span>
      </div>
    </div>

    <div class="col-md-4">
      <div class="d-flex align-items-center mb-2">
        <i class="fa-brands fa-bluetooth fa-lg me-2"></i>
        <span>Bluetooth Technology</span>
      </div>
      <div class="d-flex align-items-center mb-2">
        <i class="fa-solid fa-chair fa-lg me-2"></i>
        <span>Cloth Seats</span>
      </div>
    </div>
  </div>
</section>


  <!-- Riwayat -->
   <div id="history" class="py-4">
  <h4><b>Sejarah & Inspeksi</b></h4>
  <p><?= $car["history"]; ?></p>

  <!-- Tambahan card inspeksi -->
  <div class="row mt-3">
    <!-- Kolom kiri -->
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

    <!-- Kolom kanan -->
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


<!-- Bagian Jaminan -->
<div id="warranty" class="py-4">
  <h4><b>Jaminan</b></h4>
  <div class="accordion" id="warrantyAccordion">
    <?php 
    // Dummy detail jaminan
    $warrantyDetails = [
      "Jaminan Keaslian Dokumen" => "Semua dokumen kendaraan dijamin asli dan sah menurut hukum yang berlaku.",
      "Jaminan Tidak Dialihkan Tanpa Sepengetahuan Penjual (untuk kredit)" => "Kendaraan tidak dapat dialihkan atau dijual kembali tanpa persetujuan penjual selama masa kredit.",
      "Jaminan Kondisi Barang Setelah Serah Terima" => "Kendaraan dalam kondisi baik sesuai pemeriksaan saat serah terima.",
      "Jaminan Penyelesaian Biaya Tambahan" => "Semua biaya tambahan yang timbul akibat transaksi akan diselesaikan sesuai perjanjian.",
      "Jaminan Finansial" => "Pembeli dengan ini menyatakan sanggup dan berkomitmen penuh untuk menanggung kewajiban finansial sesuai kesepakatan."
    ];

    // Dummy array jaminan (bisa ganti dengan $car["warranty"] dari DB)
    $warrantyList = array_keys($warrantyDetails);

    $i = 0; 
    foreach($warrantyList as $w): 
      $id = "collapse".$i; 
    ?>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading<?= $i; ?>">
          <button class="accordion-button collapsed" type="button" 
                  data-bs-toggle="collapse" data-bs-target="#<?= $id; ?>" 
                  aria-expanded="false" aria-controls="<?= $id; ?>">
            <i class="bi bi-check2-circle text-success me-2"></i> <?= $w; ?>
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
      <div class="card mb-3 position-relative">
        <button class="btn btn-light position-absolute top-0 end-0 m-2">
          <i class="fa-regular fa-heart"></i>
        </button>
        <img src="<?= $rec['image']; ?>" class="card-img-top" alt="<?= $rec['name']; ?>">
        <div class="card-body">
          <h6><?= $rec["name"]; ?></h6>
          <p>Rp. <?= $rec["price"]; ?> x 60<br>
          DP Rp. <?= $rec["dp"]; ?><br>
          <?= $rec["km"]; ?> | <?= $rec["year"]; ?></p>
        </div>
        <button class="btn btn-light position-absolute bottom-0 end-0 m-2">
          <
        </button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>




<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="../assets/js/detail_mobil.js"></script>
<!-- Footer -->
<script src="../assets/js/footer.js" defer></script>

</body>
</html>
