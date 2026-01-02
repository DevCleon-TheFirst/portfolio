<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    // Helper method to get a setting value
    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    // Helper method to set a setting value
    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );

        Cache::forget("setting_{$key}");
        
        return $setting;
    }

    // Get all settings in a group
    public static function getGroup($group)
    {
        return self::where('group', $group)->pluck('value', 'key');
    }

    // Get all social media links
    public static function getSocialLinks()
    {
        return self::where('group', 'social_media')
            ->whereNotNull('value')
            ->where('value', '!=', '')
            ->pluck('value', 'key');
    }
}
