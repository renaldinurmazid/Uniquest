<div class="min-h-screen" style="animation: pageIn 0.4s ease forwards;">

    {{-- ─── Flash ──────────────────────────────────────── --}}
    @if (session('status'))
        <div class="mb-6 px-5 py-3 rounded-xl flex items-center gap-3"
            style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.3);">
            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span
                style="font-family:'Rajdhani',sans-serif;font-size:13px;letter-spacing:0.05em;color:#34d399;">{{ session('status') }}</span>
        </div>
    @endif

    {{-- ─── Page Header + Tab Navigation ─────────────────── --}}
    @include('pages.quest._header')

    {{-- ══════════════════════════════════════════════════════
         TAB CONTENT
    ══════════════════════════════════════════════════════ --}}
    @if ($activeTab === 'quests')
        @include('pages.quest._tab_quests')
    @elseif ($activeTab === 'registrations')
        @include('pages.quest._tab_registrations')
    @elseif ($activeTab === 'categories')
        <p style="color:rgba(167,139,250,0.5);font-family:'Rajdhani',sans-serif;">Categories — coming soon with backend
        </p>
    @elseif ($activeTab === 'checkin')
        <p style="color:rgba(167,139,250,0.5);font-family:'Rajdhani',sans-serif;">Check-in / QR — coming soon with
            backend</p>
    @elseif ($activeTab === 'analytics')
        <p style="color:rgba(167,139,250,0.5);font-family:'Rajdhani',sans-serif;">Analytics — coming soon with backend
        </p>
    @endif

    {{-- ══════════════════════════════════════════════════════
         MODALS
    ══════════════════════════════════════════════════════ --}}
    @include('pages.quest._modal_quest_form')
    @include('pages.quest._modal_delete')
    @include('pages.quest._modal_qr')

</div>
