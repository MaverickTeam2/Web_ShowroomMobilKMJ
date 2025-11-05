<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <!--Import Custom CSS-->
  <link rel="stylesheet" href="../assets/css/style.css" />
  <!--Import Font Awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="../assets/css/contactus.css">
</head>

<body>

  <!-- Navbar -->
  <?php include '../templates/navbar_footer/navbar.php'; ?>

  <div class="container text-center my-5">
    <h2 class="fw-bold">We hope we meet on the road</h2>

    <div class="row justify-content-center mt-5 g-4">

      <!-- Chat with us -->
      <div class="col-md-5">
        <div class="contact-card p-4">
          <div class="icon mb-3">
            <i class="bi bi-chat-dots-fill fs-1 text-primary"></i>
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempdolore magna aliqua.</p>
          <a href="#" class="btn btn-dark-blue mt-3">Chat with us</a>
        </div>
      </div>

      <!-- Phone -->
      <div class="col-md-5">
        <div class="contact-card p-4">
          <div class="icon mb-3">
            <i class="bi bi-headphones fs-1 text-success"></i>
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempdolore magna aliqua.</p>
          <a href="tel:+6285745390417" class="btn btn-dark-blue mt-3">(+62) 857 4539 0417</a>
        </div>
      </div>

      <!-- Our CV -->
      <div class="col-md-5">
        <div class="contact-card p-4 h-100 w-100">
          <div class="icon mb-3">
            <i class="bi bi-linkedin fs-1 text-primary"></i>
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempdolore magna aliqua.</p>
          <a href="#" class="btn btn-dark-blue mt-3">Our CV</a>
        </div>
      </div>

      <!-- Social Media -->
      <div class="col-md-5">
        <div class="contact-card p-4  h-100 w-100">
          <h5 class="fw-bold mb-2">Social Media</h5>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod tempdolore magna aliqua.</p>
          <div class="social-icons mt-3">
            <i class="bi bi-instagram fs-3 me-2 text-danger"></i>
            <i class="bi bi-youtube fs-3 me-2 text-danger"></i>
            <i class="bi bi-tiktok fs-3 me-2"></i>
            <i class="bi bi-facebook fs-3 text-primary"></i>
          </div>
        </div>
      </div>



    </div>
  </div>


  <!-- OTHER RESOURCES SECTION -->
  <div class="container my-5">
    <h3 class="fw-bold mb-4">Other resources</h3>

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
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#foundation">
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
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#marketing">
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
  </div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Footer -->
  <script src="../assets/js/footer.js" defer></script>

</body>

</html>