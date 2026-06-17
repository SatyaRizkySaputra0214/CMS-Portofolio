<?php

namespace App\Http\Controllers;

use App\Models\Pengalaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PengalamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('settings/Pengalaman', [
            'pengalaman' => Pengalaman::orderBy('tanggal_mulai', 'desc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kategori' => ['required', 'in:Organisasi,Magang,Kerja'],
            'posisi' => ['required', 'string', 'max:100'],
            'nama_instansi' => ['required', 'string', 'max:150'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Pengalaman::create($request->all());

        return redirect()->back()->with('status', 'Pengalaman berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengalaman $pengalaman): RedirectResponse
    {
        $request->validate([
            'kategori' => ['required', 'in:Organisasi,Magang,Kerja'],
            'posisi' => ['required', 'string', 'max:100'],
            'nama_instansi' => ['required', 'string', 'max:150'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $pengalaman->update($request->all());

        return redirect()->back()->with('status', 'Pengalaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengalaman $pengalaman): RedirectResponse
    {
        $pengalaman->delete();

        return redirect()->back()->with('status', 'Pengalaman berhasil dihapus.');
    }
}
