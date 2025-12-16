<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get the router
$router = app('router');

echo "=== Registered Routes ===\n\n";

// Filter student routes
echo "--- Student Routes (protected by auth + role:student) ---\n";
foreach ($router->getRoutes() as $route) {
    if (in_array('role:student', $route->middleware())) {
        echo $route->getMethod() . ' ' . $route->getPath() . "\n";
    }
}

echo "\n--- Teacher Routes (protected by auth + role:teacher) ---\n";
foreach ($router->getRoutes() as $route) {
    if (in_array('role:teacher', $route->middleware())) {
        echo $route->getMethod() . ' ' . $route->getPath() . "\n";
    }
}

echo "\n--- Parent Routes (protected by role:parent) ---\n";
foreach ($router->getRoutes() as $route) {
    if (in_array('role:parent', $route->middleware())) {
        echo $route->getMethod() . ' ' . $route->getPath() . "\n";
    }
}

echo "\n=== Middleware Aliases ===\n";
$middleware = app(\Illuminate\Foundation\Http\Middleware\Kernel::class);
echo "Registered middleware aliases:\n";
if (method_exists($middleware, 'getRouteMiddleware')) {
    foreach ($middleware->getRouteMiddleware() as $key => $class) {
        echo "  $key => $class\n";
    }
} else {
    echo "  (Cannot access route middleware aliases)\n";
}
