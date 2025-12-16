<?php

require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Starting data clearing process...\n\n";

    // Disable foreign key constraints
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
    // Clear quiz-related data first (due to foreign key constraints)
    echo "1. Clearing quiz attempts and answers...\n";
    DB::table('quiz_answers')->truncate();
    echo "   ✓ Cleared quiz_answers\n";
    
    DB::table('quiz_attempts')->truncate();
    echo "   ✓ Cleared quiz_attempts\n";

    // Clear quiz questions and quizzes
    echo "\n2. Clearing quiz questions and quizzes...\n";
    DB::table('quiz_questions')->truncate();
    echo "   ✓ Cleared quiz_questions\n";
    
    DB::table('quiz')->truncate();
    echo "   ✓ Cleared quiz\n";

    // Clear materials/aktivitas pembelajaran
    echo "\n3. Clearing learning activities (aktivitas pembelajaran)...\n";
    DB::table('aktivitas_pembelajaran')->truncate();
    echo "   ✓ Cleared aktivitas_pembelajaran\n";

    // Clear materials (materis)
    echo "\n4. Clearing materials (materis)...\n";
    DB::table('materis')->truncate();
    echo "   ✓ Cleared materis\n";

    // Clear student data (keep teachers and admin)
    echo "\n5. Clearing student data...\n";
    DB::table('users')->where('role', 'student')->delete();
    echo "   ✓ Deleted all student users\n";

    // Clear daily checklists
    echo "\n6. Clearing daily checklists...\n";
    DB::table('daily_checklists')->truncate();
    echo "   ✓ Cleared daily_checklists\n";

    // Re-enable foreign key constraints
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    echo "\n✅ All data cleared successfully!\n";
    echo "\nSummary:\n";
    echo "- Removed all students\n";
    echo "- Cleared all materials\n";
    echo "- Cleared all quiz questions, quizzes, attempts, and answers\n";
    echo "- Cleared all daily checklists\n";

} catch (Exception $e) {
    echo "\n❌ Error occurred: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
