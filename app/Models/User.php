<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'student_achievements')
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'student_skills')
                    ->withPivot('points')
                    ->withTimestamps();
    }

    public function externalCertificates()
    {
        return $this->hasMany(ExternalCertificate::class);
    }
    
    protected $appends = [
        'rank_info',
    ];

    public function getRankInfoAttribute()
    {
        $profile = $this->studentProfile;
        if (!$profile) return null;

        $rank = StudentProfile::query()
            ->where('level', '>', $profile->level)
            ->orWhere(function($q) use ($profile) {
                $q->where('level', $profile->level)
                  ->where('current_exp', '>', $profile->current_exp);
            })->count() + 1;

        return [
            'current_rank' => $rank,
            'total_students' => StudentProfile::count()
        ];
    }

    public function getAvatarUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : "https://api.dicebear.com/7.x/bottts/svg?seed=$this->email&backgroundColor=f8fafc";
    }
}
