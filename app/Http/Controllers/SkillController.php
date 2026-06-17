<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('settings/Skill', [
            'skills' => Skill::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'urutan' => ['required', 'integer', 'min:0'],
            'status' => ['boolean'],
        ]);

        $exists = Skill::where('nama', $request->nama)
            ->where('status', true)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['nama' => 'Skill aktif dengan nama yang sama sudah ada.'])->withInput();
        }

        $data = $request->only(['nama', 'urutan', 'status']);
        $data['ikon'] = '';

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('skills', 'public');
        }

        Skill::create($data);

        return redirect()->back()->with('status', 'Skill berhasil ditambahkan.');
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'urutan' => ['required', 'integer', 'min:0'],
            'status' => ['boolean'],
        ]);

        $exists = Skill::where('nama', $request->nama)
            ->where('status', true)
            ->where('id', '!=', $skill->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['nama' => 'Skill aktif dengan nama yang sama sudah ada.'])->withInput();
        }

        $data = $request->only(['nama', 'urutan', 'status']);
        $data['ikon'] = $skill->ikon ?? '';

        if ($request->hasFile('gambar')) {
            if ($skill->gambar) {
                Storage::disk('public')->delete($skill->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('skills', 'public');
        }

        $skill->update($data);

        return redirect()->back()->with('status', 'Skill berhasil diperbarui.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        if ($skill->gambar) {
            Storage::disk('public')->delete($skill->gambar);
        }
        $skill->delete();

        return redirect()->back()->with('status', 'Skill berhasil dihapus.');
    }
}
