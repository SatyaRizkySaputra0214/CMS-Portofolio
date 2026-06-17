<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Kontak;
use App\Models\Pendidikan;
use App\Models\Pengalaman;
use App\Models\Portofolio;
use App\Models\Skill;
use Inertia\Inertia;
use Inertia\Response;

class PublicController extends Controller
{
    /**
     * Display the public portfolio page.
     */
    public function index(): Response
    {
        // Get the single row of identity or set defaults if empty
        $identitas = Identitas::find(1);
        if (! $identitas) {
            $identitas = [
                'nama_lengkap' => 'Nama Anda',
                'profesi' => 'Software Engineer',
                'tentang_saya' => 'Tulis sesuatu tentang diri Anda di panel admin.',
                'foto_profil' => null,
                'cv_file' => null,
            ];
        }

        $pendidikan = Pendidikan::orderBy('tahun_mulai', 'desc')->get();
        $pengalaman = Pengalaman::orderBy('tanggal_mulai', 'desc')->get();
        $portofolio = Portofolio::orderBy('dibuat_pada', 'desc')->get();
        $kontak = Kontak::all();
        $skills = Skill::where('status', true)->orderBy('urutan', 'asc')->orderBy('nama', 'asc')->get();

        return Inertia::render('Welcome', [
            'identitas' => $identitas,
            'pendidikan' => $pendidikan,
            'pengalaman' => $pengalaman,
            'portofolio' => $portofolio,
            'kontak' => $kontak,
            'skills' => $skills,
        ]);
    }
}
