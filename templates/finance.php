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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

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
    <section class="section">
        <h2 class="title is-4">Finance FAQs</h2>
        <div class="content">
            <?php foreach ($faqs as $faq): ?>
                <article class="message is-light">
                    <div class="message-header">
                        <p><?= $faq; ?></p>
                        <button class="button is-small">▼</button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

</body>
</html>
