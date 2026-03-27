{{-- resources/views/pages/quest/_tab_quests.blade.php --}}

{{-- Stat Bar --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach ([['label' => 'TOTAL QUESTS', 'value' => $stats['total'], 'color' => '#a78bfa', 'border' => 'rgba(124,58,237,0.25)'], ['label' => 'ACTIVE NOW', 'value' => $stats['active'], 'color' => '#34d399', 'border' => 'rgba(16,185,129,0.25)'], ['label' => 'DRAFT / PENDING', 'value' => $stats['pending'], 'color' => '#fbbf24', 'border' => 'rgba(245,158,11,0.25)'], ['label' => 'COMPLETED', 'value' => $stats['completed'], 'color' => '#60a5fa', 'border' => 'rgba(59,130,246,0.25)']] as $s)
        <div class="stat-card rounded-xl p-4" style="border:1px solid {{ $s['border'] }};">
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.14em;color:rgba(167,139,250,0.6);">
                {{ $s['label'] }}</p>
            <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.9rem;font-weight:700;color:{{ $s['color'] }};line-height:1.1;"
                class="mt-1">{{ $s['value'] }}</h3>
        </div>
    @endforeach
</div>

{{-- Search + Filter --}}
<div class="flex flex-col sm:flex-row gap-3 mb-5">
    <div class="flex-1 relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:rgba(167,139,250,0.4);" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input wire:model.live.debounce.300ms="searchQuery" type="text" placeholder="Search quest by title..."
            class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-purple-100 placeholder-purple-400/40 focus:outline-none"
            style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);font-family:'Rajdhani',sans-serif;letter-spacing:0.03em;">
    </div>
    <select wire:model.live="filterStatus" class="px-4 py-2.5 rounded-xl text-sm focus:outline-none"
        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);color:rgba(167,139,250,0.8);font-family:'Rajdhani',sans-serif;">
        <option value="all">ALL STATUS</option>
        <option value="published">PUBLISHED</option>
        <option value="ongoing">ONGOING</option>
        <option value="draft">DRAFT</option>
        <option value="completed">COMPLETED</option>
        <option value="cancelled">CANCELLED</option>
    </select>
    <select wire:model.live="filterCategory" class="px-4 py-2.5 rounded-xl text-sm focus:outline-none"
        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);color:rgba(167,139,250,0.8);font-family:'Rajdhani',sans-serif;">
        <option value="all">ALL CATEGORIES</option>
        <option value="academic">ACADEMIC</option>
        <option value="non-academic">NON-ACADEMIC</option>
        <option value="volunteer">VOLUNTEER</option>
        <option value="other">OTHER</option>
    </select>
</div>

{{-- Quest Table --}}
<div class="stat-card rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr style="border-bottom:1px solid rgba(124,58,237,0.15);">
                    @foreach (['QUEST', 'CATEGORY', 'DATE', 'QUOTA', 'REWARD', 'SKILLS', 'STATUS', 'ACTIONS'] as $col)
                        <th class="px-5 py-4 text-left"
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.5);">
                            {{ $col }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    @include('pages.quest._table_row', ['event' => $event])
                @empty
                    <tr>
                        <td colspan="8" class="py-24 text-center">
                            <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center"
                                style="background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);">
                                <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <p
                                style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.12em;color:rgba(124,58,237,0.4);">
                                NO QUESTS FOUND</p>
                            <p style="font-size:12px;color:rgba(167,139,250,0.3);margin-top:4px;">
                                Create your first quest to get started</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($events->total() > 0)
        <div class="px-5 py-4 flex items-center justify-between" style="border-top:1px solid rgba(124,58,237,0.12);">
            <p
                style="font-family:'Rajdhani',sans-serif;font-size:11px;letter-spacing:0.06em;color:rgba(167,139,250,0.45);">
                SHOWING {{ $events->firstItem() }}–{{ $events->lastItem() }} OF {{ $events->total() }} QUESTS
            </p>
            <div>{{ $events->links() }}</div>
        </div>
    @endif
</div>
