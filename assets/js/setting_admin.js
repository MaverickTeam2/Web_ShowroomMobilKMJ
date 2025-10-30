document.addEventListener('DOMContentLoaded', function () {
  let cropper;
  const uploadLogo = document.getElementById('uploadLogo');
  const imageToCrop = document.getElementById('imageToCrop');
  const previewImage = document.getElementById('previewImage');
  const cropModalEl = document.getElementById('cropModal');
  const cropModal = new bootstrap.Modal(cropModalEl);

  uploadLogo.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = () => {
      imageToCrop.src = reader.result;

      imageToCrop.onload = () => {
        cropModal.show();

        if (cropper) cropper.destroy();

        cropper = new Cropper(imageToCrop, {
          aspectRatio: 1,
          viewMode: 2,
          autoCropArea: 1,
          responsive: true,
          background: false,
          movable: true,
          zoomable: true,
          dragMode: 'move',
          minContainerWidth: 450,
          minContainerHeight: 450,
          ready() {
            const containerData = cropper.getContainerData();
            const imageData = cropper.getImageData();

            const scaleX = containerData.width / imageData.naturalWidth;
            const scaleY = containerData.height / imageData.naturalHeight;
            const scale = Math.min(scaleX, scaleY);

            cropper.zoomTo(scale);
            cropper.setCropBoxData({
              left: (containerData.width - 350) / 2,
              top: (containerData.height - 350) / 2,
              width: 350,
              height: 350
            });
          }
        });
      };
    };
    reader.readAsDataURL(file);
  });

  document.getElementById('cropButton').addEventListener('click', () => {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
      width: 150,
      height: 150,
    });

    const croppedImage = canvas.toDataURL('image/png');
    previewImage.src = croppedImage;
    document.getElementById('profile_image').value = croppedImage;

    cropModal.hide();
    cropper.destroy();
    cropper = null;
  });

  cropModalEl.addEventListener('hidden.bs.modal', () => {
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll('.settings-menu .nav-link');
  const breadcrumbCurrent = document.getElementById('breadcrumb-current');

  navLinks.forEach(link => {
    link.addEventListener('shown.bs.tab', function () {
      const menuText = this.textContent.trim();
      breadcrumbCurrent.textContent = menuText;
    });
  });
});

const btn = document.getElementById("testChatBtn");
const input = document.getElementById("whatsappNumber");

btn.addEventListener("click", function () {
  const number = input.value.trim();
  if (!number) {
    alert("Masukkan nomor WhatsApp terlebih dahulu.");
    return;
  }

  const cleanNumber = number.replace(/\D/g, "");
  const link = `https://wa.me/62${cleanNumber}`;
  window.open(link, "_blank");
});

// import
const confirmImportBtn = document.getElementById("confirmImportBtn");
const adminPasswordInput = document.getElementById("adminPassword");
const passwordError = document.getElementById("passwordError");

if (confirmImportBtn) {
  confirmImportBtn.addEventListener("click", () => {
    const enteredPassword = adminPasswordInput.value.trim();

    if (enteredPassword === "") {
      passwordError.textContent = "Password tidak boleh kosong.";
      passwordError.style.display = "block";
      return;
    }

    // ✅ Ganti dengan sistem validasi sesungguhnya nanti (misalnya AJAX ke PHP)
    if (enteredPassword === "admin123") {
      passwordError.style.display = "none";
      const confirmModal = bootstrap.Modal.getInstance(
        document.getElementById("confirmRestoreModal")
      );
      confirmModal.hide();

      // Jalankan proses restore
      window.location.href = "import_database.php";
    } else {
      passwordError.textContent = "Password salah. Coba lagi.";
      passwordError.style.display = "block";
    }
  });
}
