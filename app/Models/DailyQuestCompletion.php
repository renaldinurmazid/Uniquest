<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuestCompletion extends Model
{
    protected $fillable = ['user_id', 'daily_quest_id', 'completed_date'];

    protected $casts = [
        'completed_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyQuest()
    {
        return $this->belongsTo(DailyQuest::class);
    }
}
