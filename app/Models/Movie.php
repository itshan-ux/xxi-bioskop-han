<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

        public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    use HasFactory;

    // Tambahkan semua kolom yang ada di tabel movies
    protected $fillable = [
        'title',
        'description',
        'duration',
        'genre',
    ];
}
