<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'internal_project_id',
        'user_id',
        'title',
        'description',
        'estimated_time',
        'actual_time',
        'due_at',
        'status',
        'priority',
        'order',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'estimated_time' => 'integer',
        'actual_time' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function internalProject()
    {
        return $this->belongsTo(InternalProject::class);
    }

    public function focusSessions()
    {
        return $this->hasMany(FocusSession::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeMissed($query)
    {
        return $query->where('status', 'missed');
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_at', today());
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_at', '<', now())
                    ->whereNotIn('status', ['completed', 'missed']);
    }

    // Helper methods
    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsMissed()
    {
        $this->update(['status' => 'missed']);
    }

    public function startFocusSession()
    {
        return $this->focusSessions()->create([
            'user_id' => $this->user_id,
            'started_at' => now(),
        ]);
    }
}
