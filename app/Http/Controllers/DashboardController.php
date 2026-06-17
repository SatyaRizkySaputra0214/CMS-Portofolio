<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Kontak;
use App\Models\Pendidikan;
use App\Models\Pengalaman;
use App\Models\Portofolio;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard summary.
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'pendidikan_count' => Pendidikan::count(),
                'pengalaman_count' => Pengalaman::count(),
                'portofolio_count' => Portofolio::count(),
                'kontak_count' => Kontak::count(),
            ],
            'identitas' => Identitas::find(1),
        ]);
    }
}
