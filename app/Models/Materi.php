<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kelas',
        'deskripsi',
        'konten',
        'gambar',
        'file',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function aktivitasPembelajaran()
    {
        return $this->hasMany(AktivitasPembelajaran::class);
    }
}
