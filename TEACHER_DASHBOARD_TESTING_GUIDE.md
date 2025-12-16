# Teacher Dashboard - Testing Guide

## 🚀 Quick Start untuk Test Dashboard Guru

### **Test User Credentials (dari Seeder)**

**Guru:**
- Email: `guru@example.com`
- Password: `password123`
- Name: `Ibu Siti Nurhaliza`
- Role: `teacher`

**Test Students (sudah ada data):**
1. Budi Santoso - NISN: 0001234567 - Kelas 6A
2. Siti Nurhaliza - NISN: 0001234568 - Kelas 6A  
3. Rina Wijaya - NISN: 0001234569 - Kelas 6B

**Test Materials (sudah ada data):**
1. Pembelajaran Bilangan Bulat
2. Operasi Hitung Pecahan
3. Perbandingan dan Skala

**Test Quizzes (sudah ada data):**
1. Kuis Bilangan Bulat (30 menit, KKM 70)
2. Kuis Operasi Pecahan (40 menit, KKM 75)

**Sample Quiz Attempts (sudah ada data):**
- Budi Santoso: 85 (Bilangan Bulat), 92 (Pecahan)
- Siti Nurhaliza: 65 (Bilangan Bulat), 72 (Pecahan)
- Rina Wijaya: 55 (Bilangan Bulat), 48 (Pecahan)

---

## 📝 Step-by-Step Testing

### **Step 1: Akses Login Page**
```
URL: http://127.0.0.1:8000/login/teacher
```
- Klik tombol "Masuk" atau navigate langsung ke URL di atas
- Lihat form login dengan field untuk username/email dan password

### **Step 2: Login sebagai Guru**
- **Username/Email**: `guru@example.com`
- **Password**: `password123`
- Klik tombol "Masuk"
- **Expected Result**: Redirect ke `/teacher/dashboard`

### **Step 3: Verifikasi Dashboard**

#### Cek Elemen-elemen ini:

**Header & Navigation:**
- ✅ Logo sekolah visible di sebelah kiri
- ✅ Nama "SDN Susukan 08 Pagi" terlihat
- ✅ Nama guru "Ibu Siti Nurhaliza" terlihat di kanan
- ✅ Tombol Logout tersedia

**Statistics Cards (harus menampilkan):**
- Total Siswa: **3** (Budi, Siti, Rina)
- Total Materi: **3** (Bilangan Bulat, Pecahan, Perbandingan)
- Total Kuis: **2** (Kuis Bilangan Bulat, Kuis Pecahan)
- Rata-rata Nilai: **69.2** (rata dari 6 attempts: 85,92,65,72,55,48)

**Quick Action Cards:**
- Tombol "Kelola Materi" → link ke `/teacher/materi`
- Tombol "Kelola Kuis" → link ke `/teacher/quiz`
- Tombol "Lihat Nilai Siswa" → link ke `/teacher/scores`
- Tombol "Lihat Badge" → placeholder (tidak aktif)

**Recent Quiz Attempts Table:**
- Harus menampilkan 6 attempts dari terbaru
- Kolom: Siswa, Kuis, Nilai, Status, Tanggal
- Setiap row menunjukkan:
  - Nama siswa + NISN
  - Judul kuis
  - Nilai dengan warna: Hijau (85,92), Kuning (65,72), Merah (55,48)
  - Status: "Completed"
  - Tanggal: Tergantung waktu seed

**Top Performers Section (5 besar):**
- Harus menampilkan urutan nilai tertinggi
- Budi Santoso: 88.5 rata-rata (atas)
- Siti Nurhaliza: 68.5 rata-rata
- Rina Wijaya: 51.5 rata-rata

**Students Needing Attention:**
- Harus menampilkan siswa dengan nilai < 60
- Rina Wijaya: 51.5 (perlu dibantu)

---

### **Step 4: Test Kelola Materi**

#### Akses List Materi
```
Klik card "Kelola Materi" atau go to: /teacher/materi
```

**Expected Elements:**
- ✅ Tombol "+ Tambah Materi" di atas
- ✅ Table dengan 3 baris (3 materials)
- ✅ Kolom: Judul, Deskripsi, Urutan, Status, Aksi

