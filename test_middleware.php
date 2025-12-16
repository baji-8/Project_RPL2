<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

// Check middleware alias registration
echo "=== Checking Middleware Alias Registration ===\n\n";

// Get the bootstrap middleware callback
$bootstrap = \Illuminate\Foundation\Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (\Illuminate\Foundation\Configuration\Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureRole::class,
        ]);
    });

echo "Middleware class exists: " . (class_exists(\App\Http\Middleware\EnsureRole::class) ? "YES" : "NO") . "\n";
echo "Middleware class path: " . \App\Http\Middleware\EnsureRole::class . "\n\n";

// Test instantiation
try {
    $middleware = new \App\Http\Middleware\EnsureRole();
    echo "Middleware instance created successfully\n";
    echo "Middleware handle method exists: " . (method_exists($middleware, 'handle') ? "YES" : "NO") . "\n";
} catch (\Exception $e) {
    echo "Error creating middleware instance: " . $e->getMessage() . "\n";
}

