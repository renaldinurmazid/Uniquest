<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'superadmin@mail.com')->first();
        if ($user) {
            StudentProfile::updateOrCreate(['user_id' => $user->id], [
                'npm' => '12345678',
                'level' => 12,
                'current_exp' => 2450,
                'total_coins' => 2450,
                'rank_title' => 'Legendary Master'
            ]);

            $skills = Skill::all();
            $sample_points = [1200, 850, 450, 420, 750]; // Expert, Advanced, Intermediate, Intermediate, Advanced
            
            foreach ($skills as $index => $skill) {
                $points = $sample_points[$index % count($sample_points)];
                $user->skills()->syncWithoutDetaching([
                    $skill->id => ['points' => $points]
                ]);
            }
        }
    }
}
