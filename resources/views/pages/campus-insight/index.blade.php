<div style="animation: pageIn 0.4s ease forwards;" x-data="{ tab: '{{ $activeTab }}' }">

    {{-- ─── Page Header ─────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-8 rounded-full"
                    style="background:linear-gradient(to bottom,#34d399,#059669);box-shadow:0 0 12px rgba(52,211,153,0.7);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">CAMPUS INSIGHT</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">
                Data intelligence dashboard — monitor activity, trends, and performance across the academy.
            </p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Period Filter --}}
            <div class="flex gap-1 p-1 rounded-xl"
                style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                @foreach (['weekly' => 'WEEK', 'monthly' => 'MONTH', 'semester' => 'SEMESTER'] as $key => $label)
                    <button wire:click="$set('periodFilter','{{ $key }}')"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all"
                        style="font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;
                            {{ $periodFilter === $key
                                ? 'background:rgba(124,58,237,0.55);color:#e2d9f3;border:1px solid rgba(167,139,250,0.35);'
                                : 'color:rgba(167,139,250,0.45);border:1px solid transparent;' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Loading overlay saat period berubah --}}
    <div wire:loading wire:target="periodFilter" class="fixed inset-0 z-40 flex items-center justify-center"
        style="background:rgba(6,4,16,0.7);backdrop-filter:blur(4px);">
        <div class="flex flex-col items-center gap-3">
            <div class="w-10 h-10 rounded-full border-2 border-violet-500 border-t-transparent animate-spin"></div>
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:0.1em;color:rgba(167,139,250,0.7);">
                LOADING DATA...
            </p>
        </div>
    </div>

    {{-- ─── KPI Row ──────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $kpis = [
                [
                    'label' => 'ACTIVE STUDENTS',
                    'value' => number_format($activeStudents),
                    'color' => '#60a5fa',
                    'border' => 'rgba(59,130,246,0.25)',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                ],
                [
                    'label' => 'QUESTS COMPLETED',
                    'value' => number_format($questsCompleted),
                    'color' => '#34d399',
                    'border' => 'rgba(16,185,129,0.25)',
                    'delta' => ($questDelta >= 0 ? '+' : '') . $questDelta . '%',
                    'up' => $questDelta >= 0,
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
                ],
                [
                    'label' => 'TOTAL XP EARNED',
                    'value' => $totalXp >= 1000 ? round($totalXp / 1000, 1) . 'k' : number_format($totalXp),
                    'color' => '#a78bfa',
                    'border' => 'rgba(124,58,237,0.25)',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                ],
                [
                    'label' => 'COINS CIRCULATING',
                    'value' =>
                        '₿ ' .
                        ($coinsCirculating >= 1000
                            ? round($coinsCirculating / 1000, 1) . 'k'
                            : number_format($coinsCirculating)),
                    'color' => '#fbbf24',
                    'border' => 'rgba(245,158,11,0.25)',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ],
            ];
        @endphp
        @foreach ($kpis as $k)
            <div class="stat-card rounded-xl p-5" style="border:1px solid {{ $k['border'] }};">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                        style="background:{{ $k['color'] }}18;border:1px solid {{ $k['color'] }}30;">
                        <svg class="w-5 h-5" style="color:{{ $k['color'] }};" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            {!! $k['icon'] !!}
                        </svg>
                    </div>
                    @if (isset($k['delta']))
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;
                                {{ $k['up']
                                    ? 'background:rgba(16,185,129,0.12);color:#34d399;border:1px solid rgba(16,185,129,0.25);'
                                    : 'background:rgba(239,68,68,0.1);color:#f87171;border:1px solid rgba(239,68,68,0.2);' }}">
                            {{ $k['delta'] }}
                        </span>
                    @endif
                </div>
                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.6);">
                    {{ $k['label'] }}
                </p>
                <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.9rem;font-weight:700;color:{{ $k['color'] }};line-height:1.1;"
                    class="mt-1">
                    {{ $k['value'] }}
                </h3>
            </div>
        @endforeach
    </div>

    {{-- ─── Tab Nav — Alpine instant ──────────────────── --}}
    <div class="flex gap-1 mb-6 p-1 rounded-xl w-fit"
        style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
        @foreach ([['key' => 'overview', 'label' => 'OVERVIEW', 'icon' => '📊'], ['key' => 'quests', 'label' => 'QUESTS', 'icon' => '⚔️'], ['key' => 'students', 'label' => 'STUDENTS', 'icon' => '🎓'], ['key' => 'economy', 'label' => 'ECONOMY', 'icon' => '💎']] as $t)
            <button @click="tab = '{{ $t['key'] }}'"
                class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition-all"
                :style="tab === '{{ $t['key'] }}'
                    ?
                    'background:rgba(124,58,237,0.6);color:#e2d9f3;border:1px solid rgba(167,139,250,0.4);' :
                    'color:rgba(167,139,250,0.5);border:1px solid transparent;'"
                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;">
                <span>{{ $t['icon'] }}</span>{{ $t['label'] }}
            </button>
        @endforeach
    </div>


    {{-- ══════════════════════════ TAB: OVERVIEW ══════════════════════════ --}}
    <div x-show="tab === 'overview'" x-cloak>
        @php
            $trendMax = max(collect($trendMonths)->max('participants'), collect($trendMonths)->max('completions'), 1);
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

            {{-- Participation Trend --}}
            <div class="lg:col-span-2 stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5 flex items-center justify-between"
                    style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">PARTICIPATION TREND</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full" style="background:#a78bfa;"></div>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.6);">REGISTRATIONS</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full" style="background:#34d399;"></div>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.6);">ATTENDED</span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="relative" style="height:180px;">
                        @foreach ([0, 25, 50, 75, 100] as $pct)
                            <div class="absolute left-0 right-0 flex items-center gap-2"
                                style="bottom:{{ $pct }}%;height:1px;">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.3);width:32px;text-align:right;flex-shrink:0;">
                                    {{ round(($trendMax * $pct) / 100) }}
                                </span>
                                <div class="flex-1 border-t" style="border-color:rgba(124,58,237,0.08);"></div>
                            </div>
                        @endforeach
                        <div class="absolute inset-0 pl-10 flex items-end gap-1.5">
                            @foreach ($trendMonths as $i => $m)
                                @php
                                    $pH = $trendMax > 0 ? round(($m['participants'] / $trendMax) * 100) : 0;
                                    $cH = $trendMax > 0 ? round(($m['completions'] / $trendMax) * 100) : 0;
                                    $isLast = $i === count($trendMonths) - 1;
                                @endphp
                                <div class="flex-1 flex flex-col items-center gap-0" style="height:100%;">
                                    <div class="w-full flex items-end justify-center gap-0.5 flex-1">
                                        <div class="w-2/5 rounded-t-sm transition-all"
                                            style="height:{{ $pH }}%;{{ $isLast ? 'background:linear-gradient(to top,#7c3aed,#a78bfa);box-shadow:0 0 8px rgba(124,58,237,0.5);' : 'background:rgba(124,58,237,0.3);' }}">
                                        </div>
                                        <div class="w-2/5 rounded-t-sm transition-all"
                                            style="height:{{ $cH }}%;{{ $isLast ? 'background:linear-gradient(to top,#059669,#34d399);box-shadow:0 0 8px rgba(16,185,129,0.5);' : 'background:rgba(16,185,129,0.2);' }}">
                                        </div>
                                    </div>
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:8px;color:rgba(167,139,250,0.4);margin-top:4px;">{{ $m['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-5 grid grid-cols-3 gap-4 pt-4" style="border-top:1px solid rgba(124,58,237,0.1);">
                        @php $lastMonth = last($trendMonths); @endphp
                        @foreach ([['label' => 'REGISTRATIONS', 'value' => number_format($lastMonth['participants']), 'color' => '#a78bfa'], ['label' => 'ATTENDED', 'value' => number_format($lastMonth['completions']), 'color' => '#34d399'], ['label' => 'RATE', 'value' => ($lastMonth['participants'] > 0 ? round(($lastMonth['completions'] / $lastMonth['participants']) * 100) : 0) . '%', 'color' => '#fbbf24']] as $s)
                            <div>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:rgba(167,139,250,0.4);">
                                    {{ $s['label'] }}</p>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;color:{{ $s['color'] }};">
                                    {{ $s['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Interest Heatmap by event category --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-5 py-4" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#fbbf24,#d97706);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:0.9rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">INTEREST HEATMAP</h2>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    @php
                        $catColors = [
                            'academic' => '#a78bfa',
                            'non-academic' => '#60a5fa',
                            'volunteer' => '#34d399',
                            'other' => '#fb923c',
                        ];
                    @endphp
                    @forelse($categoryStats as $cat)
                        @php
                            $pct = $catMax > 0 ? round(($cat['total'] / $catMax) * 100) : 0;
                            $cColor = $catColors[strtolower(str_replace(' ', '-', $cat['name']))] ?? '#a78bfa';
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.06em;color:rgba(167,139,250,0.75);">
                                    {{ strtoupper($cat['name']) }}
                                </span>
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;font-weight:700;color:{{ $cColor }};">
                                    {{ $pct }}% · {{ $cat['total'] }}
                                </span>
                            </div>
                            <div class="h-2 rounded-full" style="background:rgba(124,58,237,0.1);">
                                <div class="h-full rounded-full"
                                    style="width:{{ $pct }}%;background:{{ $cColor }};box-shadow:0 0 6px {{ $cColor }}55;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="font-size:12px;color:rgba(167,139,250,0.4);">No event data yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Activity Heatmap + Top Performers --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#34d399,#059669);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">
                            ACTIVITY HEATMAP — LAST 35 DAYS
                        </h2>
                    </div>
                </div>
                <div class="p-6">
                    @php
                        $days = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];
                        $heatColors = [
                            0 => 'rgba(124,58,237,0.06)',
                            1 => 'rgba(124,58,237,0.2)',
                            2 => 'rgba(124,58,237,0.4)',
                            3 => 'rgba(124,58,237,0.65)',
                            4 => '#a78bfa',
                        ];
                        // Build 35 cells dari activityMap
                        $cells = collect(range(34, 0))->map(function ($i) use ($activityMap) {
                            $date = now()->subDays($i)->format('Y-m-d');
                            $count = $activityMap[$date] ?? 0;
                            return match (true) {
                                $count === 0 => 0,
                                $count <= 5 => 1,
                                $count <= 15 => 2,
                                $count <= 30 => 3,
                                default => 4,
                            };
                        });
                    @endphp
                    <div class="grid grid-cols-7 gap-1.5 mb-1.5">
                        @foreach ($days as $d)
                            <div class="text-center"
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.4);">
                                {{ $d }}</div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-7 gap-1.5">
                        @foreach ($cells as $level)
                            <div class="rounded-md aspect-square"
                                style="background:{{ $heatColors[$level] }};{{ $level >= 3 ? 'box-shadow:0 0 6px ' . ($level === 4 ? '#a78bfa' : 'rgba(124,58,237,0.4)') . ';' : '' }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2 mt-4">
                        <span
                            style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.4);">LESS</span>
                        @foreach ($heatColors as $bg)
                            <div class="w-4 h-4 rounded-sm" style="background:{{ $bg }};"></div>
                        @endforeach
                        <span
                            style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.4);">MORE</span>
                    </div>
                </div>
            </div>

            {{-- Top Performers --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-5 py-4" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#f472b6,#db2777);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:0.9rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">TOP PERFORMERS</h2>
                    </div>
                </div>
                <div class="divide-y" style="divide-color:rgba(124,58,237,0.08);">
                    @forelse($topPerformers as $i => $profile)
                        @php $medals = ['🥇','🥈','🥉']; @endphp
                        <div class="px-5 py-3 flex items-center gap-3">
                            <span class="flex-shrink-0 text-sm w-5 text-center">
                                @if (isset($medals[$i]))
                                    {{ $medals[$i] }}
                                @else
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.35);">#{{ $i + 1 }}</span>
                                @endif
                            </span>
                            <div class="w-7 h-7 rounded-lg overflow-hidden flex-shrink-0"
                                style="border:1px solid rgba(124,58,237,0.25);background:rgba(124,58,237,0.12);">
                                <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $profile->user?->email }}&backgroundColor=1a1033"
                                    class="w-full h-full" alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p style="font-size:12px;font-weight:600;color:#e2d9f3;" class="truncate">
                                    {{ $profile->user?->name ?? 'Unknown' }}
                                </p>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.4);">
                                    Lv {{ $profile->level }}
                                </p>
                            </div>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;font-weight:700;color:#a78bfa;flex-shrink:0;">
                                ⚡{{ number_format($profile->current_exp) }}
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <p style="font-size:12px;color:rgba(167,139,250,0.4);">No student data yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════ TAB: QUESTS ══════════════════════════ --}}
    <div x-show="tab === 'quests'" x-cloak>
        @php
            $catColorMap = [
                'academic' => '#a78bfa',
                'non-academic' => '#60a5fa',
                'volunteer' => '#34d399',
                'other' => '#fb923c',
            ];
            $statusColors = [
                'draft' => '#fbbf24',
                'published' => '#34d399',
                'ongoing' => '#a78bfa',
                'completed' => '#60a5fa',
                'cancelled' => '#f87171',
            ];
            $totalEvents = $questStatus->sum();
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

            {{-- Completion by category --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">EVENTS BY CATEGORY</h2>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($questByCategory as $c)
                        @php
                            $pct = $c->total > 0 ? round(($c->done / $c->total) * 100) : 0;
                            $cColor = $catColorMap[strtolower($c->category)] ?? '#a78bfa';
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.06em;color:rgba(167,139,250,0.75);">
                                    {{ strtoupper(str_replace('-', ' ', $c->category)) }}
                                </span>
                                <div class="flex items-center gap-2">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.45);">{{ $c->done }}/{{ $c->total }}</span>
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:{{ $cColor }};">{{ $pct }}%</span>
                                </div>
                            </div>
                            <div class="h-2 rounded-full" style="background:rgba(124,58,237,0.1);">
                                <div class="h-full rounded-full"
                                    style="width:{{ $pct }}%;background:{{ $cColor }};box-shadow:0 0 6px {{ $cColor }}55;">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="font-size:12px;color:rgba(167,139,250,0.4);">No event data yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Status distribution --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#34d399,#059669);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">STATUS DISTRIBUTION</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-center mb-6">
                        <div class="relative w-36 h-36">
                            <svg viewBox="0 0 36 36" class="w-full h-full -rotate-90">
                                <circle cx="18" cy="18" r="15.9" fill="none"
                                    stroke="rgba(124,58,237,0.1)" stroke-width="3.8" />
                                @php
                                    $offset = 0;
                                    $statusColorsList = [
                                        'completed' => '#34d399',
                                        'published' => '#a78bfa',
                                        'ongoing' => '#60a5fa',
                                        'draft' => '#fbbf24',
                                        'cancelled' => '#f87171',
                                    ];
                                @endphp
                                @foreach ($statusColorsList as $status => $sColor)
                                    @php
                                        $count = $questStatus[$status] ?? 0;
                                        $pct2 = $totalEvents > 0 ? round(($count / $totalEvents) * 100) : 0;
                                    @endphp
                                    @if ($pct2 > 0)
                                        <circle cx="18" cy="18" r="15.9" fill="none"
                                            stroke="{{ $sColor }}" stroke-width="3.8"
                                            stroke-dasharray="{{ $pct2 }} {{ 100 - $pct2 }}"
                                            stroke-dashoffset="-{{ $offset }}" stroke-linecap="round" />
                                        @php $offset += $pct2; @endphp
                                    @endif
                                @endforeach
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:1.6rem;font-weight:700;color:white;line-height:1;">{{ $totalEvents }}</span>
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:rgba(167,139,250,0.5);">TOTAL</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @foreach ($statusColorsList as $status => $sColor)
                            @php
                                $count = $questStatus[$status] ?? 0;
                                $pct2 = $totalEvents > 0 ? round(($count / $totalEvents) * 100) : 0;
                            @endphp
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                        style="background:{{ $sColor }};box-shadow:0 0 5px {{ $sColor }}66;">
                                    </div>
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.75);">{{ strtoupper($status) }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.4);">{{ $count }}</span>
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:{{ $sColor }};">{{ $pct2 }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Most Popular Events --}}
        <div class="stat-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#fbbf24,#d97706);">
                    </div>
                    <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                        class="text-white">MOST POPULAR EVENTS</h2>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(124,58,237,0.1);">
                            @foreach (['EVENT', 'CATEGORY', 'PARTICIPANTS', 'COMPLETION', 'EXP REWARD', 'STATUS'] as $col)
                                <th class="px-5 py-3 text-left"
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.45);">
                                    {{ $col }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popularEvents as $event)
                            @php
                                $eColor = $catColorMap[strtolower($event->category)] ?? '#a78bfa';
                                $fillPct =
                                    $event->quota > 0 ? round(($event->participants_count / $event->quota) * 100) : 0;
                                $compPct =
                                    $event->participants_count > 0
                                        ? round(($event->attended_count / $event->participants_count) * 100)
                                        : 0;
                            @endphp
                            <tr class="group transition-colors hover:bg-violet-900/10"
                                style="border-bottom:1px solid rgba(124,58,237,0.07);">
                                <td class="px-5 py-3.5">
                                    <p class="text-sm font-semibold text-purple-100">{{ $event->title }}</p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="text-xs px-2.5 py-1 rounded-full font-bold"
                                        style="background:{{ $eColor }}18;color:{{ $eColor }};font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid {{ $eColor }}30;">
                                        {{ strtoupper(str_replace('-', ' ', $event->category)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="w-24">
                                        <div class="flex justify-between mb-1">
                                            <span
                                                style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.7);">{{ $event->participants_count }}/{{ $event->quota }}</span>
                                        </div>
                                        <div class="h-1.5 rounded-full" style="background:rgba(124,58,237,0.1);">
                                            <div class="h-full rounded-full"
                                                style="width:{{ min($fillPct, 100) }}%;background:{{ $eColor }};">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;{{ $compPct >= 90 ? 'color:#34d399;' : ($compPct >= 70 ? 'color:#fbbf24;' : 'color:#f87171;') }}">
                                        {{ $compPct }}%
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;color:#a78bfa;">⚡
                                        {{ $event->exp_reward }}</span>
                                </td>
                                <td class="px-5 py-3.5">
                                    @php $sc = $statusColors[$event->status] ?? '#a78bfa'; @endphp
                                    <span class="text-xs px-2 py-0.5 rounded-full font-bold"
                                        style="background:{{ $sc }}15;color:{{ $sc }};font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.07em;border:1px solid {{ $sc }}25;">
                                        {{ strtoupper($event->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center"
                                    style="color:rgba(167,139,250,0.4);font-family:'Rajdhani',sans-serif;font-size:12px;">
                                    NO EVENT DATA YET</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════ TAB: STUDENTS ══════════════════════════ --}}
    <div x-show="tab === 'students'" x-cloak>
        @php
            $levelOrder = ['Lv 1–5', 'Lv 6–10', 'Lv 11–15', 'Lv 16–20', 'Lv 21–25', 'Lv 26+'];
            $levelColors = ['#94a3b8', '#60a5fa', '#a78bfa', '#fbbf24', '#fb923c', '#34d399'];
            $levelData = collect($levelOrder)->map(fn($r) => $levelDist[$r] ?? 0);
            $lvMax = $levelData->max() ?: 1;
            $enrollMax = collect($enrollTrend)->max('count') ?: 1;
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

            {{-- Level distribution --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#f472b6,#db2777);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">LEVEL DISTRIBUTION</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-end gap-3 h-40 mb-4">
                        @foreach ($levelOrder as $idx => $range)
                            @php
                                $count = $levelData[$idx];
                                $h = round(($count / $lvMax) * 100);
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-1" style="height:100%;">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;color:{{ $levelColors[$idx] }};">{{ $count }}</span>
                                <div class="w-full flex items-end flex-1">
                                    <div class="w-full rounded-t-lg"
                                        style="height:{{ $h }}%;background:{{ $levelColors[$idx] }};box-shadow:0 0 8px {{ $levelColors[$idx] }}44;">
                                    </div>
                                </div>
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:8px;color:rgba(167,139,250,0.4);text-align:center;line-height:1.2;">{{ $range }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Enrollment trend --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">NEW ENROLLMENT TREND</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-end gap-2 h-24">
                        @foreach ($enrollTrend as $i => $e)
                            @php
                                $h = round(($e['count'] / $enrollMax) * 100);
                                $isLast = $i === count($enrollTrend) - 1;
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full rounded-t-md"
                                    style="height:{{ $h }}%;{{ $isLast ? 'background:linear-gradient(to top,#7c3aed,#a78bfa);box-shadow:0 0 10px rgba(124,58,237,0.5);' : 'background:rgba(124,58,237,0.25);' }}">
                                </div>
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:8px;color:rgba(167,139,250,0.4);">{{ $e['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    @php
                        $lastEnroll = last($enrollTrend);
                        $prevEnroll = $enrollTrend[count($enrollTrend) - 2];
                    @endphp
                    <div class="mt-4 flex gap-6 pt-4" style="border-top:1px solid rgba(124,58,237,0.1);">
                        <div>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:rgba(167,139,250,0.4);">
                                THIS MONTH</p>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;color:#a78bfa;">
                                {{ $lastEnroll['count'] }}</p>
                        </div>
                        <div>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:rgba(167,139,250,0.4);">
                                GROWTH</p>
                            @php $growth = $prevEnroll['count'] > 0 ? round((($lastEnroll['count'] - $prevEnroll['count']) / $prevEnroll['count']) * 100, 1) : 0; @endphp
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;color:{{ $growth >= 0 ? '#34d399' : '#f87171' }};">
                                {{ $growth >= 0 ? '+' : '' }}{{ $growth }}%</p>
                        </div>
                        <div>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:rgba(167,139,250,0.4);">
                                TOTAL YTD</p>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;color:#60a5fa;">
                                {{ collect($enrollTrend)->sum('count') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════ TAB: ECONOMY ══════════════════════════ --}}
    <div x-show="tab === 'economy'" x-cloak>
        @php
            $ecoMax = max(collect($coinsFlow)->max('earned'), collect($coinsFlow)->max('spent'), 1);
            $totalEarned = collect($coinsFlow)->sum('earned');
            $totalSpent = collect($coinsFlow)->sum('spent');
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

            {{-- Coins flow chart --}}
            <div class="lg:col-span-2 stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#fbbf24,#d97706);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">COINS FLOW</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full" style="background:#fbbf24;"></div>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.6);">EARNED
                                (CREDIT)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full" style="background:#f472b6;"></div>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.6);">SPENT
                                (DEBIT)</span>
                        </div>
                    </div>
                    <div class="flex items-end gap-1.5 h-32">
                        @foreach ($coinsFlow as $i => $cf)
                            @php
                                $eh = round(($cf['earned'] / $ecoMax) * 100);
                                $sh = round(($cf['spent'] / $ecoMax) * 100);
                                $isLast = $i === count($coinsFlow) - 1;
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-0.5" style="height:100%;">
                                <div class="w-full flex items-end justify-center gap-0.5 flex-1">
                                    <div class="w-2/5 rounded-t-sm"
                                        style="height:{{ $eh }}%;{{ $isLast ? 'background:#fbbf24;box-shadow:0 0 6px rgba(251,191,36,0.5);' : 'background:rgba(251,191,36,0.25);' }}">
                                    </div>
                                    <div class="w-2/5 rounded-t-sm"
                                        style="height:{{ $sh }}%;{{ $isLast ? 'background:#f472b6;box-shadow:0 0 6px rgba(244,114,182,0.5);' : 'background:rgba(244,114,182,0.18);' }}">
                                    </div>
                                </div>
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:8px;color:rgba(167,139,250,0.4);margin-top:4px;">{{ $cf['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 grid grid-cols-3 gap-4 pt-4" style="border-top:1px solid rgba(124,58,237,0.1);">
                        @foreach ([['label' => 'TOTAL EARNED', 'value' => '₿ ' . number_format($totalEarned), 'color' => '#fbbf24'], ['label' => 'TOTAL SPENT', 'value' => '₿ ' . number_format($totalSpent), 'color' => '#f472b6'], ['label' => 'NET BALANCE', 'value' => '₿ ' . number_format($totalEarned - $totalSpent), 'color' => '#34d399']] as $es)
                            <div>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:rgba(167,139,250,0.4);">
                                    {{ $es['label'] }}</p>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;color:{{ $es['color'] }};">
                                    {{ $es['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Top Redemptions --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-5 py-4" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#34d399,#059669);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:0.9rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">TOP REDEMPTIONS</h2>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    @php $rColors = ['#fbbf24','#60a5fa','#a78bfa','#34d399','#fb923c']; @endphp
                    @forelse($topRedemptions as $i => $r)
                        @php $rColor = $rColors[$i] ?? '#a78bfa'; @endphp
                        <div class="flex items-center justify-between p-3 rounded-xl"
                            style="background:{{ $rColor }}0d;border:1px solid {{ $rColor }}18;">
                            <div>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:{{ $rColor }};letter-spacing:0.04em;">
                                    {{ strtoupper($r->item?->name ?? 'Deleted Item') }}
                                </p>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.4);">
                                    {{ $r->count }} redeemed
                                </p>
                            </div>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:#fbbf24;">
                                ₿ {{ number_format($r->total_coins) }}
                            </span>
                        </div>
                    @empty
                        <p style="font-size:12px;color:rgba(167,139,250,0.4);">No redemption data yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    {{-- ─── Automated Reports Footer ──────────────────── --}}
    <div class="mt-6 stat-card rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#60a5fa,#3b82f6);"></div>
            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                class="text-white">
                AUTOMATED REPORTS FOR REKTORAT
            </h2>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            @foreach ([['label' => 'Monthly Activity', 'desc' => now()->format('M Y'), 'color' => '#a78bfa', 'icon' => '📄', 'status' => 'Ready'], ['label' => 'Semester Summary', 'desc' => 'Jan–Jun ' . now()->year, 'color' => '#60a5fa', 'icon' => '📊', 'status' => 'Ready'], ['label' => 'SKPI Batch Export', 'desc' => number_format($activeStudents) . ' students', 'color' => '#fbbf24', 'icon' => '🎓', 'status' => 'Ready'], ['label' => 'Anti-Fraud Report', 'desc' => 'Last 30 days', 'color' => '#f87171', 'icon' => '🛡️', 'status' => 'Active']] as $r)
                <button
                    class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-left transition-all hover:opacity-90"
                    style="background:{{ $r['color'] }}0d;border:1px solid {{ $r['color'] }}20;">
                    <span class="text-lg flex-shrink-0">{{ $r['icon'] }}</span>
                    <div class="flex-1 min-w-0">
                        <p
                            style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.05em;color:{{ $r['color'] }};">
                            {{ strtoupper($r['label']) }}
                        </p>
                        <p style="font-size:10px;color:rgba(167,139,250,0.4);">{{ $r['desc'] }}</p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full flex-shrink-0"
                        style="background:{{ $r['color'] }}15;color:{{ $r['color'] }};font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.06em;border:1px solid {{ $r['color'] }}25;">
                        {{ strtoupper($r['status']) }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

</div>
