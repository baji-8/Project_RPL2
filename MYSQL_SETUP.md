# Setup MySQL Database

## Konfigurasi Database

Aplikasi sudah dikonfigurasi untuk menggunakan MySQL. File `.env` sudah diset dengan konfigurasi berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elearning
DB_USERNAME=root
DB_PASSWORD=
```

## Langkah Setup

### 1. Pastikan MySQL Berjalan

Pastikan MySQL service sudah berjalan di komputer Anda.

**Windows (XAMPP/WAMP):**
- Buka XAMPP Control Panel
- Start MySQL service

**Linux/Mac:**
```bash
sudo systemctl start mysql
# atau
sudo service mysql start
```

### 2. Buat Database

Buka MySQL (phpMyAdmin atau MySQL Command Line) dan buat database:

**Via phpMyAdmin:**
1. Buka http://localhost/phpmyadmin
2. Klik "New" untuk membuat database baru
3. Nama database: `elearning`
4. Collation: `utf8mb4_unicode_ci`
5. Klik "Create"

**Via MySQL Command Line:**
```sql
CREATE DATABASE elearning CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Sesuaikan Konfigurasi (Jika Perlu)

Jika username/password MySQL Anda berbeda, edit file `.env`:

```env
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Jalankan Migrations

Setelah database dibuat, jalankan migrations:

```bash
php artisan migrate
```

Ini akan membuat semua tabel yang diperlukan:
- users
- materi
- aktivitas_pembelajaran
- quiz
- quiz_questions
- quiz_attempts
- quiz_answers
- cache
- jobs

### 5. Verifikasi Koneksi

Untuk memastikan koneksi database berhasil, jalankan:

```bash
php artisan migrate:status
```

Jika ada error, periksa:
1. MySQL service sudah berjalan
2. Database sudah dibuat
3. Username dan password di `.env` sudah benar
4. Port MySQL (default: 3306) sudah benar

## Troubleshooting

### Error: Access denied for user
- Pastikan username dan password di `.env` sudah benar
- Pastikan user MySQL memiliki permission untuk membuat database dan tabel

### Error: Unknown database 'elearning'
- Pastikan database sudah dibuat terlebih dahulu
- Periksa nama database di `.env` sudah benar

### Error: Connection refused
- Pastikan MySQL service sudah berjalan
- Periksa port MySQL (default: 3306)
- Periksa host di `.env` (default: 127.0.0.1)

## Catatan

- Database name default: `elearning`
- Jika ingin menggunakan nama database lain, ubah `DB_DATABASE` di file `.env`
- Pastikan charset database menggunakan `utf8mb4` untuk support emoji dan karakter khusus

