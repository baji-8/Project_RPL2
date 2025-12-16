<?php

echo "=== Testing Student Login Flow ===\n\n";

// Step 1: Get login page
$ch = curl_init('http://127.0.0.1:8000/login/student');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'test_cookies.txt');
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Step 1: GET /login/student\n";
echo "  Status: HTTP $httpCode\n";
if ($httpCode == 200) {
    if (strpos($response, 'csrf') !== false || strpos($response, 'token') !== false) {
        echo "  ✓ Login form contains CSRF token\n";
    }
}

// Extract CSRF token from form
preg_match('/<input[^>]+name="?_token"?[^>]+value="([^"]+)"/', $response, $matches);
$csrf_token = $matches[1] ?? null;

if ($csrf_token) {
    echo "  ✓ CSRF token extracted: " . substr($csrf_token, 0, 20) . "...\n";
}

// Step 2: Login with student credentials
echo "\nStep 2: POST /login/student\n";

$post_data = [
    '_token' => $csrf_token,
    'nisn' => '0012345678',
    'password' => 'password',
    'remember' => 'on'
];

$ch = curl_init('http://127.0.0.1:8000/login/student');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_COOKIEFILE, 'test_cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'test_cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$headers = curl_getinfo($ch);
curl_close($ch);

echo "  Status: HTTP $httpCode\n";
if ($httpCode == 302) {
    echo "  ✓ Redirect received (expected)\n";
    $location = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
}

// Step 3: Access the dashboard
echo "\nStep 3: GET /dashboard (authenticated)\n";

$ch = curl_init('http://127.0.0.1:8000/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'test_cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "  Status: HTTP $httpCode\n";
if ($httpCode == 200) {
    echo "  ✓ Dashboard page loaded\n";
    if (strpos($response, 'dashboard') !== false || strpos($response, 'Dashboard') !== false || strpos($response, 'Oleh') !== false) {
        echo "  ✓ Dashboard content found\n";
    }
} else {
    echo "  ✗ Failed to load dashboard\n";
}

// Step 4: Try accessing teacher-only route
echo "\nStep 4: GET /teacher/dashboard (student access - should fail)\n";

$ch = curl_init('http://127.0.0.1:8000/teacher/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'test_cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "  Status: HTTP $httpCode\n";
if ($httpCode == 403) {
    echo "  ✓ Access denied (expected)\n";
    if (strpos($response, 'Access denied') !== false || strpos($response, 'Forbidden') !== false) {
        echo "  ✓ Error message shown\n";
    }
}

echo "\n=== Test Complete ===\n";
