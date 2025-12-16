<?php
// Bootstrap Laravel and create a test student user
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'siswa+test@example.test')->first();
if ($user) {
    echo "User already exists: {$user->id}\n";
    exit;
}

$user = User::create([
    'name' => 'Test Siswa',
    'email' => 'siswa+test@example.test',
    'password' => Hash::make('secret123'),
    'role' => 'student',
    'nisn' => '0001234567',
]);

echo "Created user id: {$user->id}\n";
