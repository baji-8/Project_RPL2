<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'waktu_mulai',
        'waktu_selesai',
        'nilai',
        'jumlah_benar',
        'jumlah_salah',
        'status',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    // Helper methods
    public function getRemainingTimeAttribute()
    {
        if ($this->status !== 'ongoing') {
            return 0;
        }

        $quiz = $this->quiz;
        $elapsed = now()->diffInSeconds($this->waktu_mulai);
        $remaining = ($quiz->durasi * 60) - $elapsed;

        return max(0, $remaining);
    }
}
