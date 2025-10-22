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