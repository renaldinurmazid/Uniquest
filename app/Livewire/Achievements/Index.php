<?php

namespace App\Livewire\Achievements;

use App\Models\Achievement;
use App\Models\StudentAchievement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts::app')]
#[Title('Achievements')]
class Index extends Component
{
    use WithPagination;

    // ── Tab & Filter ─────────────────────────────
    public string $activeTab        = 'badges';
    public string $search           = '';
    public string $filterReqType    = 'all';

    // ── Modal state ──────────────────────────────
    public bool $showModal        = false;
    public bool $showDeleteModal  = false;
    public bool $showAwardModal   = false;

    // ── Form fields ─────────────────────────────
    public ?int   $editingId         = null;
    public string $badgeName         = '';
    public string $badgeDescription  = '';
    public string $badgeIcon         = '🏆';
    public string $reqType           = 'quest_count';
    public int    $reqValue          = 10;

    // ── Delete ──────────────────────────────────
    public ?int   $deleteId   = null;
    public string $deleteName = '';

    // ── Award modal ──────────────────────────────
    public ?int   $awardAchievementId = null;
    public string $awardSearch        = '';

    public array $requirementTypes = [
        'quest_count'        => 'Quest Count',
        'event_count'        => 'Event Count',
        'total_exp'          => 'Total EXP',
        'total_coins'        => 'Total Coins',
        'level_reached'      => 'Level Reached',
        'skill_points'       => 'Skill Points',
        'certificate_count'  => 'Certificate Count',
        'manual'             => 'Manual Award',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilterReqType(): void
    {
        $this->resetPage();
    }

    // ────────────────────────────────────────────
    // RENDER
    // ────────────────────────────────────────────
    public function render()
    {
        $achievements = Achievement::withCount('users')
            ->when(
                $this->search,
                fn($q) =>
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('requirement_type', 'like', '%' . $this->search . '%')
            )
            ->when(
                $this->filterReqType !== 'all',
                fn($q) =>
                $q->where('requirement_type', $this->filterReqType)
            )
            ->latest()
            ->paginate(12, ['*'], 'badgePage');

        $recentAwarded = StudentAchievement::with(['user', 'achievement'])
            ->latest('earned_at')
            ->limit(20)
            ->get();

        // ── Pindahan dari blade ──────────────────
        $topBadges = Achievement::withCount('users')
            ->orderByDesc('users_count')
            ->limit(5)
            ->get();

        $typeGroups = Achievement::select('requirement_type', DB::raw('count(*) as count'))
            ->groupBy('requirement_type')
            ->get();

        $typeTotal = Achievement::count() ?: 1;
        // ─────────────────────────────────────────

        $stats = [
            'total'        => Achievement::count(),
            'awardedToday' => StudentAchievement::whereDate('earned_at', today())->count(),
            'rarestCount'  => Achievement::withCount('users')->orderBy('users_count')->value('users_count') ?? 0,
            'totalAwarded' => StudentAchievement::count(),
        ];

        $awardUsers = collect();
        if ($this->showAwardModal && strlen($this->awardSearch) >= 2) {
            $alreadyAwarded = StudentAchievement::where('achievement_id', $this->awardAchievementId)
                ->pluck('user_id');

            $awardUsers = User::where(function ($q) {
                $q->where('name', 'like', '%' . $this->awardSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->awardSearch . '%');
            })
                ->whereNotIn('id', $alreadyAwarded)
                ->limit(8)
                ->get();
        }

        $awardAchievement = $this->awardAchievementId
            ? Achievement::find($this->awardAchievementId)
            : null;

        return view('pages.achievements.index', compact(
            'achievements',
            'recentAwarded',
            'stats',
            'awardUsers',
            'awardAchievement',
            'topBadges',
            'typeGroups',
            'typeTotal'
        ));
    }

    // ────────────────────────────────────────────
    // CREATE / EDIT
    // ────────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->editingId  = null;
        $this->showModal  = true;
    }

    public function openEdit(int $id): void
    {
        $a = Achievement::findOrFail($id);

        $this->editingId        = $a->id;
        $this->badgeName        = $a->title;
        $this->badgeDescription = $a->description ?? '';
        $this->badgeIcon        = $a->badge_icon_path ?? '🏆';
        $this->reqType          = $a->requirement_type;
        $this->reqValue         = $a->requirement_value;

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'badgeName'        => 'required|string|min:3|max:255',
            'badgeDescription' => 'nullable|string|max:1000',
            'badgeIcon'        => 'required|string|max:10',
            'reqType'          => 'required|string',
            'reqValue'         => 'required|integer|min:0',
        ]);

        $data = [
            'title'             => $this->badgeName,
            'description'       => $this->badgeDescription ?: null,
            'badge_icon_path'   => $this->badgeIcon,
            'requirement_type'  => $this->reqType,
            'requirement_value' => $this->reqValue,
        ];

        if ($this->editingId) {
            Achievement::findOrFail($this->editingId)->update($data);
            session()->flash('status', 'Badge updated: ' . $this->badgeName);
        } else {
            Achievement::create($data);
            session()->flash('status', 'Badge forged: ' . $this->badgeName);
        }

        $this->showModal = false;
        $this->resetForm();
    }

    // ────────────────────────────────────────────
    // DELETE
    // ────────────────────────────────────────────
    public function confirmDelete(int $id): void
    {
        $a = Achievement::findOrFail($id);

        $this->deleteId        = $a->id;
        $this->deleteName      = $a->title;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        $a    = Achievement::findOrFail($this->deleteId);
        $name = $a->title;

        $a->users()->detach();
        $a->delete();

        $this->reset(['deleteId', 'deleteName']);
        $this->showDeleteModal = false;
        session()->flash('status', 'Badge removed: ' . $name);
    }

    // ────────────────────────────────────────────
    // AWARD
    // ────────────────────────────────────────────
    public function openAward(int $achievementId): void
    {
        $this->awardAchievementId = $achievementId;
        $this->awardSearch        = '';
        $this->showAwardModal     = true;
    }

    public function awardToUser(int $userId): void
    {
        $already = StudentAchievement::where('achievement_id', $this->awardAchievementId)
            ->where('user_id', $userId)
            ->exists();

        if ($already) {
            session()->flash('status', 'User already has this badge.');
            return;
        }

        StudentAchievement::create([
            'user_id'        => $userId,
            'achievement_id' => $this->awardAchievementId,
            'earned_at'      => now(),
        ]);

        $user        = User::find($userId);
        $achievement = Achievement::find($this->awardAchievementId);

        $this->awardSearch = '';
        session()->flash('status', 'Badge "' . $achievement->title . '" awarded to ' . $user->name . '!');
    }

    public function revokeFromUser(int $studentAchievementId): void
    {
        StudentAchievement::findOrFail($studentAchievementId)->delete();
        session()->flash('status', 'Badge revoked.');
    }

    // ────────────────────────────────────────────
    // HELPER
    // ────────────────────────────────────────────
    private function resetForm(): void
    {
        $this->editingId        = null;
        $this->badgeName        = '';
        $this->badgeDescription = '';
        $this->badgeIcon        = '🏆';
        $this->reqType          = 'quest_count';
        $this->reqValue         = 10;
    }
}
