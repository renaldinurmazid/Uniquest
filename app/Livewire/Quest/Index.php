<?php

namespace App\Livewire\Quest;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Organization;
use App\Models\Skill;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts::app')]
#[Title('Quest Management')]
class Index extends Component
{
    use WithPagination;

    // ── Tab & Filter ─────────────────────────────
    public string $activeTab      = 'quests';
    public string $searchQuery    = '';
    public string $filterStatus   = 'all';
    public string $filterCategory = 'all';

    // ── Registrations tab filter ─────────────────
    public string $regSearch    = '';
    public string $regStatus    = 'all';
    public ?int   $regEventId   = null;   // filter per event (optional)

    // ── Modal state ──────────────────────────────
    public bool $showQuestModal  = false;
    public bool $showQRModal     = false;
    public bool $showDeleteModal = false;

    // ── Form fields (create & edit) ──────────────
    public ?int   $editingId        = null;
    public string $questTitle       = '';
    public string $questDescription = '';
    public int    $questQuota       = 50;
    public int    $questExp         = 100;
    public int    $questCoins       = 50;
    public string $questCategory    = 'academic';
    public string $questDate        = '';
    public string $questLocation    = '';
    public string $questStatus      = 'draft';
    public string $questOrgId       = '';

    // ── Skills (array of skill_id => exp_gain) ───
    public array $selectedSkills = [];  // ['skill_id' => exp_gain, ...]

    // ── Delete ───────────────────────────────────
    public ?int   $deleteId    = null;
    public string $deleteTitle = '';

    // ── QR preview ───────────────────────────────
    public ?int   $selectedQuestId    = null;
    public string $selectedQuestToken = '';

    // ── Registration status change ───────────────
    public ?int   $regChangeId     = null;
    public string $regChangeStatus = '';

