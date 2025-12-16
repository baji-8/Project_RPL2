<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$students = \App\Models\User::where('role', 'student')->get(['name', 'nisn']);

echo "=== Student Credentials ===\n";
foreach ($students as $student) {
    echo "Name: {$student->name}\n";
    echo "NISN: {$student->nisn}\n";
    echo "Password: (default seeded)\n\n";
}

echo "Note: Students are seeded with password: 'password'\n";
