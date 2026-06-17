<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdentitasController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PengalamanController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SkillController;

Route::get('/', [PublicController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Identitas
    Route::get('settings/identitas', [IdentitasController::class, 'edit'])->name('identitas.edit');
    Route::post('identitas', [IdentitasController::class, 'update'])->name('identitas.update');

    // Pendidikan CRUD
    Route::get('settings/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan.index');
    Route::post('pendidikan', [PendidikanController::class, 'store'])->name('pendidikan.store');
    Route::put('pendidikan/{pendidikan}', [PendidikanController::class, 'update'])->name('pendidikan.update');
    Route::delete('pendidikan/{pendidikan}', [PendidikanController::class, 'destroy'])->name('pendidikan.destroy');

    // Pengalaman CRUD
    Route::get('settings/pengalaman', [PengalamanController::class, 'index'])->name('pengalaman.index');
    Route::post('pengalaman', [PengalamanController::class, 'store'])->name('pengalaman.store');
    Route::put('pengalaman/{pengalaman}', [PengalamanController::class, 'update'])->name('pengalaman.update');
    Route::delete('pengalaman/{pengalaman}', [PengalamanController::class, 'destroy'])->name('pengalaman.destroy');

    // Portofolio CRUD
    Route::get('settings/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');
    Route::post('portofolio', [PortofolioController::class, 'store'])->name('portofolio.store');
    Route::post('portofolio/{portofolio}', [PortofolioController::class, 'update'])->name('portofolio.update'); // using POST for update because of multipart form-data issues in PHP PUT requests
    Route::delete('portofolio/{portofolio}', [PortofolioController::class, 'destroy'])->name('portofolio.destroy');

    // Kontak CRUD
    Route::get('settings/kontak', [KontakController::class, 'index'])->name('kontak.index');
    Route::post('kontak', [KontakController::class, 'store'])->name('kontak.store');
    Route::put('kontak/{kontak}', [KontakController::class, 'update'])->name('kontak.update');
    Route::delete('kontak/{kontak}', [KontakController::class, 'destroy'])->name('kontak.destroy');

    // Skills CRUD
    Route::get('settings/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::post('skills', [SkillController::class, 'store'])->name('skills.store');
    Route::put('skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');
});

require __DIR__.'/settings.php';
