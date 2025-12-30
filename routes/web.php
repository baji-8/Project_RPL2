<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Storage;

// Landing Page
Route::get('/', function () {
    $landingImages = \Illuminate\Support\Facades\Storage::disk('public')->files('landing');
    $landingImageUrl = count($landingImages) > 0 ? \Illuminate\Support\Facades\Storage::disk('public')->url($landingImages[0]) : null;
    return view('landing', compact('landingImages', 'landingImageUrl'));
})->name('landing');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Student login
    Route::get('/login/student', [AuthController::class, 'showStudentLogin'])->name('login.student');
    Route::post('/login/student', [AuthController::class, 'studentLogin'])->name('login.student.post');

    // Teacher login
    Route::get('/login/teacher', [AuthController::class, 'showTeacherLogin'])->name('login.teacher');
    Route::post('/login/teacher', [AuthController::class, 'teacherLogin'])->name('login.teacher.post');
});

// Parent view-only login (accessible to anyone)
Route::get('/login/parent', [AuthController::class, 'showParentLogin'])->name('login.parent');
Route::post('/login/parent', [AuthController::class, 'parentLogin'])->name('login.parent.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('ensure_auth');

// Protected Routes (Student only)
Route::middleware(['ensure_auth', 'redirect_role', 'role:student'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/checklist/complete', [ChecklistController::class, 'complete'])->name('checklist.complete');
    
    // Materi Routes
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
    Route::get('/materi/{id}', [MateriController::class, 'show'])->name('materi.show');
    Route::post('/materi/{id}/complete', [MateriController::class, 'markComplete'])->name('materi.complete');
    
    // Aktivitas Pembelajaran Routes
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');
    
    // Quiz Routes
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quiz/active', [QuizController::class, 'active'])->name('quiz.active');
    Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{id}/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::get('/quiz/attempt/{id}', [QuizController::class, 'attempt'])->name('quiz.attempt');
    Route::post('/quiz/attempt/{id}/answer', [QuizController::class, 'submitAnswer'])->name('quiz.submit-answer');
    Route::post('/quiz/attempt/{id}/finish', [QuizController::class, 'finish'])->name('quiz.finish');
    Route::get('/quiz/result/{id}', [QuizController::class, 'result'])->name('quiz.result');
    
    // AI Page
    // AI page is a separate public page (not inside student dashboard)
    Route::get('/ai', [AIController::class, 'index'])->name('ai.index');
    Route::post('/ai/chat', [AIController::class, 'chat'])->name('ai.chat');
    
    // Profile Routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// AI Page (check authentication in controller to allow manual redirect)
Route::get('/ai', [AIController::class, 'index'])->name('ai.index');
Route::post('/ai/chat', [AIController::class, 'chat'])->middleware('ensure_auth')->name('ai.chat');

// Teacher area (requires auth + teacher role)
Route::middleware(['ensure_auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [\App\Http\Controllers\TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    
    // Materi CRUD Routes
    Route::get('/teacher/materi', [\App\Http\Controllers\TeacherController::class, 'materiIndex'])->name('teacher.materi.index');
    Route::get('/teacher/materi/create', [\App\Http\Controllers\TeacherController::class, 'materiCreate'])->name('teacher.materi.create');
    Route::post('/teacher/materi', [\App\Http\Controllers\TeacherController::class, 'materiStore'])->name('teacher.materi.store');
    Route::get('/teacher/materi/{id}/edit', [\App\Http\Controllers\TeacherController::class, 'materiEdit'])->name('teacher.materi.edit');
    Route::put('/teacher/materi/{id}', [\App\Http\Controllers\TeacherController::class, 'materiUpdate'])->name('teacher.materi.update');
    Route::delete('/teacher/materi/{id}', [\App\Http\Controllers\TeacherController::class, 'materiDestroy'])->name('teacher.materi.destroy');
    
    // Quiz CRUD Routes
    Route::get('/teacher/quiz', [\App\Http\Controllers\TeacherController::class, 'quizIndex'])->name('teacher.quiz.index');
    Route::get('/teacher/quiz/create', [\App\Http\Controllers\TeacherController::class, 'quizCreate'])->name('teacher.quiz.create');
    Route::post('/teacher/quiz', [\App\Http\Controllers\TeacherController::class, 'quizStore'])->name('teacher.quiz.store');
    Route::get('/teacher/quiz/{id}/edit', [\App\Http\Controllers\TeacherController::class, 'quizEdit'])->name('teacher.quiz.edit');
    Route::put('/teacher/quiz/{id}', [\App\Http\Controllers\TeacherController::class, 'quizUpdate'])->name('teacher.quiz.update');
    Route::delete('/teacher/quiz/{id}', [\App\Http\Controllers\TeacherController::class, 'quizDestroy'])->name('teacher.quiz.destroy');
    
    // Question Management Routes
    Route::get('/teacher/quiz/{id}/questions', [\App\Http\Controllers\QuestionController::class, 'index'])->name('teacher.quiz.questions');
    Route::post('/teacher/quiz/{id}/question', [\App\Http\Controllers\QuestionController::class, 'store'])->name('teacher.question.store');
    Route::put('/teacher/question/{id}', [\App\Http\Controllers\QuestionController::class, 'update']);
    Route::delete('/teacher/question/{id}', [\App\Http\Controllers\QuestionController::class, 'destroy'])->name('teacher.question.destroy');
    
    // API Routes for adjust quiz time
    Route::put('/api/quiz/{id}/adjust-time', [\App\Http\Controllers\TeacherController::class, 'adjustQuizTime']);
    Route::get('/api/question/{id}', [\App\Http\Controllers\QuestionController::class, 'show']);
    
    // Student Scores Route
    Route::get('/teacher/scores', [\App\Http\Controllers\TeacherController::class, 'studentScores'])->name('teacher.scores');
    
    // Teacher Profile Routes
    Route::get('/teacher/profile/edit', [\App\Http\Controllers\TeacherController::class, 'profileEdit'])->name('teacher.profile.edit');
    Route::put('/teacher/profile', [\App\Http\Controllers\TeacherController::class, 'profileUpdate'])->name('teacher.profile.update');
});

// Parent view (uses session-based parent_view_id)
Route::middleware(['role:parent'])->group(function () {
    Route::get('/parent/dashboard', [\App\Http\Controllers\ParentController::class, 'dashboard'])->name('parent.dashboard');
});

// Parent report - accessible to anyone (parent login or direct NISN entry)
Route::get('/parent/report/student', [\App\Http\Controllers\ParentController::class, 'reportStudent'])->name('report.student');

// Admin routes (requires admin role)
Route::middleware(['ensure_auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Student management
    Route::get('/students', [\App\Http\Controllers\AdminController::class, 'students'])->name('students');
    Route::get('/students/create', [\App\Http\Controllers\AdminController::class, 'createStudent'])->name('students.create');
    Route::post('/students', [\App\Http\Controllers\AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/students/{student}/edit', [\App\Http\Controllers\AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{student}', [\App\Http\Controllers\AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{student}', [\App\Http\Controllers\AdminController::class, 'destroyStudent'])->name('students.destroy');
    
    // Teacher management
    Route::get('/teachers', [\App\Http\Controllers\AdminController::class, 'teachers'])->name('teachers');
    Route::get('/teachers/create', [\App\Http\Controllers\AdminController::class, 'createTeacher'])->name('teachers.create');
    Route::post('/teachers', [\App\Http\Controllers\AdminController::class, 'storeTeacher'])->name('teachers.store');
    Route::get('/teachers/{teacher}/edit', [\App\Http\Controllers\AdminController::class, 'editTeacher'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [\App\Http\Controllers\AdminController::class, 'updateTeacher'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [\App\Http\Controllers\AdminController::class, 'destroyTeacher'])->name('teachers.destroy');
    
    // Landing images
    Route::get('/landing-images', [\App\Http\Controllers\AdminController::class, 'landingImages'])->name('landing-images');
    Route::post('/landing-images', [\App\Http\Controllers\AdminController::class, 'storeLandingImage'])->name('landing-images.store');
    Route::delete('/landing-images/{filename}', [\App\Http\Controllers\AdminController::class, 'destroyLandingImage'])->name('landing-images.destroy');
});
