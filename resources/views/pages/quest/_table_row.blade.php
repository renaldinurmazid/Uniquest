{{-- ─── Single Quest Table Row ─────────────────────────
     Usage: @include('quest-management._table_row', ['event' => $event])
──────────────────────────────────────────────────── --}}
@php
    $filled = $event->registrations->whereIn('status', ['registered', 'attended'])->count();
    $pct = $event->quota > 0 ? round(($filled / $event->quota) * 100) : 0;

    $catColors = [
        'academic' => '#a78bfa',
        'non-academic' => '#60a5fa',
        'volunteer' => '#34d399',
        'other' => '#fb923c',
    ];
    $catColor = $catColors[$event->category] ?? '#a78bfa';

    $catIcons = [
        'academic' => '📚',
        'non-academic' => '🏆',
        'volunteer' => '🤝',
        'other' => '⚡',
    ];
    $catIcon = $catIcons[$event->category] ?? '⚡';

    $statusConfig = [
        'published' => [
            'bg' => 'rgba(16,185,129,0.12)',
            'color' => '#34d399',
            'border' => 'rgba(16,185,129,0.25)',
            'dot' => true,
        ],
        'ongoing' => [
            'bg' => 'rgba(124,58,237,0.12)',
            'color' => '#a78bfa',
            'border' => 'rgba(124,58,237,0.25)',
            'dot' => true,
        ],
        'draft' => [
            'bg' => 'rgba(245,158,11,0.12)',
            'color' => '#fbbf24',
            'border' => 'rgba(245,158,11,0.25)',
            'dot' => false,
        ],
        'completed' => [
            'bg' => 'rgba(59,130,246,0.12)',
            'color' => '#60a5fa',
            'border' => 'rgba(59,130,246,0.25)',
            'dot' => false,
        ],
        'cancelled' => [
            'bg' => 'rgba(239,68,68,0.12)',
            'color' => '#f87171',
            'border' => 'rgba(239,68,68,0.25)',
            'dot' => false,
        ],
    ];
    $sc = $statusConfig[$event->status] ?? $statusConfig['draft'];
@endphp

<tr class="group transition-colors hover:bg-violet-900/10" style="border-bottom:1px solid rgba(124,58,237,0.08);">

    {{-- Quest Title --}}
    <td class="px-5 py-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 text-base"
                style="background:rgba(124,58,237,0.15);border:1px solid rgba(124,58,237,0.25);">
                {{ $catIcon }}
            </div>
            <div>
                <p class="text-sm font-semibold text-purple-100">{{ $event->title }}</p>
                <p style="font-size:11px;color:rgba(167,139,250,0.4);font-family:'Rajdhani',sans-serif;">
                    #QST-{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}
                    @if ($event->organization)
                        · {{ $event->organization->name }}
                    @endif
                </p>
            </div>
        </div>
    </td>

    {{-- Category --}}
    <td class="px-5 py-4">
        <span class="text-xs font-bold px-2.5 py-1 rounded-full uppercase"
            style="background:{{ $catColor }}18;color:{{ $catColor }};font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;border:1px solid {{ $catColor }}30;">
            {{ $event->category }}
        </span>
    </td>

    {{-- Date --}}
    <td class="px-5 py-4">
        <span style="font-size:12px;color:rgba(167,139,250,0.7);font-family:'Rajdhani',sans-serif;">
            {{ $event->event_date->format('d M Y') }}
        </span>
    </td>

    {{-- Quota Progress --}}
    <td class="px-5 py-4">
        <div class="w-24">
            <div class="flex justify-between mb-1">
                <span style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.8);">
                    {{ $filled }}/{{ $event->quota }}
                </span>
            </div>
            <div class="h-1.5 rounded-full" style="background:rgba(124,58,237,0.12);">
                <div class="h-full rounded-full"
                    style="width:{{ $pct }}%;
                    {{ $pct >= 100
                        ? 'background:linear-gradient(90deg,#059669,#34d399);'
                        : ($pct >= 70
                            ? 'background:linear-gradient(90deg,#d97706,#fbbf24);'
                            : 'background:linear-gradient(90deg,#7c3aed,#a78bfa);') }}">
                </div>
            </div>
        </div>
    </td>

    {{-- Reward --}}
    <td class="px-5 py-4">
        <div class="flex flex-col gap-0.5">
            <span style="font-family:'Rajdhani',sans-serif;font-size:12px;color:#a78bfa;">⚡ {{ $event->exp_reward }}
                XP</span>
            <span style="font-family:'Rajdhani',sans-serif;font-size:12px;color:#fbbf24;">₿
                {{ $event->coin_reward }}</span>
        </div>
    </td>

    {{-- Skills --}}
    <td class="px-5 py-4">
        <div class="flex flex-wrap gap-1 max-w-[150px]">
            @forelse($event->skills ?? [] as $skill)
                <span class="px-1.5 py-0.5 rounded text-[10px] font-medium"
                    style="background:rgba(167,139,250,0.1); color:rgba(167,139,250,0.8); border:1px solid rgba(167,139,250,0.2); font-family:'Rajdhani',sans-serif;">
                    {{ strtoupper($skill->name) }}
                </span>
            @empty
                <span style="color:rgba(167,139,250,0.3); font-family:'Rajdhani',sans-serif;">-</span>
            @endforelse
        </div>
    </td>

    {{-- Status --}}
    <td class="px-5 py-4">
        <span class="text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 w-fit"
            style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid {{ $sc['border'] }};">
            @if ($sc['dot'])
                <span class="w-1.5 h-1.5 rounded-full inline-block"
                    style="background:{{ $sc['color'] }};box-shadow:0 0 4px {{ $sc['color'] }};"></span>
            @endif
            {{ strtoupper($event->status) }}
        </span>
    </td>

    {{-- Actions --}}
    <td class="px-5 py-4">
        <div class="flex items-center gap-2">
            {{-- QR --}}
            <button wire:click="openQRModal({{ $event->id }})" title="QR Code"
                class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:bg-violet-500/20"
                style="border:1px solid rgba(124,58,237,0.25);color:rgba(167,139,250,0.7);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </button>
            {{-- Edit --}}
            <button wire:click="openEdit({{ $event->id }})" title="Edit"
                class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:bg-violet-500/20"
                style="border:1px solid rgba(124,58,237,0.25);color:rgba(167,139,250,0.7);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>
            {{-- Delete --}}
            <button wire:click="confirmDelete({{ $event->id }})" title="Delete"
                class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:bg-red-500/20"
                style="border:1px solid rgba(239,68,68,0.2);color:rgba(248,113,113,0.6);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    </td>
</tr>
