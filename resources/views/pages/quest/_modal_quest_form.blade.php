{{-- resources/views/pages/quest/_modal_quest.blade.php --}}
@if ($showQuestModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background:rgba(0,0,0,0.75);backdrop-filter:blur(6px);">
        <div class="w-full max-w-2xl rounded-2xl overflow-hidden"
            style="background:#13111c;border:1px solid rgba(124,58,237,0.35);box-shadow:0 0 60px rgba(124,58,237,0.2);max-height:90vh;overflow-y:auto;">

            {{-- Header --}}
            <div class="px-6 py-5 flex items-center justify-between sticky top-0 z-10"
                style="background:#13111c;border-bottom:1px solid rgba(124,58,237,0.2);">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-7 rounded-full"
                        style="background:linear-gradient(to bottom,#a78bfa,#7c3aed);box-shadow:0 0 10px rgba(124,58,237,0.6);">
                    </div>
                    <h2 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;letter-spacing:0.06em;"
                        class="text-white">
                        {{ $editingId ? 'EDIT QUEST' : 'CREATE NEW QUEST' }}
                    </h2>
                </div>
                <button wire:click="$set('showQuestModal', false)"
                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:bg-red-500/20"
                    style="border:1px solid rgba(239,68,68,0.25);color:rgba(248,113,113,0.7);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-5">

                {{-- Title --}}
                <div>
                    <label
                        style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                        class="block mb-2">QUEST TITLE *</label>
                    <input wire:model="questTitle" type="text" placeholder="Enter quest title..."
                        class="w-full px-4 py-3 rounded-xl text-sm focus:outline-none transition-all"
                        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);color:#e2d9f3;font-family:'Rajdhani',sans-serif;">
                    @error('questTitle')
                        <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label
                        style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                        class="block mb-2">DESCRIPTION *</label>
                    <textarea wire:model="questDescription" rows="3" placeholder="Describe the quest objectives..."
                        class="w-full px-4 py-3 rounded-xl text-sm focus:outline-none resize-none"
                        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);color:#e2d9f3;font-family:'Rajdhani',sans-serif;"></textarea>
                    @error('questDescription')
                        <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Organization --}}
                <div>
                    <label
                        style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                        class="block mb-2">ORGANIZATION *</label>
                    <select wire:model="questOrgId" class="w-full px-4 py-3 rounded-xl text-sm focus:outline-none"
                        style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);color:#e2d9f3;font-family:'Rajdhani',sans-serif;"
                        {{ $isSubAdmin && count($organizations) <= 1 ? 'disabled' : '' }}>
                        <option value="">Select Organization</option>
                        @foreach ($organizations as $org)
                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                        @endforeach
                    </select>
                    @error('questOrgId')
                        <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Date + Location --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">EVENT DATE *</label>
                        <input wire:model="questDate" type="date"
                            class="w-full px-4 py-3 rounded-xl text-sm focus:outline-none"
                            style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);color:#e2d9f3;font-family:'Rajdhani',sans-serif;">
                        @error('questDate')
                            <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">LOCATION</label>
                        <input wire:model="questLocation" type="text" placeholder="Gedung A, Lantai 3..."
                            class="w-full px-4 py-3 rounded-xl text-sm focus:outline-none"
                            style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);color:#e2d9f3;font-family:'Rajdhani',sans-serif;">
                    </div>
                </div>

                {{-- Category + Status --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">CATEGORY *</label>
                        <select wire:model="questCategory"
                            class="w-full px-4 py-3 rounded-xl text-sm focus:outline-none"
                            style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);color:#e2d9f3;font-family:'Rajdhani',sans-serif;">
                            <option value="academic">Academic</option>
                            <option value="non-academic">Non-Academic</option>
                            <option value="volunteer">Volunteer</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                            class="block mb-2">STATUS</label>
                        <select wire:model="questStatus" class="w-full px-4 py-3 rounded-xl text-sm focus:outline-none"
                            style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);color:#e2d9f3;font-family:'Rajdhani',sans-serif;">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

                {{-- Quota + EXP + Coins --}}
                <div>
                    <label
                        style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);"
                        class="block mb-3">REWARD SETTINGS</label>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl"
                            style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:#60a5fa;"
                                class="block mb-2">QUOTA</label>
                            <input wire:model="questQuota" type="number" min="1" max="1000"
                                class="w-full bg-transparent text-xl font-bold focus:outline-none"
                                style="font-family:'Rajdhani',sans-serif;color:#60a5fa;">
                            @error('questQuota')
                                <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="p-4 rounded-xl"
                            style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.25);">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:#a78bfa;"
                                class="block mb-2">⚡ EXP</label>
                            <input wire:model="questExp" type="number" min="0"
                                class="w-full bg-transparent text-xl font-bold focus:outline-none"
                                style="font-family:'Rajdhani',sans-serif;color:#a78bfa;">
                            @error('questExp')
                                <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="p-4 rounded-xl"
                            style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);">
                            <label
                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.12em;color:#fbbf24;"
                                class="block mb-2">₿ COINS</label>
                            <input wire:model="questCoins" type="number" min="0"
                                class="w-full bg-transparent text-xl font-bold focus:outline-none"
                                style="font-family:'Rajdhani',sans-serif;color:#fbbf24;">
                            @error('questCoins')
                                <p class="mt-1 text-xs" style="color:#f87171;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── SKILLS SECTION ── --}}
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label
                            style="font-family:'Rajdhani',sans-serif;font-size:10px;letter-spacing:0.14em;color:rgba(167,139,250,0.55);">
                            SKILL REWARDS
                        </label>
                        @if (count($selectedSkills) > 0)
                            <span class="text-xs px-2 py-0.5 rounded-full font-bold"
                                style="background:rgba(124,58,237,0.15);color:#a78bfa;font-family:'Rajdhani',sans-serif;border:1px solid rgba(124,58,237,0.25);">
                                {{ count($selectedSkills) }} SELECTED
                            </span>
                        @endif
                    </div>

                    @if ($allSkills->isEmpty())
                        <p style="font-size:12px;color:rgba(167,139,250,0.4);text-align:center;padding:16px 0;">
                            No skills available. Add skills in Skills Master first.
                        </p>
                    @else
                        <div class="grid grid-cols-2 gap-2 max-h-52 overflow-y-auto pr-1"
                            style="scrollbar-width:thin;scrollbar-color:#7c3aed transparent;">
                            @foreach ($allSkills as $skill)
                                @php $isSelected = isset($selectedSkills[$skill->id]); @endphp
                                <div class="rounded-xl p-3 transition-all cursor-pointer"
                                    style="background:{{ $isSelected ? ($skill->color_hex ?? '#7c3aed') . '18' : 'rgba(124,58,237,0.05)' }};border:1px solid {{ $isSelected ? ($skill->color_hex ?? '#7c3aed') . '40' : 'rgba(124,58,237,0.15)' }};">

                                    {{-- Skill toggle header --}}
                                    <div class="flex items-center gap-2 mb-2"
                                        wire:click="toggleSkill({{ $skill->id }})">
                                        <div class="w-4 h-4 rounded flex items-center justify-center flex-shrink-0 transition-all"
                                            style="background:{{ $isSelected ? $skill->color_hex ?? '#7c3aed' : 'rgba(124,58,237,0.1)' }};border:1px solid {{ $isSelected ? $skill->color_hex ?? '#7c3aed' : 'rgba(124,58,237,0.25)' }};">
                                            @if ($isSelected)
                                                <svg class="w-2.5 h-2.5 text-white" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-sm font-bold truncate"
                                            style="color:{{ $isSelected ? $skill->color_hex ?? '#a78bfa' : 'rgba(167,139,250,0.6)' }};font-family:'Rajdhani',sans-serif;letter-spacing:0.03em;">
                                            {{ $skill->name }}
                                        </span>
                                    </div>

                                    {{-- EXP gain input — hanya tampil kalau selected --}}
                                    @if ($isSelected)
                                        <div class="flex items-center gap-2">
                                            <span
                                                style="font-family:'Rajdhani',sans-serif;font-size:9px;letter-spacing:0.1em;color:{{ $skill->color_hex ?? '#a78bfa' }};">
                                                SKILL EXP
                                            </span>
                                            <input type="number" min="0"
                                                value="{{ $selectedSkills[$skill->id] }}"
                                                wire:change="updateSkillExp({{ $skill->id }}, $event.target.value)"
                                                class="flex-1 bg-transparent text-right text-sm font-bold focus:outline-none"
                                                style="color:{{ $skill->color_hex ?? '#a78bfa' }};font-family:'Rajdhani',sans-serif;border-bottom:1px solid {{ $skill->color_hex ?? '#7c3aed' }}30;"
                                                onclick="event.stopPropagation()">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <p style="font-size:11px;color:rgba(167,139,250,0.35);margin-top:6px;">
                            Click a skill to toggle it. Set how many skill EXP points students earn per skill.
                        </p>
                    @endif
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 flex items-center justify-end gap-3 sticky bottom-0"
                style="background:#13111c;border-top:1px solid rgba(124,58,237,0.15);">
                <button wire:click="$set('showQuestModal', false)"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all"
                    style="background:rgba(124,58,237,0.08);color:rgba(167,139,250,0.7);font-family:'Rajdhani',sans-serif;letter-spacing:0.05em;border:1px solid rgba(124,58,237,0.2);">
                    CANCEL
                </button>
                <button wire:click="saveQuest"
                    class="px-6 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:opacity-90"
                    style="background:linear-gradient(135deg,#7c3aed,#a855f7);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;border:1px solid rgba(167,139,250,0.3);box-shadow:0 0 20px rgba(124,58,237,0.3);">
                    {{ $editingId ? '✏️ UPDATE QUEST' : '⚡ SAVE QUEST' }}
                </button>
            </div>

        </div>
    </div>
@endif
