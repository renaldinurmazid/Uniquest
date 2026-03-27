{{-- ══════════════════════════════════════════════════════
     MODAL: DELETE CONFIRM
══════════════════════════════════════════════════════ --}}
@if ($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background:rgba(0,0,0,0.8);backdrop-filter:blur(8px);">
        <div class="w-full max-w-md rounded-2xl overflow-hidden"
            style="background:#13111c;border:1px solid rgba(239,68,68,0.35);box-shadow:0 0 40px rgba(239,68,68,0.15);">
            <div class="h-1 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171,#ef4444);"></div>
            <div class="p-8 space-y-6">
                <div class="flex flex-col items-center text-center gap-4">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center"
                        style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.3rem;font-weight:700;letter-spacing:0.05em;"
                            class="text-white mb-2">
                            DELETE QUEST
                        </h2>
                        <p style="color:rgba(167,139,250,0.6);font-size:0.875rem;line-height:1.6;">
                            You are about to permanently delete<br>
                            <span class="text-white font-bold">{{ $deleteTitle }}</span><br>
                            and all its registrations. This cannot be undone.
                        </p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="button" wire:click="$set('showDeleteModal', false)"
                        class="flex-1 py-3 rounded-xl text-sm font-bold transition-all text-violet-400 hover:text-violet-200 hover:bg-violet-900/20"
                        style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(124,58,237,0.2);">
                        ABORT
                    </button>
                    <button wire:click="deleteQuest" type="button"
                        class="flex-1 py-3 rounded-xl text-sm font-bold text-white"
                        style="font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;background:linear-gradient(135deg,#b91c1c,#ef4444);border:1px solid #ef4444;box-shadow:0 0 16px rgba(239,68,68,0.3);">
                        ⚡ CONFIRM DELETE
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
