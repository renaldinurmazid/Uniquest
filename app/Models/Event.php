<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'image_path',
        'location',
        'event_date',
        'quota',
        'exp_reward',
        'coin_reward',
        'qr_code_token',
        'status',
        'category',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    // ── Auto-generate QR token sebelum create ──
    protected static function booted(): void
    {
        static::creating(function (Event $event) {
            if (empty($event->qr_code_token)) {
                $event->qr_code_token = Str::upper(Str::random(12));
            }
        });
    }

    // ── Relationships ──
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'event_skills')
            ->withPivot('exp_gain')
            ->withTimestamps();
    }

    // ── Helpers ──
    public function getFilledCountAttribute(): int
    {
        return $this->registrations()->whereIn('status', ['registered', 'attended'])->count();
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, $this->quota - $this->filled_count);
    }

    public function isFullAttribute(): bool
    {
        return $this->filled_count >= $this->quota;
    }
}
