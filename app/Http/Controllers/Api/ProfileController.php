<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $profile = $user->studentProfile;

            if (!$profile) {
                return response()->json([
                    'message' => 'Profile not found'
                ], 404);
            }

            // Quests Done
            $quests_done = DB::table('daily_quest_completions')->where('user_id', $user->id)->count();

            // Skill tree mapping
            $skills = $user->skills()->get()->map(function($skill) {
                $points = $skill->pivot->points;
                
                // Example proficiency logic based on points
                $proficiency = 'INTERMEDIATE';
                if ($points >= 1000) $proficiency = 'EXPERT';
                elseif ($points >= 750) $proficiency = 'ADVANCED';
                elseif ($points >= 400) $proficiency = 'INTERMEDIATE';
                else $proficiency = 'BEGINNER';

                // Example level calculation
                $level = floor($points / 100) + 1;

                return [
                    'id' => $skill->id,
                    'name' => $skill->name,
                    'proficiency' => $proficiency,
                    'level' => $level,
                    'points' => $points,
                    'icon_path' => $skill->icon_path,
                    'color_hex' => $skill->color_hex,
                ];
            });

            // Character stats
            // Placeholder: every level requires (current level * 250) exp
            $next_level_exp = $profile->level * 250; 
            $progress_percent = min(100, round(($profile->current_exp / $next_level_exp) * 100));

            return response()->json([
                'message' => 'Profile details retrieved successfully',
                'stats' => [
                    'level' => $profile->level,
                    'current_exp' => $profile->current_exp,
                    'next_level_exp' => $next_level_exp,
                    'progress_percent' => $progress_percent,
                    'total_points' => $profile->total_coins,
                    'quests_done' => $quests_done,
                ],
                'skills' => $skills
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve profile data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
