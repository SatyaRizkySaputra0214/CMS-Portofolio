<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identitas extends Model
{
    use HasFactory;

    protected $table = 'identitas';

    protected $fillable = [
        'nama_lengkap',
        'profesi',
        'tentang_saya',
        'foto_profil',
        'cv_file',
    ];
}
