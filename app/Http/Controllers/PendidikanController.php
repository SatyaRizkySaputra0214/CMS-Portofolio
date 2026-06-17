<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('settings/Pendidikan', [
            'pendidikan' => Pendidikan::orderBy('tahun_mulai', 'desc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'institusi' => ['required', 'string', 'max:150'],
            'gelar_jurusan' => ['required', 'string', 'max:100'],
            'tahun_mulai' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 5)],
            'tahun_selesai' => ['nullable', 'integer', 'min:1900', 'max:'.(date('Y') + 10), 'gte:tahun_mulai'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Pendidikan::create($request->all());

        return redirect()->back()->with('status', 'Pendidikan berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendidikan $pendidikan): RedirectResponse
    {
        $request->validate([
            'institusi' => ['required', 'string', 'max:150'],
            'gelar_jurusan' => ['required', 'string', 'max:100'],
            'tahun_mulai' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 5)],
            'tahun_selesai' => ['nullable', 'integer', 'min:1900', 'max:'.(date('Y') + 10), 'gte:tahun_mulai'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $pendidikan->update($request->all());

        return redirect()->back()->with('status', 'Pendidikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendidikan $pendidikan): RedirectResponse
    {
        $pendidikan->delete();

        return redirect()->back()->with('status', 'Pendidikan berhasil dihapus.');
    }
}
