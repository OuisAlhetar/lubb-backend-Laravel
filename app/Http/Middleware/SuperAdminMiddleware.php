<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_super_admin) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}