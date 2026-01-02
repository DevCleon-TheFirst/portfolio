<?php

namespace App\Http\Middleware;

use App\Models\IpBlacklist;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIpBlacklist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        
        // Check if IP is blacklisted
        if (IpBlacklist::isBlacklisted($ip)) {
            // Increment attempt count
            IpBlacklist::incrementAttempts($ip);
            
            // Return 403 Forbidden
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Your IP address has been blocked due to suspicious activity.',
                ], 403);
            }
            
            abort(403, 'Access denied. Your IP address has been blocked.');
        }
        
        return $next($request);
    }
}
