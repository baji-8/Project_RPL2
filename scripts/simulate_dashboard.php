<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Http\Request as HttpRequest;

// Create a request first and bind it into the container so auth/session drivers can access it
$request = HttpRequest::create('/dashboard', 'GET');
$app->instance('request', $request);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;

// Log in as the test student (id 2)
Auth::loginUsingId(2);

// Ensure the request's user resolver uses the authenticated user
$request->setUserResolver(function () { return Auth::user(); });

$response = $kernel->handle($request);

$status = $response->getStatusCode();
$body = $response->getContent();

echo "Status: $status\n";
if (stripos($body, 'Selamat Datang') !== false) {
    echo "Dashboard contains welcome text.\n";
} else {
    echo "Dashboard does NOT contain welcome text. Body length: " . strlen($body) . "\n";
}

$kernel->terminate($request, $response);
