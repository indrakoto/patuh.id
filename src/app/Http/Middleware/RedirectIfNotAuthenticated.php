<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (! $request->expectsJson() && ! auth()->check()) {
            session()->flash('warning', 'Login terlebih dahulu untuk mengakses fitur tersebut');
            session()->flash('redirect_after_login', $request->fullUrl());
            return redirect()->route('login');
        }

        return $next($request);
    }
}
