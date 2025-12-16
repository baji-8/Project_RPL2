# Teacher Dashboard - Quick Reference Guide

## 📱 View Files Created

### Dashboard
- **Route**: `/teacher/dashboard`
- **File**: `resources/views/teacher/dashboard.blade.php`
- **Display**: Statistics, recent quiz attempts, top performers, students needing attention
- **Key Variables**: $totalStudents, $totalMateri, $totalQuizzes, $averageScore, $quizAttempts, $studentScores

### Material Management

#### 1. Material List
- **Route**: `/teacher/materi`
- **File**: `resources/views/teacher/materi/index.blade.php`
- **Features**: List, Edit, Delete buttons, pagination
- **Key Variables**: $materi (paginated collection)

#### 2. Create Material
- **Route**: `/teacher/materi/create`
- **File**: `resources/views/teacher/materi/create.blade.php` → includes `form.blade.php`
- **Form**: Judul, Deskripsi, Konten, Urutan, is_active checkbox

#### 3. Edit Material
- **Route**: `/teacher/materi/{id}/edit`
- **File**: `resources/views/teacher/materi/edit.blade.php` → includes `form.blade.php`
- **Form**: Same as create, pre-populated with material data
- **Key Variable**: $materi (single record)

#### Form Template (Reusable)
- **File**: `resources/views/teacher/materi/form.blade.php`
- **Purpose**: Used by both create and edit views
- **Logic**: Detects `isset($materi)` to determine create vs edit mode

### Quiz Management

#### 1. Quiz List
- **Route**: `/teacher/quiz`
- **File**: `resources/views/teacher/quiz/index.blade.php`
- **Features**: List with question count, duration, passing score
- **Key Variables**: $quizzes (paginated with questions relationship)

#### 2. Create Quiz
- **Route**: `/teacher/quiz/create`
- **File**: `resources/views/teacher/quiz/create.blade.php` → includes `form.blade.php`
- **Form**: Judul, Deskripsi, Durasi, Passing Score, is_active

#### 3. Edit Quiz
- **Route**: `/teacher/quiz/{id}/edit`
- **File**: `resources/views/teacher/quiz/edit.blade.php` → includes `form.blade.php`
- **Form**: Same as create, pre-populated with quiz data
- **Key Variable**: $quiz (with questions relationship)

#### Form Template (Reusable)
- **File**: `resources/views/teacher/quiz/form.blade.php`
- **Purpose**: Used by both create and edit views
- **Logic**: Detects `isset($quiz)` to determine create vs edit mode

### Student Scores

#### Student Performance View
- **Route**: `/teacher/scores`
- **File**: `resources/views/teacher/scores/index.blade.php`
- **Features**: Statistics, search, sort, performance table
- **Key Variables**: $studentScores (array of student data)
- **Query Parameters**:
  - `?search=` → Search by name or NISN
  - `?sort=name|score_desc|score_asc` → Change sort order

---

## 🔗 Links Between Views

```
Dashboard (/teacher/dashboard)
├─→ Kelola Materi → Material Index (/teacher/materi)
│   ├─→ + Tambah Materi → Create Material (/teacher/materi/create)
│   └─→ Edit → Edit Material (/teacher/materi/{id}/edit)
│
├─→ Kelola Kuis → Quiz Index (/teacher/quiz)
│   ├─→ + Buat Kuis Baru → Create Quiz (/teacher/quiz/create)
│   └─→ Edit → Edit Quiz (/teacher/quiz/{id}/edit)
│
└─→ Lihat Nilai Siswa → Student Scores (/teacher/scores)
    └─→ Search & Sort functionality
```

---

## 🎯 Controller Methods Mapping

### TeacherController@dashboard
```
GET /teacher/dashboard
↓
Returns: teacher.dashboard view with statistics
```

### Material CRUD
```
GET    /teacher/materi           → materiIndex()   → materi.index
GET    /teacher/materi/create    → materiCreate()  → materi.form
POST   /teacher/materi           → materiStore()   → redirect to index
GET    /teacher/materi/{id}/edit → materiEdit()    → materi.form
PUT    /teacher/materi/{id}      → materiUpdate()  → redirect to index
DELETE /teacher/materi/{id}      → materiDestroy() → redirect to index
```

### Quiz CRUD
```
GET    /teacher/quiz             → quizIndex()     → quiz.index
GET    /teacher/quiz/create      → quizCreate()    → quiz.form
POST   /teacher/quiz             → quizStore()     → redirect to index
GET    /teacher/quiz/{id}/edit   → quizEdit()      → quiz.form
PUT    /teacher/quiz/{id}        → quizUpdate()    → redirect to index
DELETE /teacher/quiz/{id}        → quizDestroy()   → redirect to index
```

### Student Scores
```
GET /teacher/scores → studentScores() → scores.index
```

---

## 🏗️ Form Submission Flow

### Material Operations
1. **Create**: POST `/teacher/materi` → Store → Index with success message
2. **Update**: PUT `/teacher/materi/{id}` → Update → Index with success message
3. **Delete**: DELETE `/teacher/materi/{id}` → Destroy → Index with success message

