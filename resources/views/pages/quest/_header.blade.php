{{-- ─── Page Header ────────────────────────────────── --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-2 h-8 rounded-full flex-shrink-0"
                style="background:linear-gradient(to bottom,#fbbf24,#d97706);box-shadow:0 0 12px rgba(251,191,36,0.7);">
            </div>
            <h1 style="font-family:'Rajdhani',sans-serif;font-size:clamp(1.4rem,4vw,2rem);font-weight:700;letter-spacing:0.04em;"
                class="text-white leading-tight">
                QUEST MANAGEMENT
            </h1>
        </div>
        <p style="color:rgba(167,139,250,0.7);font-size:0.8rem;" class="ml-5">
            Game Master Panel — Kelola semua quest, reward, dan kategori skill.
        </p>
    </div>
    <button wire:click="openCreateModal"
        class="btn-primary px-5 py-2.5 rounded-xl text-sm text-white flex items-center justify-center gap-2 font-bold flex-shrink-0 w-full sm:w-auto"
        style="background:linear-gradient(135deg,#7c3aed,#a855f7);border:1px solid rgba(167,139,250,0.3);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        + CREATE QUEST
    </button>
</div>

{{-- ─── Tab Navigation ─────────────────────────────── --}}
<div class="mb-6 -mx-1 px-1">
    <div class="overflow-x-auto scrollbar-hide pb-1">
        <div class="flex gap-1 p-1 rounded-xl w-max"
            style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
            @foreach ([['key' => 'quests', 'label' => 'ALL QUESTS', 'icon' => '⚔️'], ['key' => 'registrations', 'label' => 'REGISTRATIONS', 'icon' => '📝'], ['key' => 'categories', 'label' => 'CATEGORIES', 'icon' => '🗂️'], ['key' => 'checkin', 'label' => 'CHECK-IN / QR', 'icon' => '📱'], ['key' => 'analytics', 'label' => 'ANALYTICS', 'icon' => '📊']] as $tab)
                <button wire:click="$set('activeTab', '{{ $tab['key'] }}')"
                    class="px-3 sm:px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5 transition-all whitespace-nowrap flex-shrink-0"
                    style="font-family:'Rajdhani',sans-serif;letter-spacing:0.07em;
                        {{ $activeTab === $tab['key']
                            ? 'background:rgba(124,58,237,0.6);color:#e2d9f3;border:1px solid rgba(167,139,250,0.4);'
                            : 'color:rgba(167,139,250,0.5);border:1px solid transparent;' }}">
                    <span class="text-sm leading-none">{{ $tab['icon'] }}</span>
                    <span>{{ $tab['label'] }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div>
