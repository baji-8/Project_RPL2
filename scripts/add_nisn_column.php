<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::statement("ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `nisn` VARCHAR(20) NULL;");
    echo "Ensured column `nisn` exists on users table.\n";
} catch (\Exception $e) {
    echo "Failed: " . $e->getMessage() . "\n";
}
