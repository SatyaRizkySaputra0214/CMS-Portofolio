<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    /** @use HasFactory<\Illuminate\Database\Eloquent\Factories\Factory> */
    use HasFactory;

    protected $table = 'pendidikan';

    protected $fillable = [
        'institusi',
        'gelar_jurusan',
        'tahun_mulai',
        'tahun_selesai',
        'deskripsi',
    ];
}
