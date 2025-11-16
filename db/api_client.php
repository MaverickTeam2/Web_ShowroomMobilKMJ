<?php
require_once __DIR__ . '/config_api.php';

// ===========================
// 2. Fungsi GET request
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
// 3. Fungsi POST request
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
