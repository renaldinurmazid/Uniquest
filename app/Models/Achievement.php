<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['title', 'description', 'badge_icon_path', 'requirement_type', 'requirement_value'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'student_achievements')
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }
}
