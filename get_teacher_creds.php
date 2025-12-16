<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$teachers = \App\Models\User::where('role', 'teacher')->get(['name', 'username', 'email']);

echo "=== Teacher Credentials ===\n";
foreach ($teachers as $teacher) {
    echo "Name: {$teacher->name}\n";
    echo "Username: {$teacher->username}\n";
    echo "Email: {$teacher->email}\n";
    echo "Password: password\n\n";
}