### Quiz Operations
1. **Create**: POST `/teacher/quiz` → Store → Index with success message
2. **Update**: PUT `/teacher/quiz/{id}` → Update → Index with success message
3. **Delete**: DELETE `/teacher/quiz/{id}` → Destroy → Index with success message

---

## 💾 Form Data Processing

### Material Form Processing
```php
// On Create/Edit POST:
validate:
  - judul: required|string|max:255
  - deskripsi: required|string
  - konten: required|string
  - urutan: required|integer
  - is_active: boolean

// Convert checkbox:
is_active = $request->has('is_active')  // true/false
```

### Quiz Form Processing
```php
// On Create/Edit POST:
validate:
  - judul: required|string|max:255
  - deskripsi: required|string
  - durasi: required|integer|min:1
  - passing_score: required|integer|min:0|max:100
  - is_active: boolean

// Convert checkbox:
is_active = $request->has('is_active')  // true/false
```

---

## 🎨 Styling Classes Used

### Header/Navigation
- `bg-green-600` - Main header background
- `h-20` - Header height (consistent across all pages)
- `text-white` - Text color

### Cards
- `bg-white rounded-lg shadow p-6` - Standard card
- `border-l-4 border-{color}-500` - Left color border
- `border-t-4 border-{color}-500` - Top color border

### Buttons
- Green: `bg-green-600 hover:bg-green-700` - Create/Save
- Purple: `bg-purple-600 hover:bg-purple-700` - Quiz actions
- Blue: `bg-blue-600 hover:bg-blue-700` - Info/Detail
- Red: `bg-red-600 hover:bg-red-900` - Delete
- Gray: `bg-gray-400 hover:bg-gray-500` - Cancel

### Status Badges
- Success/Green: `bg-green-100 text-green-800` - Passed, Active
- Warning/Yellow: `bg-yellow-100 text-yellow-800` - Fair/Cukup
- Danger/Red: `bg-red-100 text-red-800` - Failed, Needs improvement
- Info/Blue: `bg-blue-100 text-blue-800` - Info badges

### Tables
- Header: `bg-gray-50`
- Rows: `divide-y divide-gray-200`
- Hover: `hover:bg-gray-50 transition`

---

## 📊 Data Display & Calculations

### Dashboard Statistics
```
totalStudents = User::where('role', 'student')->count()
totalMateri = Materi::count()
totalQuizzes = Quiz::count()
averageScore = QuizAttempt::avg('nilai')
```

### Student Scores Calculation
```php
For each student:
  total_attempts = count of quiz attempts
  average_score = avg(nilai) from attempts
  
  Status:
  - score >= 80: "Lulus" (Green)
  - score >= 60: "Cukup" (Yellow)
  - score < 60: "Perlu Perbaikan" (Red)
```

### Top Performers (Top 5)
- Sorted by average_score DESC
- Displayed with progress bar (width = score%)

### Students Needing Attention
- Filtered by: total_attempts > 0 AND average_score < 60
- Sorted by average_score ASC
- Displayed with orange progress bar

---

## 🔐 Security & Validation

### Route Protection
- All routes protected by `['auth', EnsureRole::class . ':teacher']`
- Teachers can only access their own data
- Non-authenticated users redirected to login

### Input Validation
- All form inputs validated before processing
- CSRF token in all POST/PUT/DELETE forms
- is_active checkbox safely converted to boolean

### Error Handling
- Validation errors displayed above form fields
- Success messages after operations
- Redirect with message on completion

---

## 📱 Mobile Responsiveness

### Breakpoints
- Mobile (sm): Single column layouts
- Tablet (md): 2 column layouts
- Desktop (lg): 3-4 column layouts

### Responsive Classes
- `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4` - Statistics cards
- `hidden md:flex` - Hide on mobile, show on desktop
- `overflow-x-auto` - Horizontal scroll for tables on mobile

---

## 🚀 Quick Start as Teacher

1. Login: `/login/teacher`
2. Dashboard: `/teacher/dashboard`
3. Add Material: Click "Kelola Materi" → "+ Tambah Materi"
4. Add Quiz: Click "Kelola Kuis" → "+ Buat Kuis Baru"
5. View Scores: Click "Lihat Nilai Siswa" → Search/Sort as needed

---

## 📋 File Sizes Summary

```
views/teacher/dashboard.blade.php        ~13 KB
views/teacher/materi/index.blade.php     ~5 KB
views/teacher/materi/form.blade.php      ~7 KB
views/teacher/quiz/index.blade.php       ~5 KB
views/teacher/quiz/form.blade.php        ~6 KB
views/teacher/scores/index.blade.php     ~8 KB
```

Total: ~44 KB of view templates

---

## ✅ Implementation Status

- [x] Dashboard view created and functional
- [x] Material management (CRUD) complete
- [x] Quiz management (CRUD) complete
- [x] Student scores tracking and display
- [x] Search and sort functionality
- [x] Responsive design applied
- [x] All routes registered
- [x] Controller methods implemented
- [x] Form validation in place
- [x] Success/error messaging
- [x] Navigation between views
- [x] Navbar consistency across pages

Ready for testing and production use! 🎉
