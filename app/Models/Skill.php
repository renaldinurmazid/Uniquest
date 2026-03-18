<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'description', 'icon_path', 'color_hex'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'student_skills')
                    ->withPivot('points')
                    ->withTimestamps();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_skills')
                    ->withPivot('exp_gain')
                    ->withTimestamps();
    }
}
