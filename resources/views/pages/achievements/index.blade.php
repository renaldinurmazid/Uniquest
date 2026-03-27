<div class="space-y-8" style="animation:pageIn 0.4s ease forwards;">

    {{-- ── Flash ── --}}
    @if (session('status'))
        <div class="p-4 rounded-xl flex items-center gap-3"
            style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.3);">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:#34d399;letter-spacing:0.05em;">
                {{ session('status') }}
            </p>
        </div>
    @endif

    {{-- ── Page Header ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-8 rounded-full"
                    style="background:linear-gradient(to bottom,#fbbf24,#f59e0b);box-shadow:0 0 12px rgba(251,191,36,0.8);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">ACHIEVEMENTS</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">
                Badge Forge — design, assign, and track all hero achievements across the academy.
            </p>
        </div>
        <button wire:click="openCreate"
            class="btn-primary px-5 py-2.5 rounded-xl text-sm text-white flex items-center gap-2 font-bold self-start md:self-auto"
            style="background:linear-gradient(135deg,#d97706,#fbbf24);border:1px solid rgba(251,191,36,0.4);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;box-shadow:0 0 18px rgba(245,158,11,0.3);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            + FORGE BADGE
        </button>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['label' => 'TOTAL BADGES', 'value' => $stats['total'], 'color' => '#fbbf24', 'border' => 'rgba(245,158,11,0.25)', 'sub' => 'designed', 'icon' => '🏅'], ['label' => 'AWARDED TODAY', 'value' => $stats['awardedToday'], 'color' => '#34d399', 'border' => 'rgba(16,185,129,0.25)', 'sub' => 'distributed', 'icon' => '🎖️'], ['label' => 'TOTAL AWARDED', 'value' => $stats['totalAwarded'], 'color' => '#a78bfa', 'border' => 'rgba(124,58,237,0.25)', 'sub' => 'all time', 'icon' => '💎'], ['label' => 'RAREST BADGE', 'value' => $stats['rarestCount'], 'color' => '#f472b6', 'border' => 'rgba(244,114,182,0.25)', 'sub' => 'holders only', 'icon' => '👑']] as $k)
            <div class="stat-card rounded-xl p-5" style="border:1px solid {{ $k['border'] }};">
                <div class="flex items-center justify-between mb-2">
                    <p
                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.6);">
                        {{ $k['label'] }}</p>
                    <span class="text-xl">{{ $k['icon'] }}</span>
                </div>
                <h3
                    style="font-family:'Rajdhani',sans-serif;font-size:1.9rem;font-weight:700;color:{{ $k['color'] }};line-height:1.1;">
                    {{ $k['value'] }}
                </h3>
                <p style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.35);letter-spacing:0.05em;"
                    class="mt-1">
                    {{ $k['sub'] }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- ── Tab Nav ── --}}
    <div class="flex gap-1 p-1 rounded-xl w-fit"
        style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
        @foreach ([['key' => 'badges', 'label' => 'ALL BADGES', 'icon' => '🏅'], ['key' => 'awarded', 'label' => 'AWARDED', 'icon' => '🎖️']] as $tab)
            <button wire:click="$set('activeTab','{{ $tab['key'] }}')"
                class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition-all"
                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;
                    {{ $activeTab === $tab['key']
                        ? 'background:rgba(124,58,237,0.6);color:#e2d9f3;border:1px solid rgba(167,139,250,0.4);'
                        : 'color:rgba(167,139,250,0.5);border:1px solid transparent;' }}">
                <span>{{ $tab['icon'] }}</span>{{ $tab['label'] }}
            </button>
        @endforeach
    </div>


    {{-- ══════════════════════════ TAB: ALL BADGES ══════════════════════════ --}}
    @if ($activeTab === 'badges')

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    style="color:rgba(167,139,250,0.5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search badge..."
                    class="search-input w-full pl-11 pr-4 py-3 rounded-xl text-sm">
            </div>
            <select wire:model.live="filterReqType" class="px-4 py-2.5 rounded-xl text-sm focus:outline-none"
                style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);color:rgba(167,139,250,0.8);font-family:'Rajdhani',sans-serif;">
                <option value="all">ALL TYPES</option>
                @foreach ($requirementTypes as $key => $label)
                    <option value="{{ $key }}">{{ strtoupper($label) }}</option>
                @endforeach
            </select>
        </div>

        @if ($achievements->isEmpty())
            <div class="stat-card rounded-2xl py-24 text-center">
                <div class="text-5xl mb-4">🏅</div>
                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:14px;letter-spacing:0.12em;color:rgba(124,58,237,0.5);">
                    NO BADGES FOUND</p>
                <p style="font-size:13px;color:rgba(167,139,250,0.35);margin-top:6px;">Forge your first badge</p>
                <button wire:click="openCreate" class="mt-6 px-6 py-2.5 rounded-xl text-sm font-bold text-white"
                    style="background:linear-gradient(135deg,#d97706,#fbbf24);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                    + FORGE BADGE
                </button>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($achievements as $achievement)
                    @php
                        $typeColors = [
                            'quest_count' => '#a78bfa',
                            'event_count' => '#60a5fa',
                            'total_exp' => '#fbbf24',
                            'total_coins' => '#f59e0b',
                            'level_reached' => '#f472b6',
                            'skill_points' => '#34d399',
                            'certificate_count' => '#fb923c',
                            'manual' => '#94a3b8',
                        ];
                        $color = $typeColors[$achievement->requirement_type] ?? '#a78bfa';
                        $icon = $achievement->badge_icon_path ?? '🏆';
                        $reqLabels = [
                            'quest_count' => 'Quest Count',
                            'event_count' => 'Event Count',
                            'total_exp' => 'Total EXP',
                            'total_coins' => 'Total Coins',
                            'level_reached' => 'Level',
                            'skill_points' => 'Skill Points',
                            'certificate_count' => 'Certificates',
                            'manual' => 'Manual',
                        ];
                        $reqLabel = $reqLabels[$achievement->requirement_type] ?? $achievement->requirement_type;
                    @endphp
                    <div class="stat-card rounded-2xl overflow-hidden group hover:scale-[1.02] transition-all duration-300"
                        style="border:1px solid {{ $color }}25;">
                        <div class="h-1.5" style="background:{{ $color }};opacity:0.7;"></div>
                        <div class="p-4">
                            <div class="relative w-14 h-14 mx-auto mb-3">
                                <div class="w-full h-full rounded-2xl flex items-center justify-center text-3xl"
                                    style="background:radial-gradient(circle at 40% 35%, {{ $color }}28, {{ $color }}08);border:1px solid {{ $color }}35;">
                                    {{ $icon }}
                                </div>
                                <div class="absolute -top-1 -right-1 min-w-[18px] h-[18px] rounded-full flex items-center justify-center px-1"
                                    style="background:{{ $color }};border:2px solid #1a1033;">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:9px;font-weight:700;color:#0f0a1e;">
                                        {{ $achievement->users_count }}
                                    </span>
                                </div>
                            </div>
                            <p
                                class="text-sm font-bold text-center text-purple-100 group-hover:text-white transition-colors mb-1 leading-tight">
                                {{ $achievement->title }}
                            </p>
                            <div class="flex justify-center mb-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold"
                                    style="background:{{ $color }}15;color:{{ $color }};font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.08em;border:1px solid {{ $color }}25;">
                                    {{ strtoupper(str_replace('_', ' ', $achievement->requirement_type)) }}
                                </span>
                            </div>
                            @if ($achievement->description)
                                <p style="font-size:11px;color:rgba(167,139,250,0.55);text-align:center;line-height:1.4;"
                                    class="mb-3 line-clamp-2">
                                    {{ $achievement->description }}
                                </p>
                            @endif
                            <div class="flex items-center justify-center gap-2 mb-3 p-2 rounded-xl"
                                style="background:{{ $color }}10;border:1px solid {{ $color }}20;">
                                @if ($achievement->requirement_type !== 'manual')
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.5);">REQUIRES</span>
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:14px;font-weight:700;color:{{ $color }};">
                                        {{ number_format($achievement->requirement_value) }}
                                    </span>
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.5);">{{ $reqLabel }}</span>
                                @else
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;color:{{ $color }};">✋
                                        MANUAL AWARD ONLY</span>
                                @endif
                            </div>
                            <p style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.35);letter-spacing:0.06em;text-align:center;"
                                class="mb-3">
                                {{ $achievement->users_count }}
                                {{ $achievement->users_count === 1 ? 'HOLDER' : 'HOLDERS' }}
                            </p>
                            <div class="grid grid-cols-3 gap-1.5 pt-3"
                                style="border-top:1px solid rgba(124,58,237,0.1);">
                                <button wire:click="openEdit({{ $achievement->id }})"
                                    class="py-1.5 rounded-lg text-xs font-bold transition-all"
                                    style="background:rgba(124,58,237,0.1);color:rgba(167,139,250,0.7);font-family:'Rajdhani',sans-serif;letter-spacing:0.04em;border:1px solid rgba(124,58,237,0.2);">
                                    EDIT
                                </button>
                                <button wire:click="openAward({{ $achievement->id }})"
                                    class="py-1.5 rounded-lg text-xs font-bold transition-all"
                                    style="background:{{ $color }}12;color:{{ $color }};font-family:'Rajdhani',sans-serif;letter-spacing:0.04em;border:1px solid {{ $color }}22;">
                                    AWARD
                                </button>
                                <button wire:click="confirmDelete({{ $achievement->id }})"
                                    class="py-1.5 rounded-lg text-xs font-bold transition-all"
                                    style="background:rgba(239,68,68,0.08);color:rgba(248,113,113,0.6);font-family:'Rajdhani',sans-serif;border:1px solid rgba(239,68,68,0.15);">
                                    DEL
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between items-center">
                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:rgba(167,139,250,0.45);">
                    SHOWING {{ $achievements->firstItem() }}–{{ $achievements->lastItem() }} OF
                    {{ $achievements->total() }} BADGES
                </p>
                {{ $achievements->links() }}
            </div>
        @endif

        {{-- ══════════════════════════ TAB: AWARDED ══════════════════════════ --}}
    @elseif ($activeTab === 'awarded')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5 flex items-center justify-between"
                    style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#fbbf24,#d97706);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">RECENTLY AWARDED</h2>
                    </div>
                    <span
                        style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:rgba(167,139,250,0.45);">{{ $stats['awardedToday'] }}
                        TODAY</span>
                </div>
                @if ($recentAwarded->isEmpty())
                    <div class="py-16 text-center">
                        <p
                            style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:0.1em;color:rgba(124,58,237,0.4);">
                            NO AWARDS YET</p>
                    </div>
                @else
                    <div class="divide-y" style="divide-color:rgba(124,58,237,0.08);">
                        @foreach ($recentAwarded as $award)
                            @php
                                $typeColors2 = [
                                    'quest_count' => '#a78bfa',
                                    'event_count' => '#60a5fa',
                                    'total_exp' => '#fbbf24',
                                    'total_coins' => '#f59e0b',
                                    'level_reached' => '#f472b6',
                                    'skill_points' => '#34d399',
                                    'certificate_count' => '#fb923c',
                                    'manual' => '#94a3b8',
                                ];
                                $aColor = $typeColors2[$award->achievement?->requirement_type ?? 'manual'] ?? '#a78bfa';
                                $aIcon = $award->achievement?->badge_icon_path ?? '🏆';
                            @endphp
                            <div
                                class="px-5 py-3.5 flex items-center gap-4 group hover:bg-violet-900/10 transition-colors">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                                    style="background:{{ $aColor }}15;border:1px solid {{ $aColor }}30;">
                                    {{ $aIcon }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p style="font-size:13px;font-weight:600;color:#e2d9f3;">
                                            {{ $award->user?->name ?? 'Unknown' }}</p>
                                        <span style="font-size:11px;color:rgba(167,139,250,0.4);">earned</span>
                                        <span
                                            style="font-size:13px;font-weight:700;color:{{ $aColor }};">{{ $award->achievement?->title ?? 'Deleted Badge' }}</span>
                                    </div>
                                    <p style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.35);"
                                        class="mt-0.5">
                                        {{ \Carbon\Carbon::parse($award->earned_at)->diffForHumans() }}
                                    </p>
                                </div>
                                <button wire:click="revokeFromUser({{ $award->id }})" title="Revoke badge"
                                    class="p-1.5 rounded-lg flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="background:rgba(239,68,68,0.08);color:rgba(248,113,113,0.5);border:1px solid rgba(239,68,68,0.15);">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="space-y-5">
                {{-- Most Awarded --}}
                <div class="stat-card rounded-2xl overflow-hidden">
                    <div class="px-5 py-4" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-5 rounded-full"
                                style="background:linear-gradient(to bottom,#f472b6,#db2777);"></div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:0.9rem;font-weight:700;letter-spacing:0.06em;"
                                class="text-white">MOST AWARDED</h2>
                        </div>
                    </div>
                    <div class="p-5 space-y-3">
                        @forelse ($topBadges as $i => $top)
                            @php $tc = ['#fbbf24','#a78bfa','#60a5fa','#34d399','#94a3b8'][$i] ?? '#94a3b8'; @endphp
                            <div class="flex items-center gap-3">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:{{ $tc }};width:16px;">{{ $i + 1 }}</span>
                                <span class="text-base">{{ $top->badge_icon_path ?? '🏆' }}</span>
                                <span style="font-size:12px;color:rgba(167,139,250,0.8);flex:1;"
                                    class="truncate">{{ $top->title }}</span>
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:{{ $tc }};">{{ $top->users_count }}x</span>
                            </div>
                        @empty
                            <p style="font-size:12px;color:rgba(167,139,250,0.4);">No data yet</p>
                        @endforelse
                    </div>
                </div>

                {{-- By Type --}}
                <div class="stat-card rounded-2xl overflow-hidden">
                    <div class="px-5 py-4" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-5 rounded-full"
                                style="background:linear-gradient(to bottom,#fbbf24,#d97706);"></div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:0.9rem;font-weight:700;letter-spacing:0.06em;"
                                class="text-white">BY TYPE</h2>
                        </div>
                    </div>
                    <div class="p-5 space-y-3">
                        @php
                            $typeColorMap = [
                                'quest_count' => '#a78bfa',
                                'event_count' => '#60a5fa',
                                'total_exp' => '#fbbf24',
                                'total_coins' => '#f59e0b',
                                'level_reached' => '#f472b6',
                                'skill_points' => '#34d399',
                                'certificate_count' => '#fb923c',
                                'manual' => '#94a3b8',
                            ];
                        @endphp
                        @forelse ($typeGroups as $tg)
                            @php $tgColor = $typeColorMap[$tg->requirement_type] ?? '#a78bfa'; @endphp
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.06em;color:{{ $tgColor }};">
                                        {{ strtoupper(str_replace('_', ' ', $tg->requirement_type)) }}
                                    </span>
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;font-weight:700;color:{{ $tgColor }};">{{ $tg->count }}</span>
                                </div>
                                <div class="h-1.5 rounded-full" style="background:rgba(124,58,237,0.1);">
                                    <div class="h-full rounded-full"
                                        style="width:{{ round(($tg->count / $typeTotal) * 100) }}%;background:{{ $tgColor }};">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p style="font-size:12px;color:rgba(167,139,250,0.4);">No data yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════
         MODAL: FORGE / EDIT — FIXED SCROLL
    ══════════════════════════ --}}
    @if ($showModal)
        {{-- Backdrop --}}
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">

            <div wire:click="$set('showModal', false)" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>

            {{-- Modal wrapper — flex column, max height, scroll inside --}}
            <div class="relative z-10 w-full max-w-lg flex flex-col rounded-2xl overflow-hidden"
                style="background:#13111c;border:1px solid rgba(251,191,36,0.3);box-shadow:0 0 60px rgba(251,191,36,0.08),0 25px 80px rgba(0,0,0,0.8);max-height:90vh;"
                x-show="true" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">

                {{-- Top accent bar (fixed, tidak ikut scroll) --}}
                <div class="flex-shrink-0 h-1 w-full"
                    style="background:linear-gradient(90deg,#d97706,#fbbf24,#d97706);box-shadow:0 0 10px rgba(251,191,36,0.4);">
                </div>

                {{-- Modal header (fixed, tidak ikut scroll) --}}
                <div class="flex-shrink-0 px-6 py-5 flex items-center justify-between"
                    style="background:#13111c;border-bottom:1px solid rgba(251,191,36,0.12);">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-7 rounded-full"
                            style="background:linear-gradient(to bottom,#fbbf24,#d97706);box-shadow:0 0 10px rgba(251,191,36,0.4);">
                        </div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">
                            {{ $editingId ? 'EDIT BADGE' : 'FORGE NEW BADGE' }}
                        </h2>
                    </div>
                    <button wire:click="$set('showModal', false)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-red-500/20"
                        style="border:1px solid rgba(239,68,68,0.25);color:rgba(248,113,113,0.7);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Scrollable body --}}
                <div class="flex-1 overflow-y-auto p-6 space-y-5">

                    {{-- Icon picker --}}
                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">
                            BADGE ICON
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['🏆', '🥇', '🎖️', '🏅', '⭐', '🌟', '💎', '🔥', '⚡', '🎓', '📚', '💻', '🤝', '👑', '🎨', '🏰', '🔬', '🚀', '🎯', '🌈'] as $ico)
                                <button type="button" wire:click="$set('badgeIcon','{{ $ico }}')"
                                    class="w-10 h-10 rounded-xl flex items-center justify-center text-xl transition-all hover:scale-110"
                                    style="background:{{ $badgeIcon === $ico ? 'rgba(251,191,36,0.25)' : 'rgba(124,58,237,0.08)' }};
                                        border:{{ $badgeIcon === $ico ? '2px solid rgba(251,191,36,0.5)' : '1px solid rgba(124,58,237,0.15)' }};">
                                    {{ $ico }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Badge name --}}
                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">
                            BADGE NAME *
                        </label>
                        <input wire:model="badgeName" type="text" placeholder="e.g. Tech Enthusiast"
                            class="modal-input w-full px-4 py-3 rounded-xl text-sm focus:outline-none">
                        @error('badgeName')
                            <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">
                            EARN CONDITION
                        </label>
                        <textarea wire:model="badgeDescription" rows="2"
                            placeholder="Describe what a student must do to earn this badge..."
                            class="modal-input w-full px-4 py-3 rounded-xl text-sm focus:outline-none resize-none"></textarea>
                        @error('badgeDescription')
                            <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Requirement type + value --}}
                    <div class="space-y-3">
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                            class="block">
                            REQUIREMENT
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <select wire:model.live="reqType"
                                    class="modal-input w-full px-4 py-3 rounded-xl text-sm focus:outline-none appearance-none">
                                    @foreach ($requirementTypes as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-3 rounded-xl"
                                style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:rgba(167,139,250,0.5);"
                                    class="block mb-1">
                                    THRESHOLD VALUE
                                </label>
                                <input wire:model="reqValue" type="number" min="0"
                                    class="w-full bg-transparent text-2xl font-bold focus:outline-none"
                                    style="font-family:'Rajdhani',sans-serif;color:#a78bfa;"
                                    {{ $reqType === 'manual' ? 'disabled' : '' }}>
                            </div>
                        </div>
                        @if ($reqType !== 'manual')
                            <p style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.45);">
                                Badge will be awarded when student reaches
                                <strong style="color:#a78bfa;">{{ $reqValue }}</strong>
                                {{ str_replace('_', ' ', $reqType) }}.
                            </p>
                        @else
                            <p style="font-family:'Rajdhani',sans-serif;font-size:11px;color:#fbbf24;">
                                ✋ This badge can only be awarded manually by admin.
                            </p>
                        @endif
                    </div>

                    {{-- Live preview --}}
                    <div class="p-4 rounded-xl flex items-center gap-4"
                        style="background:rgba(251,191,36,0.06);border:1px solid rgba(251,191,36,0.2);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                            style="background:rgba(251,191,36,0.15);border:1px solid rgba(251,191,36,0.3);">
                            {{ $badgeIcon }}
                        </div>
                        <div>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:14px;font-weight:700;color:#fbbf24;letter-spacing:0.05em;">
                                {{ $badgeName ?: 'BADGE NAME' }}
                            </p>
                            <p style="font-size:11px;color:rgba(167,139,250,0.5);">
                                {{ $badgeDescription ?: 'Badge description...' }}
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Footer (fixed, tidak ikut scroll) --}}
                <div class="flex-shrink-0 px-6 py-4 flex gap-3"
                    style="background:#13111c;border-top:1px solid rgba(251,191,36,0.1);">
                    <button wire:click="$set('showModal', false)" class="flex-1 py-2.5 rounded-xl text-sm font-bold"
                        style="background:rgba(124,58,237,0.08);color:rgba(167,139,250,0.7);font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(124,58,237,0.2);">
                        CANCEL
                    </button>
                    <button wire:click="save"
                        class="flex-1 py-2.5 rounded-xl text-sm font-bold text-white hover:opacity-90"
                        style="background:linear-gradient(135deg,#d97706,#fbbf24);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(251,191,36,0.3);box-shadow:0 0 20px rgba(251,191,36,0.2);">
                        {{ $editingId ? '✏️ UPDATE BADGE' : '🏅 FORGE BADGE' }}
                    </button>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════ MODAL: AWARD TO STUDENT ══════════════════════════ --}}
    @if ($showAwardModal && $awardAchievement)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="$set('showAwardModal', false)" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-md rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#d97706,#fbbf24,#d97706);"></div>
                <div class="p-6 space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                            style="background:rgba(251,191,36,0.15);border:1px solid rgba(251,191,36,0.3);">
                            {{ $awardAchievement->badge_icon_path ?? '🏆' }}
                        </div>
                        <div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.1rem;font-weight:700;letter-spacing:0.05em;"
                                class="text-white">AWARD BADGE</h2>
                            <p style="font-family:'Rajdhani',sans-serif;font-size:11px;color:#fbbf24;">
                                {{ $awardAchievement->title }}</p>
                        </div>
                        <button wire:click="$set('showAwardModal', false)"
                            class="ml-auto p-2 text-violet-500 hover:text-violet-300 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">SEARCH STUDENT</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                style="color:rgba(167,139,250,0.5);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="awardSearch" type="text"
                                placeholder="Type name or email (min. 2 chars)..."
                                class="modal-input w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                        </div>
                    </div>
                    @if (strlen($awardSearch) >= 2)
                        @if ($awardUsers->isEmpty())
                            <p style="font-size:12px;color:rgba(167,139,250,0.4);text-align:center;padding:12px 0;">No
                                students found or all already have this badge.</p>
                        @else
                            <div class="space-y-2 max-h-56 overflow-y-auto">
                                @foreach ($awardUsers as $u)
                                    <div class="flex items-center gap-3 p-3 rounded-xl"
                                        style="background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.15);">
                                        <div class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0"
                                            style="border:1px solid rgba(124,58,237,0.3);">
                                            <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $u->email }}&backgroundColor=1a1033"
                                                class="w-full h-full" alt="">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p style="font-size:13px;font-weight:600;color:#e2d9f3;">
                                                {{ $u->name }}</p>
                                            <p
                                                style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.4);">
                                                {{ $u->email }}</p>
                                        </div>
                                        <button wire:click="awardToUser({{ $u->id }})"
                                            class="px-3 py-1.5 rounded-lg text-xs font-bold flex-shrink-0"
                                            style="background:rgba(251,191,36,0.15);color:#fbbf24;font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(251,191,36,0.3);">
                                            🏅 AWARD
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <p style="font-size:12px;color:rgba(167,139,250,0.35);text-align:center;padding:8px 0;">Type at
                            least 2 characters to search students.</p>
                    @endif
                    <button type="button" wire:click="$set('showAwardModal', false)"
                        class="w-full py-2.5 rounded-xl text-sm font-bold"
                        style="background:rgba(124,58,237,0.08);color:rgba(167,139,250,0.7);font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(124,58,237,0.2);">
                        CLOSE
                    </button>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════ MODAL: DELETE CONFIRM ══════════════════════════ --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="$set('showDeleteModal', false)" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-md rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171,#ef4444);"></div>
                <div class="p-8 space-y-6">
                    <div class="flex flex-col items-center text-center gap-4">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center"
                            style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
                            <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.3rem;font-weight:700;letter-spacing:0.05em;"
                                class="text-white mb-2">DELETE BADGE</h2>
                            <p style="color:rgba(167,139,250,0.6);font-size:0.875rem;line-height:1.6;">
                                Permanently delete<br>
                                <span class="text-white font-bold">{{ $deleteName }}</span><br>
                                and revoke it from all holders.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showDeleteModal', false)"
                            class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                            ABORT
                        </button>
                        <button wire:click="delete" type="button"
                            class="flex-1 py-3 rounded-xl text-sm font-bold text-white"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#b91c1c,#ef4444);border:1px solid #ef4444;box-shadow:0 0 16px rgba(239,68,68,0.3);">
                            ⚡ CONFIRM DELETE
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
