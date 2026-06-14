<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestApi
{
    public function handle(Request $request, Closure $next)
    {
        if (session('api_key')) {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
