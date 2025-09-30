//import navbar dari file navbar.html dan masukkan ke dalam body
fetch("navbar.html")
  .then((response) => response.text())
  .then((data) => {
    document.body.insertAdjacentHTML("afterbegin", data);

    // burger
    const burger = document.querySelector(".navbar-burger");
    const menu = document.querySelector("#navbarMenu");
    if (burger && menu) {
      burger.addEventListener("click", () => {
        burger.classList.toggle("is-active");
        menu.classList.toggle("is-active");
      });
    }

    // More Dropdown (cek dulu exist)
    const more = document.getElementById("moreDropdown");
    if (more) {
      const moreLink = more.querySelector(".navbar-link");
      if (moreLink) {
        moreLink.addEventListener("click", (e) => {
          e.preventDefault();
          more.classList.toggle("is-active");
        });
      }
    }

    // Account Dropdown (cek dulu exist)
    const account = document.getElementById("accountDropdown");
    if (account) {
      const accLink = account.querySelector(".navbar-link");
      if (accLink) {
        accLink.addEventListener("click", (e) => {
          e.preventDefault();
          account.classList.toggle("is-active");
        });
      }
    }
  })
  .catch((err) => console.error("Error loading navbar:", err));
