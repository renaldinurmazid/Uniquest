<div style="animation: pageIn 0.4s ease forwards;">

    @if (session('status'))
        <div class="mb-6 p-4 rounded-xl flex items-center gap-3"
            style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.3);">
            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:#34d399;letter-spacing:0.05em;">
                {{ session('status') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 p-4 rounded-xl flex items-center gap-3"
            style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
            <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:#f87171;letter-spacing:0.05em;">
                {{ session('error') }}</p>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-8 rounded-full"
                    style="background:linear-gradient(to bottom,#f472b6,#db2777);box-shadow:0 0 12px rgba(244,114,182,0.7);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">STUDENT ANALYTICS</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">Monitor player progression and
                academy activity.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1 p-1 rounded-xl"
                style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                <button wire:click="$set('viewMode','grid')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                    style="{{ $viewMode === 'grid' ? 'background:rgba(124,58,237,0.5);color:#e2d9f3;' : 'color:rgba(167,139,250,0.4);' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </button>
                <button wire:click="$set('viewMode','table')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                    style="{{ $viewMode === 'table' ? 'background:rgba(124,58,237,0.5);color:#e2d9f3;' : 'color:rgba(167,139,250,0.4);' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </button>
            </div>
            <button wire:click="$set('showCreate', true)"
                class="btn-primary px-5 py-2.5 rounded-xl text-sm text-white flex items-center gap-2 font-bold"
                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                + ENROLL HERO
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ([['label' => 'TOTAL HEROES', 'value' => $stats['total'], 'color' => '#f472b6', 'border' => 'rgba(244,114,182,0.25)', 'sub' => 'enrolled'], ['label' => 'AVG. LEVEL', 'value' => $stats['avg_level'], 'color' => '#60a5fa', 'border' => 'rgba(59,130,246,0.25)', 'sub' => 'academy avg'], ['label' => 'TOTAL EXP', 'value' => $stats['total_exp'], 'color' => '#a78bfa', 'border' => 'rgba(124,58,237,0.25)', 'sub' => 'earned'], ['label' => 'TOTAL COINS', 'value' => 'B ' . $stats['total_coins'], 'color' => '#fbbf24', 'border' => 'rgba(245,158,11,0.25)', 'sub' => 'circulating']] as $s)
            <div class="stat-card rounded-xl p-5 inner-glow" style="border:1px solid {{ $s['border'] }};">
                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.6);">
                    {{ $s['label'] }}</p>
                <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.9rem;font-weight:700;color:{{ $s['color'] }};line-height:1.1;"
                    class="mt-1">{{ $s['value'] }}</h3>
                <p style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.35);letter-spacing:0.05em;"
                    class="mt-1">{{ $s['sub'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Search --}}
    <div class="relative mb-6">
        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4" style="color:rgba(167,139,250,0.4);"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name, email, or NPM..."
            class="w-full pl-11 pr-4 py-3 rounded-xl text-sm focus:outline-none search-input">
    </div>

    {{-- GRID VIEW --}}
    @if ($viewMode === 'grid')
        @php $cardColors = ['#a78bfa','#60a5fa','#34d399','#fbbf24','#f472b6','#fb923c']; @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse ($students as $student)
                @php
                    $level = $student->studentProfile?->level ?? 1;
                    $exp = $student->studentProfile?->current_exp ?? 0;
                    $coins = $student->studentProfile?->total_coins ?? 0;
                    $rank = $student->studentProfile?->rank_title;
                    $expPct = min(round(($exp / 5000) * 100), 100);
                    $color = $cardColors[$loop->index % count($cardColors)];
                    $avatar =
                        $student->avatar_url ??
                        'https://api.dicebear.com/7.x/bottts/svg?seed=' . $student->email . '&backgroundColor=1a1033';
                @endphp
                <div class="stat-card rounded-2xl overflow-hidden inner-glow group hover:scale-[1.02] transition-all duration-300"
                    style="border:1px solid {{ $color }}20;">
                    <div class="h-1"
                        style="background:linear-gradient(90deg,{{ $color }},{{ $color }}44);"></div>
                    <div class="p-5 space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="relative flex-shrink-0">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden"
                                        style="border:2px solid {{ $color }}40;background:rgba(124,58,237,0.12);">
                                        <img src="{{ $avatar }}" class="w-full h-full object-cover"
                                            alt="">
                                    </div>
                                    <div class="absolute -bottom-1.5 -right-1.5 w-6 h-6 rounded-lg flex items-center justify-center text-white"
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;font-weight:700;background:{{ $color }};border:2px solid #1a1033;box-shadow:0 0 8px {{ $color }}66;">
                                        {{ $level }}</div>
                                </div>
                                <div class="min-w-0">
                                    <p
                                        class="text-sm font-bold text-purple-100 truncate group-hover:text-white transition-colors">
                                        {{ $student->name }}</p>
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.1em;color:rgba(167,139,250,0.5);">
                                        {{ $student->studentProfile?->npm ?? 'N/A' }}</p>
                                    @if ($rank)
                                        <p
                                            style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.07em;color:{{ $color }};">
                                            {{ $rank }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <button wire:click="openEdit({{ $student->id }})"
                                    class="w-7 h-7 rounded-lg flex items-center justify-center transition-all hover:bg-violet-500/20"
                                    style="border:1px solid rgba(124,58,237,0.25);color:rgba(167,139,250,0.6);">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $student->id }})"
                                    class="w-7 h-7 rounded-lg flex items-center justify-center transition-all hover:bg-red-500/20"
                                    style="border:1px solid rgba(239,68,68,0.15);color:rgba(248,113,113,0.4);">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1.5">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:rgba(167,139,250,0.5);">EXP
                                    PROGRESSION</span>
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;font-weight:700;color:{{ $color }};">{{ number_format($exp) }}
                                    / 5000</span>
                            </div>
                            <div class="h-1.5 rounded-full" style="background:rgba(124,58,237,0.12);">
                                <div class="h-full rounded-full"
                                    style="width:{{ $expPct }}%;background:{{ $color }};box-shadow:0 0 6px {{ $color }}66;">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-1.5">
                            @forelse ($student->skills->take(3) as $skill)
                                @php $sc = $skill->color_hex ?? '#a78bfa'; @endphp
                                <div class="p-2 rounded-lg text-center"
                                    style="background:{{ $sc }}12;border:1px solid {{ $sc }}25;">
                                    <p style="font-family:'Rajdhani',sans-serif;font-size:8px;letter-spacing:0.08em;color:{{ $sc }};"
                                        class="truncate">{{ strtoupper(substr($ss->skill?->name ?? '-', 0, 4)) }}</p>
                                    <p style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:{{ $sc }};"
                                        class="mt-0.5">{{ $ss->points }}</p>
                                </div>
                            @empty
                                @foreach ([['STR', '#f472b6'], ['INT', '#60a5fa'], ['AGI', '#34d399']] as [$t, $tc])
                                    <div class="p-2 rounded-lg text-center"
                                        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.12);">
                                        <p
                                            style="font-family:'Rajdhani',sans-serif;font-size:8px;letter-spacing:0.08em;color:rgba(167,139,250,0.4);">
                                            {{ $t }}</p>
                                        <p style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:rgba(167,139,250,0.25);"
                                            class="mt-0.5">0</p>
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                        <div class="pt-3 flex items-center justify-between"
                            style="border-top:1px solid rgba(124,58,237,0.1);">
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:#fbbf24;">{{ number_format($coins) }}
                                coins</span>
                            <a href="#" class="px-3 py-1.5 rounded-lg text-xs font-bold hover:opacity-90"
                                style="background:{{ $color }}18;color:{{ $color }};font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid {{ $color }}30;">INSPECT</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 flex flex-col items-center justify-center">
                    <p
                        style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.12em;color:rgba(124,58,237,0.4);">
                        NO HEROES FOUND</p>
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $students->links() }}</div>

        {{-- TABLE VIEW --}}
    @else
        <div class="stat-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(124,58,237,0.15);">
                            @foreach (['HERO', 'NPM', 'RANK', 'LEVEL', 'EXP', 'COINS', 'SKILLS', 'ACTIONS'] as $col)
                                <th class="px-5 py-4 text-left"
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.5);">
                                    {{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php
                                $level = $student->studentProfile?->level ?? 1;
                                $exp = $student->studentProfile?->current_exp ?? 0;
                                $coins = $student->studentProfile?->total_coins ?? 0;
                                $rank = $student->studentProfile?->rank_title ?? '-';
                                $expPct = min(round(($exp / 5000) * 100), 100);
                                $avatar =
                                    $student->avatar_url ??
                                    'https://api.dicebear.com/7.x/bottts/svg?seed=' .
                                        $student->email .
                                        '&backgroundColor=1a1033';
                            @endphp
                            <tr class="group transition-colors hover:bg-violet-900/10"
                                style="border-bottom:1px solid rgba(124,58,237,0.08);">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg overflow-hidden flex-shrink-0"
                                            style="border:1px solid rgba(124,58,237,0.3);background:rgba(124,58,237,0.12);">
                                            <img src="{{ $avatar }}" class="w-full h-full object-cover"
                                                alt="">
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-semibold text-purple-100 group-hover:text-white transition-colors">
                                                {{ $student->name }}</p>
                                            <p
                                                style="font-size:11px;color:rgba(167,139,250,0.4);font-family:'Rajdhani',sans-serif;">
                                                {{ $student->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4"><span
                                        style="font-family:'Rajdhani',sans-serif;font-size:12px;color:rgba(167,139,250,0.7);">{{ $student->studentProfile?->npm ?? '-' }}</span>
                                </td>
                                <td class="px-5 py-4"><span
                                        style="font-family:'Rajdhani',sans-serif;font-size:11px;color:#a78bfa;">{{ $rank }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold"
                                        style="background:rgba(124,58,237,0.15);color:#a78bfa;font-family:'Rajdhani',sans-serif;border:1px solid rgba(124,58,237,0.25);">LVL
                                        {{ $level }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="w-28">
                                        <span
                                            style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.7);">{{ number_format($exp) }}</span>
                                        <div class="h-1.5 rounded-full mt-1" style="background:rgba(124,58,237,0.1);">
                                            <div class="h-full rounded-full"
                                                style="width:{{ $expPct }}%;background:linear-gradient(90deg,#7c3aed,#a78bfa);">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4"><span
                                        style="font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;color:#fbbf24;">{{ number_format($coins) }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex gap-1.5 flex-wrap">
                                        @forelse ($student->skills->take(3) as $skill)
                                            @php $sc = $skill->color_hex ?? '#a78bfa'; @endphp
                                            <span class="text-xs px-2 py-0.5 rounded-md"
                                                style="background:{{ $sc }}12;color:{{ $sc }};font-size:10px;border:1px solid {{ $sc }}25;">{{ $ss->skill?->name ?? '-' }}</span>
                                        @empty
                                            <span
                                                style="font-size:11px;color:rgba(124,58,237,0.35);font-style:italic;">NO
                                                SKILLS</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <button wire:click="openEdit({{ $student->id }})"
                                            class="p-2.5 rounded-xl transition-all text-violet-500 hover:text-violet-300"
                                            style="border:1px solid rgba(124,58,237,0.2);"
                                            onmouseover="this.style.background='rgba(124,58,237,0.15)'"
                                            onmouseout="this.style.background='transparent'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $student->id }})"
                                            class="p-2.5 rounded-xl transition-all text-red-500/50 hover:text-red-400"
                                            style="border:1px solid rgba(239,68,68,0.15);"
                                            onmouseover="this.style.background='rgba(239,68,68,0.1)'"
                                            onmouseout="this.style.background='transparent'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-24 text-center">
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.12em;color:rgba(124,58,237,0.4);">
                                        NO HEROES FOUND</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4" style="border-top:1px solid rgba(124,58,237,0.1);">{{ $students->links() }}</div>
        </div>
    @endif

    {{-- MODAL: CREATE --}}
    @if ($showCreate)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="closeAll" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-lg rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#f472b6,#a78bfa,#7c3aed);"></div>
                <div class="p-8 space-y-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-1.5 h-6 rounded-full"
                                    style="background:linear-gradient(to bottom,#f472b6,#a78bfa);"></div>
                                <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;letter-spacing:0.05em;"
                                    class="text-white">ENROLL NEW HERO</h2>
                            </div>
                            <p style="color:rgba(167,139,250,0.6);font-size:0.8rem;" class="ml-5">Create a new
                                student identity and system account.</p>
                        </div>
                        <button wire:click="closeAll"
                            class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form wire:submit="createStudent" class="space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                    class="block">HERO NAME *</label>
                                <input wire:model="name" type="text" placeholder="Full name..."
                                    class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                                @error('name')
                                    <span style="font-size:11px;color:#f87171;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                    class="block">NPM *</label>
                                <input wire:model="npm" type="text" placeholder="e.g. 2021001234"
                                    class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                                @error('npm')
                                    <span style="font-size:11px;color:#f87171;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">EMAIL *</label>
                            <input wire:model="email" type="email" placeholder="hero@campus.ac.id"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('email')
                                <span style="font-size:11px;color:#f87171;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">PASSWORD *</label>
                            <input wire:model="password" type="password" placeholder="Min. 6 characters..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('password')
                                <span style="font-size:11px;color:#f87171;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeAll"
                                class="flex-1 py-3 rounded-xl text-sm font-bold text-violet-400 hover:text-violet-200 hover:bg-violet-900/20 transition-all"
                                style="border:1px solid rgba(124,58,237,0.2);">CANCEL</button>
                            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white text-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">INITIATE HERO</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL: EDIT --}}
    @if ($showEdit)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="closeAll" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-lg rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#8b5cf6,#c4b5fd,#8b5cf6);"></div>
                <div class="p-8 space-y-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-6 rounded-full"
                                style="background:linear-gradient(to bottom,#c4b5fd,#8b5cf6);"></div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;letter-spacing:0.05em;"
                                class="text-white">EDIT HERO</h2>
                        </div>
                        <button wire:click="closeAll"
                            class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form wire:submit="updateStudent" class="space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                    class="block">HERO NAME *</label>
                                <input wire:model="editName" type="text"
                                    class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                                @error('editName')
                                    <span style="font-size:11px;color:#f87171;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                    class="block">NPM *</label>
                                <input wire:model="editNpm" type="text"
                                    class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                                @error('editNpm')
                                    <span style="font-size:11px;color:#f87171;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">EMAIL *</label>
                            <input wire:model="editEmail" type="email"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('editEmail')
                                <span style="font-size:11px;color:#f87171;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">NEW PASSWORD <span style="color:rgba(167,139,250,0.35);">— BLANK TO
                                    KEEP</span></label>
                            <input wire:model="editPassword" type="password"
                                placeholder="Leave blank to keep current..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('editPassword')
                                <span style="font-size:11px;color:#f87171;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeAll"
                                class="flex-1 py-3 rounded-xl text-sm font-bold text-violet-400 hover:text-violet-200 hover:bg-violet-900/20 transition-all"
                                style="border:1px solid rgba(124,58,237,0.2);">CANCEL</button>
                            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white text-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">SAVE CHANGES</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL: DELETE --}}
    @if ($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="closeAll" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-md rounded-2xl overflow-hidden z-10 text-center"
                x-show="true" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171,#ef4444);"></div>
                <div class="p-8 space-y-6">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto"
                        style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.3rem;font-weight:700;letter-spacing:0.05em;"
                            class="text-white mb-2">REMOVE HERO</h2>
                        <p style="color:rgba(167,139,250,0.6);font-size:0.875rem;line-height:1.6;">
                            Permanently remove <span class="text-white font-bold">{{ $deleteName }}</span> from the
                            academy? This cannot be undone.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" wire:click="closeAll"
                            class="flex-1 py-3 rounded-xl text-sm font-bold text-violet-400 hover:text-violet-200 hover:bg-violet-900/20 transition-all"
                            style="border:1px solid rgba(124,58,237,0.2);">ABORT</button>
                        <button wire:click="deleteStudent" type="button"
                            class="flex-1 py-3 rounded-xl text-sm font-bold text-white"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#b91c1c,#ef4444);border:1px solid #ef4444;">CONFIRM</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
