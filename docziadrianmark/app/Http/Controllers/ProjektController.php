<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjektController extends Controller
{
    public function index(Request $keres): View
    {
        $projektek = Project::where('felhasznalo_id', $keres->user()->id)
            ->withCount('feladatok')
            ->latest()
            ->paginate(10);

        return view('projektek.index', compact('projektek'));
    }

    public function create(): View
    {
        return view('projektek.create');
    }

    public function store(Request $keres): RedirectResponse
    {
        $ervenyesitett = $keres->validate([
            'nev' => ['required', 'string', 'max:255'],
            'leiras' => ['nullable', 'string'],
            'allapot' => ['required', 'in:fuggoben,folyamatban,kesz'],
            'hatarido' => ['nullable', 'date'],
        ]);

        $ervenyesitett['felhasznalo_id'] = $keres->user()->id;

        Project::create($ervenyesitett);

        return redirect()->route('projektek.index')->with('uzenet', 'Projekt sikeresen létrehozva.');
    }

    public function show(Project $projekt, Request $keres): View
    {
        $this->jogosultsagEllenorzes($projekt);

        $projekt->load(['feladatok' => fn ($q) => $q->latest()]);

        $folyamatban = $projekt->feladatok->where('kesz_van', false)->values();
        $keszek      = $projekt->feladatok->where('kesz_van', true)->values();

        $kiemeltFeladatId = (int) $keres->query('feladat', 0) ?: null;

        return view('projektek.show', compact('projekt', 'folyamatban', 'keszek', 'kiemeltFeladatId'));
    }

    public function edit(Project $projekt): View
    {
        $this->jogosultsagEllenorzes($projekt);

        return view('projektek.edit', ['projekt' => $projekt]);
    }

    public function update(Request $keres, Project $projekt): RedirectResponse
    {
        $this->jogosultsagEllenorzes($projekt);

        $ervenyesitett = $keres->validate([
            'nev' => ['required', 'string', 'max:255'],
            'leiras' => ['nullable', 'string'],
            'allapot' => ['required', 'in:fuggoben,folyamatban,kesz'],
            'hatarido' => ['nullable', 'date'],
        ]);

        $projekt->update($ervenyesitett);

        return redirect()->route('projektek.index')->with('uzenet', 'Projekt sikeresen frissítve.');
    }

    public function destroy(Project $projekt): RedirectResponse
    {
        $this->jogosultsagEllenorzes($projekt);

        $projekt->delete();

        return redirect()->route('projektek.index')->with('uzenet', 'Projekt sikeresen törölve.');
    }

    private function jogosultsagEllenorzes(Project $projekt): void
    {
        abort_if($projekt->felhasznalo_id !== request()->user()->id, 403);
    }
}
