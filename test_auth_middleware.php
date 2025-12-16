<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create a mock request to test the middleware
$request = Illuminate\Http\Request::create('/dashboard', 'GET');

// Simulate authentication
Illuminate\Support\Facades\Auth::loginUsingId(1, true); // Login as student with ID 1

// Get the user
$user = Illuminate\Support\Facades\Auth::user();

echo "=== Test Authentication ===\n";
echo "Authenticated: " . ($user ? "YES" : "NO") . "\n";
if ($user) {
    echo "User ID: {$user->id}\n";
    echo "User Name: {$user->name}\n";
    echo "User Role: {$user->role}\n";
}

// Test middleware directly
echo "\n=== Test Middleware Directly ===\n";

$middleware = new \App\Http\Middleware\EnsureRole();

try {
    // Simulate proper request context
    $request = \Illuminate\Http\Request::create('/dashboard', 'GET');
    $request->setUserResolver(function () {
        return Illuminate\Support\Facades\Auth::user();
    });
    
    $result = $middleware->handle($request, function ($req) {
        return "PASSED";
    }, 'student');
    
    echo "Middleware result for student role: $result\n";
} catch (\Exception $e) {
    echo "Middleware error: " . $e->getMessage() . "\n";
}

// Test with teacher role (should fail)
echo "\n=== Test Middleware with Wrong Role ===\n";
try {
    $request = \Illuminate\Http\Request::create('/teacher/dashboard', 'GET');
    $request->setUserResolver(function () {
        return Illuminate\Support\Facades\Auth::user();
    });
    
    $result = $middleware->handle($request, function ($req) {
        return "PASSED";
    }, 'teacher');
    
    echo "Middleware result for teacher role: $result\n";
} catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
    echo "Expected: Got 403 error - " . $e->getMessage() . "\n";
}
