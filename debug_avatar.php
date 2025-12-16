<?php

// Test to identify avatar upload issues

echo "=== Avatar Upload Debug Test ===\n\n";

// 1. Check storage paths
echo "1. Storage Path Configuration:\n";
$storagePath = dirname(__DIR__) . '/storage/app/public';
$avatarPath = $storagePath . '/avatars';
echo "   Storage path: " . $storagePath . "\n";
echo "   Exists: " . (is_dir($storagePath) ? "YES" : "NO") . "\n";
echo "   Writable: " . (is_writable($storagePath) ? "YES" : "NO") . "\n\n";

echo "2. Avatars Directory:\n";
echo "   Path: " . $avatarPath . "\n";
echo "   Exists: " . (is_dir($avatarPath) ? "YES" : "NO") . "\n";
if (is_dir($avatarPath)) {
    echo "   Writable: " . (is_writable($avatarPath) ? "YES" : "NO") . "\n";
} else {
    echo "   Creating directory...\n";
    if (mkdir($avatarPath, 0755, true)) {
        echo "   Created successfully\n";
    } else {
        echo "   Failed to create\n";
    }
}
echo "\n";

// 2. Check public/storage symlink
echo "3. Public Storage Symlink:\n";
$publicStoragePath = dirname(__DIR__) . '/public/storage';
echo "   Path: " . $publicStoragePath . "\n";
if (is_dir($publicStoragePath)) {
    echo "   Exists: YES\n";
    echo "   Is Link: " . (is_link($publicStoragePath) ? "YES" : "NO") . "\n";
} else {
    echo "   Exists: NO - trying to create symlink\n";
    if (@symlink($storagePath, $publicStoragePath)) {
        echo "   Symlink created\n";
    } else {
        echo "   Symlink creation failed - trying mklink via system\n";
    }
}
echo "\n";

// 3. Test file operations
echo "4. File Operations Test:\n";
$testFile = $avatarPath . '/test_' . time() . '.txt';
if (file_put_contents($testFile, 'test content')) {
    echo "   Write test: SUCCESS\n";
    if (file_exists($testFile)) {
        echo "   Read test: SUCCESS\n";
        unlink($testFile);
        echo "   Delete test: SUCCESS\n";
    }
} else {
    echo "   Write test: FAILED\n";
}
echo "\n";

// 4. Check file permissions
echo "5. Directory Permissions:\n";
if (is_dir($avatarPath)) {
    $perms = fileperms($avatarPath);
    echo "   Permissions (octal): " . substr(sprintf('%o', $perms), -4) . "\n";
    echo "   Owner read: " . (($perms & 0x0100) ? "YES" : "NO") . "\n";
    echo "   Owner write: " . (($perms & 0x0080) ? "YES" : "NO") . "\n";
    echo "   Owner execute: " . (($perms & 0x0040) ? "YES" : "NO") . "\n";
}

?>
