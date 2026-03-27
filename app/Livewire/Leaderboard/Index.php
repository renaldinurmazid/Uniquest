<?php

namespace App\Livewire\Leaderboard;

use App\Models\User;
use App\Models\StudentProfile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

#[Layout('layouts.app')]
#[Title('Leaderboard')]
class Index extends Component
{
    use WithPagination;

    public string $activeTab = 'global'; // global | weekly
    public string $searchQuery = '';

    public function updatedActiveTab(): void
    {
        $this->resetPage();
    }

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
    }

    // ─── Main Leaderboard Query ───────────────────────────────────────
    public function getLeaderboard()
    {
        $query = User::role('student')
            ->with(['studentProfile'])
            ->whereHas('studentProfile')
            ->when(
                $this->searchQuery,
                fn($q) =>
                $q->where('name', 'like', '%' . $this->searchQuery . '%')
            );

        if ($this->activeTab === 'weekly') {
            $query->orderByDesc(
                DB::table('point_transactions')
                    ->selectRaw('COALESCE(SUM(amount), 0)')
                    ->whereColumn('user_id', 'users.id')
                    ->where('type', 'credit')
                    ->where('created_at', '>=', now()->startOfWeek())
            );
        } else {
            $query->orderByDesc(
                StudentProfile::select('current_exp')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1)
            );
        }

        return $query->paginate(20);
    }

    // ─── Top 3 Podium (cached 5 menit) ───────────────────────────────
    public function getPodium(): array
    {
        return Cache::remember("leaderboard.podium.{$this->activeTab}", 300, function () {
            $query = User::role('student')
                ->with(['studentProfile'])
                ->whereHas('studentProfile');

            if ($this->activeTab === 'weekly') {
                $query->orderByDesc(
                    DB::table('point_transactions')
                        ->selectRaw('COALESCE(SUM(amount), 0)')
                        ->whereColumn('user_id', 'users.id')
                        ->where('type', 'credit')
                        ->where('created_at', '>=', now()->startOfWeek())
                );
            } else {
                $query->orderByDesc(
                    StudentProfile::select('current_exp')
                        ->whereColumn('user_id', 'users.id')
                        ->limit(1)
                );
            }

            $top3 = $query->take(3)->get();

            $medals       = [1 => '🥇', 2 => '🥈', 3 => '🥉'];
            $colors       = [1 => '#fbbf24', 2 => '#94a3b8', 3 => '#fb923c'];
            $heights      = [1 => 'h-36', 2 => 'h-28', 3 => 'h-20'];
            $displayOrder = [2, 1, 3]; // urutan tampilan: 2nd | 1st | 3rd

            $podium = [];
            foreach ($displayOrder as $rank) {
                $user = $top3->get($rank - 1);
                if (!$user) continue;

                $weeklyExp = 0;
                if ($this->activeTab === 'weekly') {
                    $weeklyExp = DB::table('point_transactions')
                        ->where('user_id', $user->id)
                        ->where('type', 'credit')
                        ->where('created_at', '>=', now()->startOfWeek())
                        ->sum('amount');
                }

                $podium[] = [
                    'rank'   => $rank,
                    'name'   => $user->name,
                    'npm'    => $user->studentProfile->npm ?? '-',
                    'exp'    => $this->activeTab === 'weekly' ? $weeklyExp : ($user->studentProfile->current_exp ?? 0),
                    'level'  => $user->studentProfile->level ?? 1,
                    'coins'  => $user->studentProfile->total_coins ?? 0,
                    'avatar' => $user->avatar_url,
                    'badge'  => $medals[$rank],
                    'color'  => $colors[$rank],
                    'h'      => $heights[$rank],
                    'seed'   => $user->studentProfile->npm ?? $user->id,
                ];
            }

            return $podium;
        });
    }

    // ─── Rank Change (delta vs minggu lalu) ──────────────────────────
    public function getRankChange(User $user): int
    {
        $currentRank = User::role('student')
            ->whereHas(
                'studentProfile',
                fn($q) =>
                $q->where('current_exp', '>', $user->studentProfile->current_exp ?? 0)
            )
            ->count() + 1;

        $weeklyGain = DB::table('point_transactions')
            ->where('user_id', $user->id)
            ->where('type', 'credit')
            ->where('created_at', '>=', now()->subWeek())
            ->sum('amount');

        $lastWeekExp  = ($user->studentProfile->current_exp ?? 0) - $weeklyGain;

        $lastWeekRank = User::role('student')
            ->whereHas(
                'studentProfile',
                fn($q) =>
                $q->where('current_exp', '>', $lastWeekExp)
            )
            ->count() + 1;

        return $lastWeekRank - $currentRank; // positif = naik, negatif = turun
    }

    // ─── Fastest Climbers (top XP gainer minggu ini) ─────────────────
    public function getFastestClimbers(): array
    {
        return Cache::remember('leaderboard.fastest_climbers', 300, function () {
            $results = DB::table('point_transactions')
                ->join('users', 'users.id', '=', 'point_transactions.user_id')
                ->join('model_has_roles', function ($join) {
                    $join->on('model_has_roles.model_id', '=', 'users.id')
                        ->where('model_has_roles.model_type', '=', 'App\Models\User');
                })
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.name', 'student')
                ->where('point_transactions.type', 'credit')
                ->where('point_transactions.created_at', '>=', now()->startOfWeek())
                ->groupBy('users.id', 'users.name')
                ->selectRaw('users.id, users.name, SUM(point_transactions.amount) as weekly_exp')
                ->orderByDesc('weekly_exp')
                ->take(4)
                ->get();

            $colors = ['#34d399', '#60a5fa', '#a78bfa', '#fbbf24'];

            return $results->map(fn($r, $i) => [
                'name'       => $r->name,
                'weekly_exp' => (int) $r->weekly_exp,
                'color'      => $colors[$i] ?? '#94a3b8',
                'initials'   => strtoupper(mb_substr($r->name, 0, 2)),
            ])->toArray();
        });
    }

    // ─── Rare Badges ─────────────────────────────────────────────────
    public function getRareBadges(): array
    {
        return Cache::remember('leaderboard.rare_badges', 600, function () {
            return DB::table('achievements')
                ->leftJoin('student_achievements', 'achievements.id', '=', 'student_achievements.achievement_id')
                ->groupBy('achievements.id', 'achievements.title', 'achievements.badge_icon_path')
                ->selectRaw('
                    achievements.id,
                    achievements.title,
                    achievements.badge_icon_path,
                    COUNT(student_achievements.id) as holder_count
                ')
                ->orderBy('holder_count')
                ->take(6)
                ->get()
                ->map(fn($a) => [
                    'id'      => $a->id,
                    'label'   => $a->title,
                    'icon'    => $a->badge_icon_path ?? '🏅',
                    'holders' => (int) $a->holder_count,
                ])
                ->toArray();
        });
    }

    // ─── Render ───────────────────────────────────────────────────────
    public function render()
    {
        return view('pages.leaderboard.index', [
            'leaderboard'     => $this->getLeaderboard(),
            'podium'          => $this->getPodium(),
            'fastestClimbers' => $this->getFastestClimbers(),
            'rareBadges'      => $this->getRareBadges(),
        ]);
    }
}
