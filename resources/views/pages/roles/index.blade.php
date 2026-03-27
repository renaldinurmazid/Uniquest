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
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-2 h-8 rounded-full"
                    style="background:linear-gradient(to bottom,#f472b6,#db2777);box-shadow:0 0 12px rgba(244,114,182,0.7);">
                </div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;letter-spacing:0.04em;"
                    class="text-white">ROLES & ACCESS</h1>
            </div>
            <p style="color:rgba(167,139,250,0.7);font-size:0.875rem;" class="ml-5">Define authority levels and
                permissions for every guild rank.</p>
        </div>
        <button wire:click="$set('showCreate', true)"
            class="btn-primary px-6 py-3 rounded-xl text-white text-sm flex items-center gap-2 self-start sm:self-auto whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            + CREATE ROLE
        </button>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['label' => 'TOTAL ROLES', 'value' => $stats['total_roles'], 'color' => '#f472b6', 'border' => 'rgba(244,114,182,0.25)', 'sub' => 'defined'], ['label' => 'TOTAL PERMISSIONS', 'value' => $stats['total_permissions'], 'color' => '#a78bfa', 'border' => 'rgba(124,58,237,0.25)', 'sub' => 'across system'], ['label' => 'ADMIN ACCOUNTS', 'value' => $stats['admin_count'], 'color' => '#60a5fa', 'border' => 'rgba(59,130,246,0.25)', 'sub' => 'active'], ['label' => 'SUB-ADMINS', 'value' => $stats['sub_admin_count'], 'color' => '#34d399', 'border' => 'rgba(16,185,129,0.25)', 'sub' => 'guild masters']] as $s)
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

    {{-- Tabs --}}
    <div class="flex gap-1 p-1 rounded-xl w-fit"
        style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
        @foreach ([['key' => 'roles', 'label' => 'ROLES', 'icon' => '🛡️'], ['key' => 'permissions', 'label' => 'PERMISSIONS', 'icon' => '🔑'], ['key' => 'matrix', 'label' => 'ACCESS MATRIX', 'icon' => '📋']] as $tab)
            <button wire:click="$set('activeTab','{{ $tab['key'] }}')"
                class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition-all"
                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;{{ $activeTab === $tab['key'] ? 'background:rgba(124,58,237,0.6);color:#e2d9f3;border:1px solid rgba(167,139,250,0.4);' : 'color:rgba(167,139,250,0.5);border:1px solid transparent;' }}">
                <span>{{ $tab['icon'] }}</span>{{ $tab['label'] }}
            </button>
        @endforeach
    </div>

    {{-- ══════ TAB: ROLES ══════ --}}
    @if ($activeTab === 'roles')
        <div class="stat-card rounded-2xl overflow-hidden" style="min-height:50vh;">
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
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Search by name or label..."
                        class="search-input w-full pl-11 pr-4 py-3 rounded-xl text-sm">
                </div>
                <div class="px-4 py-2 rounded-xl"
                    style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                    <span
                        style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.1em;color:rgba(167,139,250,0.7);">{{ $roles->total() }}
                        ROLES DEFINED</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table w-full text-left">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-xs">ROLE</th>
                            <th class="px-6 py-4 text-xs">USERS</th>
                            <th class="px-6 py-4 text-xs">PERMISSIONS</th>
                            <th class="px-6 py-4 text-xs text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr class="group">
                                <td class="px-6 py-5">
                                    <p
                                        class="font-bold text-sm text-white group-hover:text-violet-300 transition-colors">
                                        {{ $role->name }}</p>
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.08em;color:rgba(167,139,250,0.5);">
                                        {{ $role->name }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;color:#a78bfa;">{{ number_format($role->users_count) }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;color:#a78bfa;">{{ $role->permissions_count }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="openPerms({{ $role->id }})" title="Manage Permissions"
                                            class="p-2.5 rounded-xl transition-all text-violet-500 hover:text-violet-300"
                                            style="border:1px solid rgba(124,58,237,0.2);"
                                            onmouseover="this.style.background='rgba(124,58,237,0.15)'"
                                            onmouseout="this.style.background='transparent'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                        </button>
                                        <button wire:click="openEdit({{ $role->id }})" title="Edit Role"
                                            class="p-2.5 rounded-xl transition-all text-violet-500 hover:text-violet-300"
                                            style="border:1px solid rgba(124,58,237,0.2);"
                                            onmouseover="this.style.background='rgba(124,58,237,0.15)'"
                                            onmouseout="this.style.background='transparent'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $role->id }})" title="Delete Role"
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
                                <td colspan="4" class="py-32 text-center">
                                    <p
                                        style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.12em;color:rgba(124,58,237,0.4);">
                                        NO ROLES FOUND</p>
                                    <code class="block mt-2 text-xs" style="color:rgba(167,139,250,0.3);">php artisan
                                        db:seed --class=PermissionSeeder</code>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-5" style="border-top:1px solid rgba(124,58,237,0.1);">{{ $roles->links() }}</div>
        </div>

        {{-- ══════ TAB: PERMISSIONS ══════ --}}
    @elseif ($activeTab === 'permissions')
        @php
            $groupColors = [
                'Quest Management' => '#a78bfa',
                'Student Management' => '#60a5fa',
                'Point Shop & Economy' => '#fbbf24',
                'System & Analytics' => '#f472b6',
                'Verification' => '#34d399',
            ];
            $groupIcons = [
                'Quest Management' => '⚔️',
                'Student Management' => '🎓',
                'Point Shop & Economy' => '💎',
                'System & Analytics' => '⚙️',
                'Verification' => '🔍',
            ];
        @endphp
        <div class="space-y-5">
            <div class="stat-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 flex items-center gap-3"
                    style="border-bottom:1px solid rgba(124,58,237,0.12); background: rgba(124,58,237,0.05);">
                    <span class="text-lg">🔑</span>
                    <div class="w-1 h-5 rounded-full" style="background:#a78bfa;"></div>
                    <h2
                        style="font-family:'Rajdhani',sans-serif;font-size:0.95rem;font-weight:700;letter-spacing:0.06em;color:white;">
                        ALL SYSTEM PERMISSIONS
                    </h2>
                    <span class="ml-auto text-xs px-2.5 py-0.5 rounded-full"
                        style="background:rgba(167,139,250,0.1);color:#a78bfa;font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;border:1px solid rgba(167,139,250,0.2);font-size:10px;">
                        {{ count($allPermissions) }} TOTAL
                    </span>
                </div>

                <div class="divide-y" style="border-color:rgba(124,58,237,0.07);">
                    @forelse ($allPermissions as $perm)
                        <div
                            class="px-6 py-4 flex flex-col md:flex-row md:items-center justify-between hover:bg-violet-900/10 transition-colors gap-4">
                            <div class="flex items-center gap-4">
                                <div class="flex flex-col">
                                    <span
                                        style="font-family:'Rajdhani',sans-serif;font-size:14px;font-weight:700;color:#e2d9f3;letter-spacing:0.03em;">
                                        {{ strtoupper(str_replace('-', ' ', $perm->name)) }}
                                    </span>
                                    <code style="color:#a78bfa;font-size:10px;opacity:0.8;">{{ $perm->name }}</code>
                                </div>
                            </div>

                            {{-- Roles yang punya permission ini --}}
                            <div class="flex gap-1.5 flex-wrap md:justify-end">
                                @php
                                    // Kita filter role mana saja yang punya permission ini
                                    $rolesWithThisPerm = $allRoles->filter(
                                        fn($role) => $role->hasPermissionTo($perm->name),
                                    );
                                @endphp

                                @forelse ($rolesWithThisPerm as $role)
                                    <span class="px-2 py-0.5 rounded-md text-xs font-bold"
                                        style="background:rgba(167,139,250,0.1);color:#a78bfa;font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.07em;border:1px solid rgba(167,139,250,0.2);">
                                        {{ strtoupper($role->name) }}
                                    </span>
                                @empty
                                    <span class="text-[10px] italic text-slate-500 font-medium"
                                        style="font-family:'Rajdhani';">NO ROLES ASSIGNED</span>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="p-16 text-center">
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.12em;color:rgba(124,58,237,0.4);">
                                NO PERMISSIONS REGISTERED IN DATABASE
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ══════ TAB: MATRIX ══════ --}}
    @elseif ($activeTab === 'matrix')
        <div class="stat-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5" style="border-bottom:1px solid rgba(124,58,237,0.15);">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-5 rounded-full" style="background:linear-gradient(to bottom,#f472b6,#db2777);">
                    </div>
                    <h2 style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;"
                        class="text-white">PERMISSION MATRIX</h2>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(124,58,237,0.12);">
                            <th class="px-5 py-4 text-left sticky left-0 z-10"
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.45);background:#1a1033;min-width:180px;">
                                PERMISSION</th>
                            @foreach ($allRoles as $role)
                                <th class="px-4 py-4 text-center"
                                    style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:#a78bfa;min-width:90px;">
                                    {{ strtoupper($role->name) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matrixData as $i => $row)
                            <tr class="group hover:bg-violet-900/10 transition-colors"
                                style="{{ $i < count($matrixData) - 1 ? 'border-bottom:1px solid rgba(124,58,237,0.06);' : '' }}">
                                <td class="px-5 py-3 sticky left-0 z-10" style="background:#1a1033;"><span
                                        style="font-size:12px;color:rgba(167,139,250,0.8);">{{ $row['label'] }}</span>
                                </td>
                                @foreach ($row['cells'] as $has)
                                    <td class="px-4 py-3 text-center">
                                        @if ($has)
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center mx-auto"
                                                style="background:rgba(52,211,153,0.15);border:1px solid rgba(52,211,153,0.3);">
                                                <svg class="w-3.5 h-3.5" style="color:#34d399;" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-6 h-6 rounded-lg flex items-center justify-center mx-auto"
                                                style="background:rgba(124,58,237,0.04);border:1px solid rgba(124,58,237,0.08);">
                                                <div class="w-1.5 h-0.5 rounded-full"
                                                    style="background:rgba(124,58,237,0.2);"></div>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 flex items-center gap-4" style="border-top:1px solid rgba(124,58,237,0.1);">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded flex items-center justify-center"
                        style="background:rgba(52,211,153,0.15);border:1px solid rgba(52,211,153,0.3);"><svg
                            class="w-3 h-3" style="color:#34d399;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 13l4 4L19 7" />
                        </svg></div>
                    <span style="font-family:'Rajdhani',sans-serif;font-size:11px;color:rgba(167,139,250,0.6);">HAS
                        ACCESS</span>
                </div>
                <span style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.3);"
                    class="ml-auto">{{ count($matrixData) }} × {{ $allRoles->count() }}</span>
            </div>
        </div>
    @endif


    {{-- ══════ MODAL: CREATE ══════ --}}
    @if ($showCreate)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-show="true"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div wire:click="closeAll" class="absolute inset-0"
                style="background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);"></div>
            <div class="modal-panel relative w-full max-w-md rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#db2777,#f472b6,#db2777);"></div>
                <div class="p-8 space-y-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-1.5 h-6 rounded-full"
                                    style="background:linear-gradient(to bottom,#f472b6,#db2777);"></div>
                                <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;letter-spacing:0.05em;"
                                    class="text-white">CREATE NEW ROLE</h2>
                            </div>
                        </div>
                        <button wire:click="closeAll"
                            class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form wire:submit="createRole" class="space-y-5">
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">DISPLAY LABEL *</label>
                            <input wire:model="label" type="text" placeholder="e.g. Moderator"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('label')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">ROLE SLUG * <span style="color:rgba(167,139,250,0.35);">— for internal
                                    use</span></label>
                            <input wire:model="name" type="text" placeholder="e.g. moderator"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('name')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeAll"
                                class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">CANCEL</button>
                            <button type="submit" class="btn-primary flex-1 py-3 rounded-xl text-white text-sm"
                                style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">🛡️ CREATE
                                ROLE</button>
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
            <div class="modal-panel relative w-full max-w-md rounded-2xl overflow-hidden z-10" x-show="true"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#8b5cf6,#c4b5fd,#8b5cf6);"></div>
                <div class="p-8 space-y-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-6 rounded-full"
                                style="background:linear-gradient(to bottom,#c4b5fd,#8b5cf6);"></div>
                            <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.4rem;font-weight:700;letter-spacing:0.05em;"
                                class="text-white">EDIT ROLE</h2>
                        </div>
                        <button wire:click="closeAll"
                            class="p-2 text-violet-500 hover:text-violet-300 rounded-lg hover:bg-violet-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form wire:submit="updateRole" class="space-y-5">
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">DISPLAY LABEL *</label>
                            <input wire:model="editLabel" type="text"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('editLabel')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.12em;color:rgba(167,139,250,0.6);"
                                class="block">ROLE SLUG *</label>
                            <input wire:model="editName" type="text"
                                class="modal-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                            @error('editName')
                                <span style="font-size:11px;color:#f87171;font-family:'Rajdhani',sans-serif;">⚠
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeAll"
                                class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
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
                            class="text-white mb-2">DELETE ROLE</h2>
                        <p style="color:rgba(167,139,250,0.6);font-size:0.875rem;line-height:1.6;">
                            Permanently delete role <span class="text-white font-bold">{{ $deleteName }}</span>?
                            This cannot be undone.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" wire:click="closeAll"
                            class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">ABORT</button>
                        <button wire:click="deleteRole" type="button"
                            class="flex-1 py-3 rounded-xl text-sm font-bold text-white"
                            style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#b91c1c,#ef4444);border:1px solid #ef4444;">⚡
                            CONFIRM</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════ MODAL: PERMISSIONS ══════ --}}
    {{-- MODAL PERMISSIONS --}}
    @if ($showPerms)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" wire:click="closeAll"></div>
            <div class="relative bg-slate-900 border border-violet-500/30 w-full max-w-2xl max-h-[90vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden"
                style="animation: modalIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;">

                <div class="p-6 border-b border-violet-500/15 flex justify-between items-center bg-slate-900/50">
                    <div>
                        <h3 class="text-xl font-bold text-white uppercase tracking-wider"
                            style="font-family:'Rajdhani';">SET PERMISSIONS</h3>
                        <p class="text-sm text-violet-400 font-medium tracking-wide italic">{{ $permRoleName }}</p>
                    </div>
                    <button wire:click="closeAll" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar bg-slate-900/30">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($allPermissions as $perm)
                            <button type="button" wire:click="togglePerm({{ $perm->id }})"
                                class="group p-4 rounded-2xl flex items-center gap-4 transition-all duration-300 {{ in_array($perm->id, $selectedPerms) ? 'bg-violet-600/20 border-violet-500/50 shadow-[0_0_15px_rgba(124,58,237,0.1)]' : 'bg-slate-800/40 border-slate-700/50 hover:border-violet-500/30' }}"
                                style="border: 1px solid;">

                                <div
                                    class="w-6 h-6 rounded-lg border-2 flex items-center justify-center transition-all duration-300 {{ in_array($perm->id, $selectedPerms) ? 'bg-violet-500 border-violet-400 shadow-[0_0_10px_rgba(124,58,237,0.5)]' : 'border-slate-600 group-hover:border-violet-500/50' }}">
                                    @if (in_array($perm->id, $selectedPerms))
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    @endif
                                </div>

                                <div class="flex flex-col items-start">
                                    <span
                                        class="text-sm font-bold tracking-wider {{ in_array($perm->id, $selectedPerms) ? 'text-violet-200' : 'text-slate-400' }}"
                                        style="font-family:'Rajdhani';">
                                        {{ strtoupper($perm->name) }}
                                    </span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="p-6 border-t border-violet-500/15 flex gap-3 bg-slate-900/50">
                    <button type="button" wire:click="closeAll"
                        class="flex-1 py-3 rounded-xl text-sm font-bold text-slate-400 hover:bg-slate-800 transition-all uppercase tracking-widest"
                        style="font-family:'Rajdhani';">CANCEL</button>
                    <button wire:click="savePerms" type="button"
                        class="flex-1 py-3 bg-violet-600 hover:bg-violet-500 rounded-xl text-white text-sm font-black uppercase tracking-widest shadow-lg shadow-violet-900/20 transition-all"
                        style="font-family:'Rajdhani';">✓ SAVE CHANGES</button>
                </div>
            </div>
        </div>
    @endif

</div>
