<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IdentitasController extends Controller
{
    /**
     * Show the form for editing the identity.
     */
    public function edit(): \Inertia\Response
    {
        return \Inertia\Inertia::render('settings/Identitas', [
            'identitas' => Identitas::find(1),
        ]);
    }

    /**
     * Update the identity configuration.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'profesi' => ['required', 'string', 'max:100'],
            'tentang_saya' => ['nullable', 'string'],
            'foto_profil' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'cv_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // Max 5MB
        ]);

        $identitas = Identitas::findOrNew(1);
        $identitas->id = 1;
        $identitas->nama_lengkap = $request->nama_lengkap;
        $identitas->profesi = $request->profesi;
        $identitas->tentang_saya = $request->tentang_saya;

        if ($request->hasFile('foto_profil')) {
            // Delete old file if exists
            if ($identitas->foto_profil) {
                Storage::disk('public')->delete($identitas->foto_profil);
            }
            $identitas->foto_profil = $request->file('foto_profil')->store('identitas', 'public');
        }

        if ($request->hasFile('cv_file')) {
            // Delete old file if exists
            if ($identitas->cv_file) {
                Storage::disk('public')->delete($identitas->cv_file);
            }
            $identitas->cv_file = $request->file('cv_file')->store('cv_files', 'public');
        }

        $identitas->save();

        return redirect()->back()->with('status', 'Identitas berhasil diperbarui.');
    }
}
