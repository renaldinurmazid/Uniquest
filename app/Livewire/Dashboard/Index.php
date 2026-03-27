<?php

namespace App\Livewire\Dashboard;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\PointTransaction;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app', ['title' => 'Dashboard'])]
class Index extends Component
{
    // ─── Computed Stats ──────────────────────────────────────────────

    public function getTotalPlayersProperty(): int
    {
        return User::role('student')->count();
    }

    public function getActiveQuestsProperty(): int
    {
        return Event::whereIn('status', ['published', 'ongoing'])->count();
    }

    public function getTotalCoinsProperty(): int
    {
        return PointTransaction::where('type', 'credit')->sum('amount');
    }

    public function getCompletionRateProperty(): int
    {
        $total = EventRegistration::count();
        if ($total === 0) return 0;
        $attended = EventRegistration::where('status', 'attended')->count();
        return (int) round(($attended / $total) * 100);
    }

    // ─── Recent Activity ─────────────────────────────────────────────

    public function getRecentActivityProperty()
    {
        // Ambil event_registrations terbaru dengan status attended
        return EventRegistration::with(['user', 'event'])
            ->where('status', 'attended')
            ->latest('attended_at')
            ->take(5)
            ->get()
            ->map(function ($reg) {
                return [
                    'text'  => $reg->user->name . ' completed "' . $reg->event->title . '"',
                    'xp'    => '+' . $reg->event->exp_reward . ' XP',
                    'time'  => $reg->attended_at?->diffForHumans() ?? $reg->created_at->diffForHumans(),
                    'color' => '#34d399',
                    'icon'  => '✅',
                ];
            });
    }

    // ─── Quest Status Breakdown ───────────────────────────────────────

    public function getQuestStatusProperty()
    {
        $statusMap = [
            'published' => ['label' => 'Published',  'color' => '#34d399'],
            'ongoing'   => ['label' => 'Ongoing',    'color' => '#a78bfa'],
            'draft'     => ['label' => 'Draft',      'color' => '#fbbf24'],
            'completed' => ['label' => 'Completed',  'color' => '#60a5fa'],
            'cancelled' => ['label' => 'Cancelled',  'color' => '#f87171'],
        ];

        $counts = Event::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalEvents = $counts->sum() ?: 1;

        return collect($statusMap)->map(function ($cfg, $key) use ($counts, $totalEvents) {
            $val = $counts[$key] ?? 0;
            return [
                'label' => $cfg['label'],
                'value' => $val,
                'max'   => $totalEvents,
                'color' => $cfg['color'],
            ];
        })->values();
    }

    // ─── Top Heroes (by XP) ──────────────────────────────────────────

    public function getTopHeroesProperty()
    {
        $medals = ['🥇', '🥈', '🥉'];

        return StudentProfile::with('user')
            ->orderByDesc('current_exp')
            ->take(3)
            ->get()
            ->map(function ($profile, $index) use ($medals) {
                return [
                    'name' => $profile->user->name,
                    'xp'   => number_format($profile->current_exp),
                    'rank' => $medals[$index] ?? '🎖️',
                ];
            });
    }

    // ─── Stat Card Growth (simple delta vs last month) ────────────────

    public function getStatCardsProperty(): array
    {
        $totalPlayers  = $this->totalPlayers;
        $activeQuests  = $this->activeQuests;
        $totalCoins    = $this->totalCoins;
        $completionRate = $this->completionRate;

        // Delta players bulan ini vs bulan lalu
        $playersThisMonth = User::role('student')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $playersLastMonth = User::role('student')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $playerDelta = $playersLastMonth > 0
            ? round((($playersThisMonth - $playersLastMonth) / $playersLastMonth) * 100)
            : 0;

        // Delta quests
        $questsThisMonth = Event::whereIn('status', ['published', 'ongoing'])
            ->whereMonth('created_at', now()->month)->count();
        $questsLastMonth = Event::whereIn('status', ['published', 'ongoing'])
            ->whereMonth('created_at', now()->subMonth()->month)->count();
        $questDelta = $questsLastMonth > 0
            ? round((($questsThisMonth - $questsLastMonth) / $questsLastMonth) * 100)
            : 0;

        return [
            [
                'label'    => 'TOTAL PLAYERS',
                'value'    => number_format($totalPlayers),
                'delta'    => ($playerDelta >= 0 ? '+' : '') . $playerDelta . '%',
                'positive' => $playerDelta >= 0,
                'pct'      => min(100, $totalPlayers > 0 ? 78 : 0), // progress bar visual
                'barColor' => 'linear-gradient(90deg,#3b82f6,#60a5fa)',
                'iconBg'   => 'rgba(59,130,246,0.15)',
                'iconBorder' => 'rgba(59,130,246,0.3)',
                'iconColor'  => 'text-blue-400',
                'barBg'    => 'rgba(59,130,246,0.15)',
                'icon'     => 'users',
            ],
            [
                'label'    => 'ACTIVE QUESTS',
                'value'    => number_format($activeQuests),
                'delta'    => ($questDelta >= 0 ? '+' : '') . $questDelta . '%',
                'positive' => $questDelta >= 0,
                'pct'      => min(100, $activeQuests > 0 ? 62 : 0),
                'barColor' => null, // pakai class xp-bar-fill
                'iconBg'   => 'rgba(124,58,237,0.15)',
                'iconBorder' => 'rgba(124,58,237,0.35)',
                'iconColor'  => 'text-violet-400',
                'barBg'    => 'rgba(124,58,237,0.15)',
                'icon'     => 'bolt',
            ],
            [
                'label'    => 'TOTAL REWARDS',
                'value'    => '₿ ' . ($totalCoins >= 1000 ? number_format($totalCoins / 1000, 1) . 'k' : $totalCoins),
                'delta'    => 'COINS',
                'positive' => true,
                'pct'      => 45,
                'barColor' => 'linear-gradient(90deg,#d97706,#fbbf24)',
                'iconBg'   => 'rgba(245,158,11,0.12)',
                'iconBorder' => 'rgba(245,158,11,0.25)',
                'iconColor'  => 'text-yellow-400',
                'barBg'    => 'rgba(245,158,11,0.12)',
                'icon'     => 'coin',
            ],
            [
                'label'    => 'COMPLETED',
                'value'    => $completionRate . '%',
                'delta'    => '🔥 HOT',
                'positive' => true,
                'pct'      => $completionRate,
                'barColor' => 'linear-gradient(90deg,#059669,#34d399)',
                'iconBg'   => 'rgba(16,185,129,0.12)',
                'iconBorder' => 'rgba(16,185,129,0.25)',
                'iconColor'  => 'text-emerald-400',
                'barBg'    => 'rgba(16,185,129,0.12)',
                'icon'     => 'check',
            ],
        ];
    }

    // ─── Render ──────────────────────────────────────────────────────

    public function render()
    {
        return view('pages.dashboard.index', [
            'statCards'      => $this->statCards,
            'recentActivity' => $this->recentActivity,
            'questStatus'    => $this->questStatus,
            'topHeroes'      => $this->topHeroes,
        ]);
    }
}
