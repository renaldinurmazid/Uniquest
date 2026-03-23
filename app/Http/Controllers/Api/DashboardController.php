<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyQuest;
use App\Models\Event;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Exception;

class DashboardController extends Controller
{
    public function skillHexagon(Request $request)
    {
        try {
            $user = $request->user();
            $data = $user->skills()->get()->map(function($skill) {
                return [
                    'label' => $skill->name,
                    'value' => $skill->pivot->points
                ];
            });

            return response()->json([
                'message' => 'Skill Hexagon data retrieved',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function upcomingEvents(Request $request)
    {
        try {
            $data = Event::where('event_date', '>=', now())
                ->orderBy('event_date', 'asc')
                ->take(5)
                ->get()
                ->map(function($event) {
                    return [
                        'title' => $event->title,
                        'location' => $event->location,
                        'event_date' => $event->event_date,
                        'exp_reward' => $event->exp_reward,
                        'coin_reward' => $event->coin_reward,
                    ];
                });

            return response()->json([
                'message' => 'Upcoming events retrieved',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function dailyQuests(Request $request)
    {
        try {
            $data = DailyQuest::where('is_active', true)
                ->take(3)
                ->get()
                ->map(function($quest) {
                    return [
                        'title' => $quest->title,
                        'difficulty' => strtoupper($quest->type),
                        'exp_reward' => $quest->exp_reward,
                        'coin_reward' => $quest->coin_reward,
                    ];
                });

            return response()->json([
                'message' => 'Daily quests retrieved',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function leaderboard(Request $request)
    {
        try {
            $data = StudentProfile::with('user')
                ->orderBy('level', 'desc')
                ->orderBy('current_exp', 'desc')
                ->take(5)
                ->get()
                ->map(function($profile, $index) {
                    return [
                        'rank' => $index + 1,
                        'name' => $profile->user->name,
                        'level' => $profile->level,
                        'exp' => $profile->current_exp,
                        'avatar' => $profile->user->avatar_url,
                    ];
                });

            return response()->json([
                'message' => 'Leaderboard retrieved',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
