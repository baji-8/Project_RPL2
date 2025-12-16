# Quick Setup Guide

## Langkah Cepat Setup

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Database
1. Buat database MySQL dengan nama `elearning` (atau sesuai keinginan)
2. Copy `.env.example` menjadi `.env`
3. Edit `.env` dan sesuaikan:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=elearning
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 3. Generate Key & Setup
```bash
php artisan key:generate
php artisan storage:link
php artisan migrate
```

### 4. Build Assets
```bash
npm run build
```

### 5. Run Server
```bash
php artisan serve
```

Akses: http://localhost:8000

## Membuat User Pertama

1. Buka http://localhost:8000/register
2. Daftar dengan email dan password
3. Login di http://localhost:8000/login

## Struktur Halaman

- `/` - Landing Page
- `/dashboard` - Dashboard Murid (setelah login)
- `/materi` - Daftar Materi
- `/quiz` - Daftar Quiz
- `/quiz/active` - Quiz Aktif
- `/aktivitas` - Aktivitas Pembelajaran
- `/ai` - AI Assistant
- `/profile/edit` - Edit Profile

## Catatan Penting

1. Pastikan MySQL sudah berjalan
2. Pastikan folder `storage/app/public` ada dan bisa diakses
3. Untuk development, jalankan `npm run dev` di terminal terpisah untuk hot reload

