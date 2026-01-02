<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image_path',
        'featured_image_path',
        'category',
        'tags',
        'read_time',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_image',
        'index_page',
        'is_published',
        'published_at',
        'scheduled_at',
        'view_count',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'view_count' => 'integer',
        'read_time' => 'integer',
        'index_page' => 'boolean',
    ];

    // Boot method to auto-generate slug and read time
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            
            // Auto-calculate read time (average 200 words per minute)
            if (empty($post->read_time) && !empty($post->content)) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->read_time = max(1, ceil($wordCount / 200));
            }
        });
        
        static::updating(function ($post) {
            // Recalculate read time if content changed
            if ($post->isDirty('content')) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->read_time = max(1, ceil($wordCount / 200));
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function scopeScheduled($query)
    {
        return $query->where('is_published', false)
                    ->whereNotNull('scheduled_at');
    }

    public function scopeDraft($query)
    {
        return $query->where('is_published', false)
                    ->whereNull('scheduled_at');
    }

    // Helper methods
    public function incrementViews()
    {
        $this->increment('view_count');
    }

    public function publish()
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
