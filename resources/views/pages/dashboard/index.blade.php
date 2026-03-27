<div class="space-y-8" style="animation: pageIn 0.4s ease forwards;">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-8 rounded-full"
                    style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);box-shadow:0 0 12px rgba(124,58,237,0.8);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">COMMAND CENTER</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">
                Hero, your campus realm awaits. Today's mission briefing is ready.
            </p>
        </div>
        <div class="flex items-center gap-3">
            {{-- <button class="btn-secondary px-5 py-2.5 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                EXPORT STATS
            </button> --}}
            <a href="{{ route('quests') }}"
                class="btn-primary px-5 py-2.5 rounded-xl text-sm text-white flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                + NEW QUEST
            </a>
        </div>
    </div>

    <!-- ─── Stat Cards ──────────────────────────────────────────── -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach ($statCards as $card)
            <div class="stat-card rounded-2xl p-6 inner-glow">
                <div class="flex items-start justify-between mb-5">

                    {{-- Icon --}}
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                        style="background:{{ $card['iconBg'] }};border:1px solid {{ $card['iconBorder'] }};">
                        @if ($card['icon'] === 'users')
                            <svg class="w-6 h-6 {{ $card['iconColor'] }}" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        @elseif ($card['icon'] === 'bolt')
                            <svg class="w-6 h-6 {{ $card['iconColor'] }}" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        @elseif ($card['icon'] === 'coin')
                            <svg class="w-6 h-6 {{ $card['iconColor'] }} rank-star" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif ($card['icon'] === 'check')
                            <svg class="w-6 h-6 {{ $card['iconColor'] }}" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        @endif
                    </div>

                    {{-- Delta badge --}}
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                        style="background:{{ $card['positive'] ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.12)' }};
                                 color:{{ $card['positive'] ? '#34d399' : '#f87171' }};
                                 font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;
                                 border:1px solid {{ $card['positive'] ? 'rgba(16,185,129,0.25)' : 'rgba(239,68,68,0.2)' }};">
                        {{ $card['delta'] }}
                    </span>
                </div>

                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.15em;color:rgba(167,139,250,0.6);">
                    {{ $card['label'] }}
                </p>
                <h3 style="font-family:'Rajdhani',sans-serif;font-size:2.2rem;font-weight:700;color:white;line-height:1.1;"
                    class="mt-1">
                    {{ $card['value'] }}
                </h3>

                {{-- Progress bar --}}
                <div class="mt-4 h-1 rounded-full" style="background:{{ $card['barBg'] }};">
                    @if ($card['barColor'])
                        <div class="h-full rounded-full"
                            style="width:{{ $card['pct'] }}%;background:{{ $card['barColor'] }};box-shadow:0 0 8px {{ $card['iconBg'] }};">
                        </div>
                    @else
                        <div class="h-full rounded-full xp-bar-fill" style="width:{{ $card['pct'] }}%;"></div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- ─── Bottom Section ───────────────────────────────────────── -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <!-- Recent Activity (2/3) -->
        <div class="lg:col-span-2 stat-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5 flex items-center justify-between"
                style="border-bottom:1px solid rgba(124,58,237,0.15);">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);">
                    </div>
                    <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                        class="text-white">
                        RECENT QUEST ACTIVITY
                    </h2>
                </div>
                <a href="{{ route('quests') }}"
                    style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:#a78bfa;"
                    class="hover:text-violet-300 transition-colors">
                    VIEW ALL →
                </a>
            </div>

            <div class="divide-y" style="divide-color:rgba(124,58,237,0.08);">
                @forelse ($recentActivity as $activity)
                    <div
                        class="px-6 py-4 flex items-center justify-between group hover:bg-violet-900/10 transition-colors cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-shrink-0"
                                style="background:rgba(124,58,237,0.12);border:1px solid rgba(124,58,237,0.2);">
                                {{ $activity['icon'] }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-purple-100">{{ $activity['text'] }}</p>
                                <p
                                    style="font-size:11px;color:rgba(167,139,250,0.5);font-family:'Rajdhani',sans-serif;letter-spacing:0.04em;">
                                    {{ $activity['time'] }}
                                </p>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full flex-shrink-0"
                            style="background:rgba(124,58,237,0.1);color:{{ $activity['color'] }};font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid {{ $activity['color'] }}22;">
                            {{ $activity['xp'] }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <p
                            style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:0.1em;color:rgba(124,58,237,0.4);">
                            NO RECENT ACTIVITY YET
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quest Status Panel (1/3) -->
        <div class="stat-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#fbbf24,#f59e0b);">
                    </div>
                    <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                        class="text-white">
                        QUEST STATUS
                    </h2>
                </div>
            </div>

            <div class="p-6 space-y-5">
                @foreach ($questStatus as $quest)
                    @php $pct = $quest['max'] > 0 ? round($quest['value'] / $quest['max'] * 100) : 0; @endphp
                    <div>
                        <div class="flex justify-between mb-2">
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:0.06em;color:rgba(167,139,250,0.8);">
                                {{ $quest['label'] }}
                            </span>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;color:{{ $quest['color'] }};">
                                {{ $quest['value'] }}/{{ $quest['max'] }}
                            </span>
                        </div>
                        <div class="h-2 rounded-full" style="background:rgba(124,58,237,0.1);">
                            <div class="h-full rounded-full transition-all"
                                style="width:{{ $pct }}%;background:{{ $quest['color'] }};box-shadow:0 0 8px {{ $quest['color'] }}66;">
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Top Heroes mini leaderboard -->
                <div class="mt-2 pt-4" style="border-top:1px solid rgba(124,58,237,0.15);">
                    <p style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.5);"
                        class="mb-3">
                        TOP HEROES TODAY
                    </p>
                    @forelse ($topHeroes as $hero)
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm">{{ $hero['rank'] }}</span>
                                <span style="font-size:13px;color:#e2d9f3;font-weight:600;">{{ $hero['name'] }}</span>
                            </div>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:11px;color:#fbbf24;font-weight:700;">
                                {{ $hero['xp'] }} XP
                            </span>
                        </div>
                    @empty
                        <p style="font-size:11px;color:rgba(167,139,250,0.3);">No heroes yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
