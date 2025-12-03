<?php
require_once __DIR__ . '/../../db/config_api.php';
require_once __DIR__ . '/../../db/api_client.php';

// Ambil data sosial media dari API
$response = api_get('admin/get_social_settings.php');

// Ambil data dari API atau set default
$contacts = $response['data'] ?? [];
function fix_url($url)
{
  if (empty($url) || $url == '#')
    return '#';
  if (!preg_match('/^https?:\/\//i', $url)) {
    return 'https://' . ltrim($url, '/');
  }
  return $url;
}

$whatsapp = $contacts['whatsapp'] ?? '';
$instagram = fix_url($contacts['instagram_url'] ?? '#');
$facebook = fix_url($contacts['facebook_url'] ?? '#');
$tiktok = fix_url($contacts['tiktok_url'] ?? '#');
$youtube = fix_url($contacts['youtube_url'] ?? '#');


// Format WhatsApp link WA.me
$whatsapp_url = (!empty($whatsapp))
  ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp)
  : '#';
?>

<footer class="footer has-background-light">
  <div class="container">
    <div class="columns">

      <!-- Logo & Sosmed -->
      <div class="column is-one-quarter">
        <div class="logo-sosmed">
          <figure class="image is-128x128 mb-3">
            <img src="../assets/img/Logo_KMJ_YB.png" alt="KMJ Logo" />
          </figure>

          <p>
            <?php if (!empty($whatsapp)): ?>
              <a href="<?php echo $whatsapp_url; ?>" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-whatsapp fa-lg mx-1 whatsapp-icon"></i>
              </a>
            <?php endif; ?>

            <?php if (!empty($facebook) && $facebook != '#'): ?>
              <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-facebook fa-lg mx-1 facebook-icon"></i>
              </a>
            <?php endif; ?>

            <?php if (!empty($instagram) && $instagram != '#'): ?>
              <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-instagram fa-lg mx-1 instagram-icon"></i>
              </a>
            <?php endif; ?>

            <?php if (!empty($tiktok) && $tiktok != '#'): ?>
              <a href="<?php echo htmlspecialchars($tiktok); ?>" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-tiktok fa-lg mx-1 tiktok-icon"></i>
              </a>
            <?php endif; ?>

            <?php if (!empty($youtube) && $youtube != '#'): ?>
              <a href="<?php echo htmlspecialchars($youtube); ?>" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-youtube fa-lg mx-1 youtube-icon"></i>
              </a>
            <?php endif; ?>
          </p>
        </div>
      </div>

      <!-- Shop -->
      <div class="column">
        <p class="title is-6">Shop</p>
        <ul>
          <li><a href="#" class="has-text-black">Kategori</a></li>
          <li><a href="../templates/catalog.html" class="has-text-black">Semua produk</a></li>
        </ul>
      </div>

      <!-- Sell -->
      <div class="column">
        <p class="title is-6">Sell</p>
        <ul>
          <li><a href="#" class="has-text-black">Bagaimana cara kerjanya?</a></li>
        </ul>
      </div>

      <!-- Finance -->
      <div class="column">
        <p class="title is-6">Finance</p>
        <ul>
          <li><a href="#" class="has-text-black">Kalkulator Pembayaran</a></li>
          <li><a href="#" class="has-text-black">Tutorial</a></li>
        </ul>
      </div>

      <!-- About -->
      <div class="column">
        <p class="title is-6">About</p>
        <ul>
          <li><a href="contactus.php" class="has-text-black">Contact us</a></li>
          <li><a href="../templates/about.html" class="has-text-black">About KMJ</a></li>
          <li><a href="#" class="has-text-black">Media Center</a></li>
        </ul>
      </div>

    </div>

    <div class="content has-text-centered">
      <p>
        Dengan menggunakan <strong>kmj.com</strong>, Anda menyetujui
        pemantauan dan penyimpanan interaksi Anda dengan situs web, termasuk vendor KMJ.
        <br />
        <a href="#">Kebijakan Privasi</a> kami untuk detail selengkapnya.
      </p>
    </div>
  </div>
</footer>

<style>
  /* Social Media Icon Colors */
  .whatsapp-icon {
    color: #25D366;
    transition: color 0.3s ease;
  }

  .whatsapp-icon:hover {
    color: #128C7E;
  }

  .facebook-icon {
    color: #1877F2;
    transition: color 0.3s ease;
  }

  .facebook-icon:hover {
    color: #0C63D4;
  }

  .instagram-icon {
    color: #E4405F;
    transition: color 0.3s ease;
  }

  .instagram-icon:hover {
    color: #C13584;
  }

  .tiktok-icon {
    color: #000000;
    transition: color 0.3s ease;
  }

  .tiktok-icon:hover {
    color: #FF0050;
  }

  .youtube-icon {
    color: #FF0000;
    transition: color 0.3s ease;
  }

  .youtube-icon:hover {
    color: #CC0000;
  }
</style>