<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolio';

    // We use the database timestamp default for dibuat_pada, so we disable Eloquent timestamps
    public $timestamps = false;

    protected $fillable = [
        'judul_proyek',
        'thumbnail',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'link_eksternal',
        'tools',
    ];

    protected function casts(): array
    {
        return [
            'tools' => 'array',
        ];
    }
}
