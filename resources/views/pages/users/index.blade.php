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
                    style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);box-shadow:0 0 12px rgba(124,58,237,0.8);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">SYSTEM USERS</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">
                Manage access keys and authority levels for guild masters & staff.
            </p>
        </div>
        <button wire:click="$set('showCreate', true)"
            class="btn-primary px-6 py-3 rounded-xl text-white text-sm flex items-center gap-2 self-start sm:self-auto whitespace-nowrap"
            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            GRANT ACCESS
        </button>
    </div>

    {{-- ── Stats Row ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['label' => 'TOTAL ADMINS', 'value' => $users->total(), 'color' => '#a78bfa', 'border' => 'rgba(124,58,237,0.25)', 'icon' => '👑'], ['label' => 'SUPERADMIN', 'value' => $users->getCollection()->filter(fn($u) => $u->roles->contains('name', 'superadmin'))->count(), 'color' => '#f472b6', 'border' => 'rgba(244,114,182,0.25)', 'icon' => '⚡'], ['label' => 'ADMIN', 'value' => $users->getCollection()->filter(fn($u) => $u->roles->contains('name', 'admin'))->count(), 'color' => '#60a5fa', 'border' => 'rgba(59,130,246,0.25)', 'icon' => '🛡️'], ['label' => 'STAFF', 'value' => $users->getCollection()->filter(fn($u) => $u->roles->contains('name', 'staff'))->count(), 'color' => '#34d399', 'border' => 'rgba(16,185,129,0.25)', 'icon' => '🔑']] as $s)
            <div class="stat-card rounded-xl p-5" style="border:1px solid {{ $s['border'] }};">
                <div class="flex items-center justify-between mb-2">
                    <p
                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.15em;color:rgba(167,139,250,0.6);">
                        {{ $s['label'] }}</p>
                    <span class="text-xl">{{ $s['icon'] }}</span>
                </div>
                <h3
                    style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;color:{{ $s['color'] }};line-height:1.1;">
                    {{ $s['value'] }}</h3>
            </div>
        @endforeach
    </div>

    {{-- ── Table Card ── --}}
    <div class="stat-card rounded-2xl overflow-hidden">

        {{-- Search + counter --}}
        <div class="px-6 py-5 flex flex-col md:flex-row md:items-center justify-between gap-4"
            style="border-bottom:1px solid rgba(124,58,237,0.15);">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    style="color:rgba(167,139,250,0.5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.500ms="search" type="text" placeholder="Search by name or email..."
                    class="search-input w-full pl-11 pr-4 py-3 rounded-xl text-sm">
            </div>
            <div class="px-4 py-2 rounded-xl"
                style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                <span
                    style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.1em;color:rgba(167,139,250,0.7);">
                    {{ $users->total() }} ACCOUNTS
                </span>
            </div>
        </div>

        {{-- Loading skeleton --}}
        <div wire:loading wire:target="search" class="px-6 py-4 space-y-3">
            @for ($i = 0; $i < 4; $i++)
                <div class="h-14 rounded-xl animate-pulse" style="background:rgba(124,58,237,0.08);"></div>
            @endfor
        </div>

        {{-- Table --}}
        <div wire:loading.remove wire:target="search" class="overflow-x-auto">
            <table class="data-table w-full text-left">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-xs">VAULT ID</th>
                        <th class="px-6 py-4 text-xs">HERO IDENTITY</th>
                        <th class="px-6 py-4 text-xs">AUTHORITY RANK</th>
                        <th class="px-6 py-4 text-xs text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="group">
                            <td class="px-6 py-5">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:rgba(124,58,237,0.6);">
                                    #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative flex-shrink-0">
                                        <div class="w-11 h-11 rounded-xl overflow-hidden"
                                            style="border:2px solid rgba(124,58,237,0.35);background:rgba(124,58,237,0.1);">
                                            <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $user->email }}&backgroundColor=1a1033"
                                                class="w-full h-full" alt="{{ $user->name }}">
                                        </div>
                                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full"
                                            style="background:#34d399;border:2px solid var(--bg-card);box-shadow:0 0 6px rgba(52,211,153,0.6);">
                                        </div>
                                    </div>
                                    <div class="min-w-0">
                                        <p
                                            class="font-bold text-sm text-white group-hover:text-violet-300 transition-colors">
                                            {{ $user->name }}
                                        </p>
                                        <p
                                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.08em;color:rgba(167,139,250,0.5);">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $roleColors = [
                                            'superadmin' => [
                                                'bg' => 'rgba(244,114,182,0.12)',
                                                'c' => '#f472b6',
                                                'b' => 'rgba(244,114,182,0.3)',
                                            ],
                                            'admin' => [
                                                'bg' => 'rgba(96,165,250,0.12)',
                                                'c' => '#60a5fa',
                                                'b' => 'rgba(96,165,250,0.3)',
                                            ],
                                            'staff' => [
                                                'bg' => 'rgba(52,211,153,0.12)',
                                                'c' => '#34d399',
                                                'b' => 'rgba(52,211,153,0.3)',
                                            ],
                                            'student' => [
                                                'bg' => 'rgba(196,181,253,0.12)',
                                                'c' => '#c4b5fd',
                                                'b' => 'rgba(196,181,253,0.3)',
                                            ],
                                            'sub-admin' => [
                                                'bg' => 'rgba(251,191,36,0.12)',
                                                'c' => '#fbbf24',
                                                'b' => 'rgba(251,191,36,0.3)',
                                            ],
                                            'verifier' => [
                                                'bg' => 'rgba(244,114,182,0.12)',
                                                'c' => '#f472b6',
                                                'b' => 'rgba(244,114,182,0.3)',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($user->roles->sortBy('name') as $role)
                                        @php $rc = $roleColors[$role->name] ?? ['bg'=>'rgba(124,58,237,0.12)','c'=>'#a78bfa','b'=>'rgba(124,58,237,0.3)']; @endphp
                                        <span class="text-xs px-3 py-1 rounded-lg font-bold"
                                            style="background:{{ $rc['bg'] }};color:{{ $rc['c'] }};border:1px solid {{ $rc['b'] }};font-family:'Rajdhani',sans-serif;letter-spacing:0.08em;">
                                            {{ strtoupper($role->name) }}
                                        </span>
                                    @endforeach
                                    @if ($user->roles->isEmpty())
                                        <span
                                            style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(124,58,237,0.35);font-style:italic;">
                                            NO RANK
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="openEdit({{ $user->id }})" wire:loading.attr="disabled"
                                        wire:target="openEdit({{ $user->id }})" title="Edit User"
                                        class="p-2.5 rounded-xl transition-all text-violet-500 hover:text-violet-300"
                                        style="border:1px solid rgba(124,58,237,0.2);"
                                        onmouseover="this.style.background='rgba(124,58,237,0.15)'"
                                        onmouseout="this.style.background='transparent'">
                                        <span wire:loading.remove wire:target="openEdit({{ $user->id }})">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </span>
                                        <span wire:loading wire:target="openEdit({{ $user->id }})"
                                            style="font-family:'Rajdhani',sans-serif;font-size:10px;">...</span>
                                    </button>
                                    <button wire:click="confirmDelete({{ $user->id }})" title="Remove Access"
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
                            <td colspan="4" class="py-24 text-center">
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
                                    NO ACCOUNTS FOUND
                                </p>
                                <p style="font-size:12px;color:rgba(167,139,250,0.3);margin-top:4px;">
                                    Try a different search or grant access to a new user
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-5 flex items-center justify-between" style="border-top:1px solid rgba(124,58,237,0.1);">
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.08em;color:rgba(167,139,250,0.45);">
                @if ($users->total() > 0)
                    SHOWING {{ $users->firstItem() }}–{{ $users->lastItem() }} OF {{ $users->total() }}
                @else
                    NO RECORDS
                @endif
            </p>
            {{ $users->links() }}
        </div>
    </div>


    {{-- ══════════════════════════════════════
         MODAL: CREATE
    ══════════════════════════════════════ --}}
    @if ($showCreate)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="$set('showCreate', false)" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>

            <div class="relative z-10 w-full max-w-lg flex flex-col rounded-2xl overflow-hidden"
                style="background:#13111c;border:1px solid rgba(124,58,237,0.4);box-shadow:0 25px 80px rgba(0,0,0,0.8),0 0 40px rgba(124,58,237,0.1);max-height:90vh;"
                x-show="true" x-transition:enter="transition ease-out duration-200 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">

                <div class="flex-shrink-0 h-1 w-full"
                    style="background:linear-gradient(90deg,#7c3aed,#a78bfa,#7c3aed);"></div>

                {{-- Header --}}
                <div class="flex-shrink-0 px-7 py-5 flex items-start justify-between"
                    style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <div class="w-1.5 h-6 rounded-full"
                                style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);"></div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;letter-spacing:0.05em;"
                                class="text-white">GRANT SYSTEM ACCESS</h2>
                        </div>
                        <p style="color:rgba(167,139,250,0.6);font-size:0.8rem;" class="ml-5">
                            Create a new administrative account with role assignment.
                        </p>
                    </div>
                    <button wire:click="$set('showCreate', false)"
                        class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Scrollable body --}}
                <div class="flex-1 overflow-y-auto px-7 py-6">
                    <form wire:submit="createUser" class="space-y-5">

                        {{-- Name --}}
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                HERO NAME
                            </label>
                            <input wire:model="name" type="text" placeholder="Enter full name..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('name')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                EMAIL TERMINAL
                            </label>
                            <input wire:model="email" type="email" placeholder="hero@guild.id"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('email')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Multi-Role Selector --}}
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);">
                                    AUTHORITY RANKS
                                </label>
                                @if (count($roleIds) > 0)
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:#a78bfa;background:rgba(124,58,237,0.15);border:1px solid rgba(124,58,237,0.3);padding:2px 8px;border-radius:6px;">
                                        {{ count($roleIds) }} SELECTED
                                    </span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                @php
                                    $roleColors = [
                                        'superadmin' => [
                                            'c' => '#f472b6',
                                            'b' => 'rgba(244,114,182,0.4)',
                                            'bg' => 'rgba(244,114,182,0.08)',
                                            'icon' => '👑',
                                        ],
                                        'admin' => [
                                            'c' => '#60a5fa',
                                            'b' => 'rgba(96,165,250,0.4)',
                                            'bg' => 'rgba(96,165,250,0.08)',
                                            'icon' => '🛡️',
                                        ],
                                        'staff' => [
                                            'c' => '#34d399',
                                            'b' => 'rgba(52,211,153,0.4)',
                                            'bg' => 'rgba(52,211,153,0.08)',
                                            'icon' => '⚔️',
                                        ],
                                        'student' => [
                                            'c' => '#c4b5fd',
                                            'b' => 'rgba(196,181,253,0.4)',
                                            'bg' => 'rgba(196,181,253,0.08)',
                                            'icon' => '🎓',
                                        ],
                                        'sub-admin' => [
                                            'c' => '#fbbf24',
                                            'b' => 'rgba(251,191,36,0.4)',
                                            'bg' => 'rgba(251,191,36,0.08)',
                                            'icon' => '⭐',
                                        ],
                                        'verifier' => [
                                            'c' => '#f472b6',
                                            'b' => 'rgba(244,114,182,0.4)',
                                            'bg' => 'rgba(244,114,182,0.08)',
                                            'icon' => '🔍',
                                        ],
                                    ];
                                @endphp
                                @foreach ($roles as $role)
                                    @php
                                        $rc = $roleColors[$role->name] ?? [
                                            'c' => '#a78bfa',
                                            'b' => 'rgba(124,58,237,0.4)',
                                            'bg' => 'rgba(124,58,237,0.08)',
                                            'icon' => '🔑',
                                        ];
                                        $isChecked = in_array((string) $role->id, array_map('strval', $roleIds));
                                    @endphp
                                    <label
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl cursor-pointer transition-all"
                                        style="background:{{ $isChecked ? $rc['bg'] : 'rgba(124,58,237,0.04)' }};border:1px solid {{ $isChecked ? $rc['b'] : 'rgba(124,58,237,0.15)' }};"
                                        wire:key="create-role-{{ $role->id }}">
                                        <div class="relative flex-shrink-0">
                                            <input type="checkbox" wire:model.live="roleIds"
                                                value="{{ $role->id }}" class="sr-only peer">
                                            <div class="w-5 h-5 rounded-md flex items-center justify-center transition-all"
                                                style="background:{{ $isChecked ? $rc['b'] : 'rgba(124,58,237,0.1)' }};border:1.5px solid {{ $isChecked ? $rc['c'] : 'rgba(124,58,237,0.25)' }};">
                                                @if ($isChecked)
                                                    <svg class="w-3 h-3" fill="none" stroke="{{ $rc['c'] }}"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold"
                                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;color:{{ $isChecked ? $rc['c'] : 'rgba(167,139,250,0.6)' }};">
                                            {{ $rc['icon'] }} {{ strtoupper($role->name) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('roleIds')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                VAULT PASSWORD
                            </label>
                            <input wire:model="password" type="password" placeholder="Min. 6 characters..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('password')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Preview card --}}
                        <div class="p-4 rounded-xl flex items-center gap-4"
                            style="background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.2);">
                            <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0"
                                style="border:1px solid rgba(124,58,237,0.3);background:rgba(124,58,237,0.1);">
                                <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $email ?: 'new' }}&backgroundColor=1a1033"
                                    class="w-full h-full" alt="Preview">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:#e2d9f3;letter-spacing:0.04em;">
                                    {{ $name ?: 'HERO NAME' }}
                                </p>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.5);">
                                    {{ $email ?: 'hero@guild.id' }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-1 justify-end max-w-[120px]">
                                @foreach ($roles->whereIn('id', $roleIds) as $r)
                                    @php $rc2 = $roleColors[$r->name] ?? ['c'=>'#a78bfa','b'=>'rgba(124,58,237,0.3)','bg'=>'rgba(124,58,237,0.12)']; @endphp
                                    <span class="text-xs px-2 py-0.5 rounded font-bold"
                                        style="background:{{ $rc2['bg'] }};color:{{ $rc2['c'] }};border:1px solid {{ $rc2['b'] }};font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.06em;">
                                        {{ strtoupper($r->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-3 pt-1">
                            <button type="button" wire:click="$set('showCreate', false)"
                                class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                                CANCEL
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="createUser"
                                class="btn-primary flex-1 py-3 rounded-xl text-white text-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                                <span wire:loading.remove wire:target="createUser">🔑 INITIALIZE KEY</span>
                                <span wire:loading wire:target="createUser">CREATING...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════
         MODAL: EDIT
    ══════════════════════════════════════ --}}
    @if ($showEdit)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="$set('showEdit', false)" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>

            <div class="relative z-10 w-full max-w-lg flex flex-col rounded-2xl overflow-hidden"
                style="background:#13111c;border:1px solid rgba(139,92,246,0.4);box-shadow:0 25px 80px rgba(0,0,0,0.8),0 0 40px rgba(139,92,246,0.1);max-height:90vh;"
                x-show="true" x-transition:enter="transition ease-out duration-200 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">

                <div class="flex-shrink-0 h-1 w-full"
                    style="background:linear-gradient(90deg,#8b5cf6,#c4b5fd,#8b5cf6);"></div>

                <div class="flex-shrink-0 px-7 py-5 flex items-start justify-between"
                    style="border-bottom:1px solid rgba(139,92,246,0.15);">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <div class="w-1.5 h-6 rounded-full"
                                style="background:linear-gradient(to bottom,#c4b5fd,#8b5cf6);"></div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;letter-spacing:0.05em;"
                                class="text-white">EDIT ACCOUNT</h2>
                        </div>
                        <p style="color:rgba(167,139,250,0.6);font-size:0.8rem;" class="ml-5">
                            Update identity and authority. Leave password blank to keep current.
                        </p>
                    </div>
                    <button wire:click="$set('showEdit', false)"
                        class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto px-7 py-6">
                    <form wire:submit="updateUser" class="space-y-5">

                        {{-- Name --}}
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                HERO NAME
                            </label>
                            <input wire:model="editName" type="text" placeholder="Enter full name..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('editName')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                EMAIL TERMINAL
                            </label>
                            <input wire:model="editEmail" type="email" placeholder="hero@guild.id"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('editEmail')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Multi-Role Selector --}}
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);">
                                    AUTHORITY RANKS
                                </label>
                                @if (count($editRoleIds) > 0)
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:#a78bfa;background:rgba(124,58,237,0.15);border:1px solid rgba(124,58,237,0.3);padding:2px 8px;border-radius:6px;">
                                        {{ count($editRoleIds) }} SELECTED
                                    </span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                @php
                                    $roleColors = [
                                        'superadmin' => [
                                            'c' => '#f472b6',
                                            'b' => 'rgba(244,114,182,0.4)',
                                            'bg' => 'rgba(244,114,182,0.08)',
                                            'icon' => '👑',
                                        ],
                                        'admin' => [
                                            'c' => '#60a5fa',
                                            'b' => 'rgba(96,165,250,0.4)',
                                            'bg' => 'rgba(96,165,250,0.08)',
                                            'icon' => '🛡️',
                                        ],
                                        'staff' => [
                                            'c' => '#34d399',
                                            'b' => 'rgba(52,211,153,0.4)',
                                            'bg' => 'rgba(52,211,153,0.08)',
                                            'icon' => '⚔️',
                                        ],
                                        'student' => [
                                            'c' => '#c4b5fd',
                                            'b' => 'rgba(196,181,253,0.4)',
                                            'bg' => 'rgba(196,181,253,0.08)',
                                            'icon' => '🎓',
                                        ],
                                        'sub-admin' => [
                                            'c' => '#fbbf24',
                                            'b' => 'rgba(251,191,36,0.4)',
                                            'bg' => 'rgba(251,191,36,0.08)',
                                            'icon' => '⭐',
                                        ],
                                        'verifier' => [
                                            'c' => '#f472b6',
                                            'b' => 'rgba(244,114,182,0.4)',
                                            'bg' => 'rgba(244,114,182,0.08)',
                                            'icon' => '🔍',
                                        ],
                                    ];
                                @endphp
                                @foreach ($roles as $role)
                                    @php
                                        $rc = $roleColors[$role->name] ?? [
                                            'c' => '#a78bfa',
                                            'b' => 'rgba(124,58,237,0.4)',
                                            'bg' => 'rgba(124,58,237,0.08)',
                                            'icon' => '🔑',
                                        ];
                                        $isChecked = in_array((string) $role->id, array_map('strval', $editRoleIds));
                                    @endphp
                                    <label
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl cursor-pointer transition-all"
                                        style="background:{{ $isChecked ? $rc['bg'] : 'rgba(124,58,237,0.04)' }};border:1px solid {{ $isChecked ? $rc['b'] : 'rgba(124,58,237,0.15)' }};"
                                        wire:key="edit-role-{{ $role->id }}">
                                        <div class="relative flex-shrink-0">
                                            <input type="checkbox" wire:model.live="editRoleIds"
                                                value="{{ $role->id }}" class="sr-only peer">
                                            <div class="w-5 h-5 rounded-md flex items-center justify-center transition-all"
                                                style="background:{{ $isChecked ? $rc['b'] : 'rgba(124,58,237,0.1)' }};border:1.5px solid {{ $isChecked ? $rc['c'] : 'rgba(124,58,237,0.25)' }};">
                                                @if ($isChecked)
                                                    <svg class="w-3 h-3" fill="none" stroke="{{ $rc['c'] }}"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold"
                                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;color:{{ $isChecked ? $rc['c'] : 'rgba(167,139,250,0.6)' }};">
                                            {{ $rc['icon'] }} {{ strtoupper($role->name) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('editRoleIds')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                NEW PASSWORD
                                <span style="color:rgba(167,139,250,0.35);"> — BLANK TO KEEP CURRENT</span>
                            </label>
                            <input wire:model="editPassword" type="password"
                                placeholder="Leave blank to keep current..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('editPassword')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Preview --}}
                        <div class="p-4 rounded-xl flex items-center gap-4"
                            style="background:rgba(139,92,246,0.06);border:1px solid rgba(139,92,246,0.2);">
                            <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0"
                                style="border:1px solid rgba(139,92,246,0.3);background:rgba(139,92,246,0.1);">
                                <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $editEmail }}&backgroundColor=1a1033"
                                    class="w-full h-full" alt="Preview">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:#e2d9f3;letter-spacing:0.04em;">
                                    {{ $editName ?: 'HERO NAME' }}
                                </p>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.5);">
                                    {{ $editEmail ?: 'hero@guild.id' }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-1 justify-end max-w-[120px]">
                                @foreach ($roles->whereIn('id', $editRoleIds) as $r)
                                    @php $rc2 = $roleColors[$r->name] ?? ['c'=>'#a78bfa','b'=>'rgba(124,58,237,0.3)','bg'=>'rgba(124,58,237,0.12)']; @endphp
                                    <span class="text-xs px-2 py-0.5 rounded font-bold"
                                        style="background:{{ $rc2['bg'] }};color:{{ $rc2['c'] }};border:1px solid {{ $rc2['b'] }};font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.06em;">
                                        {{ strtoupper($r->name) }}
                                    </span>
                                @endforeach
                            </div>
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:rgba(167,139,250,0.4);">
                                ID #{{ str_pad($editId ?? 0, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-3 pt-1">
                            <button type="button" wire:click="$set('showEdit', false)"
                                class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                                CANCEL
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="updateUser"
                                class="btn-primary flex-1 py-3 rounded-xl text-white text-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                                <span wire:loading.remove wire:target="updateUser">✏️ SAVE CHANGES</span>
                                <span wire:loading wire:target="updateUser">SAVING...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════
         MODAL: DELETE CONFIRMATION
    ══════════════════════════════════════ --}}
    @if ($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="$set('showDelete', false)" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-md rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-200 transform"
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
                                class="text-white mb-2">REVOKE ACCESS</h2>
                            <p style="color:rgba(167,139,250,0.6);font-size:0.875rem;line-height:1.6;">
                                You are about to permanently remove<br>
                                <span class="text-white font-bold">{{ $deleteName }}</span><br>
                                from the system. This cannot be undone.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showDelete', false)"
                            class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                            ABORT
                        </button>
                        <button wire:click="deleteUser" type="button" wire:loading.attr="disabled"
                            wire:target="deleteUser" class="flex-1 py-3 rounded-xl text-sm font-bold text-white"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#b91c1c,#ef4444);border:1px solid #ef4444;box-shadow:0 0 16px rgba(239,68,68,0.3);">
                            <span wire:loading.remove wire:target="deleteUser">⚡ CONFIRM REVOKE</span>
                            <span wire:loading wire:target="deleteUser">REVOKING...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
