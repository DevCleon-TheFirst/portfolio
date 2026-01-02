<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'description',
        'icon',
        'color',
        'link',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];
}
