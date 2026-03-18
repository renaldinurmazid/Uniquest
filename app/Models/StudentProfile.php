<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = ['user_id', 'npm', 'level', 'current_exp', 'total_coins', 'rank_title', 'skill_distribution'];

    protected $casts = [
        'skill_distribution' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
