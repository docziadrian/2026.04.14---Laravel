<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feladatok listája') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-6">

                @if (session('uzenet'))
                    <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 text-sm">
                        {{ session('uzenet') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <p class="text-sm text-gray-600">Összesen: <span class="font-semibold text-gray-900">{{ $feladatok->total() }}</span> feladat</p>
                    <a href="{{ route('feladatok.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Új feladat
                    </a>
                </div>

                <!-- Szűrés -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <form method="GET" action="{{ route('feladatok.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                        <div class="w-full sm:w-1/3">
                            <label for="project_id" class="block text-sm font-medium text-gray-700 mb-1">Projekt</label>
                            <select name="project_id" id="project_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Összes projekt</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->nev }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <label for="allapot" class="block text-sm font-medium text-gray-700 mb-1">Állapot</label>
                            <select name="allapot" id="allapot" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Összes állapot</option>
                                <option value="folyamatban" {{ request('allapot') == 'folyamatban' ? 'selected' : '' }}>Folyamatban</option>
                                <option value="kesz" {{ request('allapot') == 'kesz' ? 'selected' : '' }}>Kész</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-auto flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Szűrés
                            </button>
                            @if(request()->hasAny(['project_id', 'allapot']))
                                <a href="{{ route('feladatok.index') }}" class="px-4 py-2 bg-red-50 border border-red-200 rounded-md shadow-sm text-sm font-medium text-red-700 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Törlés
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                @if ($feladatok->isEmpty())
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg">
                        <p class="text-gray-500">
                            @if(request()->hasAny(['project_id', 'allapot']))
                                Nincs a szűrésnek megfelelő feladat.
                            @else
                                Még nincs egyetlen feladat sem. Hozz létre egyet!
                            @endif
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cím</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Projekt</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prioritás</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Állapot</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Határidő</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Műveletek</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @php
                                    $prioritasSzinek = [
                                        'surgos' => 'bg-red-50 text-red-700 ring-red-200',
                                        'fontos' => 'bg-amber-50 text-amber-700 ring-amber-200',
                                        'legyen kesz' => 'bg-gray-50 text-gray-700 ring-gray-200',
                                    ];
                                    $prioritasCimkek = [
                                        'surgos' => 'Sürgős',
                                        'fontos' => 'Fontos',
                                        'legyen kesz' => 'Legyen kész',
                                    ];
                                @endphp
                                @foreach ($feladatok as $feladat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium {{ $feladat->kesz_van ? 'text-gray-400 line-through' : 'text-gray-900' }}">
                                            <a href="{{ route('feladatok.show', $feladat) }}" class="hover:text-indigo-600">
                                                {{ $feladat->cim }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                            <a href="{{ route('projektek.show', $feladat->project) }}" class="hover:text-indigo-600">
                                                {{ $feladat->project->nev }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full ring-1 ring-inset {{ $prioritasSzinek[$feladat->prioritas] }}">
                                                {{ $prioritasCimkek[$feladat->prioritas] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($feladat->kesz_van)
                                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full ring-1 ring-inset bg-emerald-50 text-emerald-700 ring-emerald-200">Kész</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full ring-1 ring-inset bg-sky-50 text-sky-700 ring-sky-200">Folyamatban</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ $feladat->hatarido ? \Illuminate\Support\Carbon::parse($feladat->hatarido)->format('Y-m-d') : '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                            <a href="{{ route('feladatok.edit', $feladat) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Szerkesztés</a>
                                            <form action="{{ route('feladatok.destroy', $feladat) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Törlés</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $feladatok->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
