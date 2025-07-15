<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddSecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Tambahkan header keamanan
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // atau DENY
        //$response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self';");

        return $response;
    }
}
