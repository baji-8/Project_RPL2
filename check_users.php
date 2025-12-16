<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$users = \App\Models\User::select('id', 'name', 'role')->get();
echo "=== ALL USERS ===\n";
foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Role: {$user->role}\n";
}
