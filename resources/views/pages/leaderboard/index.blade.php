<div style="animation: pageIn 0.4s ease forwards;">

    {{-- ─── Page Header ─────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-8 rounded-full"
                    style="background:linear-gradient(to bottom,#fbbf24,#d97706);box-shadow:0 0 12px rgba(251,191,36,0.7);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">HALL OF FAME</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">
                Glory rankings across the entire academy — who reigns supreme?
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button class="btn-secondary px-5 py-2.5 rounded-xl text-sm flex items-center gap-2"
                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                EXPORT
            </button>
        </div>
    </div>

    {{-- ─── Top 3 Podium ────────────────────────────────── --}}
    <div class="flex items-end justify-center gap-4 mb-10 px-4">
        @forelse ($podium as $p)
            <div class="flex-1 max-w-xs flex flex-col items-center">
                {{-- Avatar --}}
                <div class="relative mb-3">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden"
                        style="border:3px solid {{ $p['color'] }};box-shadow:0 0 20px {{ $p['color'] }}55;background:rgba(124,58,237,0.15);">
                        @if ($p['avatar'])
                            <img src="{{ $p['avatar'] }}" class="w-full h-full object-cover" alt="{{ $p['name'] }}">
                        @else
                            <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $p['seed'] }}&backgroundColor=1a1033"
                                class="w-full h-full" alt="{{ $p['name'] }}">
                        @endif
                    </div>
                    <div class="absolute -top-3 -right-3 text-2xl">{{ $p['badge'] }}</div>
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-2 py-0.5 rounded-md text-xs font-bold"
                        style="background:{{ $p['color'] }};color:#0f0a1e;font-family:'Rajdhani',sans-serif;white-space:nowrap;">
                        LVL {{ $p['level'] }}
                    </div>
                </div>

                {{-- Name + npm --}}
                <p class="text-sm font-bold text-white text-center mt-3 mb-0.5">{{ $p['name'] }}</p>
                <p style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:rgba(167,139,250,0.5);"
                    class="mb-3">{{ $p['npm'] }}</p>

                {{-- Podium block --}}
                <div class="w-full {{ $p['h'] }} rounded-t-2xl flex flex-col items-center justify-center gap-1 relative overflow-hidden"
                    style="background:linear-gradient(to top, {{ $p['color'] }}22, {{ $p['color'] }}08);border:1px solid {{ $p['color'] }}30;border-bottom:none;">
                    <div class="absolute inset-0 opacity-5"
                        style="background:radial-gradient(circle at 50% 0%, {{ $p['color'] }}, transparent 70%);">
                    </div>
                    <span
                        style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;color:{{ $p['color'] }};line-height:1;">
                        #{{ $p['rank'] }}
                    </span>
                    <span
                        style="font-family:'Rajdhani',sans-serif;font-size:10px;color:{{ $p['color'] }};letter-spacing:0.1em;">
                        {{ number_format($p['exp']) }} XP
                    </span>
                    <span style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.5);">
                        ₿ {{ number_format($p['coins']) }}
                    </span>
                </div>
            </div>
        @empty
            <p
                style="color:rgba(167,139,250,0.4);font-family:'Rajdhani',sans-serif;letter-spacing:0.08em;font-size:13px;">
                NO HEROES YET
            </p>
        @endforelse
    </div>

    {{-- ─── Tab + Search Row ────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-5">
        {{-- Tabs --}}
        <div class="flex gap-1 p-1 rounded-xl"
            style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
            @foreach ([['key' => 'global', 'label' => 'GLOBAL', 'icon' => '🌐'], ['key' => 'weekly', 'label' => 'THIS WEEK', 'icon' => '⚡']] as $tab)
                <button wire:click="$set('activeTab','{{ $tab['key'] }}')"
                    class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition-all"
                    style="font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;
                        {{ $activeTab === $tab['key']
                            ? 'background:rgba(124,58,237,0.55);color:#e2d9f3;border:1px solid rgba(167,139,250,0.35);'
                            : 'color:rgba(167,139,250,0.5);border:1px solid transparent;' }}">
                    <span>{{ $tab['icon'] }}</span>
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </div>

        {{-- Search --}}
        <div class="relative w-full sm:w-72">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:rgba(167,139,250,0.4);"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input wire:model.live="searchQuery" type="text" placeholder="Search hero..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm focus:outline-none"
                style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);color:#e2d9f3;font-family:'Rajdhani',sans-serif;letter-spacing:0.03em;">
        </div>
    </div>

    {{-- ─── Main Leaderboard Table ───────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Rank Table (2/3) --}}
        <div class="lg:col-span-2 stat-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5 flex items-center justify-between"
                style="border-bottom:1px solid rgba(124,58,237,0.15);">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#fbbf24,#d97706);">
                    </div>
                    <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                        class="text-white">
                        {{ $activeTab === 'global' ? 'GLOBAL RANKING' : 'WEEKLY RANKING' }}
                    </h2>
                </div>
                <span
                    style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:rgba(167,139,250,0.45);">
                    {{ $leaderboard->total() }} HEROES
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(124,58,237,0.1);">
                            @foreach (['RANK', 'HERO', 'LEVEL', 'EXP', 'COINS', 'CHANGE'] as $col)
                                <th class="px-5 py-3 text-left"
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.45);">
                                    {{ $col }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leaderboard as $i => $user)
                            @php
                                $rank = ($leaderboard->currentPage() - 1) * $leaderboard->perPage() + $i + 1;
                                $profile = $user->studentProfile;
                                $exp = $activeTab === 'weekly' ? $user->weekly_exp ?? 0 : $profile->current_exp ?? 0;
                                $rankColor = match (true) {
                                    $rank === 1 => '#fbbf24',
                                    $rank === 2 => '#94a3b8',
                                    $rank === 3 => '#fb923c',
                                    default => 'rgba(167,139,250,0.4)',
                                };
                                $change = $this->getRankChange($user);
                            @endphp
                            <tr class="group transition-colors hover:bg-violet-900/10"
                                style="border-bottom:1px solid rgba(124,58,237,0.07);">

                                {{-- Rank --}}
                                <td class="px-5 py-3.5">
                                    @if ($rank <= 3)
                                        <span style="font-size:1.1rem;">
                                            {{ $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : '🥉') }}
                                        </span>
                                    @else
                                        <span
                                            style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:rgba(167,139,250,0.4);">
                                            #{{ $rank }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Hero --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0"
                                            style="border:1px solid rgba(124,58,237,0.3);background:rgba(124,58,237,0.12);">
                                            @if ($user->avatar_url)
                                                <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover"
                                                    alt="">
                                            @else
                                                <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $profile->npm ?? $user->id }}&backgroundColor=1a1033"
                                                    class="w-full h-full" alt="">
                                            @endif
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-semibold text-purple-100 group-hover:text-white transition-colors">
                                                {{ $user->name }}
                                            </p>
                                            <p
                                                style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.4);letter-spacing:0.08em;">
                                                {{ $profile->npm ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Level --}}
                                <td class="px-5 py-3.5">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold"
                                        style="background:{{ $rankColor }}15;color:{{ $rankColor }};font-family:'Rajdhani',sans-serif;border:1px solid {{ $rankColor }}30;">
                                        LVL {{ $profile->level ?? 1 }}
                                    </span>
                                </td>

                                {{-- EXP --}}
                                <td class="px-5 py-3.5">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;color:#a78bfa;">
                                        ⚡ {{ number_format($exp) }}
                                    </span>
                                </td>

                                {{-- Coins --}}
                                <td class="px-5 py-3.5">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;color:#fbbf24;">
                                        ₿ {{ number_format($profile->total_coins ?? 0) }}
                                    </span>
                                </td>

                                {{-- Change --}}
                                <td class="px-5 py-3.5">
                                    @if ($change > 0)
                                        <span class="flex items-center gap-1 text-xs font-bold"
                                            style="color:#34d399;font-family:'Rajdhani',sans-serif;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M5 15l7-7 7 7" />
                                            </svg>
                                            {{ $change }}
                                        </span>
                                    @elseif ($change < 0)
                                        <span class="flex items-center gap-1 text-xs font-bold"
                                            style="color:#f87171;font-family:'Rajdhani',sans-serif;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                            </svg>
                                            {{ abs($change) }}
                                        </span>
                                    @else
                                        <span
                                            style="color:rgba(167,139,250,0.35);font-family:'Rajdhani',sans-serif;font-size:12px;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center"
                                    style="color:rgba(167,139,250,0.4);font-family:'Rajdhani',sans-serif;letter-spacing:0.08em;font-size:13px;">
                                    NO HEROES FOUND
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-5 py-4" style="border-top:1px solid rgba(124,58,237,0.1);">
                {{ $leaderboard->links() }}
            </div>
        </div>

        {{-- ─── Right Sidebar ──────────────────────────── --}}
        <div class="space-y-5">

            {{-- Rare Badges --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-5 py-4" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#fbbf24,#d97706);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:0.9rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">RARE BADGES</h2>
                    </div>
                </div>
                <div class="p-5 grid grid-cols-3 gap-3">
                    @forelse ($rareBadges as $badge)
                        @php
                            $badgeColors = ['#fbbf24', '#f87171', '#60a5fa', '#a78bfa', '#fb923c', '#34d399'];
                            $badgeColor = $badgeColors[$loop->index % count($badgeColors)];
                        @endphp
                        <div class="flex flex-col items-center p-3 rounded-xl transition-all hover:scale-105 cursor-pointer"
                            style="background:{{ $badgeColor }}10;border:1px solid {{ $badgeColor }}20;">
                            <span class="text-xl mb-1">{{ $badge['icon'] }}</span>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.06em;color:{{ $badgeColor }};">
                                {{ strtoupper($badge['label']) }}
                            </p>
                            <p style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.4);"
                                class="mt-0.5">
                                {{ $badge['holders'] }} heroes
                            </p>
                        </div>
                    @empty
                        <div class="col-span-3 py-6 text-center"
                            style="color:rgba(167,139,250,0.35);font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;">
                            NO BADGES YET
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Fastest Climbers --}}
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-5 py-4" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-5 rounded-full"
                            style="background:linear-gradient(to bottom,#34d399,#059669);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:0.9rem;font-weight:700;letter-spacing:0.06em;"
                            class="text-white">FASTEST CLIMBERS</h2>
                    </div>
                </div>
                <div class="divide-y" style="divide-color:rgba(124,58,237,0.08);">
                    @forelse ($fastestClimbers as $climber)
                        <div class="px-5 py-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 text-xs font-bold"
                                    style="background:{{ $climber['color'] }}18;color:{{ $climber['color'] }};font-family:'Rajdhani',sans-serif;">
                                    {{ $climber['initials'] }}
                                </div>
                                <p style="font-size:12px;font-weight:600;color:#e2d9f3;">{{ $climber['name'] }}</p>
                            </div>
                            <div class="text-right">
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:{{ $climber['color'] }};">
                                    +{{ number_format($climber['weekly_exp']) }} XP
                                </p>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.4);">
                                    this week
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-6 text-center"
                            style="color:rgba(167,139,250,0.35);font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;">
                            NO ACTIVITY THIS WEEK
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>
