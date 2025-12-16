<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

try {
    require __DIR__ . '/vendor/autoload.php';
    $app = require __DIR__ . '/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    echo "✓ App bootstrapped successfully\n";
    echo "✓ Database connection: " . config('database.default') . "\n";
    
    // Try to access users
    $users = \App\Models\User::count();
    echo "✓ Users in database: $users\n";
    
    echo "\n✓ All checks passed!\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString();
}
