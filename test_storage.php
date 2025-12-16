<?php

require 'bootstrap/app.php';

use App\Models\User;
use Illuminate\Http\UploadedFile;

// Get first user
$user = User::first();
echo "User: {$user->name}\n";
echo "Current Avatar: " . ($user->avatar ?? 'None') . "\n";
echo "\n";

// Test the file storage path
echo "Testing file storage:\n";
echo "Storage Path: " . storage_path('app/public') . "\n";
echo "Directory exists: " . (is_dir(storage_path('app/public')) ? 'Yes' : 'No') . "\n";
echo "Writable: " . (is_writable(storage_path('app/public')) ? 'Yes' : 'No') . "\n";

// Check avatars subdirectory
$avatarPath = storage_path('app/public/avatars');
echo "\nAvatars directory: " . $avatarPath . "\n";
echo "Directory exists: " . (is_dir($avatarPath) ? 'Yes' : 'No') . "\n";
echo "Writable: " . (is_writable($avatarPath) ? 'Yes' : 'No') . "\n";

// Check if public/storage is accessible
echo "\nPublic storage access:\n";
echo "Public path: " . public_path('storage') . "\n";
echo "Exists: " . (is_dir(public_path('storage')) ? 'Yes' : 'No') . "\n";

?>
