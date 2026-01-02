<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password',
        'resume_path',
        'discipline_score',
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
            'discipline_score' => 'decimal:2',
        ];
    }

    // Relationships
    public function internalProjects()
    {
        return $this->hasMany(InternalProject::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function focusSessions()
    {
        return $this->hasMany(FocusSession::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function accountabilityMetrics()
    {
        return $this->hasMany(AccountabilityMetric::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
