@props(['projekt' => null])

<div class="space-y-6">
    <div>
        <x-input-label for="nev" value="Név" />
        <x-text-input id="nev" name="nev" type="text" class="mt-1 block w-full"
                      :value="old('nev', $projekt?->nev)" required autofocus />
        <x-input-error :messages="$errors->get('nev')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="leiras" value="Leírás" />
        <textarea id="leiras" name="leiras" rows="5"
                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">{{ old('leiras', $projekt?->leiras) }}</textarea>
        <x-input-error :messages="$errors->get('leiras')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="allapot" value="Állapot" />
            @php $aktualis = old('allapot', $projekt?->allapot ?? 'fuggoben'); @endphp
            <select id="allapot" name="allapot"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                <option value="fuggoben" @selected($aktualis === 'fuggoben')>Függőben</option>
                <option value="folyamatban" @selected($aktualis === 'folyamatban')>Folyamatban</option>
                <option value="kesz" @selected($aktualis === 'kesz')>Kész</option>
            </select>
            <x-input-error :messages="$errors->get('allapot')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="hatarido" value="Határidő" />
            <x-text-input id="hatarido" name="hatarido" type="date" class="mt-1 block w-full"
                          :value="old('hatarido', $projekt?->hatarido ? \Illuminate\Support\Carbon::parse($projekt->hatarido)->format('Y-m-d') : null)" />
            <x-input-error :messages="$errors->get('hatarido')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
        <x-primary-button>{{ $projekt ? 'Frissítés' : 'Létrehozás' }}</x-primary-button>
        <a href="{{ route('projektek.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Mégse</a>
    </div>
</div>
