<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuest extends Model
{
    protected $fillable = ['title', 'description', 'exp_reward', 'coin_reward', 'type', 'is_active'];

    public function completions()
    {
        return $this->hasMany(DailyQuestCompletion::class);
    }
}
