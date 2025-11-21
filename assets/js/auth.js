// Toggle password
document.querySelectorAll(".toggle-password").forEach((icon) => {
    icon.addEventListener("click", () => {
        const input = document.getElementById(icon.dataset.target);
        const type = input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);
        icon.innerHTML = type === "password"
            ? '<i class="bx bx-show"></i>'
            : '<i class="bx bx-hide"></i>';
    });
});

// Animasi pindah login atau register
const authContainer = document.getElementById("authContainer");
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const showRegister = document.getElementById("showRegister");
const showLogin = document.getElementById("showLogin");

// Ganti form dan animasi gambar
showRegister.addEventListener("click", () => {
    authContainer.classList.add("active");
    loginForm.classList.add("hidden");
    loginForm.classList.remove("active");
    registerForm.classList.remove("hidden");
    registerForm.classList.add("active");
});

showLogin.addEventListener("click", () => {
    authContainer.classList.remove("active");
    registerForm.classList.add("hidden");
    registerForm.classList.remove("active");
    loginForm.classList.remove("hidden");
    loginForm.classList.add("active");
});

// Toggle password visibility
document.querySelectorAll(".toggle-password").forEach((icon) => {
    icon.addEventListener("click", () => {
        const input = document.getElementById(icon.dataset.target);
        const type =
            input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);
        icon.innerHTML =
            type === "password"
                ? '<i class="bx bx-show"></i>'
                : '<i class="bx bx-hide"></i>';
    });
});
function showPopup(type, title, message) {
    const modal = document.getElementById('popupModal');
    const popupTitle = document.getElementById('popupTitle');
    const popupMessage = document.getElementById('popupMessage');
    const popupIcon = document.getElementById('popupIcon');

    popupTitle.textContent = title;
    popupMessage.textContent = message;

    if (type === 'success') {
        popupIcon.innerHTML = '<i class="fa-solid fa-circle-check has-text-success fa-2x"></i>';
    } else if (type === 'error') {
        popupIcon.innerHTML = '<i class="fa-solid fa-circle-xmark has-text-danger fa-2x"></i>';
    }

    modal.classList.add('is-active');
}

function closePopup() {
    document.getElementById('popupModal').classList.remove('is-active');
}

document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  if (params.get("form") === "register") {
    authContainer.classList.add("active");
    loginForm.classList.add("hidden");
    loginForm.classList.remove("active");
    registerForm.classList.remove("hidden");
    registerForm.classList.add("active");
  }
});

// login JSON
document.getElementById("loginFormElement").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    const req = await fetch("login.php", {
        method: "POST",
        body: formData
    });

    const res = await req.json();

    if (res.status === "error") {
        alert(res.message); 
        return;
    }

    //
    window.location.href = res.redirect;
});
