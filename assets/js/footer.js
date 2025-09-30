fetch("../templates/navbar_footer/footer.html")
    .then((response) => response.text())
    .then((data) => {
        document.body.insertAdjacentHTML("beforeend", data);
    })
    .catch((err) => console.error("Error loading footer:", err));
// assets/js/footer.js