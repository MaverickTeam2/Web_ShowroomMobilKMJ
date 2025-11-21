<?php
// api_client.php
// File ini berfungsi sebagai "client" untuk memanggil API
// Bisa digunakan di file PHP lain dengan include atau require

// ===========================
// 1. Konfigurasi Base URL API
// ===========================
define('BASE_API_URL', 'http://localhost:80/API_kmj');


// ===========================
// 2. Fungsi untuk GET request
// ===========================
function api_get($endpoint)
{
    $url = BASE_API_URL . '/' . ltrim($endpoint, '/');

    $response = @file_get_contents($url);
    if ($response === false) {
        return [
            'status' => false,
            'message' => 'Gagal mengakses API: ' . $url
        ];
    }

    $data = json_decode($response, true);
    if ($data === null) {
        return [
            'status' => false,
            'message' => 'JSON API tidak valid'
        ];
    }

    return $data;
}

// ===========================
// 3. Fungsi untuk POST request
// ===========================
function api_post($endpoint, $postData = [])
{
    $url = BASE_API_URL . '/' . ltrim($endpoint, '/');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

    $response = curl_exec($ch);
    if ($response === false) {
        curl_close($ch);
        return [
            'status' => false,
            'message' => 'Gagal mengakses API via cURL'
        ];
    }
    curl_close($ch);

    $data = json_decode($response, true);
    if ($data === null) {
        return [
            'status' => false,
            'message' => 'JSON API tidak valid'
        ];
    }

    return $data;
}