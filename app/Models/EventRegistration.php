<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'attended_at',
        'claimed_at',
        'ticket_code',
    ];

    protected $casts = [
        'attended_at' => 'datetime',
        'claimed_at'  => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (EventRegistration $reg) {
            if (empty($reg->ticket_code)) {
                $reg->ticket_code = Str::upper(Str::random(10));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
