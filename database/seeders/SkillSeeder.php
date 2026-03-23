<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Frontend Development', 'icon_path' => 'code', 'color_hex' => '#8b5cf6'],
            ['name' => 'UI/UX Design', 'icon_path' => 'palette', 'color_hex' => '#ec4899'],
            ['name' => 'Cloud Computing', 'icon_path' => 'cpu', 'color_hex' => '#a855f7'],
            ['name' => 'System Security', 'icon_path' => 'shield-check', 'color_hex' => '#22c55e'],
            ['name' => 'Prompt Engineering', 'icon_path' => 'chevron-right', 'color_hex' => '#eab308']
        ];

        foreach ($data as $item) {
            Skill::firstOrCreate(['name' => $item['name']], [
                'description' => $item['name'],
                'icon_path' => $item['icon_path'],
                'color_hex' => $item['color_hex']
            ]);
        }
    }
}
