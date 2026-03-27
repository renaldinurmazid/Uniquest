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
                    style="background:linear-gradient(to bottom,#34d399,#059669);box-shadow:0 0 12px rgba(52,211,153,0.7);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">SKILLS MASTER</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">
                Kelola skill tree mahasiswa — kategori kemampuan yang berkembang dari quest.
            </p>
        </div>
        <button wire:click="openCreate"
            class="btn-primary px-6 py-3 rounded-xl text-white text-sm flex items-center gap-2 self-start sm:self-auto whitespace-nowrap"
            style="background:linear-gradient(135deg,#059669,#10b981);border:1px solid rgba(52,211,153,0.4);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;box-shadow:0 0 18px rgba(16,185,129,0.3);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            ADD SKILL
        </button>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['label' => 'TOTAL SKILLS', 'value' => $stats['total'], 'color' => '#a78bfa', 'border' => 'rgba(124,58,237,0.25)', 'icon' => '⚡'], ['label' => 'SKILLS ASSIGNED', 'value' => $stats['totalAssigned'], 'color' => '#34d399', 'border' => 'rgba(16,185,129,0.25)', 'icon' => '🎯'], ['label' => 'TOTAL POINTS', 'value' => number_format($stats['totalPoints']), 'color' => '#fbbf24', 'border' => 'rgba(245,158,11,0.25)', 'icon' => '💎'], ['label' => 'IN EVENTS', 'value' => $stats['totalEvents'], 'color' => '#60a5fa', 'border' => 'rgba(59,130,246,0.25)', 'icon' => '🏆']] as $s)
            <div class="stat-card rounded-xl p-5" style="border:1px solid {{ $s['border'] }};">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-2xl">{{ $s['icon'] }}</span>
                </div>
                <p
                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.15em;color:rgba(167,139,250,0.6);">
                    {{ $s['label'] }}
                </p>
                <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.8rem;font-weight:700;color:{{ $s['color'] }};line-height:1.1;"
                    class="mt-1">
                    {{ $s['value'] }}
                </h3>
            </div>
        @endforeach
    </div>

    {{-- ── Search Bar ── --}}
    <div class="flex items-center gap-4">
        <div class="flex-1 relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                style="color:rgba(167,139,250,0.5);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="Search skill by name or description..."
                class="search-input w-full pl-11 pr-4 py-3 rounded-xl text-sm">
        </div>
        <div class="px-4 py-3 rounded-xl"
            style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
            <span
                style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.1em;color:rgba(167,139,250,0.7);">
                {{ $skills->total() }} SKILLS
            </span>
        </div>
    </div>

    {{-- ── Skills Grid ── --}}
    @if ($skills->isEmpty())
        <div class="stat-card rounded-2xl py-24 text-center">
            <div class="w-20 h-20 rounded-2xl mx-auto mb-5 flex items-center justify-center text-4xl"
                style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                ⚡
            </div>
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:14px;letter-spacing:0.12em;color:rgba(124,58,237,0.5);">
                NO SKILLS FOUND
            </p>
            <p style="font-size:13px;color:rgba(167,139,250,0.35);margin-top:6px;">
                Create your first skill to build the skill tree
            </p>
            <button wire:click="openCreate" class="mt-6 px-6 py-2.5 rounded-xl text-sm font-bold text-white"
                style="background:linear-gradient(135deg,#059669,#10b981);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                + ADD FIRST SKILL
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($skills as $skill)
                @php
                    $color = $skill->color_hex ?? '#7c3aed';
                    $colorRgb =
                        hexdec(substr($color, 1, 2)) .
                        ',' .
                        hexdec(substr($color, 3, 2)) .
                        ',' .
                        hexdec(substr($color, 5, 2));
                @endphp
                <div class="stat-card rounded-2xl overflow-hidden group hover:scale-[1.02] transition-transform"
                    style="border:1px solid rgba({{ $colorRgb }},0.3);">

                    {{-- Color bar top --}}
                    <div class="h-1.5 w-full"
                        style="background:{{ $color }};box-shadow:0 0 8px {{ $color }}88;"></div>

                    <div class="p-5">
                        {{-- Icon + color badge --}}
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                                style="background:rgba({{ $colorRgb }},0.15);border:1px solid rgba({{ $colorRgb }},0.3);">
                                @if ($skill->icon_path)
                                    <img src="{{ $skill->icon_path }}" class="w-7 h-7 object-contain"
                                        alt="{{ $skill->name }}">
                                @else
                                    ⚡
                                @endif
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-white/20 flex-shrink-0 cursor-pointer"
                                style="background:{{ $color }};box-shadow:0 0 8px {{ $color }}66;"
                                title="{{ $color }}">
                            </div>
                        </div>

                        {{-- Name --}}
                        <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.1rem;font-weight:700;letter-spacing:0.05em;color:white;line-height:1.2;"
                            class="mb-1">
                            {{ strtoupper($skill->name) }}
                        </h3>

                        {{-- Description --}}
                        <p style="font-size:12px;color:rgba(167,139,250,0.6);line-height:1.5;"
                            class="mb-4 line-clamp-2">
                            {{ $skill->description ?? 'No description provided.' }}
                        </p>

                        {{-- Stats chips --}}
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg"
                                style="background:rgba({{ $colorRgb }},0.1);border:1px solid rgba({{ $colorRgb }},0.2);">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    style="color:{{ $color }};">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;font-weight:700;color:{{ $color }};letter-spacing:0.06em;">
                                    {{ $skill->users_count }} students
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg"
                                style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                                <span
                                    style="font-family:'Rajdhani',sans-serif;font-size:10px;font-weight:700;color:rgba(167,139,250,0.8);letter-spacing:0.06em;">
                                    {{ $skill->events_count }} events
                                </span>
                            </div>
                        </div>

                        {{-- Hex code --}}
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.08em;color:rgba(167,139,250,0.4);">
                                COLOR:
                            </span>
                            <code style="font-size:10px;color:{{ $color }};font-family:'Rajdhani',sans-serif;">
                                {{ strtoupper($color) }}
                            </code>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2 pt-3" style="border-top:1px solid rgba(124,58,237,0.1);">
                            <button wire:click="openEdit({{ $skill->id }})"
                                class="flex-1 py-2 rounded-lg text-xs font-bold transition-all flex items-center justify-center gap-1.5"
                                style="background:rgba({{ $colorRgb }},0.1);color:{{ $color }};font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba({{ $colorRgb }},0.25);"
                                onmouseover="this.style.background='rgba({{ $colorRgb }},0.2)'"
                                onmouseout="this.style.background='rgba({{ $colorRgb }},0.1)'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                EDIT
                            </button>
                            <button wire:click="confirmDelete({{ $skill->id }})"
                                class="px-3 py-2 rounded-lg text-xs font-bold transition-all flex items-center justify-center"
                                style="background:rgba(239,68,68,0.08);color:rgba(248,113,113,0.6);border:1px solid rgba(239,68,68,0.15);"
                                onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.color='#f87171'"
                                onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.color='rgba(248,113,113,0.6)'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
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
                SHOWING {{ $skills->firstItem() }}–{{ $skills->lastItem() }} OF {{ $skills->total() }} SKILLS
            </p>
            {{ $skills->links() }}
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════
         MODAL: CREATE / EDIT SKILL
    ══════════════════════════════════════════════════════ --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="$set('showModal', false)" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-lg rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">

                {{-- Top accent --}}
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#059669,#34d399,#059669);"></div>

                <div class="p-8 space-y-6">
                    {{-- Header --}}
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-1.5 h-6 rounded-full"
                                    style="background:linear-gradient(to bottom,#34d399,#059669);"></div>
                                <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;letter-spacing:0.05em;"
                                    class="text-white">
                                    {{ $editingId ? 'EDIT SKILL' : 'ADD NEW SKILL' }}
                                </h2>
                            </div>
                            <p style="color:rgba(167,139,250,0.6);font-size:0.8rem;" class="ml-5">
                                {{ $editingId ? 'Update skill information.' : 'Create a new skill for the campus skill tree.' }}
                            </p>
                        </div>
                        <button wire:click="$set('showModal', false)"
                            class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="save" class="space-y-5">

                        {{-- Skill Name --}}
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                SKILL NAME *
                            </label>
                            <input wire:model="name" type="text"
                                placeholder="e.g. Public Speaking, Coding, Leadership..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('name')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                DESCRIPTION
                            </label>
                            <textarea wire:model="description" rows="3" placeholder="Describe what this skill represents..."
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium resize-none"></textarea>
                            @error('description')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Color Picker ── --}}
                        <div class="space-y-3">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">
                                SKILL COLOR
                            </label>

                            {{-- Palette --}}
                            <div class="flex flex-wrap gap-2">
                                @foreach ($colorPalette as $c)
                                    <button type="button" wire:click="$set('colorHex', '{{ $c }}')"
                                        class="w-8 h-8 rounded-lg transition-all"
                                        style="background:{{ $c }};border:2px solid {{ $colorHex === $c ? 'white' : 'transparent' }};box-shadow:{{ $colorHex === $c ? '0 0 10px ' . $c . '88' : 'none' }};">
                                    </button>
                                @endforeach
                            </div>

                            {{-- Custom hex input --}}
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex-shrink-0"
                                    style="background:{{ $colorHex }};border:2px solid rgba(255,255,255,0.2);box-shadow:0 0 12px {{ $colorHex }}66;">
                                </div>
                                <div class="flex-1">
                                    <input wire:model.live="colorHex" type="text" placeholder="#7c3aed"
                                        class="modal-input w-full px-4 py-2.5 rounded-xl text-sm font-medium"
                                        style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
                                </div>
                                <input type="color" wire:model.live="colorHex"
                                    class="w-10 h-10 rounded-lg cursor-pointer border-0 p-0.5"
                                    style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.3);">
                            </div>
                            @error('colorHex')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Preview card --}}
                        <div class="rounded-xl p-4 flex items-center gap-4"
                            style="background:rgba({{ hexdec(substr($colorHex, 1, 2)) }},{{ hexdec(substr($colorHex, 3, 2)) }},{{ hexdec(substr($colorHex, 5, 2)) }},0.08);border:1px solid rgba({{ hexdec(substr($colorHex, 1, 2)) }},{{ hexdec(substr($colorHex, 3, 2)) }},{{ hexdec(substr($colorHex, 5, 2)) }},0.3);">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                                style="background:{{ $colorHex }}22;border:1px solid {{ $colorHex }}44;">
                                ⚡
                            </div>
                            <div>
                                <p
                                    style="font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:{{ $colorHex }};letter-spacing:0.05em;">
                                    {{ $name ?: 'SKILL NAME' }}
                                </p>
                                <p style="font-size:11px;color:rgba(167,139,250,0.5);">
                                    {{ $description ?: 'Skill description will appear here...' }}
                                </p>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="$set('showModal', false)"
                                class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                                CANCEL
                            </button>
                            <button type="submit"
                                class="flex-1 py-3 rounded-xl text-sm font-bold text-white transition-all"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#059669,#10b981);border:1px solid rgba(52,211,153,0.4);box-shadow:0 0 16px rgba(16,185,129,0.3);">
                                {{ $editingId ? '✏️ UPDATE SKILL' : '⚡ CREATE SKILL' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════
         MODAL: DELETE CONFIRM
    ══════════════════════════════════════════════════════ --}}
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
                                DELETE SKILL
                            </h2>
                            <p style="color:rgba(167,139,250,0.6);font-size:0.875rem;line-height:1.6;">
                                You are about to permanently delete<br>
                                <span class="text-white font-bold">{{ $deleteName }}</span>.<br>
                                All student & event associations will be removed.
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
