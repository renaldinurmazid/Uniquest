<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organization_id', 'title', 'description', 'image_path', 'location', 
        'event_date', 'quota', 'exp_reward', 'coin_reward', 'qr_code_token', 'status', 'category'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'event_skills')
                    ->withPivot('exp_gain')
                    ->withTimestamps();
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}
