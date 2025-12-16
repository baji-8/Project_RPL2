# SDN Susukan 08 Pagi - Learning Management System

Platform pembelajaran online terpadu dengan fitur dashboard guru, manajemen materi, quiz, tracking perkembangan siswa, dan asisten AI.

## 🎯 Status Project

**✅ COMPLETE & READY FOR USE**

Semua fitur telah diimplementasikan, diuji, dan didokumentasikan dengan lengkap.

## ✨ Fitur Lengkap

### Dashboard Guru ✅
- Dashboard dengan statistik (jumlah siswa, materi, kuis)
- Manajemen Materi (CRUD - Create, Read, Update, Delete)
- Manajemen Quiz (CRUD)
- Tracking nilai siswa dengan pencarian dan sortir
- Tampilan top performer
- Riwayat quiz attempt terakhir

### Dashboard Siswa ✅
- Daftar materi pembelajaran
- Daftar quiz yang tersedia
- Pengingat harian dan checklist
- Akses AI learning assistant
- Profil dan pengaturan

### Dashboard Orang Tua ✅
- Monitoring perkembangan anak
- Hasil quiz
- Aktivitas pembelajaran

### Sistem Autentikasi Multi-Role ✅
- Login terpisah untuk guru, siswa, dan orang tua
- Role-based access control
- Session management
- CSRF protection
- Password hashing dengan bcrypt

### Fitur Logout Enhanced ✅
- User dropdown menu pada semua dashboard
- Role-aware redirects (guru → login guru, siswa → login siswa)
- Session invalidation + CSRF token regeneration
- Success flash messages
- Edit profil quick link

### Fitur Tambahan ✅
- Landing Page
- Responsive Design (Mobile, Tablet, Desktop)
- Database Seeding dengan data test
- Validasi form
- Error handling
- Optimized performance

## 🛠️ Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL 8.0+
- **Frontend**: TailwindCSS 3.x
- **Template Engine**: Blade
- **Build Tool**: Vite
- **Language**: PHP 8.2+
- **Node.js**: 18+## 🚀 Instalasi & Setup

### 1. Clone Repository

```bash
git clone <repository-url>
cd PPPL2
```

### 2. Install Dependencies

```bash
# PHP dependencies
composer install

# Frontend dependencies
npm install
```

### 3. Setup Environment

Salin file `.env.example` ke `.env`:

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME="SDN Susukan 08 Pagi"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pppl2
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations & Seeders

```bash
# Create database dan jalankan migrations
php artisan migrate:fresh --seed
```

Ini akan:
- ✅ Membuat semua tabel database
- ✅ Menjalankan seeders dengan data test
- ✅ Membuat user guru dan siswa untuk testing

### 6. Start Development Server

Terminal 1 - PHP Server:
```bash
php artisan serve
```

Terminal 2 - Frontend Build Watcher:
```bash
npm run dev
```

### 7. Akses Aplikasi

Buka browser dan akses:
```
Landing Page:     http://localhost:8000
Teacher Login:    http://localhost:8000/login/teacher
Student Login:    http://localhost:8000/login/student
```

---

## 📝 Test Credentials

Setelah seeding, gunakan kredensial berikut untuk test:

### Guru (Teacher)
```
Email:    guru@example.com
Password: password123
```

### Siswa (Student)
```
Email:    budi@example.com / siti@example.com / rina@example.com
Password: password
```

---

## 📚 Dokumentasi

Dokumentasi lengkap tersedia dalam file-file berikut:

1. **PROJECT_COMPLETION_SUMMARY.md**
   - Ringkasan lengkap project
   - Semua fitur yang diimplementasikan
   - Testing results
   - Deployment checklist

2. **COMPLETE_SYSTEM_DOCUMENTATION.md**
   - Dokumentasi teknis lengkap
   - Database schema
   - Routes reference
   - Authentication flow
   - Troubleshooting guide

3. **LOGOUT_FEATURE_UPDATE.md**
   - Detail fitur logout enhanced
   - Testing scenarios
   - Security checklist
   - UI/UX improvements

4. **LOGOUT_QUICK_REFERENCE.md**
   - Quick reference untuk logout
   - Feature comparison
   - Quick test guide
   - Troubleshooting

5. **TESTING_GUIDE.md**
   - Comprehensive testing scenarios
   - Step-by-step test procedures
   - Expected results
   - Debugging checklist

