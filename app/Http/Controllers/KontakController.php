<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('settings/Kontak', [
            'kontak' => Kontak::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'platform' => ['required', 'string', 'max:50'],
            'url' => ['required', 'string', 'max:255'],
            'ikon' => ['nullable', 'string', 'max:100'],
        ]);

        Kontak::create($request->all());

        return redirect()->back()->with('status', 'Kontak berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontak $kontak): RedirectResponse
    {
        $request->validate([
            'platform' => ['required', 'string', 'max:50'],
            'url' => ['required', 'string', 'max:255'],
            'ikon' => ['nullable', 'string', 'max:100'],
        ]);

        $kontak->update($request->all());

        return redirect()->back()->with('status', 'Kontak berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontak $kontak): RedirectResponse
    {
        $kontak->delete();

        return redirect()->back()->with('status', 'Kontak berhasil dihapus.');
    }
}