**Test Create Material:**
1. Klik "+ Tambah Materi"
2. Isi form:
   - Judul: "Materi Test"
   - Deskripsi: "Test description"
   - Konten: "Test content untuk pembelajaran"
   - Urutan: 4
   - Checkbox is_active: checked
3. Klik "Simpan Materi"
4. **Expected**: Redirect ke materi list, success message muncul
5. **Verify**: Material baru terlihat di list dengan 4 row

**Test Edit Material:**
1. Klik "Edit" pada salah satu material (misal "Pembelajaran Bilangan Bulat")
2. Ubah judul menjadi "Pembelajaran Bilangan Bulat - Updated"
3. Klik "Update Materi"
4. **Expected**: Redirect ke list, success message, perubahan terlihat

**Test Delete Material:**
1. Klik "Hapus" pada material yang baru dibuat
2. Confirm dialog muncul "Yakin ingin menghapus?"
3. Klik OK
4. **Expected**: Material dihapus, success message, list berkurang

---

### **Step 5: Test Kelola Kuis**

#### Akses List Kuis
```
Klik card "Kelola Kuis" atau go to: /teacher/quiz
```

**Expected Elements:**
- ✅ Tombol "+ Buat Kuis Baru"
- ✅ Table dengan 2 baris (2 quizzes)
- ✅ Kolom: Judul Kuis, Soal, Durasi, Nilai Lulus, Status, Aksi

**Verify Existing Quizzes:**
1. Kuis Bilangan Bulat
   - 0 Soal (karena belum ada questions)
   - Durasi: 30 menit
   - Nilai Lulus: 70
   - Status: Aktif

2. Kuis Operasi Pecahan
   - 0 Soal
   - Durasi: 40 menit
   - Nilai Lulus: 75
   - Status: Aktif

**Test Create Quiz:**
1. Klik "+ Buat Kuis Baru"
2. Isi form:
   - Judul: "Kuis Test"
   - Deskripsi: "Test quiz"
   - Durasi: 25
   - Passing Score: 60
   - is_active: checked
3. Klik "Simpan Kuis"
4. **Expected**: Redirect ke list, success message, 3 quizzes sekarang

**Test Edit Quiz:**
1. Klik "Edit" pada quiz yang baru dibuat
2. Ubah durasi menjadi 35 menit
3. Klik "Update Kuis"
4. **Expected**: Perubahan terlihat di list

**Test Delete Quiz:**
1. Klik "Hapus" pada quiz yang baru dibuat
2. Confirm dan OK
3. **Expected**: Kembali ke 2 quizzes

---

### **Step 6: Test Lihat Nilai Siswa**

#### Akses Student Scores
```
Klik card "Lihat Nilai Siswa" atau go to: /teacher/scores
```

**Expected Elements:**
- Statistics Cards:
  - Total Siswa: 3
  - Rata-rata Nilai: 69.2
  - Nilai Tertinggi: 92
  - Nilai Terendah: 48

**Search & Filter:**
- Search box tersedia (cari nama atau NISN)
- Sort dropdown dengan opsi:
  - Urutkan Nama
  - Nilai Tertinggi
  - Nilai Terendah

**Test Search:**
1. Ketik "Budi" di search box
2. Klik "Cari"
3. **Expected**: Hanya Budi Santoso yang tampil

**Test Sort Highest:**
1. Select "Nilai Tertinggi" dari dropdown
2. Klik "Cari"
3. **Expected**: 
   - Row 1: Budi Santoso (88.5)
   - Row 2: Siti Nurhaliza (68.5)
   - Row 3: Rina Wijaya (51.5)

**Test Sort Lowest:**
1. Select "Nilai Terendah"
2. **Expected**: Rina (51.5) paling atas

**Student Table Verification:**
Untuk setiap siswa, lihat:
- Nama Siswa
- NISN
- Total Kuis (berapa kali attempt)
- Rata-rata Nilai (warna: hijau ≥80, kuning 60-79, merah <60)
- Status (Lulus/Cukup/Perlu Perbaikan)

---

### **Step 7: Test Responsive Design**

**Test Mobile View:**
1. Buka DevTools (F12)
2. Click device toolbar (mobile icon)
3. Set ke iPhone 12 (390px width)
4. **Expected**:
   - Layout single column
   - Table horizontal scroll
   - Cards stack vertically
   - Menu hamburgermenu (jika applicable)

**Test Tablet View:**
1. Set device ke iPad (768px)
2. **Expected**: 2 column grid untuk cards

