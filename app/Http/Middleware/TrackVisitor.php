<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\VisitorLog;
use Illuminate\Support\Facades\Cache;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = $request->ip();
        $url = $request->fullUrl();
        $cacheKey = 'visitor_' . md5($ipAddress . $url);

        // Check if the visitor has already been logged today
        if (!Cache::has($cacheKey)) {
            // Simpan data pengunjung ke database
            VisitorLog::create([
                'v_ip_address' => $ipAddress,
                'v_user_agent' => $request->userAgent(),
                'v_referer' => $request->headers->get('referer'),
                'v_url' => $url,
                'v_visited_at' => now(),
            ]);

            // Set cache to expire in 24 hours
            Cache::put($cacheKey, true, now()->addDay());
        }

        return $next($request);
    }
}
