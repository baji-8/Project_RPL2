<?php
require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://127.0.0.1:8000', 'cookies' => true, 'http_errors' => false]);

// GET login page
$res = $client->get('/login');
$body = (string) $res->getBody();
if (!preg_match('/name="_token" value="([^"]+)"/', $body, $m)) {
    echo "CSRF token not found\n";
    exit(1);
}
$token = $m[1];
echo "Token: $token\n";

// POST login
$res = $client->post('/login', [
    'form_params' => [
        '_token' => $token,
        'nisn' => '0001234567',
        'password' => 'secret123'
    ]
]);

echo "Login response status: " . $res->getStatusCode() . "\n";

// GET dashboard
$res = $client->get('/dashboard');
$body = (string) $res->getBody();
$status = $res->getStatusCode();

echo "Dashboard status: $status\n";
if (stripos($body, 'Selamat Datang') !== false) {
    echo "Dashboard contains welcome text.\n";
} else {
    echo "Dashboard does not contain welcome text. (body length: " . strlen($body) . ")\n";
}

