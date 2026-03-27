<?php

namespace App\Livewire\CampusInsight;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\ExternalCertificate;
use App\Models\Item;
use App\Models\ItemRedemption;
use App\Models\PointTransaction;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts::app')]
#[Title('Campus Insight')]
class Index extends Component
{
    public string $activeTab    = 'overview';
    public string $periodFilter = 'monthly';

    // ── Rebuild cache kalau period berubah ────────
    public function updatingPeriodFilter(): void
    {
        Cache::forget('campus_insight.' . $this->periodFilter);
    }

    // ────────────────────────────────────────────
    // RENDER
    // ────────────────────────────────────────────
    public function render()
    {
        $period = $this->periodFilter;

        // Semua data di-cache 5 menit per period
        $data = Cache::remember("campus_insight.{$period}", 300, function () use ($period) {

            // ── Date range ───────────────────────
            $startDate = match ($period) {
                'weekly'   => now()->subWeek(),
                'semester' => now()->subMonths(6),
                default    => now()->subMonth(),   // monthly
            };

            $prevStart = match ($period) {
                'weekly'   => now()->subWeeks(2),
                'semester' => now()->subMonths(12),
                default    => now()->subMonths(2),
            };
            $prevEnd = $startDate;

            // ── KPI ──────────────────────────────
            $activeStudents     = User::whereHas('roles', fn($q) => $q->where('name', 'user'))->count();
            $prevActiveStudents = $activeStudents; // baseline
            $questsCompleted    = EventRegistration::where('status', 'attended')
                ->whereBetween('attended_at', [$startDate, now()])->count();
            $prevQuestsCompleted = EventRegistration::where('status', 'attended')
                ->whereBetween('attended_at', [$prevStart, $prevEnd])->count();
            $totalXp            = StudentProfile::sum('current_exp');
            $coinsCirculating   = StudentProfile::sum('total_coins');

            // ── Participation trend (9 bulan terakhir) ──
            $trendMonths = collect(range(8, 0))->map(function ($i) {
                $month = now()->subMonths($i);
                $start = $month->copy()->startOfMonth();
                $end   = $month->copy()->endOfMonth();

                return [
                    'label'        => $month->format('M'),
                    'participants' => EventRegistration::whereBetween('created_at', [$start, $end])->count(),
                    'completions'  => EventRegistration::where('status', 'attended')
                        ->whereBetween('attended_at', [$start, $end])->count(),
                ];
            })->all();

            // ── Interest heatmap — by event category ──
            $categoryStats = Event::select('category', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->get()
                ->map(fn($e) => [
                    'name'  => ucfirst(str_replace('-', ' ', $e->category)),
                    'total' => $e->total,
                ]);
            $catMax = $categoryStats->max('total') ?: 1;

            // ── Activity heatmap — last 35 days ──
            $activityMap = EventRegistration::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
                ->where('created_at', '>=', now()->subDays(35))
                ->groupBy('date')
                ->pluck('count', 'date');

            // ── Top performers ──
            $topPerformers = StudentProfile::with('user')
                ->orderByDesc('current_exp')
                ->limit(6)
                ->get();

            // ── Quest tab: completion by category ──
            $questByCategory = Event::select(
                'category',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when status = "completed" then 1 else 0 end) as done')
            )
                ->groupBy('category')
                ->get();

            // ── Quest status distribution ──
            $questStatus = Event::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status');

            // ── Most popular events ──
            $popularEvents = Event::withCount([
                'registrations as participants_count' => fn($q) =>
                $q->whereIn('status', ['registered', 'attended'])
            ])
                ->withCount([
                    'registrations as attended_count' => fn($q) =>
                    $q->where('status', 'attended')
                ])
                ->orderByDesc('participants_count')
                ->limit(5)
                ->get();

            // ── Students tab: level distribution ──
            $levelDist = StudentProfile::select(
                DB::raw('CASE
                        WHEN level BETWEEN 1 AND 5   THEN "Lv 1–5"
                        WHEN level BETWEEN 6 AND 10  THEN "Lv 6–10"
                        WHEN level BETWEEN 11 AND 15 THEN "Lv 11–15"
                        WHEN level BETWEEN 16 AND 20 THEN "Lv 16–20"
                        WHEN level BETWEEN 21 AND 25 THEN "Lv 21–25"
                        ELSE "Lv 26+"
                    END as level_group'),
                DB::raw('count(*) as count')
            )
                ->groupBy('level_group')
                ->pluck('count', 'level_group')
                ->toArray();

            // ── Enrollment trend ──
            $enrollTrend = collect(range(8, 0))->map(function ($i) {
                $month = now()->subMonths($i);
                return [
                    'label' => $month->format('M'),
                    'count' => User::whereBetween('created_at', [
                        $month->copy()->startOfMonth(),
                        $month->copy()->endOfMonth(),
                    ])->count(),
                ];
            })->all();

            // ── Economy tab: coins flow ──
            $coinsFlow = collect(range(8, 0))->map(function ($i) {
                $month = now()->subMonths($i);
                $start = $month->copy()->startOfMonth();
                $end   = $month->copy()->endOfMonth();

                return [
                    'label'  => $month->format('M'),
                    'earned' => PointTransaction::where('type', 'credit')
                        ->whereBetween('created_at', [$start, $end])->sum('amount'),
                    'spent'  => PointTransaction::where('type', 'debit')
                        ->whereBetween('created_at', [$start, $end])->sum('amount'),
                ];
            })->all();

            // ── Top redemptions ──
            $topRedemptions = ItemRedemption::select('item_id', DB::raw('count(*) as count'), DB::raw('sum(total_price_coins) as total_coins'))
                ->whereIn('status', ['verified', 'completed'])
                ->with('item')
                ->groupBy('item_id')
                ->orderByDesc('count')
                ->limit(5)
                ->get();

            // ── Delta calculations ──
            $questDelta = $prevQuestsCompleted > 0
                ? round((($questsCompleted - $prevQuestsCompleted) / $prevQuestsCompleted) * 100, 1)
                : 0;

            return compact(
                'activeStudents',
                'questsCompleted',
                'questDelta',
                'totalXp',
                'coinsCirculating',
                'trendMonths',
                'categoryStats',
                'catMax',
                'activityMap',
                'topPerformers',
                'questByCategory',
                'questStatus',
                'popularEvents',
                'levelDist',
                'enrollTrend',
                'coinsFlow',
                'topRedemptions'
            );
        });

        return view('pages.campus-insight.index', $data + [
            'periodFilter' => $this->periodFilter,
            'activeTab'    => $this->activeTab,
        ]);
    }
}
