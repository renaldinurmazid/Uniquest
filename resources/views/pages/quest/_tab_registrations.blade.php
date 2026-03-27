{{-- resources/views/pages/quest/_tab_registrations.blade.php --}}

{{-- Filter Bar --}}
<div class="flex flex-col sm:flex-row gap-3 mb-5">
    {{-- Search by student name --}}
    <div class="flex-1 relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:rgba(167,139,250,0.4);" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input wire:model.live.debounce.300ms="regSearch" type="text" placeholder="Search by student name..."
            class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-purple-100 placeholder-purple-400/40 focus:outline-none"
            style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);font-family:'Rajdhani',sans-serif;">
    </div>

    {{-- Filter by event --}}
    <select wire:model.live="regEventId" class="px-4 py-2.5 rounded-xl text-sm focus:outline-none"
        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);color:rgba(167,139,250,0.8);font-family:'Rajdhani',sans-serif;min-width:200px;">
        <option value="">ALL EVENTS</option>
        @foreach ($eventList as $ev)
            <option value="{{ $ev->id }}">{{ Str::limit($ev->title, 40) }}</option>
        @endforeach
    </select>

    {{-- Filter by status --}}
    <select wire:model.live="regStatus" class="px-4 py-2.5 rounded-xl text-sm focus:outline-none"
        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);color:rgba(167,139,250,0.8);font-family:'Rajdhani',sans-serif;">
        <option value="all">ALL STATUS</option>
        <option value="registered">REGISTERED</option>
        <option value="waitlisted">WAITLISTED</option>
        <option value="attended">ATTENDED</option>
        <option value="cancelled">CANCELLED</option>
    </select>
</div>

{{-- Registrations Table --}}
<div class="stat-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    @foreach (['STUDENT', 'QUEST', 'TICKET', 'REGISTERED AT', 'ATTENDED AT', 'STATUS', 'ACTIONS'] as $col)
                        <th class="px-5 py-4 text-left"
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.5);">
                            {{ $col }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($registrations as $reg)
                    @php
                        $regStatusConfig = [
                            'registered' => [
                                'bg' => 'rgba(124,58,237,0.12)',
                                'color' => '#a78bfa',
                                'border' => 'rgba(124,58,237,0.25)',
                            ],
                            'waitlisted' => [
                                'bg' => 'rgba(245,158,11,0.12)',
                                'color' => '#fbbf24',
                                'border' => 'rgba(245,158,11,0.25)',
                            ],
                            'attended' => [
                                'bg' => 'rgba(16,185,129,0.12)',
                                'color' => '#34d399',
                                'border' => 'rgba(16,185,129,0.25)',
                            ],
                            'cancelled' => [
                                'bg' => 'rgba(239,68,68,0.12)',
                                'color' => '#f87171',
                                'border' => 'rgba(239,68,68,0.25)',
                            ],
                        ];
                        $rs = $regStatusConfig[$reg->status] ?? $regStatusConfig['registered'];
                    @endphp
                    <tr class="group transition-colors hover:bg-violet-900/10"
                        style="border-bottom:1px solid rgba(124,58,237,0.08);">

                        {{-- Student --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0"
                                    style="border:1px solid rgba(124,58,237,0.25);background:rgba(124,58,237,0.1);">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($reg->user?->name ?? 'user') }}"
                                        class="w-full h-full" alt="">
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-purple-100">{{ $reg->user?->name ?? '—' }}</p>
                                    <p
                                        style="font-size:11px;color:rgba(167,139,250,0.4);font-family:'Rajdhani',sans-serif;">
                                        {{ $reg->user?->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Quest --}}
                        <td class="px-5 py-4">
                            <p class="text-sm text-purple-200 font-medium">
                                {{ Str::limit($reg->event?->title ?? '—', 35) }}</p>
                            @if ($reg->event?->organization)
                                <p
                                    style="font-size:11px;color:rgba(167,139,250,0.4);font-family:'Rajdhani',sans-serif;">
                                    {{ $reg->event->organization->name }}</p>
                            @endif
                        </td>

                        {{-- Ticket --}}
                        <td class="px-5 py-4">
                            <span class="font-mono text-xs px-2 py-1 rounded-lg"
                                style="background:rgba(124,58,237,0.08);color:rgba(167,139,250,0.7);border:1px solid rgba(124,58,237,0.15);letter-spacing:0.08em;">
                                {{ $reg->ticket_code }}
                            </span>
                        </td>

                        {{-- Registered At --}}
                        <td class="px-5 py-4">
                            <span style="font-size:12px;color:rgba(167,139,250,0.6);font-family:'Rajdhani',sans-serif;">
                                {{ $reg->created_at?->format('d M Y') }}<br>
                                <span
                                    style="color:rgba(167,139,250,0.4);font-size:11px;">{{ $reg->created_at?->format('H:i') }}</span>
                            </span>
                        </td>

                        {{-- Attended At --}}
                        <td class="px-5 py-4">
                            @if ($reg->attended_at)
                                <span style="font-size:12px;color:#34d399;font-family:'Rajdhani',sans-serif;">
                                    {{ $reg->attended_at->format('d M Y') }}<br>
                                    <span
                                        style="font-size:11px;color:rgba(52,211,153,0.6);">{{ $reg->attended_at->format('H:i') }}</span>
                                </span>
                            @else
                                <span
                                    style="font-size:11px;color:rgba(167,139,250,0.3);font-family:'Rajdhani',sans-serif;">—</span>
                            @endif
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-5 py-4">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                                style="background:{{ $rs['bg'] }};color:{{ $rs['color'] }};font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid {{ $rs['border'] }};">
                                {{ strtoupper($reg->status) }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-1.5">
                                @if ($reg->status === 'registered' || $reg->status === 'waitlisted')
                                    {{-- Mark Attended --}}
                                    <button wire:click="markAttended({{ $reg->id }})" title="Mark as Attended"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:bg-emerald-500/20"
                                        style="border:1px solid rgba(16,185,129,0.25);color:rgba(52,211,153,0.7);">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    {{-- Cancel --}}
                                    <button wire:click="cancelRegistration({{ $reg->id }})"
                                        title="Cancel Registration"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:bg-red-500/20"
                                        style="border:1px solid rgba(239,68,68,0.2);color:rgba(248,113,113,0.6);">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @elseif ($reg->status === 'attended')
                                    {{-- Sudah attended, tampilkan claimed status --}}
                                    <span
                                        style="font-size:10px;font-family:'Rajdhani',sans-serif;color:rgba(52,211,153,0.5);">
                                        {{ $reg->claimed_at ? '✓ CLAIMED' : 'NOT CLAIMED' }}
                                    </span>
                                @else
                                    <span
                                        style="font-size:10px;font-family:'Rajdhani',sans-serif;color:rgba(167,139,250,0.3);">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-24 text-center">
                            <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center"
                                style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                                <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.12em;color:rgba(124,58,237,0.4);">
                                NO REGISTRATIONS FOUND</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($registrations->total() > 0)
        <div class="px-5 py-4 flex items-center justify-between" style="border-top:1px solid rgba(124,58,237,0.12);">
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.06em;color:rgba(167,139,250,0.45);">
                SHOWING {{ $registrations->firstItem() }}–{{ $registrations->lastItem() }} OF
                {{ $registrations->total() }} REGISTRATIONS
            </p>
            <div>{{ $registrations->links() }}</div>
        </div>
    @endif
</div>
