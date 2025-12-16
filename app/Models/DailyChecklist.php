<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyChecklist extends Model
{
    use HasFactory;

    protected $table = 'daily_checklists';

    protected $fillable = [
        'user_id',
        'key',
        'status',
        'date',
        'completed_at',
    ];

    protected $casts = [
        'date' => 'date',
        'completed_at' => 'datetime',
    ];
}
