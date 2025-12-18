<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(AiKeywordSeeder::class);
        // User::factory(10)->create();

        // Create test student for parent login
        User::factory()->create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@example.com',
            'nisn' => '0012345678',
            'role' => 'student',
            'tanggal_lahir' => '2015-03-15',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create test teacher for dashboard testing
        $teacher = User::factory()->create([
            'name' => 'Ibu Siti Nurhaliza',
            'email' => 'guru@example.com',
            'password' => bcrypt('password123'),
            'role' => 'teacher',
            'tanggal_lahir' => '1990-05-20',
        ]);

        // Create some test students for teacher to view
        $student1 = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'nisn' => '0001234567',
            'role' => 'student',
            'kelas' => '6A',
            'tanggal_lahir' => '2014-07-10',
        ]);

        $student2 = User::factory()->create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'nisn' => '0001234568',
            'role' => 'student',
            'kelas' => '6A',
            'tanggal_lahir' => '2014-08-15',
        ]);

        $student3 = User::factory()->create([
            'name' => 'Rina Wijaya',
            'email' => 'rina@example.com',
            'nisn' => '0001234569',
            'role' => 'student',
            'kelas' => '6B',
            'tanggal_lahir' => '2014-09-20',
        ]);

        // Create test materials
        Materi::create([
            'judul' => 'Pembelajaran Bilangan Bulat',
            'deskripsi' => 'Materi tentang operasi bilangan bulat positif dan negatif',
            'konten' => 'Bilangan bulat adalah himpunan bilangan yang terdiri dari bilangan negatif, nol, dan bilangan positif. Bilangan bulat dapat digunakan untuk menggambarkan berbagai situasi dalam kehidupan sehari-hari.',
            'urutan' => 1,
            'is_active' => true,
        ]);

        Materi::create([
            'judul' => 'Operasi Hitung Pecahan',
            'deskripsi' => 'Memahami operasi penjumlahan, pengurangan, perkalian, dan pembagian pecahan',
            'konten' => 'Pecahan adalah bagian dari keseluruhan. Pecahan ditulis dalam bentuk a/b dimana a adalah pembilang dan b adalah penyebut. Dalam materi ini kita akan mempelajari operasi dasar pada pecahan.',
            'urutan' => 2,
            'is_active' => true,
        ]);

        Materi::create([
            'judul' => 'Perbandingan dan Skala',
            'deskripsi' => 'Mempelajari konsep perbandingan dan penerapannya dalam skala',
            'konten' => 'Perbandingan adalah cara membandingkan dua kuantitas. Skala adalah perbandingan antara jarak pada peta dengan jarak sebenarnya di lapangan.',
            'urutan' => 3,
            'is_active' => true,
        ]);

        // Create test quizzes
        $quiz1 = Quiz::create([
            'judul' => 'Kuis Bilangan Bulat',
            'deskripsi' => 'Uji pemahaman tentang operasi bilangan bulat',
            'durasi' => 30,
            'passing_score' => 70,
            'is_active' => true,
        ]);

        $quiz2 = Quiz::create([
            'judul' => 'Kuis Operasi Pecahan',
            'deskripsi' => 'Uji kemampuan operasi hitung pecahan',
            'durasi' => 40,
            'passing_score' => 75,
            'is_active' => true,
        ]);

        // Create test quiz attempts
        QuizAttempt::create([
            'user_id' => $student1->id,
            'quiz_id' => $quiz1->id,
            'nilai' => 85,
            'status' => 'completed',
        ]);

        QuizAttempt::create([
            'user_id' => $student1->id,
            'quiz_id' => $quiz2->id,
            'nilai' => 92,
            'status' => 'completed',
        ]);

        QuizAttempt::create([
            'user_id' => $student2->id,
            'quiz_id' => $quiz1->id,
            'nilai' => 65,
            'status' => 'completed',
        ]);

        QuizAttempt::create([
            'user_id' => $student2->id,
            'quiz_id' => $quiz2->id,
            'nilai' => 72,
            'status' => 'completed',
        ]);

        QuizAttempt::create([
            'user_id' => $student3->id,
            'quiz_id' => $quiz1->id,
            'nilai' => 55,
            'status' => 'completed',
        ]);

        QuizAttempt::create([
            'user_id' => $student3->id,
            'quiz_id' => $quiz2->id,
            'nilai' => 48,
            'status' => 'completed',
        ]);
    }
}
