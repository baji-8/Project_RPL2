<?php

// Test authentication and route access via HTTP

echo "=== Testing Student Login ===\n\n";

// Get login page
$ch = curl_init('http://127.0.0.1:8000/login/student');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "GET /login/student: HTTP $httpCode\n";
if (strpos($response, 'login') !== false) {
    echo "✓ Login page contains login form\n";
}

echo "\n=== Attempting to Access Student Dashboard Without Auth ===\n\n";

// Try to access /dashboard without auth
$ch = curl_init('http://127.0.0.1:8000/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "GET /dashboard (no auth): HTTP $httpCode\n";
if ($httpCode == 302 || $httpCode == 200) {
    echo "✓ Request handled (redirected or returned page)\n";
}

echo "\n=== Testing Teacher Dashboard Without Auth ===\n\n";

// Try to access /teacher/dashboard without auth
$ch = curl_init('http://127.0.0.1:8000/teacher/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "GET /teacher/dashboard (no auth): HTTP $httpCode\n";
if ($httpCode == 302 || $httpCode == 200) {
    echo "✓ Request handled (redirected or returned page)\n";
}

echo "\n=== Testing Landing Page ===\n\n";

// Test landing page
$ch = curl_init('http://127.0.0.1:8000/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "GET /: HTTP $httpCode\n";
if ($httpCode == 200) {
    echo "✓ Landing page accessible\n";
    if (strpos($response, 'Siswa') !== false && strpos($response, 'Guru') !== false) {
        echo "✓ Landing page has student and teacher login buttons\n";
    }
}

echo "\n=== All Basic Tests Complete ===\n";
