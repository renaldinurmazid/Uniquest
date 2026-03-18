<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalCertificate extends Model
{
    protected $fillable = [
        'user_id', 'title', 'organizer', 'issue_date', 'file_path', 
        'status', 'verified_by', 'verified_at', 'admin_notes', 
        'exp_reward_given', 'coin_reward_given'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
