<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class IpBlacklist extends Model
{
    protected $fillable = [
        'ip_address',
        'reason',
        'blocked_at',
        'expires_at',
        'blocked_by',
        'attempt_count',
        'last_attempt_at',
        'notes',
    ];

    protected $casts = [
        'blocked_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_attempt_at' => 'datetime',
    ];

    // Relationship to user who blocked the IP
    public function blocker()
    {
        return $this->belongsTo(\App\Models\User::class, 'blocked_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
                    ->where('expires_at', '<=', now());
    }

    public function scopeAutoBlocked($query)
    {
        return $query->whereIn('reason', ['auto_blocked', 'rate_limit', 'spam_detected']);
    }

    public function scopeManual($query)
    {
        return $query->where('reason', 'manual');
    }

    // Helper methods
    public static function isBlacklisted($ip)
    {
        return Cache::remember("ip_blacklist_{$ip}", 300, function () use ($ip) {
            return self::where('ip_address', $ip)
                ->active()
                ->exists();
        });
    }

    public static function addToBlacklist($ip, $reason = 'manual', $expiresAt = null, $blockedBy = null, $notes = null)
    {
        $blacklist = self::updateOrCreate(
            ['ip_address' => $ip],
            [
                'reason' => $reason,
                'blocked_at' => now(),
                'expires_at' => $expiresAt,
                'blocked_by' => $blockedBy,
                'attempt_count' => 1,
                'last_attempt_at' => now(),
                'notes' => $notes,
            ]
        );

        Cache::forget("ip_blacklist_{$ip}");
        
        return $blacklist;
    }

    public static function removeFromBlacklist($ip)
    {
        $deleted = self::where('ip_address', $ip)->delete();
        Cache::forget("ip_blacklist_{$ip}");
        
        return $deleted;
    }

    public static function incrementAttempts($ip)
    {
        $blacklist = self::where('ip_address', $ip)->first();
        
        if ($blacklist) {
            $blacklist->increment('attempt_count');
            $blacklist->update(['last_attempt_at' => now()]);
            Cache::forget("ip_blacklist_{$ip}");
        }
    }

    // Check if IP should be auto-blocked
    public static function shouldAutoBlock($ip, $attemptCount = 5)
    {
        // Check recent failed attempts from this IP
        $recentAttempts = \App\Models\ContactMessage::where('created_at', '>=', now()->subHour())
            ->count();
            
        return $recentAttempts >= $attemptCount;
    }
}
