document.getElementById("addAdminForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const data = {
        first_name: document.getElementById("first_name").value,
        last_name: document.getElementById("last_name").value,
        username: document.getElementById("username").value,
        no_telf: document.getElementById("no_telf").value,
        email: document.getElementById("email").value,
        alamat: document.getElementById("alamat").value,
        password: document.getElementById("password").value
    };

    const response = await fetch("../../api/admin/add_admin.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    });

    const res = await response.json();

    if (res.status === "success") {
        alert("Akun admin berhasil dibuat!");
        window.location.href = "../../templates/index.php";
    } else {
        alert("Error: " + res.message);
    }
});
