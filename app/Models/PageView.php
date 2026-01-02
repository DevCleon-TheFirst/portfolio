<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PageView extends Model
{
    protected $fillable = [
        'url',
        'referrer',
        'ip_address',
        'user_agent',
        'session_id',
        'duration',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'browser_version',
        'platform_version',
        'screen_resolution',
    ];

    // Scopes for date filtering
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    public function scopeLastDays($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Analytics methods
    public static function getTotalViews()
    {
        return self::count();
    }

    public static function getUniqueVisitors()
    {
        return self::distinct('ip_address')->count('ip_address');
    }

    public static function getTodayViews()
    {
        return self::today()->count();
    }

    public static function getThisWeekViews()
    {
        return self::thisWeek()->count();
    }

    public static function getPopularPages($limit = 10)
    {
        return self::select('url', DB::raw('count(*) as views'))
            ->groupBy('url')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();
    }

    public static function getDailyViews($days = 7)
    {
        return self::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public static function getRecentVisitors($limit = 10)
    {
        return self::latest()
            ->limit($limit)
            ->get();
    }

    public static function getTopReferrers($limit = 10)
    {
        return self::select('referrer', DB::raw('count(*) as count'))
            ->whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->groupBy('referrer')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }
    
    public static function getDeviceStats()
    {
        return self::select('device_type', DB::raw('count(*) as count'))
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get();
    }
    
    public static function getTopCountries($limit = 10)
    {
        return self::select('country', DB::raw('count(*) as count'))
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }
    
    public static function getBrowserStats()
    {
        return self::select('browser', DB::raw('count(*) as count'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->get();
    }
}
