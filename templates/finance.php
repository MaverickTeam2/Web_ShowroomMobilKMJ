<?php
// Dummy data (simulasi data dari database)

// Data mobil
$mobil = [
    "judul" => "Dapatkan hasil pembiayaan tanpa memengaruhi kredit Anda",
    "gambar" => "https://via.placeholder.com/500x300.png?text=Mobil+Dummy",
    "cta" => "Dapatkan Persyaratan"
];

// Data finance company
$finance = [
    ["nama" => "BCA Finance", "logo" => "https://via.placeholder.com/150x50.png?text=BCA+Finance"],
    ["nama" => "FIFGROUP", "logo" => "https://via.placeholder.com/150x50.png?text=FIFGROUP"],
    ["nama" => "BRI Finance", "logo" => "https://via.placeholder.com/150x50.png?text=BRI+Finance"],
    ["nama" => "Mandiri Utama Finance", "logo" => "https://via.placeholder.com/150x50.png?text=Mandiri+Finance"],
    ["nama" => "PT Summit OTO Finance", "logo" => "https://via.placeholder.com/150x50.png?text=OTO+Finance"],
];

// Data tips kredit
$tips = [
    [
        "judul" => "Tips Kredit Kendaraan 1",
        "deskripsi" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
        "gambar" => "https://via.placeholder.com/150.png?text=Card+1"
    ],
    [
        "judul" => "Tips Kredit Kendaraan 2",
        "deskripsi" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
        "gambar" => "https://via.placeholder.com/150.png?text=Card+2"
    ],
    [
        "judul" => "Tips Kredit Kendaraan 3",
        "deskripsi" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
        "gambar" => "https://via.placeholder.com/150.png?text=Card+3"
    ],
];

// Data FAQ
$faqs = [
    "Lorem Ipsum is simply dummy text of the printing text?",
    "Apa keuntungan menggunakan kredit di KMJ?",
    "Bagaimana cara mengajukan pembiayaan?",
    "Apa saja syarat dokumen yang diperlukan?",
    "Berapa lama proses persetujuan kredit?",
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMJ Finance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="../assets/css/finance.css">
</head>
<body>

<!-- navbar -->
 <script src="../assets/js/navbar.js" defer></script>

    <!-- Hero -->
    <section class="section">
        <div class="columns is-vcentered">
            <div class="column is-half">
                <h1 class="title"><?= $mobil['judul']; ?></h1>
                <button class="button is-warning"><?= $mobil['cta']; ?></button>
            </div>
            <div class="column is-half">
                <figure class="image">
                    <img src="<?= $mobil['gambar']; ?>" alt="Mobil Dummy">
                </figure>
            </div>
        </div>
    </section>

    <!-- Finance Company -->
    <section class="section has-background-light">
        <div class="box has-text-centered">
            <div class="columns is-multiline is-mobile is-centered">
                <?php foreach ($finance as $f): ?>
                    <div class="column is-2">
                        <figure class="image is-128x128">
                            <img src="<?= $f['logo']; ?>" alt="<?= $f['nama']; ?>">
                        </figure>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Tips Kredit -->
    <section class="section">
        <h2 class="title is-4">Tips Kredit Kendaraan</h2>
        <div class="columns">
            <?php foreach ($tips as $t): ?>
                <div class="column is-one-third">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <img src="<?= $t['gambar']; ?>" alt="<?= $t['judul']; ?>">
                            </figure>
                        </div>
                        <div class="card-content">
                            <p class="title is-6"><?= $t['judul']; ?></p>
                            <p><?= $t['deskripsi']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- FAQ -->
  <div class="container my-5">
    <h2 class="fw-bold mb-4">Finance FAQs</h2>

    <div class="accordion custom-accordion" id="resourcesAccordion">

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#office">
            Corporate Home Office
          </button>
        </h2>
        <div id="office" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for Corporate Home Office.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#foundation">
            The KMJ Foundation
          </button>
        </h2>
        <div id="foundation" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for The KMJ Foundation.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#marketing">
            Marketing Vendoring Inquiries
          </button>
        </h2>
        <div id="marketing" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for Marketing Vendoring Inquiries.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#news">
            News Media Inquiries
          </button>
        </h2>
        <div id="news" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for News Media Inquiries.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#supplied">
            Supplied Inquiries
          </button>
        </h2>
        <div id="supplied" class="accordion-collapse collapse" data-bs-parent="#resourcesAccordion">
          <div class="accordion-body">
            Content for Supplied Inquiries.
          </div>
        </div>
      </div>

    </div>
  </div>

    
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Footer -->
<script src="../assets/js/footer.js" defer></script>

</body>
</html>
