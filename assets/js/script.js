// File: showroom_kmj/js/script.js
fetch('http://API_kmj.test/get-data.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        // Proses data disini
    })
    .catch(error => console.error('Error:', error));