**Test Desktop View:**
1. Full width (1200px+)
2. **Expected**: 4 column grid untuk stats cards

---

### **Step 8: Test Navigation**

**Test Navbar Links:**
1. Dari dashboard, klik logo sekolah
   - **Expected**: Redirect ke landing page
2. Dari materi page, klik logo
   - **Expected**: Redirect ke landing page
3. Dari scores page, klik logo
   - **Expected**: Redirect ke landing page

**Test Breadcrumb/Back Buttons:**
1. Di materi edit, klik "← Kembali ke Daftar Materi"
   - **Expected**: Redirect ke materi index
2. Di quiz create, klik "← Kembali ke Daftar Kuis"
   - **Expected**: Redirect ke quiz index

---

## 🔍 Debugging Checklist

Jika ada issue, cek:

- [ ] Server Laravel masih running (`php artisan serve`)
- [ ] Database sudah di-migrate (`php artisan migrate:fresh --seed`)
- [ ] User authenticated sebelum akses protected routes
- [ ] Routes registered dengan benar (`php artisan route:list --name=teacher`)
- [ ] View files exist di `resources/views/teacher/`
- [ ] Models sudah updated (Quiz with passing_score)
- [ ] CSRF token ada di semua form

---

## 📊 Expected Dashboard Numbers

Setelah fresh seed, dashboard harus menampilkan:

| Metric | Expected Value |
|--------|---|
| Total Siswa | 3 |
| Total Materi | 3 |
| Total Kuis | 2 |
| Rata-rata Nilai | 69.2 |
| Quiz Attempts | 6 |
| Top Performer | Budi (88.5) |
| Lowest Score | Rina (51.5) |

---

## 🎯 Test Scenarios

### Scenario 1: Guru Baru Melihat Ringkasan
1. Login sebagai guru
2. Lihat dashboard dengan semua statistik
3. Identifikasi siswa terbaik dan terendah
4. ✅ **PASS** jika semua data akurat

### Scenario 2: Membuat Material Baru
1. Dari dashboard, klik "Kelola Materi"
2. Klik "+ Tambah Materi"
3. Isi semua field
4. Simpan
5. ✅ **PASS** jika material muncul di list

### Scenario 3: Membuat Kuis
1. Dari dashboard, klik "Kelola Kuis"
2. Klik "+ Buat Kuis Baru"
3. Isi semua field dengan durasi dan KKM
4. Simpan
5. ✅ **PASS** jika kuis muncul dengan info lengkap

### Scenario 4: Monitoring Nilai Siswa
1. Dari dashboard, klik "Lihat Nilai Siswa"
2. Lihat semua siswa dengan nilai mereka
3. Cari siswa tertentu
4. Sort berdasarkan nilai
5. ✅ **PASS** jika search dan sort berfungsi

### Scenario 5: Responsif Design
1. Buka dashboard di mobile view
2. Cek semua elemen readable
3. Cek form dapat diisi di mobile
4. ✅ **PASS** jika responsive tanpa issue

---

## 💾 Data Reset & Troubleshooting

**Reset Database:**
```bash
php artisan migrate:fresh --seed
```

**Check Routes:**
```bash
php artisan route:list --name=teacher
```

**Check Teacher User:**
```bash
php artisan tinker
# Kemudian jalankan:
User::where('role', 'teacher')->first()
```

**Clear Cache:**
```bash
php artisan cache:clear
php artisan view:clear
```

---

## 📝 Notes

- Semua password dalam test adalah `password123`
- Seeder membuat 3 siswa dengan 6 quiz attempts total
- Materials urutan 1-3, dapat ditambah lebih banyak
- Quiz attempts seeded with varied scores (55-92) untuk realistic scenario
- Dashboard auto-calculate statistik dari database

---

## 🎉 Success Criteria

Implementasi dinyatakan **SUKSES** jika:

✅ Login sebagai guru berhasil  
✅ Dashboard muncul dengan statistik benar  
✅ Material CRUD bekerja sempurna  
✅ Quiz CRUD bekerja sempurna  
✅ Student scores display dengan benar  
✅ Search dan sort berfungsi  
✅ Responsive design di semua device  
✅ Navigation dan link bekerja  
✅ Error handling proper  

**Status**: Ready for Testing! 🚀
