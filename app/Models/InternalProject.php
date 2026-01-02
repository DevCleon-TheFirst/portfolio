<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_date',
        'deadline',
        'is_public',
        'status',
        'completion_percentage',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
        'is_public' => 'boolean',
        'completion_percentage' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helper methods
    public function updateCompletionPercentage()
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) {
            $this->update(['completion_percentage' => 0]);
            return;
        }

        $completedTasks = $this->tasks()->completed()->count();
        $percentage = ($completedTasks / $totalTasks) * 100;
        
        $this->update(['completion_percentage' => round($percentage)]);
    }
}