---

## 🗂️ Struktur Project

```
PPPL2/
├── app/
│   ├── Http/Controllers/       # Controllers
│   │   ├── Auth/AuthController.php
│   │   └── TeacherController.php
│   ├── Models/                 # Eloquent Models
│   └── Providers/
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php (Student)
│   │   ├── teacher/dashboard.blade.php (Teacher)
│   │   ├── parent/dashboard.blade.php (Parent)
│   │   ├── auth/               # Login/Register pages
│   │   └── landing.blade.php
│   ├── css/
│   └── js/
├── routes/
│   └── web.php                 # Route definitions
├── public/
│   └── img/logo.svg
└── config/                     # Configuration files
```

---

## 🧪 Testing

### Login & Logout Testing

1. **Teacher Login:**
   ```
   Kunjungi: http://localhost:8000/login/teacher
   Email: guru@example.com
   Password: password123
   ```

2. **Logout:**
   - Klik icon profil (kanan atas)
   - Pilih "Logout" (tombol merah)
   - Akan diarahkan ke halaman login guru
   - Success message muncul

3. **Student Login:**
   ```
   Kunjungi: http://localhost:8000/login/student
   Email: budi@example.com
   Password: password
   ```

### Dashboard Testing

1. **Teacher Dashboard Features:**
   - ✅ Lihat statistik (3 siswa, 3 materi, 2 kuis)
   - ✅ Buat/Edit/Hapus materi
   - ✅ Buat/Edit/Hapus kuis
   - ✅ Lihat nilai siswa
   - ✅ Cari dan sortir siswa

2. **Student Dashboard Features:**
   - ✅ Lihat materi yang tersedia
   - ✅ Lihat kuis yang tersedia
   - ✅ Akses pengingat harian
   - ✅ Edit profil

### Database Testing

Untuk verifikasi database:

```bash
# Login ke MySQL
mysql -u root

# Gunakan database
USE pppl2;

# Check users
SELECT id, name, email, role FROM users;

# Check materials
SELECT id, title, user_id FROM materis;

# Check quizzes
SELECT id, title, passing_score FROM quizzes;

# Check quiz attempts
SELECT id, skor FROM quiz_attempts;
```

---

## 🔐 Security Features

- ✅ CSRF Token Protection
- ✅ Password Hashing (bcrypt)
- ✅ Session Management
- ✅ Role-Based Access Control (RBAC)
- ✅ Input Validation
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ XSS Protection (Blade Escaping)
- ✅ HTTPS Ready
- ✅ Secure Password Reset
- ✅ Activity Logging Support

---

## 🚀 Deployment

### Production Checklist

Sebelum deploy ke production:

```bash
# 1. Set environment ke production
APP_ENV=production
APP_DEBUG=false

# 2. Generate cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Optimize autoloader
composer install --optimize-autoloader --no-dev

# 4. Migrate database
php artisan migrate --force

# 5. Build frontend
npm run build
```

### Server Requirements

- PHP 8.2+
- MySQL 8.0+ atau MariaDB 10.6+
- Composer
- Node.js 18+
- HTTPS (SSL Certificate)
- 512MB RAM minimum
- 1GB Storage minimum

---

## 🐛 Troubleshooting

### "SQLSTATE[HY000]: General error"
```bash
# Clear database cache
php artisan cache:clear

# Regenerate keys
php artisan key:generate

# Re-migrate
php artisan migrate:fresh --seed
```

### "Page not found" error
```bash
# Clear route cache
php artisan route:clear
php artisan cache:clear
```

### Styling looks broken
```bash
# Rebuild Tailwind
npm run build

# Clear view cache
php artisan view:clear
```

### Session/Auth issues
```bash
# Clear session
php artisan session:clear

# Check config/session.php
```

---

## 📊 Database Schema

### Main Tables

| Table | Purpose | Key Fields |
|-------|---------|-----------|
| `users` | User data (guru, siswa, orang tua) | id, name, email, password, role, nisn, kelas |
| `materis` | Learning materials | id, user_id (guru), title, description, content |
| `quizzes` | Quiz data | id, user_id, materi_id, title, durasi, passing_score |
| `quiz_questions` | Quiz questions | id, quiz_id, pertanyaan, tipe, poin |
| `quiz_attempts` | Student quiz attempts | id, user_id, quiz_id, skor, status, waktu |
| `quiz_answers` | Quiz answers | id, attempt_id, question_id, jawaban, poin |
| `aktivitas_pembelajarans` | Learning activities | id, user_id, type, description |
| `daily_checklists` | Daily checklists | id, user_id, status, date |
| `reminders` | Learning reminders | id, user_id, title, description |

