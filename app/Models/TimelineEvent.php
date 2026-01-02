<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimelineEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'event_type', // 'work', 'education', 'project', 'award', etc.
        'icon',
        'order',
    ];

    protected $casts = [
        'date' => 'date',
        'order' => 'integer',
        'icon' => 'string', // Ensure icon is treated as string if it's an emoji/text
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
