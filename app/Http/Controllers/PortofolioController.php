<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PortofolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('settings/Portofolio', [
            'portofolio' => Portofolio::orderBy('dibuat_pada', 'desc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul_proyek' => ['required', 'string', 'max:150'],
            'thumbnail' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'deskripsi_singkat' => ['required', 'string', 'max:255'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'link_eksternal' => ['nullable', 'string', 'max:255'],
            'tools' => ['nullable', 'string'],
        ]);

        $data = $request->only(['judul_proyek', 'deskripsi_singkat', 'deskripsi_lengkap', 'link_eksternal']);

        if ($request->filled('tools')) {
            $data['tools'] = array_map('trim', explode(',', $request->input('tools')));
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('portfolio', 'public');
        }

        Portofolio::create($data);

        return redirect()->back()->with('status', 'Proyek portofolio berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portofolio $portofolio): RedirectResponse
    {
        $request->validate([
            'judul_proyek' => ['required', 'string', 'max:150'],
            'thumbnail' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'deskripsi_singkat' => ['required', 'string', 'max:255'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'link_eksternal' => ['nullable', 'string', 'max:255'],
            'tools' => ['nullable', 'string'],
        ]);

        $data = $request->only(['judul_proyek', 'deskripsi_singkat', 'deskripsi_lengkap', 'link_eksternal']);

        if ($request->filled('tools')) {
            $data['tools'] = array_map('trim', explode(',', $request->input('tools')));
        } else {
            $data['tools'] = [];
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old file if exists
            if ($portofolio->thumbnail) {
                Storage::disk('public')->delete($portofolio->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('portfolio', 'public');
        }

        $portofolio->update($data);

        return redirect()->back()->with('status', 'Proyek portofolio berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portofolio $portofolio): RedirectResponse
    {
        if ($portofolio->thumbnail) {
            Storage::disk('public')->delete($portofolio->thumbnail);
        }
        $portofolio->delete();

        return redirect()->back()->with('status', 'Proyek portofolio berhasil dihapus.');
    }
}