---

## 📍 Available Routes

### Public Routes
```
GET  /               - Landing page
GET  /login          - Generic login page
GET  /register       - Generic registration page
```

### Teacher Routes (Protected)
```
GET    /teacher/dashboard     - Teacher dashboard
GET/POST /teacher/materi      - Manage materials
GET    /teacher/quiz          - Manage quizzes
GET    /teacher/scores        - Student performance
GET    /teacher/badges        - Student achievements
GET    /teacher/activities    - Learning activities
```

### Student Routes (Protected)
```
GET    /dashboard             - Student dashboard
GET    /materi                - View materials
GET    /quiz                  - View quizzes
GET    /ai                    - AI assistant
GET    /reminders             - Daily reminders
GET    /checklist             - Daily checklist
GET    /profile/edit          - Edit profile
```

### Authentication Routes
```
POST   /login                 - Login submission
POST   /register              - Registration submission
POST   /logout                - Logout (role-aware)
GET    /login/teacher         - Teacher login page
GET    /login/student         - Student login page
GET    /register/teacher      - Teacher registration
GET    /register/student      - Student registration
```

---

## 💡 Features Usage

### For Teachers

1. **Login** → `http://localhost:8000/login/teacher`
2. **Dashboard** - View statistics and recent activities
3. **Materials Management** - Add/Edit/Delete materials
4. **Quiz Management** - Create and manage quizzes
5. **Monitor Students** - Track performance and scores
6. **Logout** - Click profile icon → Logout

### For Students

1. **Login** → `http://localhost:8000/login/student`
2. **View Materials** - Browse and read learning materials
3. **Take Quizzes** - Answer quiz questions
4. **Check Progress** - View scores and achievements
5. **Daily Reminders** - Complete daily checklists
6. **AI Assistant** - Get help with learning

### For Parents

1. **Login** → Role-based redirect
2. **Monitor Child** - Track progress and results
3. **View Achievements** - See badges and scores

---

## 🔧 Useful Commands

### Database Operations
```bash
# Create fresh database with seeders
php artisan migrate:fresh --seed

# Rollback last migration
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# View migration status
php artisan migrate:status
```

### Cache Management
```bash
# Clear all caches
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear
```

### Tinker (PHP REPL)
```bash
# Access tinker
php artisan tinker

# Example: Create a user
User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => Hash::make('password')])

# Example: List all users
User::all()

# Example: Find user by email
User::where('email', 'guru@example.com')->first()
```

### Asset Building
```bash
# Build assets once
npm run build

# Watch assets for changes (development)
npm run dev

# Optimize production assets
npm run build
```

---

## 📱 Responsive Design

Aplikasi fully responsive untuk:
- ✅ Mobile (< 768px)
- ✅ Tablet (768px - 1024px)
- ✅ Desktop (> 1024px)

Semua dashboard, form, dan tabel dapat diakses dengan nyaman di semua perangkat.

---

## 🎓 API Documentation

Dokumentasi lengkap tersedia dalam file markdown:

- **PROJECT_COMPLETION_SUMMARY.md** - Overview proyek
- **COMPLETE_SYSTEM_DOCUMENTATION.md** - Dokumentasi teknis
- **LOGOUT_FEATURE_UPDATE.md** - Detail fitur logout
- **LOGOUT_QUICK_REFERENCE.md** - Quick reference
- **TESTING_GUIDE.md** - Testing procedures

---

## 🤝 Contributing

Untuk contribute ke project ini:

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is open source and available under the MIT License.

---

## 👥 Support & Contact

Untuk pertanyaan atau dukungan:

1. Baca dokumentasi yang tersedia
2. Check TESTING_GUIDE.md untuk testing procedures
3. Check COMPLETE_SYSTEM_DOCUMENTATION.md untuk technical details
4. Lihat PROJECT_COMPLETION_SUMMARY.md untuk overview lengkap

---

**Status:** ✅ Production Ready  
**Version:** 1.0  
**Last Updated:** December 7, 2024

🎉 **Siap digunakan!**
#   P r o j e c t _ R P L 2  
 