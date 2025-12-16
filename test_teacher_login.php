<?php

echo "=== Testing Teacher Login and Dashboard Access ===\n\n";

// Step 1: Get teacher login page
echo "Step 1: GET /login/teacher\n";
$ch = curl_init('http://127.0.0.1:8000/login/teacher');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'teacher_cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "  Status: HTTP $httpCode\n";
if ($httpCode == 200) {
    echo "  ✓ Teacher login page loaded\n";
    
    // Extract CSRF token
    preg_match('/<input[^>]+name="?_token"?[^>]+value="([^"]+)"/', $response, $matches);
    $csrf_token = $matches[1] ?? null;
    
    if ($csrf_token) {
        echo "  ✓ CSRF token found\n";
    } else {
        echo "  ✗ CSRF token not found\n";
    }
}

// Step 2: Login as teacher
echo "\nStep 2: POST /login/teacher\n";

if (isset($csrf_token)) {
    $post_data = [
        '_token' => $csrf_token,
        'username' => 'kenneth',
        'password' => 'password',
        'remember' => 'on'
    ];

    $ch = curl_init('http://127.0.0.1:8000/login/teacher');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'teacher_cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'teacher_cookies.txt');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "  Status: HTTP $httpCode\n";
    if ($httpCode == 302) {
        echo "  ✓ Login successful (redirected)\n";
    } else if ($httpCode == 200) {
        if (strpos($response, 'tidak sesuai') !== false) {
            echo "  ✗ Login failed - credentials not accepted\n";
        } else {
            echo "  Status: Page rendered\n";
        }
    }
}

// Step 3: Access teacher dashboard
echo "\nStep 3: GET /teacher/dashboard (authenticated)\n";

$ch = curl_init('http://127.0.0.1:8000/teacher/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'teacher_cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "  Status: HTTP $httpCode\n";
if ($httpCode == 200) {
    echo "  ✓ Teacher dashboard loaded\n";
    
    // Check for dashboard content
    if (strpos($response, 'Dashboard') !== false || strpos($response, 'Guru') !== false || strpos($response, 'Materi') !== false) {
        echo "  ✓ Dashboard content found\n";
    }
} else {
    echo "  ✗ Failed to load dashboard\n";
}

// Step 4: Try accessing teacher dashboard without login
echo "\nStep 4: GET /teacher/dashboard (without auth - should redirect)\n";

$ch = curl_init('http://127.0.0.1:8000/teacher/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'temp_cookies.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "  Status: HTTP $httpCode\n";
if ($httpCode == 302) {
    echo "  ✓ Redirected to login (expected)\n";
} else if ($httpCode == 0) {
    echo "  Server may be down\n";
}

echo "\n=== Test Complete ===\n";

// Cleanup
@unlink('teacher_cookies.txt');
@unlink('temp_cookies.txt');
