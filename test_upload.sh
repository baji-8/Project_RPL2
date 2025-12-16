#!/bin/bash

# Create a simple test image using ImageMagick or base64
# Since we don't have GD library, create a simple image file

# Create a minimal PNG file (1x1 red pixel)
echo "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8DwHwAFBQIAX8jx0gAAAABJRU5ErkJggg==" | base64 -d > test_avatar.png

echo "Test image created: test_avatar.png"
ls -lh test_avatar.png

# Now test uploading via curl
curl -X POST http://localhost:8000/profile \
  -H "Accept: application/json" \
  -F "avatar=@test_avatar.png" \
  -F "name=Test User" \
  -F "email=test@example.com" \
  -F "phone=" \
  -F "address=" \
  -F "kelas=" \
  -F "nisn=" \
  -F "tanggal_lahir=" \
  -F "tentang_aku=" \
  -F "email_orang_tua=" \
  -F "nomor_telepon_orang_tua=" \
  -F "_token=$(curl -s http://localhost:8000/profile/edit | grep -oP 'name="csrf-token" content="\K[^"]*')"

# Clean up
rm test_avatar.png
