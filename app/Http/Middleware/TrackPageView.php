<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests
        if ($request->isMethod('get')) {
            // Exclude admin routes, assets, and API routes
            $excludedPaths = [
                'dashboard',
                'login',
                'register',
                'password',
                'api',
                'livewire',
                '_debugbar',
            ];

            $path = $request->path();
            $shouldTrack = true;

            foreach ($excludedPaths as $excluded) {
                if (str_starts_with($path, $excluded)) {
                    $shouldTrack = false;
                    break;
                }
            }

            // Don't track asset requests
            if (str_contains($path, '.')) {
                $shouldTrack = false;
            }

            if ($shouldTrack) {
                try {
                    $userAgent = $request->userAgent();
                    
                    // Detect device type
                    $deviceType = $this->detectDeviceType($userAgent);
                    
                    // Detect browser and version
                    $browser = $this->detectBrowser($userAgent);
                    $browserVersion = $this->detectBrowserVersion($userAgent, $browser);
                    
                    // Detect platform/OS and version
                    $platform = $this->detectPlatform($userAgent);
                    $platformVersion = $this->detectPlatformVersion($userAgent, $platform);
                    
                    // Get location from IP (basic detection)
                    $location = $this->getLocationFromIP($request->ip());
                    
                    PageView::create([
                        'url' => $request->fullUrl(),
                        'referrer' => $request->header('referer'),
                        'ip_address' => $request->ip(),
                        'user_agent' => $userAgent,
                        'session_id' => $request->session()->getId(),
                        'device_type' => $deviceType,
                        'browser' => $browser,
                        'browser_version' => $browserVersion,
                        'platform' => $platform,
                        'platform_version' => $platformVersion,
                        'country' => $location['country'] ?? null,
                        'city' => $location['city'] ?? null,
                        'screen_resolution' => null, // Will be updated via JavaScript
                    ]);
                } catch (\Exception $e) {
                    // Silently fail - don't break the request
                    \Log::error('Failed to track page view: ' . $e->getMessage());
                }
            }
        }

        return $next($request);
    }
    
    private function detectDeviceType($userAgent)
    {
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
            return 'tablet';
        }
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
            return 'mobile';
        }
        return 'desktop';
    }
    
    private function detectBrowser($userAgent)
    {
        if (preg_match('/Edge/i', $userAgent)) return 'Edge';
        if (preg_match('/Chrome/i', $userAgent)) return 'Chrome';
        if (preg_match('/Safari/i', $userAgent)) return 'Safari';
        if (preg_match('/Firefox/i', $userAgent)) return 'Firefox';
        if (preg_match('/MSIE|Trident/i', $userAgent)) return 'IE';
        if (preg_match('/Opera|OPR/i', $userAgent)) return 'Opera';
        return 'Other';
    }
    
    private function detectPlatform($userAgent)
    {
        if (preg_match('/windows/i', $userAgent)) return 'Windows';
        if (preg_match('/macintosh|mac os x/i', $userAgent)) return 'macOS';
        if (preg_match('/linux/i', $userAgent)) return 'Linux';
        if (preg_match('/android/i', $userAgent)) return 'Android';
        if (preg_match('/iphone|ipad|ipod/i', $userAgent)) return 'iOS';
        return 'Other';
    }
    
    private function getLocationFromIP($ip)
    {
        // For local/private IPs, return null
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return ['country' => 'Local', 'city' => 'Localhost'];
        }
        
        // Use a free IP geolocation service
        try {
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country,city");
            if ($response) {
                $data = json_decode($response, true);
                return [
                    'country' => $data['country'] ?? null,
                    'city' => $data['city'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            // Silently fail
        }
        
        return ['country' => null, 'city' => null];
    }
    
    private function detectBrowserVersion($userAgent, $browser)
    {
        $version = 'Unknown';
        
        switch ($browser) {
            case 'Chrome':
                if (preg_match('/Chrome\/([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'Firefox':
                if (preg_match('/Firefox\/([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'Safari':
                if (preg_match('/Version\/([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'Edge':
                if (preg_match('/Edg\/([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                } elseif (preg_match('/Edge\/([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'Opera':
                if (preg_match('/OPR\/([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                } elseif (preg_match('/Opera\/([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'IE':
                if (preg_match('/MSIE ([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                } elseif (preg_match('/rv:([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                }
                break;
        }
        
        return $version;
    }
    
    private function detectPlatformVersion($userAgent, $platform)
    {
        $version = 'Unknown';
        
        switch ($platform) {
            case 'Windows':
                if (preg_match('/Windows NT ([0-9.]+)/', $userAgent, $matches)) {
                    $ntVersion = $matches[1];
                    // Map NT versions to Windows versions
                    $windowsVersions = [
                        '10.0' => '10/11',
                        '6.3' => '8.1',
                        '6.2' => '8',
                        '6.1' => '7',
                        '6.0' => 'Vista',
                        '5.1' => 'XP',
                    ];
                    $version = $windowsVersions[$ntVersion] ?? $ntVersion;
                }
                break;
            case 'macOS':
                if (preg_match('/Mac OS X ([0-9_]+)/', $userAgent, $matches)) {
                    $version = str_replace('_', '.', $matches[1]);
                }
                break;
            case 'iOS':
                if (preg_match('/OS ([0-9_]+)/', $userAgent, $matches)) {
                    $version = str_replace('_', '.', $matches[1]);
                }
                break;
            case 'Android':
                if (preg_match('/Android ([0-9.]+)/', $userAgent, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'Linux':
                $version = 'Generic';
                break;
        }
        
        return $version;
    }
}
