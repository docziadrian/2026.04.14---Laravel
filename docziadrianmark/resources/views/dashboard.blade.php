<x-app-layout>
    

    <div class="bg-surface text-on-surface">

        <section class="px-6 py-16 md:py-28 overflow-hidden">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-6 space-y-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-xs font-bold tracking-wider uppercase">
                        <span class="material-symbols-outlined text-[14px]">auto_awesome</span>
                        <span>Új korszak a projektkezelésben</span>
                    </div>
                    <h1 class="font-headline text-5xl md:text-7xl font-extrabold tracking-tight text-on-surface leading-[1.1]">
                        Szervezze projektjeit
                        <span class="text-gradient">könnyedén</span>
                    </h1>
                    <p class="text-lg md:text-xl text-on-surface-variant max-w-xl leading-relaxed">
A weboldal segítségével átláthatóan és hatékonyabban
                            dolgozhat. Felejtse el a káoszt, és kezelje
                            könnyedén projektjeit.                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('projektek.create') }}"
                           class="btn-primary-gradient text-white font-headline text-lg font-bold px-8 py-4 rounded-2xl shadow-xl shadow-primary/25 hover:shadow-2xl transition-all text-center">
                            Új projekt létrehozása
                        </a>
                        <a href="{{ route('projektek.index') }}"
                           class="flex items-center justify-center gap-2 font-headline text-lg font-bold px-8 py-4 text-primary border border-outline-variant/30 rounded-2xl hover:bg-surface-container-low transition-all">
                            <span class="material-symbols-outlined">play_circle</span>
                            Projektjeim
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-6 relative">
                    <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl shadow-slate-900/10 border border-surface-container-highest bg-surface-container-lowest p-6 transform lg:rotate-2 lg:translate-x-8">
                        @php
                            $sajatProjektek = auth()->user()->projects()->withCount('feladatok')->latest()->take(4)->get();
                            $osszesProjekt = auth()->user()->projects()->count();
                            $osszesFeladat = \App\Models\Feladat::whereHas('project', fn($q) => $q->where('felhasznalo_id', auth()->id()))->count();
                            $keszFeladat = \App\Models\Feladat::whereHas('project', fn($q) => $q->where('felhasznalo_id', auth()->id()))->where('kesz_van', true)->count();
                        @endphp
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="font-headline font-bold text-on-surface">Aktív projektek</h3>
                                <span class="text-xs text-on-surface-variant uppercase tracking-wider">{{ $osszesProjekt }} db</span>
                            </div>
                            @forelse ($sajatProjektek as $p)
                                <a href="{{ route('projektek.show', $p) }}" class="block p-4 rounded-xl bg-surface-container hover:bg-surface-container-high transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-primary">folder</span>
                                            <span class="font-semibold text-on-surface">{{ $p->nev }}</span>
                                        </div>
                                        <span class="text-xs text-on-surface-variant">{{ $p->feladatok_count }} feladat</span>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-on-surface-variant text-center py-6">Még nincs projekted.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10"></div>
                    <div class="absolute -bottom-12 -left-12 w-64 h-64 bg-secondary/10 rounded-full blur-3xl -z-10"></div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-container-highest">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-symbols-outlined text-primary">dashboard</span>
                        <p class="text-sm text-on-surface-variant uppercase tracking-wider">Projektek</p>
                    </div>
                    <p class="font-headline text-4xl font-bold text-on-surface">{{ $osszesProjekt }}</p>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-container-highest">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-symbols-outlined text-primary">checklist</span>
                        <p class="text-sm text-on-surface-variant uppercase tracking-wider">Feladatok</p>
                    </div>
                    <p class="font-headline text-4xl font-bold text-on-surface">{{ $osszesFeladat }}</p>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-container-highest">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-symbols-outlined text-primary">task_alt</span>
                        <p class="text-sm text-on-surface-variant uppercase tracking-wider">Kész</p>
                    </div>
                    <p class="font-headline text-4xl font-bold text-on-surface">{{ $keszFeladat }}</p>
                </div>
            </div>
        </section>

        <section class="bg-surface-container-low py-24 px-6 rounded-[3rem] mx-4" id="features">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="font-headline text-3xl md:text-5xl font-bold text-on-surface">
                        Minden, amire szüksége van
                    </h2>
                    <p class="text-on-surface-variant max-w-2xl mx-auto text-lg">
                        Intelligens eszközök, amelyekkel a csapat minden tagja szárnyalhat.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm border border-transparent hover:border-primary/10 transition-all group">
                        <div class="w-14 h-14 bg-blue-50 text-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">groups</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold mb-4">Csapatmunka</h3>
                        <p class="text-on-surface-variant leading-relaxed">
                            Valós idejű együttműködés, ahol mindenki látja a közös célt és a saját feladatait.
                        </p>
                    </div>
                    <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm border border-transparent hover:border-primary/10 transition-all group">
                        <div class="w-14 h-14 bg-blue-50 text-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold mb-4">Automatizálás</h3>
                        <p class="text-on-surface-variant leading-relaxed">
                            Szabaduljon meg a repetitív feladatoktól egyedi munkafolyamatokkal és értesítésekkel.
                        </p>
                    </div>
                    <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm border border-transparent hover:border-primary/10 transition-all group">
                        <div class="w-14 h-14 bg-blue-50 text-primary rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">analytics</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold mb-4">Riportok</h3>
                        <p class="text-on-surface-variant leading-relaxed">
                            Mélyreható elemzések a haladásról, az erőforrásokról és a határidők teljesüléséről.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-6" id="reviews">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-4">
                    <div class="space-y-4">
                        <h2 class="font-headline text-3xl md:text-5xl font-bold">Vélemények</h2>
                        <p class="text-on-surface-variant text-lg">Akik már velünk együtt építik a jövőt.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-surface p-10 rounded-2xl border border-surface-container-highest relative">
                        <p class="text-xl font-medium leading-relaxed mb-8 relative z-10 italic text-on-surface">
                            "A weboldal teljesen megváltoztatta a fejlesztési ciklusainkat. A kanban nézet és az automatizálások heti 10 órát spórolnak meg nekünk."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center font-headline font-bold text-primary">KP</div>
                            <div>
                                <h4 class="font-bold text-on-surface">Kovács Péter</h4>
                                <p class="text-sm text-on-surface-variant">CTO, TechFront Kft.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface p-10 rounded-2xl border border-surface-container-highest relative">
                        <p class="text-xl font-medium leading-relaxed mb-8 relative z-10 italic text-on-surface">
                            "Végre egy eszköz, ami nem csak funkcionális, de szép is. A csapatom imádja használni, ami a hatékonyságunkon is látszik."
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-tertiary-container flex items-center justify-center font-headline font-bold text-tertiary">NA</div>
                            <div>
                                <h4 class="font-bold text-on-surface">Nagy Anna</h4>
                                <p class="text-sm text-on-surface-variant">Project Manager, Creative Solutions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-6 bg-surface-container hidden" id="pricing">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-headline text-3xl md:text-5xl font-bold mb-4">Válassza a siker útját</h2>
                    <p class="text-on-surface-variant text-lg">Egyszerű árazás, rejtett költségek nélkül.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-surface-container-lowest p-8 rounded-2xl flex flex-col hover:scale-[1.02] transition-transform">
                        <h3 class="text-lg font-bold text-on-surface-variant uppercase tracking-widest mb-2">Ingyenes</h3>
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="text-4xl font-bold text-on-surface">0 Ft</span>
                            <span class="text-on-surface-variant">/hó</span>
                        </div>
                        <p class="text-sm text-on-surface-variant mb-8">Egyéni vállalkozóknak és kis projektekhez.</p>
                        <ul class="space-y-4 mb-10 flex-grow">
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>3 Projekt</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>Korlátlan feladat</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>Alap riportok</span>
                            </li>
                        </ul>
                        <button class="w-full py-4 px-6 rounded-xl border border-outline-variant/30 font-bold hover:bg-surface-container-low transition-colors">
                            Regisztráció
                        </button>
                    </div>
                    <div class="bg-surface-container-lowest p-8 rounded-2xl flex flex-col border-2 border-primary relative hover:scale-[1.02] transition-transform shadow-xl shadow-primary/5">
                        <div class="absolute top-0 right-8 -translate-y-1/2 bg-primary text-on-primary text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">
                            Legnépszerűbb
                        </div>
                        <h3 class="text-lg font-bold text-primary uppercase tracking-widest mb-2">Pro</h3>
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="text-4xl font-bold text-on-surface">3.900 Ft</span>
                            <span class="text-on-surface-variant">/hó</span>
                        </div>
                        <p class="text-sm text-on-surface-variant mb-8">Növekvő csapatoknak a maximális hatékonyságért.</p>
                        <ul class="space-y-4 mb-10 flex-grow">
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>Korlátlan projekt</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>Haladó automatizálások</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>Időmérés és büdzsé</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>Prioritásos ügyfélszolgálat</span>
                            </li>
                        </ul>
                        <button class="btn-primary-gradient w-full py-4 px-6 rounded-xl text-on-primary font-bold shadow-lg shadow-primary/20 transition-all">
                            Kezdje el most
                        </button>
                    </div>
                    <div class="bg-surface-container-lowest p-8 rounded-2xl flex flex-col hover:scale-[1.02] transition-transform">
                        <h3 class="text-lg font-bold text-on-surface-variant uppercase tracking-widest mb-2">Enterprise</h3>
                        <div class="flex items-baseline gap-1 mb-6">
                            <span class="text-4xl font-bold text-on-surface">Egyedi</span>
                        </div>
                        <p class="text-sm text-on-surface-variant mb-8">Nagyvállalatoknak, speciális igényekkel.</p>
                        <ul class="space-y-4 mb-10 flex-grow">
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>SSO és extra biztonság</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>Egyedi integrációk</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                                <span>Dedikált tanácsadó</span>
                            </li>
                        </ul>
                        <button class="w-full py-4 px-6 rounded-xl border border-outline-variant/30 font-bold hover:bg-surface-container-low transition-colors">
                            Kapcsolatfelvétel
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-slate-100 py-12 px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center max-w-7xl mx-auto">
                <div class="space-y-4">
                    <div class="text-lg font-black text-slate-800 uppercase tracking-tight">Weboldal</div>
                    <p class="font-body text-xs uppercase tracking-widest text-slate-500">
                        © {{ date('Y') }} Weboldal Kft. Minden jog fenntartva.
                    </p>
                </div>
                <div class="flex flex-wrap gap-8 md:justify-end font-body text-xs uppercase tracking-widest">
                    <a class="text-slate-500 hover:text-blue-500 transition-colors underline decoration-blue-500 underline-offset-4" href="#">Adatvédelem</a>
                    <a class="text-slate-500 hover:text-blue-500 transition-colors underline decoration-blue-500 underline-offset-4" href="#">Feltételek</a>
                    <a class="text-slate-500 hover:text-blue-500 transition-colors underline decoration-blue-500 underline-offset-4" href="#">Kapcsolat</a>
                    <a class="text-slate-500 hover:text-blue-500 transition-colors underline decoration-blue-500 underline-offset-4" href="#">Blog</a>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>
