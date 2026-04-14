<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projektek listája') }}
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
                    <p class="text-sm text-gray-600">Összesen: <span class="font-semibold text-gray-900">{{ $projektek->total() }}</span> projekt</p>
                    <a href="{{ route('projektek.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Új projekt
                    </a>
                </div>

                @if ($projektek->isEmpty())
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg">
                        <p class="text-gray-500">Még nincs egyetlen projekt sem. Hozz létre egyet!</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Név</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Állapot</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Feladatok</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Határidő</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Műveletek</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @php
                                    $allapotSzinek = [
                                        'fuggoben' => 'bg-amber-50 text-amber-700 ring-amber-200',
                                        'folyamatban' => 'bg-sky-50 text-sky-700 ring-sky-200',
                                        'kesz' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                    ];
                                    $allapotCimkek = [
                                        'fuggoben' => 'Függőben',
                                        'folyamatban' => 'Folyamatban',
                                        'kesz' => 'Kész',
                                    ];
                                @endphp
                                @foreach ($projektek as $projekt)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            <a href="{{ route('projektek.show', $projekt) }}" class="hover:text-indigo-600">
                                                {{ $projekt->nev }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full ring-1 ring-inset {{ $allapotSzinek[$projekt->allapot] }}">
                                                {{ $allapotCimkek[$projekt->allapot] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $projekt->feladatok_count }} db</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                            {{ $projekt->hatarido ? \Illuminate\Support\Carbon::parse($projekt->hatarido)->format('Y-m-d') : '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                            <a href="{{ route('projektek.edit', $projekt) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Szerkesztés</a>
                                            <form action="{{ route('projektek.destroy', $projekt) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd? Az összes kapcsolódó feladat is törlődik.');">
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
                        {{ $projektek->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
