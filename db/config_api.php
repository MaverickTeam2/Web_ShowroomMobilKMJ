<?php
// =============================================
// KONFIGURASI BASE URL API (1 sumber kebenaran)
// =============================================

// Jika localhost (sedang development)
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
    strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
    
    // Ganti dengan alamat API lokal kamu
    define('BASE_API_URL', 'http://192.168.1.51:8888/api_kmj');
    define("IMAGE_URL", BASE_API_URL);

} else {
    // PRODUKSI (Hosting)
    define('BASE_API_URL', 'https://api.maverick.my.id');
}
