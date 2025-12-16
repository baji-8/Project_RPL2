<?php

require __DIR__ . '/vendor/autoload.php';

try {
    $app = require __DIR__ . '/bootstrap/app.php';
    echo "✓ Bootstrap loaded\n";
    
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    echo "✓ HTTP Kernel resolved\n";
    
    // Try a simple request
    $request = \Illuminate\Http\Request::create('/dashboard', 'GET');
    echo "✓ Request created\n";
    
    // Don't actually handle the request, just verify the setup
    echo "✓ All components initialized successfully\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}
