<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\VisitorLog;
use Carbon\Carbon;

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
        $today = Carbon::today(); // Ambil tanggal hari ini

        // Jika URL mengarah ke halaman admin atau auth, lewati middleware
        if ($request->is('admin/*') || $request->is('login') || $request->is('register') || $request->is('user/*') || $request->routeIs('login') || $request->routeIs('register')) {
            return $next($request);
        }

        // Daftar nama route yang akan dilacak
        $trackedRoutes = [
            'home', 'blog', 'blog.show', 'destination', 'destination.show', 'contact', 
            'berita', 'tatatertib', 'pembiasaan', 'penghargaan', 'ekstrakurikuler.show', 
            'strukturorganisasi', 'ekstrakurikuler.pramuka', 'ekstrakurikuler.kesenian', 
            'ekstrakurikuler.karate', 'ekstrakurikuler.silat', 'ekstrakurikuler.olimpiade', 
            'ekstrakurikuler.paskibra', 'ekstrakurikuler.hoki', 'ekstrakurikuler.pmr', 
            'ekstrakurikuler.renang'
        ];

        // Jika nama route tidak ada dalam daftar, lewati middleware
        $route = $request->route();
        if ($route && !in_array($route->getName(), $trackedRoutes)) {
            return $next($request);
        }

        $existingVisit = VisitorLog::where('v_ip_address', $ipAddress)
            ->where('v_url', $url)
            ->whereDate('v_visited_at', $today)
            ->first();

        // Jika belum tercatat, simpan data ke database
        if (!$existingVisit) {
            VisitorLog::create([
                'v_ip_address' => $ipAddress,
                'v_user_agent' => $request->userAgent(),
                'v_referer' => $request->headers->get('referer'),
                'v_url' => $url,
                'v_visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
