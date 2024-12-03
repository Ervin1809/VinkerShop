<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GuestOrBuyerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guest() || Auth::user()->role === 'buyer') {
            return $next($request);
        }

        return redirect('/')->with('error', 'You are not authorized to access this page');
    }
}
