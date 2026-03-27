{{-- resources/views/pages/organizations/index.blade.php --}}

<div class="space-y-8" style="animation: pageIn 0.4s ease forwards;">

    {{-- Flash --}}
    @if (session('status'))
        <div class="p-4 rounded-xl flex items-center gap-3"
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
        <div class="p-4 rounded-xl flex items-center gap-3"
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
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-8 rounded-full"
                    style="background:linear-gradient(to bottom,#fb923c,#ea580c);box-shadow:0 0 12px rgba(251,146,60,0.7);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">ORGANIZATIONS</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">Manage guilds, UKM, and HIMA —
                delegate quest creation to sub-admins.</p>
        </div>

        {{-- Tombol Register Guild — disabled untuk sub-admin --}}
        @if ($isSubAdmin)
            <div class="relative group self-start md:self-auto">
                <button disabled
                    class="px-5 py-2.5 rounded-xl text-sm flex items-center gap-2 font-bold cursor-not-allowed"
                    style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.15);color:rgba(167,139,250,0.3);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    + REGISTER GUILD
                </button>
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10"
                    style="background:#1a1033;border:1px solid rgba(239,68,68,0.3);color:#f87171;font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;">
                    🔒 Sub-admin tidak dapat membuat organisasi
                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-0 h-0"
                        style="border-left:5px solid transparent;border-right:5px solid transparent;border-top:5px solid rgba(239,68,68,0.3);">
                    </div>
                </div>
            </div>
        @else
            <button wire:click="$set('showCreate', true)"
                class="btn-primary px-5 py-2.5 rounded-xl text-sm text-white flex items-center gap-2 font-bold self-start md:self-auto"
                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                + REGISTER GUILD
            </button>
        @endif
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['label' => 'TOTAL GUILDS', 'value' => $stats['total'], 'color' => '#fb923c', 'border' => 'rgba(251,146,60,0.25)', 'sub' => 'registered'], ['label' => 'ACTIVE GUILDS', 'value' => $stats['active'], 'color' => '#34d399', 'border' => 'rgba(16,185,129,0.25)', 'sub' => 'running'], ['label' => 'TOTAL MEMBERS', 'value' => $stats['members'], 'color' => '#60a5fa', 'border' => 'rgba(59,130,246,0.25)', 'sub' => 'across all'], ['label' => 'PENDING REVIEW', 'value' => $stats['pending'], 'color' => '#fbbf24', 'border' => 'rgba(245,158,11,0.25)', 'sub' => 'need approval']] as $s)
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

    {{-- Tab + Search --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex gap-1 p-1 rounded-xl"
            style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
            @foreach ([['key' => 'all', 'label' => 'ALL'], ['key' => 'ukm', 'label' => 'UKM'], ['key' => 'hima', 'label' => 'HIMA'], ['key' => 'lembaga', 'label' => 'LEMBAGA']] as $tab)
                <button wire:click="$set('activeTab','{{ $tab['key'] }}')"
                    class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all"
                    style="font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;{{ $activeTab === $tab['key'] ? 'background:rgba(124,58,237,0.55);color:#e2d9f3;border:1px solid rgba(167,139,250,0.35);' : 'color:rgba(167,139,250,0.5);border:1px solid transparent;' }}">
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </div>
        <div class="relative w-full sm:w-72">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:rgba(167,139,250,0.4);"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search organization..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm focus:outline-none search-input">
        </div>
    </div>

    {{-- Organization Cards --}}
    @php
        $cardColors = ['#60a5fa', '#a78bfa', '#fb923c', '#34d399', '#fbbf24', '#f472b6', '#f87171'];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse ($organizations as $org)
            @php $color = $cardColors[$loop->index % count($cardColors)]; @endphp
            <div class="stat-card rounded-2xl overflow-hidden group hover:scale-[1.01] transition-all duration-300"
                style="border:1px solid {{ $color }}22;">

                <div class="h-1"
                    style="background:linear-gradient(90deg,{{ $color }},{{ $color }}44);"></div>

                <div class="p-5">
                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 text-xl font-bold"
                                style="background:{{ $color }}18;border:1px solid {{ $color }}30;color:{{ $color }};font-family:'Rajdhani',sans-serif;">
                                @if ($org->logo_path)
                                    <img src="{{ asset('storage/' . $org->logo_path) }}"
                                        class="w-full h-full rounded-xl object-cover" alt="">
                                @else
                                    {{ strtoupper(substr($org->name, 0, 2)) }}
                                @endif
                            </div>
                            <div>
                                <h3
                                    class="text-sm font-bold text-purple-100 group-hover:text-white transition-colors leading-tight">
                                    {{ $org->name }}
                                </h3>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.5);">
                                    ID #{{ str_pad($org->id, 4, '0', STR_PAD_LEFT) }}
                                </p>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full flex-shrink-0"
                            style="background:{{ $color }}15;color:{{ $color }};font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.07em;border:1px solid {{ $color }}25;">
                            {{ $org->events_count }} EVENTS
                        </span>
                    </div>

                    {{-- Description --}}
                    <p style="font-size:12px;color:rgba(167,139,250,0.6);line-height:1.5;" class="mb-4 line-clamp-2">
                        {{ $org->description ?? 'No description provided.' }}
                    </p>

                    {{-- Leader --}}
                    <div class="flex items-center gap-2 mb-4 p-2.5 rounded-lg"
                        style="background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.12);">
                        <div class="w-6 h-6 rounded-lg overflow-hidden flex-shrink-0"
                            style="border:1px solid {{ $color }}30;background:rgba(124,58,237,0.15);">
                            <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ $org->owner?->email }}&backgroundColor=1a1033"
                                class="w-full h-full" alt="">
                        </div>
                        <div>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:8px;letter-spacing:0.1em;color:rgba(167,139,250,0.4);">
                                LEADER</p>
                            <p style="font-size:12px;color:#e2d9f3;">{{ $org->owner?->name ?? '—' }}</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-2 pt-3" style="border-top:1px solid rgba(124,58,237,0.1);">
                        @if ($isSubAdmin)
                            {{-- EDIT disabled --}}
                            <div class="relative group/btn flex-1">
                                <button disabled class="w-full py-2 rounded-lg text-xs font-bold cursor-not-allowed"
                                    style="background:rgba(124,58,237,0.05);color:rgba(167,139,250,0.2);font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(124,58,237,0.1);">
                                    🔒 EDIT
                                </button>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2.5 py-1 rounded-lg text-xs font-bold whitespace-nowrap opacity-0 group-hover/btn:opacity-100 transition-opacity pointer-events-none z-10"
                                    style="background:#1a1033;border:1px solid rgba(239,68,68,0.3);color:#f87171;font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.04em;">
                                    Akses ditolak untuk sub-admin
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-0 h-0"
                                        style="border-left:4px solid transparent;border-right:4px solid transparent;border-top:4px solid rgba(239,68,68,0.3);">
                                    </div>
                                </div>
                            </div>

                            {{-- DELETE disabled --}}
                            <div class="relative group/del flex-shrink-0">
                                <button disabled
                                    class="w-9 h-9 rounded-lg flex items-center justify-center cursor-not-allowed"
                                    style="border:1px solid rgba(239,68,68,0.08);color:rgba(248,113,113,0.2);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-full right-0 mb-2 px-2.5 py-1 rounded-lg text-xs font-bold whitespace-nowrap opacity-0 group-hover/del:opacity-100 transition-opacity pointer-events-none z-10"
                                    style="background:#1a1033;border:1px solid rgba(239,68,68,0.3);color:#f87171;font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.04em;">
                                    Akses ditolak untuk sub-admin
                                    <div class="absolute top-full right-3 w-0 h-0"
                                        style="border-left:4px solid transparent;border-right:4px solid transparent;border-top:4px solid rgba(239,68,68,0.3);">
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- EDIT normal --}}
                            <button wire:click="openEdit({{ $org->id }})"
                                class="flex-1 py-2 rounded-lg text-xs font-bold transition-all"
                                style="background:{{ $color }}15;color:{{ $color }};font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid {{ $color }}25;">
                                ✏️ EDIT
                            </button>

                            {{-- DELETE normal --}}
                            <button wire:click="confirmDelete({{ $org->id }})"
                                class="w-9 h-9 rounded-lg flex items-center justify-center transition-all hover:bg-red-500/20 flex-shrink-0"
                                style="border:1px solid rgba(239,68,68,0.2);color:rgba(248,113,113,0.6);"
                                onmouseover="this.style.background='rgba(239,68,68,0.1)'"
                                onmouseout="this.style.background='transparent'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 flex flex-col items-center justify-center">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                    style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                    <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.12em;color:rgba(124,58,237,0.4);">
                    NO ORGANIZATIONS FOUND</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div>{{ $organizations->links() }}</div>


    {{-- ══════ MODAL: CREATE ══════ --}}
    @if ($showCreate)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="closeAll" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-lg rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#ea580c,#fb923c,#ea580c);"></div>
                <div class="p-8 space-y-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-1.5 h-6 rounded-full"
                                    style="background:linear-gradient(to bottom,#fb923c,#ea580c);"></div>
                                <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;letter-spacing:0.05em;"
                                    class="text-white">REGISTER NEW GUILD</h2>
                            </div>
                            <p style="color:rgba(167,139,250,0.6);font-size:0.8rem;" class="ml-5">Create a new
                                organization and assign a leader.</p>
                        </div>
                        <button wire:click="closeAll"
                            class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form wire:submit="createOrganization" class="space-y-5">
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">ORGANIZATION NAME *</label>
                            <input wire:model="name" type="text" placeholder="e.g. Robotics & AI Club"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('name')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">DESCRIPTION *</label>
                            <textarea wire:model="description" rows="3" placeholder="Describe the organization's mission..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium resize-none"></textarea>
                            @error('description')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">GUILD LEADER *</label>
                            <select wire:model="userId"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium appearance-none">
                                <option value="">— Select Leader —</option>
                                @foreach ($leaders as $leader)
                                    <option value="{{ $leader->id }}">{{ $leader->name }} ({{ $leader->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('userId')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeAll"
                                class="flex-1 py-3 rounded-xl text-sm font-bold text-violet-400 hover:text-violet-200 hover:bg-violet-900/20 transition-all"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">CANCEL</button>
                            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white text-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">🏰 REGISTER
                                GUILD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════ MODAL: EDIT ══════ --}}
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
                                class="text-white">EDIT ORGANIZATION</h2>
                        </div>
                        <button wire:click="closeAll"
                            class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form wire:submit="updateOrganization" class="space-y-5">
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">ORGANIZATION NAME *</label>
                            <input wire:model="editName" type="text"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('editName')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">DESCRIPTION *</label>
                            <textarea wire:model="editDescription" rows="3"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium resize-none"></textarea>
                            @error('editDescription')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">GUILD LEADER *</label>
                            <select wire:model="editUserId"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium appearance-none">
                                <option value="">— Select Leader —</option>
                                @foreach ($leaders as $leader)
                                    <option value="{{ $leader->id }}">{{ $leader->name }} ({{ $leader->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('editUserId')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeAll"
                                class="flex-1 py-3 rounded-xl text-sm font-bold text-violet-400 hover:text-violet-200 hover:bg-violet-900/20 transition-all"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">CANCEL</button>
                            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white text-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">✏️ SAVE
                                CHANGES</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════ MODAL: DELETE ══════ --}}
    @if ($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="closeAll" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-md rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171,#ef4444);"></div>
                <div class="p-8 space-y-6 text-center">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto"
                        style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.3rem;font-weight:700;letter-spacing:0.05em;"
                            class="text-white mb-2">DELETE ORGANIZATION</h2>
                        <p style="color:rgba(167,139,250,0.6);font-size:0.875rem;line-height:1.6;">
                            Permanently delete <span class="text-white font-bold">{{ $deleteName }}</span>? This
                            cannot be undone.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" wire:click="closeAll"
                            class="flex-1 py-3 rounded-xl text-sm font-bold text-violet-400 hover:text-violet-200 hover:bg-violet-900/20 transition-all"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">ABORT</button>
                        <button wire:click="deleteOrganization" type="button"
                            class="flex-1 py-3 rounded-xl text-sm font-bold text-white"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#b91c1c,#ef4444);border:1px solid #ef4444;">⚡
                            CONFIRM</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
