<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'icon',
        'order',
    ];

    protected $casts = [
        'proficiency' => 'integer',
        'order' => 'integer',
    ];

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
