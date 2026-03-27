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
                    style="background:linear-gradient(to bottom,#fbbf24,#d97706);box-shadow:0 0 12px rgba(251,191,36,0.7);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">
                    POINT SHOP
                </h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">
                Reward Vault — manage merchandise, vouchers, and redemption requests.
            </p>
        </div>
        <button wire:click="openCreate"
            class="btn-primary px-5 py-2.5 rounded-xl text-sm text-white flex items-center gap-2 font-bold self-start md:self-auto"
            style="background:linear-gradient(135deg,#d97706,#fbbf24);border:1px solid rgba(251,191,36,0.4);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;box-shadow:0 0 18px rgba(245,158,11,0.3);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            + ADD ITEM
        </button>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['label' => 'TOTAL ITEMS', 'value' => $stats['total'], 'color' => '#fbbf24', 'border' => 'rgba(245,158,11,0.25)', 'sub' => 'in vault', 'icon' => '🏪'], ['label' => 'PENDING REDEEM', 'value' => $stats['pending'], 'color' => '#f87171', 'border' => 'rgba(239,68,68,0.25)', 'sub' => 'need verify', 'icon' => '⏳'], ['label' => 'COINS SPENT', 'value' => '₿ ' . number_format($stats['coinsSpent']), 'color' => '#a78bfa', 'border' => 'rgba(124,58,237,0.25)', 'sub' => 'all time', 'icon' => '💎'], ['label' => 'OUT OF STOCK', 'value' => $stats['outOfStock'], 'color' => '#fb923c', 'border' => 'rgba(251,146,60,0.25)', 'sub' => 'need restock', 'icon' => '📦']] as $k)
            <div class="stat-card rounded-xl p-5" style="border:1px solid {{ $k['border'] }};">
                <div class="flex items-center justify-between mb-2">
                    <p
                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.6);">
                        {{ $k['label'] }}</p>
                    <span class="text-lg">{{ $k['icon'] }}</span>
                </div>
                <h3
                    style="font-family:'Rajdhani',sans-serif;font-size:1.8rem;font-weight:700;color:{{ $k['color'] }};line-height:1.1;">
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
        @foreach ([['key' => 'inventory', 'label' => 'INVENTORY', 'icon' => '🏪'], ['key' => 'redemptions', 'label' => 'REDEMPTIONS', 'icon' => '🎫'], ['key' => 'history', 'label' => 'HISTORY', 'icon' => '📜']] as $tab)
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


    {{-- ══════════════════════════
         TAB: INVENTORY
    ══════════════════════════ --}}
    @if ($activeTab === 'inventory')

        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:rgba(167,139,250,0.4);"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search item..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm focus:outline-none search-input">
            </div>
            <select wire:model.live="filterType" class="px-4 py-2.5 rounded-xl text-sm focus:outline-none"
                style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);color:rgba(167,139,250,0.8);font-family:'Rajdhani',sans-serif;">
                <option value="all">ALL TYPES</option>
                <option value="merchandise">MERCHANDISE</option>
                <option value="voucher">VOUCHER</option>
                <option value="priority_access">PRIORITY ACCESS</option>
                <option value="other">OTHER</option>
            </select>
            <select wire:model.live="filterStatus" class="px-4 py-2.5 rounded-xl text-sm focus:outline-none"
                style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);color:rgba(167,139,250,0.8);font-family:'Rajdhani',sans-serif;">
                <option value="all">ALL STATUS</option>
                <option value="active">ACTIVE</option>
                <option value="inactive">HIDDEN</option>
                <option value="out">OUT OF STOCK</option>
            </select>
        </div>

        {{-- Items Grid --}}
        @if ($items->isEmpty())
            <div class="stat-card rounded-2xl py-24 text-center">
                <div class="text-5xl mb-4">🏪</div>
                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:14px;letter-spacing:0.12em;color:rgba(124,58,237,0.5);">
                    VAULT IS EMPTY
                </p>
                <p style="font-size:13px;color:rgba(167,139,250,0.35);margin-top:6px;">Add your first reward item</p>
                <button wire:click="openCreate" class="mt-6 px-6 py-2.5 rounded-xl text-sm font-bold text-white"
                    style="background:linear-gradient(135deg,#d97706,#fbbf24);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                    + ADD ITEM
                </button>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($items as $item)
                    @php
                        $typeColors = [
                            'merchandise' => ['c' => '#a78bfa', 'icon' => '👕'],
                            'voucher' => ['c' => '#34d399', 'icon' => '🎫'],
                            'priority_access' => ['c' => '#60a5fa', 'icon' => '🔑'],
                            'other' => ['c' => '#fbbf24', 'icon' => '🎁'],
                        ];
                        $tc = $typeColors[$item->type] ?? $typeColors['other'];
                        $color = $tc['c'];
                        $icon = $tc['icon'];

                        $stockStatus = match (true) {
                            $item->stock === 0 => [
                                'label' => 'SOLD OUT',
                                'c' => '#f87171',
                                'bg' => 'rgba(239,68,68,0.1)',
                                'border' => 'rgba(239,68,68,0.2)',
                            ],
                            $item->stock <= 5 => [
                                'label' => 'LOW STOCK',
                                'c' => '#fbbf24',
                                'bg' => 'rgba(245,158,11,0.1)',
                                'border' => 'rgba(245,158,11,0.2)',
                            ],
                            default => [
                                'label' => 'IN STOCK',
                                'c' => '#34d399',
                                'bg' => 'rgba(16,185,129,0.1)',
                                'border' => 'rgba(16,185,129,0.2)',
                            ],
                        };
                    @endphp
                    <div class="stat-card rounded-2xl overflow-hidden group hover:scale-[1.02] transition-all duration-300 {{ !$item->is_active ? 'opacity-60' : '' }}"
                        style="border:1px solid {{ $color }}20;">
                        <div class="h-1.5" style="background:{{ $color }};opacity:0.7;"></div>
                        <div class="p-4">

                            {{-- Icon + Status --}}
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                                    style="background:{{ $color }}15;border:1px solid {{ $color }}25;">
                                    {{ $icon }}
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="text-xs px-2 py-0.5 rounded-full font-bold"
                                        style="background:{{ $stockStatus['bg'] }};color:{{ $stockStatus['c'] }};font-family:'Rajdhani',sans-serif;font-size:8px;letter-spacing:0.07em;border:1px solid {{ $stockStatus['border'] }};">
                                        {{ $stockStatus['label'] }}
                                    </span>
                                    @if (!$item->is_active)
                                        <span
                                            style="font-family:'Rajdhani',sans-serif;font-size:8px;letter-spacing:0.07em;color:rgba(167,139,250,0.4);">HIDDEN</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Name --}}
                            <p
                                class="text-sm font-bold text-purple-100 mb-1 leading-tight group-hover:text-white transition-colors">
                                {{ $item->name }}
                            </p>

                            {{-- Type badge --}}
                            <span class="text-xs px-2 py-0.5 rounded-md inline-block mb-3"
                                style="background:{{ $color }}12;color:{{ $color }};font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.07em;border:1px solid {{ $color }}20;">
                                {{ strtoupper(str_replace('_', ' ', $item->type)) }}
                            </span>

                            {{-- Description --}}
                            @if ($item->description)
                                <p style="font-size:11px;color:rgba(167,139,250,0.5);line-height:1.4;"
                                    class="mb-3 line-clamp-2">
                                    {{ $item->description }}
                                </p>
                            @endif

                            {{-- Price + Stock --}}
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:rgba(167,139,250,0.45);">
                                        PRICE</p>
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;color:#fbbf24;line-height:1;">
                                        ₿ {{ number_format($item->price_coins) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:rgba(167,139,250,0.45);">
                                        STOCK</p>
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;line-height:1;color:{{ $item->stock === 0 ? '#f87171' : ($item->stock <= 5 ? '#fbbf24' : '#34d399') }};">
                                        {{ $item->stock >= 999 ? '∞' : $item->stock }}
                                    </p>
                                </div>
                            </div>

                            {{-- Redeemed count --}}
                            <p style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.35);letter-spacing:0.06em;"
                                class="mb-3">
                                {{ number_format($item->redemptions_count) }} REDEEMED
                            </p>

                            {{-- Actions --}}
                            <div class="grid grid-cols-3 gap-1.5 pt-3"
                                style="border-top:1px solid rgba(124,58,237,0.1);">
                                <button wire:click="openEdit({{ $item->id }})"
                                    class="py-1.5 rounded-lg text-xs font-bold transition-all"
                                    style="background:rgba(124,58,237,0.1);color:rgba(167,139,250,0.8);font-family:'Rajdhani',sans-serif;letter-spacing:0.04em;border:1px solid rgba(124,58,237,0.2);">
                                    EDIT
                                </button>
                                <button wire:click="openRestock({{ $item->id }})"
                                    class="py-1.5 rounded-lg text-xs font-bold transition-all"
                                    style="background:{{ $color }}12;color:{{ $color }};font-family:'Rajdhani',sans-serif;letter-spacing:0.04em;border:1px solid {{ $color }}22;">
                                    +STOCK
                                </button>
                                <button wire:click="confirmDelete({{ $item->id }})"
                                    class="py-1.5 rounded-lg text-xs font-bold transition-all"
                                    style="background:rgba(239,68,68,0.08);color:rgba(248,113,113,0.6);font-family:'Rajdhani',sans-serif;border:1px solid rgba(239,68,68,0.15);">
                                    DEL
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-between items-center">
                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:rgba(167,139,250,0.45);">
                    SHOWING {{ $items->firstItem() }}–{{ $items->lastItem() }} OF {{ $items->total() }} ITEMS
                </p>
                {{ $items->links() }}
            </div>
        @endif


        {{-- ══════════════════════════
         TAB: REDEMPTIONS
    ══════════════════════════ --}}
    @elseif($activeTab === 'redemptions')
        @if ($stats['pending'] > 0)
            <div class="px-5 py-3.5 rounded-xl flex items-center gap-3"
                style="background:rgba(248,113,113,0.08);border:1px solid rgba(248,113,113,0.25);">
                <div class="w-2 h-2 rounded-full flex-shrink-0"
                    style="background:#f87171;box-shadow:0 0 6px #f87171;animation:notifPulse 1.5s infinite;"></div>
                <p style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:0.05em;color:#f87171;">
                    {{ $stats['pending'] }} REDEMPTIONS PENDING VERIFICATION — Students are waiting.
                </p>
            </div>
        @endif

        {{-- Filter tabs --}}
        <div class="flex gap-2">
            @foreach (['all' => 'ALL', 'pending' => 'PENDING', 'verified' => 'VERIFIED', 'cancelled' => 'REJECTED'] as $key => $label)
                <button wire:click="$set('redemptionFilter', '{{ $key }}')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all"
                    style="font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;
                        {{ $redemptionFilter === $key
                            ? 'background:rgba(124,58,237,0.4);color:#e2d9f3;border:1px solid rgba(167,139,250,0.3);'
                            : 'color:rgba(167,139,250,0.45);border:1px solid rgba(124,58,237,0.15);' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="stat-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5 flex items-center gap-3" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#f87171,#dc2626);">
                </div>
                <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                    class="text-white">
                    REDEMPTION REQUESTS
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(124,58,237,0.1);">
                            @foreach (['CODE', 'STUDENT', 'ITEM', 'COINS', 'REQUESTED', 'STATUS', 'ACTION'] as $col)
                                <th class="px-5 py-3 text-left"
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.45);">
                                    {{ $col }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($redemptions as $r)
                            <tr class="group transition-colors hover:bg-violet-900/10"
                                style="border-bottom:1px solid rgba(124,58,237,0.07);">
                                <td class="px-5 py-3.5">
                                    <code
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(124,58,237,0.6);letter-spacing:0.06em;">
                                        {{ $r->redemption_code }}
                                    </code>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0"
                                            style="border:1px solid rgba(124,58,237,0.25);background:rgba(124,58,237,0.12);">
                                            <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $r->user?->email }}&backgroundColor=1a1033"
                                                class="w-full h-full" alt="">
                                        </div>
                                        <div>
                                            <p style="font-size:12px;font-weight:600;color:#e2d9f3;">
                                                {{ $r->user?->name ?? 'Unknown' }}</p>
                                            <p
                                                style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.4);">
                                                {{ $r->user?->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <span
                                            style="font-size:12px;color:#e2d9f3;">{{ $r->item?->name ?? 'Deleted Item' }}</span>
                                        @if ($r->quantity > 1)
                                            <span
                                                style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.5);">×{{ $r->quantity }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:#fbbf24;">
                                        ₿ {{ number_format($r->total_price_coins) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.5);">
                                        {{ $r->created_at->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    @php
                                        $sc = match ($r->status) {
                                            'pending' => [
                                                'bg' => 'rgba(248,113,113,0.1)',
                                                'c' => '#f87171',
                                                'b' => 'rgba(248,113,113,0.25)',
                                                'label' => 'PENDING',
                                            ],
                                            'verified' => [
                                                'bg' => 'rgba(16,185,129,0.1)',
                                                'c' => '#34d399',
                                                'b' => 'rgba(16,185,129,0.25)',
                                                'label' => 'VERIFIED ✓',
                                            ],
                                            'completed' => [
                                                'bg' => 'rgba(59,130,246,0.1)',
                                                'c' => '#60a5fa',
                                                'b' => 'rgba(59,130,246,0.25)',
                                                'label' => 'COMPLETED',
                                            ],
                                            default => [
                                                'bg' => 'rgba(124,58,237,0.1)',
                                                'c' => 'rgba(167,139,250,0.5)',
                                                'b' => 'rgba(124,58,237,0.2)',
                                                'label' => 'REJECTED',
                                            ],
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold"
                                        style="background:{{ $sc['bg'] }};color:{{ $sc['c'] }};font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid {{ $sc['b'] }};">
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    @if ($r->status === 'pending')
                                        <div class="flex gap-2">
                                            <button wire:click="verifyRedemption({{ $r->id }})"
                                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all"
                                                style="background:rgba(16,185,129,0.12);color:#34d399;font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(16,185,129,0.25);">
                                                ✓ VERIFY
                                            </button>
                                            <button wire:click="rejectRedemption({{ $r->id }})"
                                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all"
                                                style="background:rgba(239,68,68,0.08);color:#f87171;font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(239,68,68,0.2);">
                                                ✕
                                            </button>
                                        </div>
                                    @elseif($r->verifier)
                                        <span
                                            style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.35);">
                                            by {{ $r->verifier->name }}
                                        </span>
                                    @else
                                        <span style="color:rgba(167,139,250,0.3);font-size:13px;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:0.1em;color:rgba(124,58,237,0.4);">
                                        NO REDEMPTIONS FOUND
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4" style="border-top:1px solid rgba(124,58,237,0.1);">
                {{ $redemptions->links() }}
            </div>
        </div>


        {{-- ══════════════════════════
         TAB: HISTORY
    ══════════════════════════ --}}
    @elseif($activeTab === 'history')
        <div class="stat-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5 flex items-center gap-3" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);">
                </div>
                <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                    class="text-white">
                    TRANSACTION HISTORY
                </h2>
            </div>
            <div class="divide-y" style="divide-color:rgba(124,58,237,0.08);">
                @forelse($history as $tx)
                    @php
                        $typeColors = [
                            'merchandise' => '#a78bfa',
                            'voucher' => '#34d399',
                            'priority_access' => '#60a5fa',
                            'other' => '#fbbf24',
                        ];
                        $txColor = $typeColors[$tx->item?->type ?? 'other'] ?? '#a78bfa';
                    @endphp
                    <div
                        class="px-5 py-3.5 flex items-center justify-between group hover:bg-violet-900/10 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                                style="background:{{ $txColor }}15;border:1px solid {{ $txColor }}25;">
                                <span style="font-size:16px;">
                                    @switch($tx->item?->type)
                                        @case('merchandise')
                                            👕
                                        @break

                                        @case('voucher')
                                            🎫
                                        @break

                                        @case('priority_access')
                                            🔑
                                        @break

                                        @default
                                            🎁
                                    @endswitch
                                </span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p style="font-size:12px;font-weight:600;color:#e2d9f3;">
                                        {{ $tx->user?->name ?? 'Unknown' }}</p>
                                    <span style="font-size:10px;color:rgba(167,139,250,0.4);">→</span>
                                    <p style="font-size:12px;color:rgba(167,139,250,0.7);">
                                        {{ $tx->item?->name ?? 'Deleted Item' }}</p>
                                </div>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(167,139,250,0.35);">
                                    {{ $tx->created_at->format('d M Y, H:i') }} · {{ $tx->redemption_code }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:#fbbf24;">
                                ₿ {{ number_format($tx->total_price_coins) }}
                            </span>
                            @if ($tx->status === 'cancelled')
                                <span style="font-size:14px;" title="Rejected">❌</span>
                            @else
                                <span style="font-size:14px;" title="Completed">✅</span>
                            @endif
                        </div>
                    </div>
                    @empty
                        <div class="py-16 text-center">
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:0.1em;color:rgba(124,58,237,0.4);">
                                NO HISTORY YET
                            </p>
                        </div>
                    @endforelse
                </div>
                <div class="px-6 py-4" style="border-top:1px solid rgba(124,58,237,0.1);">
                    {{ $history->links() }}
                </div>
            </div>
        @endif


        {{-- ══════════════════════════
         MODAL: CREATE / EDIT ITEM
    ══════════════════════════ --}}
        @if ($showItemModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100">
                <div wire:click="$set('showItemModal', false)" class="absolute inset-0"
                    style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
                <div class="relative w-full max-w-lg rounded-2xl overflow-hidden z-10"
                    style="background:#13111c;border:1px solid rgba(251,191,36,0.3);box-shadow:0 0 60px rgba(251,191,36,0.08),0 25px 80px rgba(0,0,0,0.8);max-height:90vh;overflow-y:auto;"
                    x-show="true" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">

                    <div class="h-1" style="background:linear-gradient(90deg,#d97706,#fbbf24,#d97706);"></div>

                    <div class="px-6 py-5 flex items-center justify-between sticky top-0 z-10"
                        style="background:#13111c;border-bottom:1px solid rgba(251,191,36,0.12);">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-7 rounded-full"
                                style="background:linear-gradient(to bottom,#fbbf24,#d97706);box-shadow:0 0 10px rgba(251,191,36,0.4);">
                            </div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;letter-spacing:0.06em;"
                                class="text-white">
                                {{ $editingId ? 'EDIT ITEM' : 'ADD NEW ITEM' }}
                            </h2>
                        </div>
                        <button wire:click="$set('showItemModal', false)"
                            class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-red-500/20"
                            style="border:1px solid rgba(239,68,68,0.25);color:rgba(248,113,113,0.7);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-5">

                        {{-- Name --}}
                        <div>
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                                class="block mb-2">
                                ITEM NAME *
                            </label>
                            <input wire:model="itemName" type="text" placeholder="e.g. Voucher Kantin 15k"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm focus:outline-none">
                            @error('itemName')
                                <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Type + Active toggle --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                                    class="block mb-2">
                                    ITEM TYPE *
                                </label>
                                <select wire:model="itemType"
                                    class="modal-input w-full px-4 py-3 rounded-xl text-sm focus:outline-none appearance-none">
                                    <option value="merchandise">Merchandise</option>
                                    <option value="voucher">Voucher</option>
                                    <option value="priority_access">Priority Access</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                                    class="block mb-2">
                                    VISIBILITY
                                </label>
                                <div class="flex items-center gap-3 h-12 px-4 rounded-xl"
                                    style="background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.2);">
                                    <button type="button" wire:click="$set('itemIsActive', true)"
                                        class="flex-1 py-1 rounded-lg text-xs font-bold transition-all"
                                        style="font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;
                                        {{ $itemIsActive ? 'background:rgba(16,185,129,0.2);color:#34d399;border:1px solid rgba(16,185,129,0.3);' : 'color:rgba(167,139,250,0.4);border:1px solid transparent;' }}">
                                        ACTIVE
                                    </button>
                                    <button type="button" wire:click="$set('itemIsActive', false)"
                                        class="flex-1 py-1 rounded-lg text-xs font-bold transition-all"
                                        style="font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;
                                        {{ !$itemIsActive ? 'background:rgba(124,58,237,0.2);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);' : 'color:rgba(167,139,250,0.4);border:1px solid transparent;' }}">
                                        HIDDEN
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                                class="block mb-2">
                                DESCRIPTION
                            </label>
                            <textarea wire:model="itemDesc" rows="2" placeholder="Brief description shown to students..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm focus:outline-none resize-none"></textarea>
                            @error('itemDesc')
                                <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Price + Stock --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl"
                                style="background:rgba(251,191,36,0.06);border:1px solid rgba(251,191,36,0.15);">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:#fbbf24;"
                                    class="block mb-2">
                                    ₿ COIN PRICE *
                                </label>
                                <input wire:model="itemPrice" type="number" min="1"
                                    class="w-full bg-transparent text-2xl font-bold focus:outline-none"
                                    style="font-family:'Rajdhani',sans-serif;color:#fbbf24;">
                                @error('itemPrice')
                                    <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="p-4 rounded-xl"
                                style="background:rgba(52,211,153,0.06);border:1px solid rgba(52,211,153,0.15);">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:#34d399;"
                                    class="block mb-2">
                                    STOCK QTY *
                                </label>
                                <input wire:model="itemStock" type="number" min="0"
                                    class="w-full bg-transparent text-2xl font-bold focus:outline-none"
                                    style="font-family:'Rajdhani',sans-serif;color:#34d399;">
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;color:rgba(52,211,153,0.5);margin-top:2px;">
                                    999 = unlimited
                                </p>
                                @error('itemStock')
                                    <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="px-6 py-4 flex gap-3 sticky bottom-0"
                        style="background:#13111c;border-top:1px solid rgba(251,191,36,0.1);">
                        <button wire:click="$set('showItemModal', false)"
                            class="flex-1 py-2.5 rounded-xl text-sm font-bold"
                            style="background:rgba(124,58,237,0.08);color:rgba(167,139,250,0.7);font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(124,58,237,0.2);">
                            CANCEL
                        </button>
                        <button wire:click="saveItem"
                            class="flex-1 py-2.5 rounded-xl text-sm font-bold text-white hover:opacity-90"
                            style="background:linear-gradient(135deg,#d97706,#fbbf24);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(251,191,36,0.3);box-shadow:0 0 20px rgba(251,191,36,0.15);">
                            {{ $editingId ? '✏️ UPDATE ITEM' : '💎 SAVE TO VAULT' }}
                        </button>
                    </div>
                </div>
            </div>
        @endif


        {{-- ══════════════════════════
         MODAL: RESTOCK
    ══════════════════════════ --}}
        @if ($showRestockModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100">
                <div wire:click="$set('showRestockModal', false)" class="absolute inset-0"
                    style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
                <div class="modal-panel relative w-full max-w-sm rounded-2xl overflow-hidden z-10" x-show="true"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                    <div class="h-1 w-full" style="background:linear-gradient(90deg,#059669,#34d399,#059669);"></div>
                    <div class="p-8 space-y-5">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="w-1.5 h-6 rounded-full"
                                style="background:linear-gradient(to bottom,#34d399,#059669);"></div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;letter-spacing:0.05em;"
                                class="text-white">
                                RESTOCK ITEM
                            </h2>
                        </div>
                        <p style="font-size:13px;color:rgba(167,139,250,0.6);">
                            Adding stock to <strong style="color:#e2d9f3;">{{ $restockName }}</strong>
                        </p>
                        <div>
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                                class="block mb-2">
                                ADD QTY
                            </label>
                            <input wire:model="restockQty" type="number" min="1"
                                class="modal-input w-full px-4 py-3 rounded-xl text-2xl font-bold focus:outline-none"
                                style="font-family:'Rajdhani',sans-serif;color:#34d399;">
                            @error('restockQty')
                                <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex gap-3 pt-1">
                            <button type="button" wire:click="$set('showRestockModal', false)"
                                class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                                CANCEL
                            </button>
                            <button wire:click="restock" type="button"
                                class="flex-1 py-3 rounded-xl text-sm font-bold text-white"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#059669,#34d399);border:1px solid rgba(52,211,153,0.4);">
                                ✓ UPDATE STOCK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- ══════════════════════════
         MODAL: DELETE CONFIRM
    ══════════════════════════ --}}
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
                                    class="text-white mb-2">
                                    DELETE ITEM
                                </h2>
                                <p style="color:rgba(167,139,250,0.6);font-size:0.875rem;line-height:1.6;">
                                    Permanently remove<br>
                                    <span class="text-white font-bold">{{ $deleteName }}</span><br>
                                    and all its redemption records.
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" wire:click="$set('showDeleteModal', false)"
                                class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                                ABORT
                            </button>
                            <button wire:click="deleteItem" type="button"
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