    // Reset pagination saat filter/search berubah
    public function updatingSearchQuery(): void
    {
        $this->resetPage();
    }
    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }
    public function updatingFilterCategory(): void
    {
        $this->resetPage();
    }
    public function updatingRegSearch(): void
    {
        $this->resetPage();
    }
    public function updatingRegStatus(): void
    {
        $this->resetPage();
    }
    public function updatingRegEventId(): void
    {
        $this->resetPage();
    }

    // ────────────────────────────────────────────
    // RENDER
    // ────────────────────────────────────────────
    public function render()
    {
        $user       = auth()->user();
        $isSubAdmin = $user->hasRole('sub-admin');

        $myOrgIds = $isSubAdmin
            ? Organization::where('user_id', $user->id)->pluck('id')
            : null;

        // ── Events query ──
        $eventQuery = Event::with(['organization', 'registrations'])
            ->when($myOrgIds,              fn($q) => $q->whereIn('organization_id', $myOrgIds))
            ->when($this->searchQuery,     fn($q) => $q->where('title', 'like', '%' . $this->searchQuery . '%'))
            ->when($this->filterStatus !== 'all',   fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterCategory !== 'all', fn($q) => $q->where('category', $this->filterCategory))
            ->latest();

        $events = $eventQuery->paginate(10, ['*'], 'eventsPage');

        // ── Stats ──
        $baseQ = fn() => $myOrgIds ? Event::whereIn('organization_id', $myOrgIds) : Event::query();
        $stats = [
            'total'     => $baseQ()->count(),
            'active'    => $baseQ()->whereIn('status', ['published', 'ongoing'])->count(),
            'pending'   => $baseQ()->where('status', 'draft')->count(),
            'completed' => $baseQ()->where('status', 'completed')->count(),
        ];

        // ── Organizations (scoped for sub-admin) ──
        $organizations = $isSubAdmin
            ? Organization::where('user_id', $user->id)->orderBy('name')->get()
            : Organization::orderBy('name')->get();

        // ── All skills (untuk form) ──
        $allSkills = Skill::orderBy('name')->get();

        // ── Registrations query ──
        $regQuery = EventRegistration::with(['user', 'event.organization'])
            ->when($myOrgIds, fn($q) => $q->whereHas('event', fn($eq) => $eq->whereIn('organization_id', $myOrgIds)))
            ->when($this->regEventId,           fn($q) => $q->where('event_id', $this->regEventId))
            ->when($this->regStatus !== 'all',  fn($q) => $q->where('status', $this->regStatus))
            ->when($this->regSearch, fn($q) => $q->whereHas('user', fn($uq) => $uq->where('name', 'like', '%' . $this->regSearch . '%')))
            ->latest();

        $registrations = $regQuery->paginate(15, ['*'], 'regPage');

        // ── Event list untuk filter dropdown di tab registrations ──
        $eventList = $myOrgIds
            ? Event::whereIn('organization_id', $myOrgIds)->orderBy('title')->get(['id', 'title'])
            : Event::orderBy('title')->get(['id', 'title']);

        return view('pages.quest.index', compact(
            'events',
            'stats',
            'organizations',
            'allSkills',
            'registrations',
            'eventList',
            'isSubAdmin'
        ));
    }

    // ────────────────────────────────────────────
    // CREATE — buka modal kosong
    // ────────────────────────────────────────────
    public function openCreateModal(): void
    {
        $this->resetForm();

        // Auto-select org untuk sub-admin
        if (auth()->user()->hasRole('sub-admin')) {
            $myOrg = Organization::where('user_id', auth()->id())->first();
            if ($myOrg) $this->questOrgId = (string) $myOrg->id;
        }

        $this->showQuestModal = true;
    }

    // ────────────────────────────────────────────
    // EDIT — buka modal isi data
    // ────────────────────────────────────────────
    public function openEdit(int $eventId): void
    {
        $event = Event::with('skills')->findOrFail($eventId);

        $this->editingId        = $event->id;
        $this->questTitle       = $event->title;
        $this->questDescription = $event->description ?? '';
        $this->questQuota       = $event->quota;
        $this->questExp         = $event->exp_reward;
        $this->questCoins       = $event->coin_reward;
        $this->questCategory    = $event->category;
        $this->questDate        = $event->event_date->format('Y-m-d');
        $this->questLocation    = $event->location ?? '';
        $this->questStatus      = $event->status;
        $this->questOrgId       = (string) $event->organization_id;

        // Load existing skills dengan exp_gain dari pivot
        $this->selectedSkills = [];
        foreach ($event->skills as $skill) {
            $this->selectedSkills[$skill->id] = $skill->pivot->exp_gain;
        }

        $this->showQuestModal = true;
    }

    // ────────────────────────────────────────────
    // TOGGLE SKILL di form
    // ────────────────────────────────────────────
    public function toggleSkill(int $skillId): void
    {
        if (isset($this->selectedSkills[$skillId])) {
            unset($this->selectedSkills[$skillId]);
        } else {
            $this->selectedSkills[$skillId] = 0;
        }
    }

    public function updateSkillExp(int $skillId, int $exp): void
    {
        if (isset($this->selectedSkills[$skillId])) {
            $this->selectedSkills[$skillId] = max(0, $exp);
        }
    }

    // ────────────────────────────────────────────
    // SAVE (create atau update)
    // ────────────────────────────────────────────
    public function saveQuest(): void
    {
        $this->validate([
            'questTitle'       => 'required|string|min:5',
            'questDescription' => 'required|string|min:10',
            'questQuota'       => 'required|integer|min:1|max:1000',
            'questExp'         => 'required|integer|min:0',
            'questCoins'       => 'required|integer|min:0',
            'questDate'        => 'required|date',
            'questOrgId'       => 'required|exists:organizations,id',
            'questStatus'      => 'required|in:draft,published,ongoing,completed,cancelled',
            'questCategory'    => 'required|in:academic,non-academic,volunteer,other',
        ]);

        $data = [
            'organization_id' => $this->questOrgId,
            'title'           => $this->questTitle,
            'description'     => $this->questDescription,
            'quota'           => $this->questQuota,
            'exp_reward'      => $this->questExp,
            'coin_reward'     => $this->questCoins,
            'category'        => $this->questCategory,
            'event_date'      => $this->questDate,
            'location'        => $this->questLocation,
            'status'          => $this->questStatus,
        ];

        if ($this->editingId) {
            $event = Event::findOrFail($this->editingId);
            $event->update($data);
            session()->flash('status', 'Quest updated: ' . $event->title);
        } else {
            $data['qr_code_token'] = strtoupper(Str::random(12));
            $event = Event::create($data);
            session()->flash('status', 'Quest created: ' . $event->title);
        }

        // Sync skills dengan exp_gain di pivot
        $syncData = [];
        foreach ($this->selectedSkills as $skillId => $expGain) {
            $syncData[$skillId] = ['exp_gain' => (int) $expGain];
        }
        $event->skills()->sync($syncData);

        $this->showQuestModal = false;
        $this->resetForm();
    }

    // ────────────────────────────────────────────
    // DELETE
    // ────────────────────────────────────────────
    public function confirmDelete(int $eventId): void
    {
        $event             = Event::findOrFail($eventId);
        $this->deleteId    = $event->id;
        $this->deleteTitle = $event->title;
        $this->showDeleteModal = true;
    }

    public function deleteQuest(): void
    {
        $event = Event::findOrFail($this->deleteId);
        $title = $event->title;

        $event->registrations()->delete();
        $event->skills()->detach();
        $event->delete();

        $this->reset(['deleteId', 'deleteTitle']);
        $this->showDeleteModal = false;
        session()->flash('status', 'Quest removed: ' . $title);
    }

    // ────────────────────────────────────────────
    // TOGGLE STATUS
    // ────────────────────────────────────────────
    public function toggleStatus(int $eventId): void
    {
        $event = Event::findOrFail($eventId);

        $next = match ($event->status) {
            'draft'     => 'published',
            'published' => 'ongoing',
            'ongoing'   => 'completed',
            default     => 'draft',
        };

        $event->update(['status' => $next]);
        session()->flash('status', "Quest '{$event->title}' status → " . strtoupper($next));
    }

    // ────────────────────────────────────────────
    // QR MODAL
    // ────────────────────────────────────────────
    public function openQRModal(int $eventId): void
    {
        $event = Event::findOrFail($eventId);

        $this->selectedQuestId    = $event->id;
        $this->selectedQuestToken = $event->qr_code_token;
        $this->showQRModal        = true;
    }

    // ────────────────────────────────────────────
    // REGISTRATIONS — update status
    // ────────────────────────────────────────────
    public function updateRegStatus(int $regId, string $newStatus): void
    {
        $allowed = ['registered', 'waitlisted', 'attended', 'cancelled'];
        if (!in_array($newStatus, $allowed)) return;

        $reg = EventRegistration::findOrFail($regId);
        $reg->update([
            'status'      => $newStatus,
            'attended_at' => $newStatus === 'attended' ? now() : $reg->attended_at,
        ]);

        session()->flash('status', "Registration #{$regId} updated → " . strtoupper($newStatus));
    }

    public function cancelRegistration(int $regId): void
    {
        $this->updateRegStatus($regId, 'cancelled');
    }

    public function markAttended(int $regId): void
    {
        $this->updateRegStatus($regId, 'attended');
    }

    // ────────────────────────────────────────────
    // HELPERS
    // ────────────────────────────────────────────
    private function resetForm(): void
    {
        $this->editingId        = null;
        $this->questTitle       = '';
        $this->questDescription = '';
        $this->questQuota       = 50;
        $this->questExp         = 100;
        $this->questCoins       = 50;
        $this->questCategory    = 'academic';
        $this->questDate        = '';
        $this->questLocation    = '';
        $this->questStatus      = 'draft';
        $this->questOrgId       = '';
        $this->selectedSkills   = [];
    }
}
