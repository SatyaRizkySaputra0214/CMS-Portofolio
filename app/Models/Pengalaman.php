<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengalaman extends Model
{
    use HasFactory;

    protected $table = 'pengalaman';

    protected $fillable = [
        'kategori',
        'posisi',
        'nama_instansi',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
    ];
}
