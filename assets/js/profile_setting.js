// WEB_SHOWROOMMOBILKMJ/assets/js/profile_setting.js

document.addEventListener("DOMContentLoaded", () => {
  // BASE_API_URL harus sudah didefinisikan di header.php / config_api.php
  if (typeof BASE_API_URL === "undefined") {
    console.error("BASE_API_URL belum didefinisikan!");
    return;
  }

  /* ===========================
     Helper: kirim request JSON
  ============================ */
  async function postAccount(action, payload) {
    const res = await fetch(`${BASE_API_URL}/user/routes/account.php?action=${action}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });

    const json = await res.json();
    if (!res.ok || json.code !== 200) {
      throw new Error(json.message || "Request gagal");
    }
    return json;
  }

  /* ===========================
     1. GANTI PASSWORD
  ============================ */
  const formChangePassword = document.getElementById("formChangePassword");
  if (formChangePassword) {
    formChangePassword.addEventListener("submit", async (e) => {
      e.preventDefault();

      const fd = new FormData(formChangePassword);
      const payload = Object.fromEntries(fd.entries());

      try {
        const res = await postAccount("change_password", payload);
        alert(res.message || "Password berhasil diubah");
        formChangePassword.reset();
        // Tutup modal bootstrap
        const modalEl = document.getElementById("modalPassword");
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal && modal.hide();
      } catch (err) {
        alert(err.message);
      }
    });
  }

  /* ===========================
     2. TOGGLE 2FA
  ============================ */
  const form2FA = document.getElementById("form2FA");
  if (form2FA) {
    form2FA.addEventListener("submit", async (e) => {
      e.preventDefault();

      const fd = new FormData(form2FA);
      const payload = Object.fromEntries(fd.entries()); // {kode_user, mode}

      try {
        const res = await postAccount("toggle_2fa", payload);
        alert(res.message || "Pengaturan 2FA diperbarui");
        const modalEl = document.getElementById("modal2FA");
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal && modal.hide();
      } catch (err) {
        alert(err.message);
      }
    });
  }

  /* ===========================
     3. REQUEST CHANGE EMAIL
  ============================ */
  const formChangeEmail = document.getElementById("formChangeEmail");
  if (formChangeEmail) {
    formChangeEmail.addEventListener("submit", async (e) => {
      e.preventDefault();

      const fd = new FormData(formChangeEmail);
      const payload = Object.fromEntries(fd.entries()); // {kode_user, new_email}

      try {
        const res = await postAccount("request_change_email", payload);
        alert(res.message || "Kode verifikasi dikirim ke email baru");
        // TODO: tampilkan modal baru untuk input kode_verifikasi + new_email
        const modalEl = document.getElementById("modalChangeEmail");
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal && modal.hide();
      } catch (err) {
        alert(err.message);
      }
    });
  }

  /* ===========================
     4. DELETE ACCOUNT
  ============================ */
  const formDeleteAccount = document.getElementById("formDeleteAccount");
  if (formDeleteAccount) {
    formDeleteAccount.addEventListener("submit", async (e) => {
      e.preventDefault();

      if (!confirm("Yakin ingin menghapus akun secara permanen?")) {
        return;
      }

      const fd = new FormData(formDeleteAccount);
      const payload = Object.fromEntries(fd.entries()); // {kode_user, password}

      try {
        const res = await postAccount("delete_account", payload);
        alert(res.message || "Akun berhasil dihapus");
        // Setelah akun dihapus, logout dari web
        window.location.href = "auth/logout.php"; // relative dari templates/
      } catch (err) {
        alert(err.message);
      }
    });
  }
});
