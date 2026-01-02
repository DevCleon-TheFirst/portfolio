<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'problem',
        'solution',
        'result',
        'tech_stack',
        'screenshots',
        'lessons_learned',
        'project_url',
        'github_url',
        'category',
        'image_path',
        'is_featured',
        'order',
        'view_count',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'screenshots' => 'array',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'view_count' => 'integer',
    ];

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Helper methods
    public function incrementViews()
    {
        $this->increment('view_count');
    }
}
