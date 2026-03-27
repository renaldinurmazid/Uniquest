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
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-2 h-8 rounded-full"
                    style="background:linear-gradient(to bottom,#60a5fa,#2563eb);box-shadow:0 0 12px rgba(96,165,250,0.7);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">
                    VERIFICATION CENTER
                </h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">
                Review and verify external certificates submitted by students.
            </p>
        </div>
        {{-- Pending badge --}}
        @if ($stats['pending'] > 0)
            <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl self-start sm:self-auto"
                style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);">
                <div class="w-2 h-2 rounded-full"
                    style="background:#f87171;box-shadow:0 0 6px #f87171;animation:notifPulse 1.5s infinite;"></div>
                <span
                    style="font-family:'Rajdhani',sans-serif;font-size:12px;font-weight:700;color:#f87171;letter-spacing:0.08em;">
                    {{ $stats['pending'] }} AWAITING REVIEW
                </span>
            </div>
        @endif
    </div>

    {{-- ── Stats ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['label' => 'TOTAL CERTS', 'value' => $stats['total'], 'color' => '#a78bfa', 'border' => 'rgba(124,58,237,0.25)', 'icon' => '📋'], ['label' => 'PENDING', 'value' => $stats['pending'], 'color' => '#fbbf24', 'border' => 'rgba(245,158,11,0.25)', 'icon' => '⏳'], ['label' => 'VERIFIED', 'value' => $stats['verified'], 'color' => '#34d399', 'border' => 'rgba(16,185,129,0.25)', 'icon' => '✅'], ['label' => 'REJECTED', 'value' => $stats['rejected'], 'color' => '#f87171', 'border' => 'rgba(239,68,68,0.25)', 'icon' => '❌']] as $s)
            <div class="stat-card rounded-xl p-5" style="border:1px solid {{ $s['border'] }};">
                <div class="flex items-center justify-between mb-2">
                    <p
                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.15em;color:rgba(167,139,250,0.6);">
                        {{ $s['label'] }}
                    </p>
                    <span class="text-xl">{{ $s['icon'] }}</span>
                </div>
                <h3
                    style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;color:{{ $s['color'] }};line-height:1.1;">
                    {{ $s['value'] }}
                </h3>
            </div>
        @endforeach
    </div>

    {{-- ── Tab Nav ── --}}
    <div class="flex flex-wrap gap-1 p-1 rounded-xl w-fit"
        style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
        @foreach ([['key' => 'pending', 'label' => 'PENDING', 'icon' => '⏳', 'count' => $stats['pending']], ['key' => 'verified', 'label' => 'VERIFIED', 'icon' => '✅', 'count' => $stats['verified']], ['key' => 'rejected', 'label' => 'REJECTED', 'icon' => '❌', 'count' => $stats['rejected']], ['key' => 'all', 'label' => 'ALL', 'icon' => '📋', 'count' => $stats['total']]] as $tab)
            <button wire:click="switchTab('{{ $tab['key'] }}')"
                class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition-all"
                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;
                    {{ $activeTab === $tab['key']
                        ? 'background:rgba(124,58,237,0.6);color:#e2d9f3;border:1px solid rgba(167,139,250,0.4);'
                        : 'color:rgba(167,139,250,0.5);border:1px solid transparent;' }}">
                <span>{{ $tab['icon'] }}</span>
                {{ $tab['label'] }}
                @if ($tab['count'] > 0)
                    <span class="px-1.5 py-0.5 rounded-md text-xs"
                        style="background:rgba(124,58,237,0.3);color:#c4b5fd;font-size:10px;">
                        {{ $tab['count'] }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    {{-- ── Search ── --}}
    <div class="relative max-w-md">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
            style="color:rgba(167,139,250,0.5);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input wire:model.live.debounce.300ms="search" type="text"
            placeholder="Search by title, organizer, or student name..."
            class="search-input w-full pl-11 pr-4 py-3 rounded-xl text-sm">
    </div>

    {{-- ── Certificates Table ── --}}
    <div class="stat-card rounded-2xl overflow-hidden">
        <div class="px-6 py-5 flex items-center justify-between" style="border-bottom:1px solid rgba(124,58,237,0.15);">
            <div class="flex items-center gap-3">
                <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#60a5fa,#2563eb);"></div>
                <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                    class="text-white">
                    {{ strtoupper($activeTab) }} CERTIFICATES
                </h2>
            </div>
            <div class="px-3 py-1.5 rounded-lg"
                style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                <span
                    style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:rgba(96,165,250,0.8);">
                    {{ $certs->total() }} RECORDS
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="border-bottom:1px solid rgba(124,58,237,0.1);">
                        @foreach (['STUDENT', 'CERTIFICATE', 'ORGANIZER', 'ISSUED', 'SUBMITTED', 'STATUS', 'ACTION'] as $col)
                            <th class="px-5 py-4 text-left"
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.5);">
                                {{ $col }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($certs as $cert)
                        @php
                            $statusConfig = [
                                'pending' => [
                                    'bg' => 'rgba(245,158,11,0.1)',
                                    'c' => '#fbbf24',
                                    'b' => 'rgba(245,158,11,0.25)',
                                    'label' => 'PENDING',
                                    'dot' => true,
                                ],
                                'verified' => [
                                    'bg' => 'rgba(16,185,129,0.1)',
                                    'c' => '#34d399',
                                    'b' => 'rgba(16,185,129,0.25)',
                                    'label' => 'VERIFIED',
                                    'dot' => false,
                                ],
                                'rejected' => [
                                    'bg' => 'rgba(239,68,68,0.1)',
                                    'c' => '#f87171',
                                    'b' => 'rgba(239,68,68,0.25)',
                                    'label' => 'REJECTED',
                                    'dot' => false,
                                ],
                            ];
                            $sc = $statusConfig[$cert->status] ?? $statusConfig['pending'];
                        @endphp
                        <tr class="group transition-colors hover:bg-violet-900/10"
                            style="border-bottom:1px solid rgba(124,58,237,0.07);">

                            {{-- Student --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl overflow-hidden flex-shrink-0"
                                        style="border:1px solid rgba(124,58,237,0.3);background:rgba(124,58,237,0.1);">
                                        <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $cert->user?->email }}&backgroundColor=1a1033"
                                            class="w-full h-full" alt="">
                                    </div>
                                    <div>
                                        <p style="font-size:13px;font-weight:600;color:#e2d9f3;">
                                            {{ $cert->user?->name ?? 'Unknown' }}
                                        </p>
                                        <p
                                            style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.45);">
                                            {{ $cert->user?->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Certificate title --}}
                            <td class="px-5 py-4">
                                <p style="font-size:13px;font-weight:600;color:#e2d9f3;max-width:200px;"
                                    class="truncate">
                                    {{ $cert->title }}
                                </p>
                                @if ($cert->status === 'verified' && $cert->exp_reward_given > 0)
                                    <div class="flex items-center gap-2 mt-1">
                                        <span style="font-family:'Rajdhani',sans-serif;font-size:10px;color:#a78bfa;">⚡
                                            {{ $cert->exp_reward_given }} XP</span>
                                        <span style="font-family:'Rajdhani',sans-serif;font-size:10px;color:#fbbf24;">₿
                                            {{ $cert->coin_reward_given }}</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Organizer --}}
                            <td class="px-5 py-4">
                                <p style="font-size:12px;color:rgba(167,139,250,0.7);max-width:160px;" class="truncate">
                                    {{ $cert->organizer }}
                                </p>
                            </td>

                            {{-- Issue date --}}
                            <td class="px-5 py-4">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:12px;color:rgba(167,139,250,0.6);">
                                    {{ $cert->issue_date->format('d M Y') }}
                                </span>
                            </td>

                            {{-- Submitted --}}
                            <td class="px-5 py-4">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.5);">
                                    {{ $cert->created_at->diffForHumans() }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-fit"
                                    style="background:{{ $sc['bg'] }};color:{{ $sc['c'] }};font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid {{ $sc['b'] }};">
                                    @if ($sc['dot'])
                                        <span class="w-1.5 h-1.5 rounded-full inline-block"
                                            style="background:{{ $sc['c'] }};box-shadow:0 0 4px {{ $sc['c'] }};"></span>
                                    @endif
                                    {{ $sc['label'] }}
                                </span>
                            </td>

                            {{-- Action --}}
                            <td class="px-5 py-4">
                                @if ($cert->status === 'pending')
                                    <button wire:click="openDetail({{ $cert->id }})"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5"
                                        style="background:rgba(96,165,250,0.12);color:#60a5fa;font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(96,165,250,0.25);">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        REVIEW
                                    </button>
                                @else
                                    <button wire:click="openDetail({{ $cert->id }})"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all"
                                        style="background:rgba(124,58,237,0.08);color:rgba(167,139,250,0.6);font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(124,58,237,0.15);">
                                        VIEW
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-24 text-center">
                                <div class="text-5xl mb-4">
                                    {{ $activeTab === 'pending' ? '⏳' : ($activeTab === 'verified' ? '✅' : '📋') }}
                                </div>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.12em;color:rgba(124,58,237,0.4);">
                                    NO {{ strtoupper($activeTab) }} CERTIFICATES
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 flex items-center justify-between" style="border-top:1px solid rgba(124,58,237,0.1);">
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:rgba(167,139,250,0.45);">
                @if ($certs->total() > 0)
                    SHOWING {{ $certs->firstItem() }}–{{ $certs->lastItem() }} OF {{ $certs->total() }}
                @else
                    NO RECORDS
                @endif
            </p>
            {{ $certs->links() }}
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════
         MODAL: DETAIL / REVIEW
    ══════════════════════════════════════════════════════ --}}
    @if ($showDetailModal && $selected)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="closeModals" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>

            <div class="relative w-full max-w-2xl rounded-2xl overflow-hidden z-10"
                style="background:#13111c;border:1px solid rgba(96,165,250,0.3);box-shadow:0 25px 80px rgba(0,0,0,0.8);max-height:92vh;overflow-y:auto;"
                x-show="true" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">

                <div class="h-1 w-full" style="background:linear-gradient(90deg,#2563eb,#60a5fa,#2563eb);"></div>

                {{-- Header --}}
                <div class="px-6 py-5 flex items-center justify-between sticky top-0 z-10"
                    style="background:#13111c;border-bottom:1px solid rgba(96,165,250,0.15);">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-6 rounded-full"
                            style="background:linear-gradient(to bottom,#60a5fa,#2563eb);"></div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;letter-spacing:0.05em;"
                            class="text-white">
                            {{ $selected->status === 'pending' ? 'REVIEW CERTIFICATE' : 'CERTIFICATE DETAIL' }}
                        </h2>
                    </div>
                    <button wire:click="closeModals"
                        class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-6">

                    {{-- Student info --}}
                    <div class="flex items-center gap-4 p-4 rounded-xl"
                        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);">
                        <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0"
                            style="border:2px solid rgba(124,58,237,0.4);">
                            <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $selected->user?->email }}&backgroundColor=1a1033"
                                class="w-full h-full" alt="">
                        </div>
                        <div>
                            <p style="font-family:'Rajdhani',sans-serif;font-size:14px;font-weight:700;letter-spacing:0.04em;"
                                class="text-white">
                                {{ $selected->user?->name ?? 'Unknown' }}
                            </p>
                            <p style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.5);">
                                {{ $selected->user?->email }}
                            </p>
                        </div>
                        {{-- Status badge --}}
                        @php
                            $sc2 =
                                [
                                    'pending' => [
                                        'bg' => 'rgba(245,158,11,0.1)',
                                        'c' => '#fbbf24',
                                        'b' => 'rgba(245,158,11,0.25)',
                                        'label' => 'PENDING',
                                    ],
                                    'verified' => [
                                        'bg' => 'rgba(16,185,129,0.1)',
                                        'c' => '#34d399',
                                        'b' => 'rgba(16,185,129,0.25)',
                                        'label' => 'VERIFIED ✓',
                                    ],
                                    'rejected' => [
                                        'bg' => 'rgba(239,68,68,0.1)',
                                        'c' => '#f87171',
                                        'b' => 'rgba(239,68,68,0.25)',
                                        'label' => 'REJECTED',
                                    ],
                                ][$selected->status] ?? [];
                        @endphp
                        <div class="ml-auto">
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold"
                                style="background:{{ $sc2['bg'] }};color:{{ $sc2['c'] }};font-family:'Rajdhani',sans-serif;letter-spacing:0.08em;border:1px solid {{ $sc2['b'] }};">
                                {{ $sc2['label'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Certificate details --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.5);">
                                CERTIFICATE TITLE
                            </p>
                            <p style="font-size:14px;font-weight:600;color:#e2d9f3;">{{ $selected->title }}</p>
                        </div>
                        <div class="space-y-1">
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.5);">
                                ORGANIZER
                            </p>
                            <p style="font-size:14px;font-weight:600;color:#e2d9f3;">{{ $selected->organizer }}</p>
                        </div>
                        <div class="space-y-1">
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.5);">
                                ISSUE DATE
                            </p>
                            <p style="font-size:14px;font-weight:600;color:#e2d9f3;">
                                {{ $selected->issue_date->format('d F Y') }}
                            </p>
                        </div>
                        <div class="space-y-1">
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.5);">
                                SUBMITTED
                            </p>
                            <p style="font-size:14px;font-weight:600;color:#e2d9f3;">
                                {{ $selected->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    {{-- File preview / download --}}
                    <div class="p-4 rounded-xl flex items-center justify-between"
                        style="background:rgba(96,165,250,0.06);border:1px dashed rgba(96,165,250,0.3);">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                style="background:rgba(96,165,250,0.15);border:1px solid rgba(96,165,250,0.3);">
                                <svg class="w-5 h-5" style="color:#60a5fa;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:11px;font-weight:700;color:#60a5fa;letter-spacing:0.05em;">
                                    CERTIFICATE FILE
                                </p>
                                <p style="font-size:11px;color:rgba(167,139,250,0.5);">
                                    {{ basename($selected->file_path) }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $selected->file_path) }}" target="_blank"
                            class="px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5"
                            style="background:rgba(96,165,250,0.15);color:#60a5fa;font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(96,165,250,0.3);">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            OPEN FILE
                        </a>
                    </div>

                    {{-- If already verified/rejected — show notes --}}
                    @if ($selected->status !== 'pending')
                        <div class="p-4 rounded-xl space-y-3"
                            style="background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.2);">
                            <div class="flex items-center gap-2">
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.5);">
                                    REVIEWED BY
                                </p>
                                <p style="font-size:13px;color:#e2d9f3;font-weight:600;">
                                    {{ $selected->verifier?->name ?? 'Admin' }}
                                    <span style="font-size:11px;color:rgba(167,139,250,0.5);font-weight:400;">
                                        · {{ $selected->verified_at?->format('d M Y, H:i') }}
                                    </span>
                                </p>
                            </div>
                            @if ($selected->status === 'verified')
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg"
                                        style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                                        <span style="font-family:'Rajdhani',sans-serif;font-size:11px;color:#a78bfa;">⚡
                                            {{ $selected->exp_reward_given }} XP GIVEN</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg"
                                        style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);">
                                        <span style="font-family:'Rajdhani',sans-serif;font-size:11px;color:#fbbf24;">₿
                                            {{ $selected->coin_reward_given }} COINS GIVEN</span>
                                    </div>
                                </div>
                            @endif
                            @if ($selected->admin_notes)
                                <div>
                                    <p style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.5);"
                                        class="mb-1">
                                        ADMIN NOTES
                                    </p>
                                    <p style="font-size:13px;color:rgba(167,139,250,0.8);line-height:1.6;">
                                        {{ $selected->admin_notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Review form — only for pending --}}
                    @if ($selected->status === 'pending')
                        <div class="space-y-4 pt-2" style="border-top:1px solid rgba(124,58,237,0.15);">
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.1em;color:rgba(167,139,250,0.6);">
                                REWARD SETTINGS
                            </p>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 rounded-xl"
                                    style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);">
                                    <label
                                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:#a78bfa;"
                                        class="block mb-2">
                                        ⚡ EXP REWARD
                                    </label>
                                    <input wire:model="expReward" type="number" min="0" max="9999"
                                        class="w-full bg-transparent text-2xl font-bold focus:outline-none"
                                        style="font-family:'Rajdhani',sans-serif;color:#a78bfa;">
                                    @error('expReward')
                                        <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="p-4 rounded-xl"
                                    style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);">
                                    <label
                                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:#fbbf24;"
                                        class="block mb-2">
                                        ₿ COIN REWARD
                                    </label>
                                    <input wire:model="coinReward" type="number" min="0" max="9999"
                                        class="w-full bg-transparent text-2xl font-bold focus:outline-none"
                                        style="font-family:'Rajdhani',sans-serif;color:#fbbf24;">
                                    @error('coinReward')
                                        <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Admin notes --}}
                            <div>
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.55);"
                                    class="block mb-2">
                                    ADMIN NOTES <span style="color:rgba(167,139,250,0.35);">(OPTIONAL)</span>
                                </label>
                                <textarea wire:model="adminNotes" rows="2" placeholder="Add a note for the student..."
                                    class="modal-input w-full px-4 py-3 rounded-xl text-sm focus:outline-none resize-none"></textarea>
                            </div>

                            {{-- Action buttons --}}
                            <div class="flex gap-3 pt-1">
                                <button wire:click="openReject({{ $selected->id }})"
                                    class="flex-1 py-3 rounded-xl text-sm font-bold transition-all"
                                    style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:rgba(239,68,68,0.08);color:#f87171;border:1px solid rgba(239,68,68,0.25);">
                                    ✕ REJECT
                                </button>
                                <button wire:click="verify"
                                    class="flex-1 py-3 rounded-xl text-sm font-bold text-white transition-all"
                                    style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#059669,#34d399);border:1px solid rgba(52,211,153,0.4);box-shadow:0 0 18px rgba(16,185,129,0.25);">
                                    ✓ VERIFY & REWARD
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-end pt-2">
                            <button wire:click="closeModals"
                                class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:rgba(124,58,237,0.1);color:rgba(167,139,250,0.8);border:1px solid rgba(124,58,237,0.25);">
                                CLOSE
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════
         MODAL: REJECT WITH NOTES
    ══════════════════════════════════════════════════════ --}}
    @if ($showRejectModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="closeModals" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-md rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171,#ef4444);"></div>
                <div class="p-8 space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;letter-spacing:0.05em;"
                                class="text-white">
                                REJECT CERTIFICATE
                            </h2>
                            <p style="color:rgba(167,139,250,0.6);font-size:12px;">Provide a reason for rejection.</p>
                        </div>
                    </div>

                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">
                            REASON / NOTES *
                        </label>
                        <textarea wire:model="rejectNotes" rows="4"
                            placeholder="e.g. Certificate appears to be invalid, please resubmit with a clearer scan..."
                            class="modal-input w-full px-4 py-3 rounded-xl text-sm focus:outline-none resize-none"></textarea>
                        @error('rejectNotes')
                            <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="button" wire:click="closeModals"
                            class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                            CANCEL
                        </button>
                        <button wire:click="reject" type="button"
                            class="flex-1 py-3 rounded-xl text-sm font-bold text-white"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#b91c1c,#ef4444);border:1px solid #ef4444;box-shadow:0 0 16px rgba(239,68,68,0.3);">
                            ⚡ CONFIRM REJECT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
