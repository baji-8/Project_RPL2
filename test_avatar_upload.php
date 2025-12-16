<?php

// Test avatar upload functionality
$uploadDir = 'storage/app/public/avatars';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
    echo "✓ Created avatars directory\n";
} else {
    echo "✓ Avatars directory exists\n";
}

// Check permissions
if (is_writable($uploadDir)) {
    echo "✓ Directory is writable\n";
} else {
    echo "✗ Directory is NOT writable\n";
}

// Test creating a file
$testFile = $uploadDir . '/test.txt';
if (file_put_contents($testFile, 'test')) {
    echo "✓ Can write files to avatars directory\n";
    unlink($testFile);
} else {
    echo "✗ Cannot write files to avatars directory\n";
}

// Check if public/storage link works
if (is_link('public/storage')) {
    echo "✓ public/storage symlink exists\n";
    $target = readlink('public/storage');
    echo "  Target: $target\n";
} else {
    echo "✗ public/storage symlink does NOT exist\n";
}

// List existing avatars
$avatarFiles = glob($uploadDir . '/*');
echo "\nExisting avatars: " . count($avatarFiles) . "\n";

?>
