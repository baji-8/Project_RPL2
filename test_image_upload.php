<?php

// Test avatar upload with manual test
$testImagePath = __DIR__ . '/test_image.png';

// Create a simple test PNG image
$image = imagecreatetruecolor(100, 100);
$color = imagecolorallocate($image, 255, 0, 0);
imagefill($image, 0, 0, $color);
imagepng($image, $testImagePath);
imagedestroy($image);

echo "Test image created: " . (file_exists($testImagePath) ? 'YES' : 'NO') . "\n";
echo "File size: " . filesize($testImagePath) . " bytes\n";
echo "File path: " . $testImagePath . "\n";

// Now test copy to avatars directory
$destPath = 'storage/app/public/avatars/test_avatar.png';
if (copy($testImagePath, $destPath)) {
    echo "✓ Successfully copied test image to avatars directory\n";
    echo "  Destination: " . $destPath . "\n";
    echo "  Accessible at: /storage/avatars/test_avatar.png\n";
    
    // Clean up
    unlink($destPath);
} else {
    echo "✗ Failed to copy test image\n";
}

// Clean up test image
unlink($testImagePath);

?>
