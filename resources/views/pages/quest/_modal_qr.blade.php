{{-- ══════════════════════════════════════════════════════
     MODAL: QR CODE
══════════════════════════════════════════════════════ --}}
@if ($showQRModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background:rgba(0,0,0,0.75);backdrop-filter:blur(6px);">
        <div class="w-full max-w-sm rounded-2xl overflow-hidden"
            style="background:#13111c;border:1px solid rgba(124,58,237,0.35);box-shadow:0 0 40px rgba(124,58,237,0.25);">

            {{-- Header --}}
            <div class="px-6 py-5 flex items-center justify-between"
                style="border-bottom:1px solid rgba(124,58,237,0.18);">
                <h2
                    style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:700;letter-spacing:0.06em;color:white;">
                    QR CHECK-IN CODE
                </h2>
                <button wire:click="$set('showQRModal', false)"
                    class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="border:1px solid rgba(239,68,68,0.25);color:rgba(248,113,113,0.7);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-8 flex flex-col items-center">
                {{-- QR placeholder visual --}}
                <div style="background:white;padding:16px;border-radius:12px;box-shadow:0 0 30px rgba(124,58,237,0.4);">
                    <div style="width:160px;height:160px;display:grid;grid-template-columns:repeat(9,1fr);gap:1px;">
                        @php
                            $pattern = [
                                [1, 1, 1, 1, 1, 1, 1, 0, 1],
                                [1, 0, 0, 0, 0, 0, 1, 0, 0],
                                [1, 0, 1, 1, 1, 0, 1, 0, 1],
                                [1, 0, 1, 1, 1, 0, 1, 0, 0],
                                [1, 0, 0, 0, 0, 0, 1, 0, 1],
                                [1, 1, 1, 1, 1, 1, 1, 0, 0],
                                [0, 0, 0, 0, 0, 0, 0, 0, 1],
                                [1, 0, 1, 0, 0, 1, 0, 1, 0],
                                [0, 1, 1, 0, 1, 0, 1, 0, 1],
                            ];
                        @endphp
                        @foreach ($pattern as $row)
                            @foreach ($row as $cell)
                                <div style="background:{{ $cell ? '#7c3aed' : 'white' }};"></div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <p style="font-family:'Rajdhani',sans-serif;font-size:12px;letter-spacing:0.1em;color:rgba(167,139,250,0.7);"
                    class="mt-4">
                    {{ $selectedQuestToken }}
                </p>
                <p style="font-family:'Rajdhani',sans-serif;font-size:10px;color:rgba(167,139,250,0.4);" class="mt-1">
                    Quest #{{ str_pad($selectedQuestId ?? 0, 4, '0', STR_PAD_LEFT) }}
                </p>
                <button class="mt-5 w-full py-3 rounded-xl font-bold text-sm text-white transition-all"
                    style="background:linear-gradient(135deg,#7c3aed,#a855f7);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(167,139,250,0.3);">
                    📥 DOWNLOAD QR CODE
                </button>
            </div>

        </div>
    </div>
@endif
