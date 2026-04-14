<?php

namespace App\Http\Controllers;

use App\Models\Feladat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeladatController extends Controller
{
    public function index(Request $keres): View
    {
        $projects = $keres->user()->projects;

        $feladatQuery = Feladat::whereHas('project', function ($query) use ($keres) {
            $query->where('felhasznalo_id', $keres->user()->id);
        });

        if ($keres->filled('project_id')) {
            $feladatQuery->where('project_id', $keres->input('project_id'));
        }

        if ($keres->filled('allapot')) {
            if ($keres->input('allapot') === 'kesz') {
                $feladatQuery->where('kesz_van', true);
            } elseif ($keres->input('allapot') === 'folyamatban') {
                $feladatQuery->where('kesz_van', false);
            }
        }

        $feladatok = $feladatQuery->latest()->paginate(10)->withQueryString();

        return view('feladatok.index', compact('feladatok', 'projects'));
    }

    public function create(Request $keres): View
    {
        $projects = $keres->user()->projects;
        return view('feladatok.create', compact('projects'));
    }

    public function store(Request $keres): RedirectResponse
    {
        $ervenyesitett = $keres->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'cim' => ['required', 'string', 'max:255'],
            'reszletek' => ['nullable', 'string'],
            'prioritas' => ['required', 'in:surgos,fontos,legyen kesz'],
            'hatarido' => ['nullable', 'date'],
        ]);

        $project = $keres->user()->projects()->findOrFail($ervenyesitett['project_id']);

        $project->feladatok()->create($ervenyesitett);

        return redirect()->route('feladatok.index')->with('uzenet', 'Feladat sikeresen létrehozva.');
    }

    public function show(Feladat $feladat): RedirectResponse
    {
        $this->jogosultsagEllenorzes($feladat);

        return redirect()->route('projektek.show', [
            'projekt' => $feladat->project_id,
            'feladat' => $feladat->id,
        ]);
    }

    public function allapot(Request $keres, Feladat $feladat): \Illuminate\Http\JsonResponse
    {
        $this->jogosultsagEllenorzes($feladat);

        $ervenyesitett = $keres->validate([
            'kesz_van' => ['required', 'boolean'],
        ]);

        $feladat->update(['kesz_van' => $ervenyesitett['kesz_van']]);

        return response()->json(['ok' => true]);
    }

    public function edit(Feladat $feladat): View
    {
        $this->jogosultsagEllenorzes($feladat);

        $projects = request()->user()->projects;

        return view('feladatok.edit', compact('feladat', 'projects'));
    }

    public function update(Request $keres, Feladat $feladat): RedirectResponse
    {
        $this->jogosultsagEllenorzes($feladat);

        $ervenyesitett = $keres->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'cim' => ['required', 'string', 'max:255'],
            'reszletek' => ['nullable', 'string'],
            'prioritas' => ['required', 'in:surgos,fontos,legyen kesz'],
            'kesz_van' => ['boolean'],
            'hatarido' => ['nullable', 'date'],
        ]);

        // ensure the user owns the new project
        $keres->user()->projects()->findOrFail($ervenyesitett['project_id']);

        $ervenyesitett['kesz_van'] = $keres->has('kesz_van');

        $feladat->update($ervenyesitett);

        return redirect()->route('feladatok.index')->with('uzenet', 'Feladat sikeresen frissítve.');
    }

    public function destroy(Feladat $feladat): RedirectResponse
    {
        $this->jogosultsagEllenorzes($feladat);

        $feladat->delete();

        return redirect()->route('feladatok.index')->with('uzenet', 'Feladat sikeresen törölve.');
    }

    private function jogosultsagEllenorzes(Feladat $feladat): void
    {
        abort_if($feladat->project->felhasznalo_id !== request()->user()->id, 403);
    }
}
