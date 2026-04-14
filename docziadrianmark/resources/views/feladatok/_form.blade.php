@props(['feladat' => null, 'projects' => collect()])

<div class="space-y-6">
    <div>
        <x-input-label for="project_id" value="Projekt" />
        <select id="project_id" name="project_id"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
            @php $aktProj = old('project_id', $feladat?->project_id); @endphp
            <option value="">— Válassz projektet —</option>
            @foreach ($projects as $p)
                <option value="{{ $p->id }}" @selected((int) $aktProj === $p->id)>{{ $p->nev }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
        @if ($projects->isEmpty())
            <p class="mt-2 text-xs text-amber-600">Előbb hozz létre egy <a href="{{ route('projektek.create') }}" class="underline">projektet</a>.</p>
        @endif
    </div>

    <div>
        <x-input-label for="cim" value="Cím" />
        <x-text-input id="cim" name="cim" type="text" class="mt-1 block w-full"
                      :value="old('cim', $feladat?->cim)" required />
        <x-input-error :messages="$errors->get('cim')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="reszletek" value="Részletek" />
        <textarea id="reszletek" name="reszletek" rows="5"
                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">{{ old('reszletek', $feladat?->reszletek) }}</textarea>
        <x-input-error :messages="$errors->get('reszletek')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="prioritas" value="Prioritás" />
            @php $aktPri = old('prioritas', $feladat?->prioritas ?? 'legyen kesz'); @endphp
            <select id="prioritas" name="prioritas"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                <option value="surgos" @selected($aktPri === 'surgos')>Sürgős</option>
                <option value="fontos" @selected($aktPri === 'fontos')>Fontos</option>
                <option value="legyen kesz" @selected($aktPri === 'legyen kesz')>Legyen kész</option>
            </select>
            <x-input-error :messages="$errors->get('prioritas')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="hatarido" value="Határidő" />
            <x-text-input id="hatarido" name="hatarido" type="date" class="mt-1 block w-full"
                          :value="old('hatarido', $feladat?->hatarido ? \Illuminate\Support\Carbon::parse($feladat->hatarido)->format('Y-m-d') : null)" />
            <x-input-error :messages="$errors->get('hatarido')" class="mt-2" />
        </div>
    </div>

    @if ($feladat)
        <div class="flex items-center">
            <input type="hidden" name="kesz_van" value="0">
            <input id="kesz_van" name="kesz_van" type="checkbox" value="1"
                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                   @checked(old('kesz_van', $feladat->kesz_van)) />
            <label for="kesz_van" class="ml-2 text-sm text-gray-700">Kész van</label>
        </div>
    @endif

    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
        <x-primary-button>{{ $feladat ? 'Frissítés' : 'Létrehozás' }}</x-primary-button>
        <a href="{{ route('feladatok.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Mégse</a>
    </div>
</div>
