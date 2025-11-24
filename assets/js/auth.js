document.addEventListener("DOMContentLoaded", () => {

    /* ===========================================================
       UTIL: Show Only One Form
    =========================================================== */
    function showForm(formId) {
        document.querySelectorAll(".form-box").forEach(f => f.classList.remove("active"));
        document.getElementById(formId).classList.add("active");
    }

    /* ===========================================================
       AUTOMATIC EMAIL RESTORE for VERIFY FORM
    =========================================================== */
    const savedKodeUser = localStorage.getItem("verify_kode_user");
    if (savedKodeUser) {
        const kodeField = document.getElementById("verifyKodeUser");
        if (kodeField) kodeField.value = savedKodeUser;
    }

    /* ===========================================================
       SWITCH LOGIN <-> REGISTER
    =========================================================== */
    document.getElementById("showRegister").addEventListener("click", () => {
        showForm("registerForm");
    });

    document.getElementById("showLogin").addEventListener("click", () => {
        showForm("loginForm");
    });


    /* ===========================================================
       LOGIN CUSTOMER / ADMIN / OWNER
    =========================================================== */
    const loginForm = document.getElementById("loginFormElement");

    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const form = new FormData(loginForm);

        const payload = {
            identifier: form.get("email"),
            password: form.get("password"),
            provider_type: "local"
        };

        Swal.fire({
            title: "Memproses...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const res = await fetch(`${BASE_API_URL}/admin/login.php`, {
            method: "POST",
            body: JSON.stringify(payload)
        });

        Swal.close();

        const json = await res.json();
        console.log(json);

        if (json.code !== 200) {
            return Swal.fire("Error", json.message, "error");
        }

        // SIMPAN SESSION VIA PHP
        await fetch("auth_session.php", {
            method: "POST",
            body: JSON.stringify(json.user)
        });

        // REDIRECT
        if (json.user.role === "customer") {
            window.location.href = "../../templates/index.php";
        } else {
            window.location.href = "../../templates/admin/index.php";
        }
    });


    /* ===========================================================
       REGISTER CUSTOMER
    =========================================================== */
    const registerForm = document.getElementById("registerFormElement");

    registerForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const form = new FormData(registerForm);

        if (form.get("password") !== form.get("confirm")) {
            return Swal.fire("Error", "Password tidak cocok!", "error");
        }

        const payload = {
            role: "customer",
            provider_type: "local",
            username: form.get("email").split("@")[0],
            full_name: form.get("nama"),
            email: form.get("email"),
            password: form.get("password"),
            no_telp: form.get("no_telp")
        };

        Swal.fire({
            title: "Mengirim kode verifikasi...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const res = await fetch(`${BASE_API_URL}/admin/register.php`, {
            method: "POST",
            body: JSON.stringify(payload)
        });

        Swal.close();

        const json = await res.json();
        console.log(json);

        if (json.code !== 200) {
            return Swal.fire("Error", json.message, "error");
        }

        localStorage.setItem("verify_kode_user", json.kode_user);
        document.getElementById("verifyKodeUser").value = json.kode_user;

        showForm("verifyForm");
    });


    /* ===========================================================
       VERIFIKASI OTP
    =========================================================== */
    const verifyForm = document.getElementById("verifyFormElement");

    verifyForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const form = new FormData(verifyForm);

        const payload = {
            kode_user: form.get("kode_user"),
            kode_verifikasi: form.get("kode_verifikasi")
        };


        Swal.fire({
            title: "Memverifikasi kode...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const res = await fetch(`${BASE_API_URL}/admin/verify_email.php`, {
            method: "POST",
            body: JSON.stringify(payload)
        });

        Swal.close();

        const json = await res.json();
        console.log(json);

        if (json.code !== 200) {
            return Swal.fire("Error", json.message, "error");
        }

        localStorage.removeItem("verify_kode_user");
        window.location.href = "../../templates/index.php";
    });

});
