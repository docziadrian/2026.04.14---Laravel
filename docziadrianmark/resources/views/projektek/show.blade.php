@php
    $prioritasCimkek = [
        'surgos' => 'Sürgős',
        'fontos' => 'Fontos',
        'legyen kesz' => 'Legyen kész',
    ];
    $prioritasSzinek = [
        'surgos' => 'bg-red-50 text-red-700',
        'fontos' => 'bg-amber-50 text-amber-700',
        'legyen kesz' => 'bg-slate-100 text-slate-700',
    ];
    $allapotCimkek = [
        'fuggoben' => 'Függőben',
        'folyamatban' => 'Folyamatban',
        'kesz' => 'Kész',
    ];
    $allapotSzinek = [
        'fuggoben' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'folyamatban' => 'bg-sky-50 text-sky-700 ring-sky-200',
        'kesz' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
    ];

    $oszlopok = [
        ['kulcs' => 'folyamatban', 'cim' => 'Folyamatban', 'feladatok' => $folyamatban, 'kesz' => false],
        ['kulcs' => 'kesz',        'cim' => 'Kész',        'feladatok' => $keszek,      'kesz' => true],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $projekt->nev }} — Tábla</h2>
    </x-slot>

    <main class="pt-8 pb-12 px-6 max-w-7xl mx-auto">
        <div class="mb-10">
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                <a href="{{ route('projektek.index') }}" class="font-medium hover:text-slate-700">Projektek</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="font-medium text-slate-700">{{ $projekt->nev }}</span>
            </div>
            <div class="flex justify-between items-end gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-4xl font-extrabold tracking-tight text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $projekt->nev }}
                        </h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full ring-1 ring-inset {{ $allapotSzinek[$projekt->allapot] }}">
                            {{ $allapotCimkek[$projekt->allapot] }}
                        </span>
                    </div>
                    <p class="text-slate-500 max-w-2xl whitespace-pre-line">
                        {{ $projekt->leiras ?? 'Nincs leírás.' }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('projektek.edit', $projekt) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-blue-700">
                        <span class="material-symbols-outlined text-base">edit</span>
                        Projekt szerkesztése
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="scrum-board">
            @foreach ($oszlopok as $oszlop)
                <div class="bg-slate-100 rounded-xl p-4 min-h-[600px] flex flex-col"
                     data-column
                     data-allapot="{{ $oszlop['kulcs'] }}"
                     data-kesz="{{ $oszlop['kesz'] ? '1' : '0' }}">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $oszlop['cim'] }}
                            </h2>
                            <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-bold" data-counter>
                                {{ $oszlop['feladatok']->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow space-y-4" data-column-body>
                        @foreach ($oszlop['feladatok'] as $f)
                            @php $kiemelt = $kiemeltFeladatId === $f->id; @endphp
                            <div data-card
                                 id="feladat-{{ $f->id }}"
                                 data-feladat-id="{{ $f->id }}"
                                 class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all group {{ $kiemelt ? 'ring-2 ring-blue-500' : '' }} {{ $f->kesz_van ? 'opacity-75' : '' }}">
                                <div data-card-handle class="cursor-grab active:cursor-grabbing">
                                    <div class="flex justify-between items-start mb-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $prioritasSzinek[$f->prioritas] }}">
                                            {{ $prioritasCimkek[$f->prioritas] }}
                                        </span>
                                        @if ($f->kesz_van)
                                            <span class="material-symbols-outlined text-blue-600 text-xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        @endif
                                    </div>
                                    <h3 class="font-bold text-slate-900 mb-2 leading-snug {{ $f->kesz_van ? 'line-through decoration-slate-400' : '' }}" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        {{ $f->cim }}
                                    </h3>
                                </div>

                                <button type="button"
                                        data-toggle-details
                                        aria-expanded="{{ $kiemelt ? 'true' : 'false' }}"
                                        class="mt-2 w-full flex items-center justify-between gap-2 text-xs font-semibold text-blue-600 hover:text-blue-800 py-1">
                                    <span>Részletek</span>
                                    <span data-chevron class="material-symbols-outlined text-base transition-transform {{ $kiemelt ? 'rotate-180' : '' }}">expand_more</span>
                                </button>

                                <div data-details class="overflow-hidden transition-all {{ $kiemelt ? '' : 'hidden' }}">
                                    <div class="pt-3 border-t border-slate-100 space-y-3 text-sm">
                                        <div>
                                            <p class="text-slate-500 text-xs uppercase tracking-wider">Részletek</p>
                                            <p class="text-slate-700 whitespace-pre-line">{{ $f->reszletek ?? 'Nincs részlet megadva.' }}</p>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <p class="text-slate-500 text-xs uppercase tracking-wider">Állapot</p>
                                                <p class="font-medium text-slate-900">{{ $f->kesz_van ? 'Kész' : 'Folyamatban' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-slate-500 text-xs uppercase tracking-wider">Határidő</p>
                                                <p class="font-medium text-slate-900">
                                                    {{ $f->hatarido ? \Illuminate\Support\Carbon::parse($f->hatarido)->format('Y-m-d') : '—' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 pt-2">
                                            <a href="{{ route('feladatok.edit', $f) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700">
                                                <span class="material-symbols-outlined text-sm">edit</span>
                                                Szerkesztés
                                            </a>
                                            <form method="POST" action="{{ route('feladatok.destroy', $f) }}"
                                                  onsubmit="return confirm('Biztosan törlöd?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-100">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                    Törlés
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('feladatok.create') }}"
                       class="mt-4 w-full flex items-center justify-center gap-2 py-3 rounded-xl border-2 border-dashed border-slate-300 text-slate-500 text-sm font-semibold hover:bg-white hover:border-blue-400 hover:text-blue-600 transition-all">
                        <span class="material-symbols-outlined text-xl">add</span>
                        <span>Új feladat</span>
                    </a>
                </div>
            @endforeach

            <div class="hidden lg:flex flex-col gap-8">
                @php
                    $osszes = $folyamatban->count() + $keszek->count();
                    $arany = $osszes > 0 ? round(($keszek->count() / $osszes) * 100) : 0;
                @endphp
                <div class="bg-white border border-slate-200 rounded-xl p-6">
                    <h3 class="font-bold text-slate-900 mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">Projekt info</h3>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-slate-500">Határidő</dt>
                            <dd class="font-medium text-slate-900">
                                {{ $projekt->hatarido ? \Illuminate\Support\Carbon::parse($projekt->hatarido)->format('Y-m-d') : '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Létrehozva</dt>
                            <dd class="font-medium text-slate-900">{{ $projekt->created_at->format('Y-m-d') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6">
                    <h3 class="font-bold text-blue-700 mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">Sprint statisztika</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Befejezett feladatok</span>
                            <span class="font-bold text-slate-900 " id="stat-percent">{{ $arany }}%</span>
                        </div>
                        <div class="w-full bg-blue-100 h-2 rounded-sm overflow-hidden">
                            <div class="bg-blue-600 h-full transition-all" style="width: {{ $arany }}%" id="stat-bar"></div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('projektek.index') }}" class="text-slate-500 hover:text-slate-900 text-sm self-start">← Vissza a listához</a>
            </div>
        </div>

        <div id="dnd-toast" class="fixed bottom-6 right-6 bg-slate-900 text-white text-sm px-4 py-2 rounded-lg shadow-lg opacity-0 translate-y-2 transition-all pointer-events-none">
            Mentve
        </div>
    </main>

    <script type="module">
        import { draggable, dropTargetForElements } from 'https://esm.sh/@atlaskit/pragmatic-drag-and-drop@1.4.0/element/adapter';

        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const toast = document.getElementById('dnd-toast');
        const board = document.getElementById('scrum-board');

        const showToast = (msg, ok = true) => {
            toast.textContent = msg;
            toast.classList.toggle('bg-red-600', !ok);
            toast.classList.toggle('bg-slate-900', ok);
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(8px)';
            }, 1500);
        };

        const updateCounters = () => {
            board.querySelectorAll('[data-column]').forEach(col => {
                col.querySelector('[data-counter]').textContent = col.querySelectorAll('[data-card]').length;
            });
            const folyN = board.querySelector('[data-allapot="folyamatban"]').querySelectorAll('[data-card]').length;
            const keszN = board.querySelector('[data-allapot="kesz"]').querySelectorAll('[data-card]').length;
            const total = folyN + keszN;
            const pct = total > 0 ? Math.round((keszN / total) * 100) : 0;
            document.getElementById('stat-percent').textContent = pct + '%';
            document.getElementById('stat-bar').style.width = pct + '%';
        };

        const refreshCardStyle = (card, kesz) => {
            const title = card.querySelector('h3');
            if (kesz) {
                card.classList.add('opacity-75');
                title?.classList.add('line-through', 'decoration-slate-400');
            } else {
                card.classList.remove('opacity-75');
                title?.classList.remove('line-through', 'decoration-slate-400');
            }
        };

        const persist = async (id, kesz) => {
            try {
                const res = await fetch(`/feladatok/${id}/allapot`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ kesz_van: kesz }),
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                showToast('Mentve');
            } catch (e) {
                showToast('Hiba mentéskor', false);
            }
        };

        board.querySelectorAll('[data-card]').forEach(card => {
            const handle = card.querySelector('[data-card-handle]') ?? card;
            draggable({
                element: card,
                dragHandle: handle,
                getInitialData: () => ({ feladatId: card.dataset.feladatId }),
                onDragStart: () => card.classList.add('opacity-40'),
                onDrop: () => card.classList.remove('opacity-40'),
            });
        });

        board.querySelectorAll('[data-column]').forEach(col => {
            const body = col.querySelector('[data-column-body]');
            dropTargetForElements({
                element: col,
                getData: () => ({ allapot: col.dataset.allapot, kesz: col.dataset.kesz === '1' }),
                onDragEnter: () => col.classList.add('ring-2', 'ring-blue-400'),
                onDragLeave: () => col.classList.remove('ring-2', 'ring-blue-400'),
                onDrop: ({ source }) => {
                    col.classList.remove('ring-2', 'ring-blue-400');
                    const id = source.data.feladatId;
                    const card = board.querySelector(`[data-card][data-feladat-id="${id}"]`);
                    if (!card || card.parentElement === body) return;
                    body.appendChild(card);
                    const kesz = col.dataset.kesz === '1';
                    refreshCardStyle(card, kesz);
                    updateCounters();
                    persist(id, kesz);
                },
            });
        });

        board.querySelectorAll('[data-toggle-details]').forEach(btn => {
            btn.addEventListener('click', () => {
                const card = btn.closest('[data-card]');
                const panel = card.querySelector('[data-details]');
                const chev = btn.querySelector('[data-chevron]');
                const open = panel.classList.toggle('hidden') === false;
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                chev.classList.toggle('rotate-180', open);
            });
        });

        const params = new URLSearchParams(window.location.search);
        const highlight = params.get('feladat');
        if (highlight) {
            const target = document.getElementById('feladat-' + highlight);
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>
</x-app-layout>
