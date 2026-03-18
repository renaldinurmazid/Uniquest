<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSkill extends Model
{
    protected $fillable = ['event_id', 'skill_id', 'exp_gain'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
