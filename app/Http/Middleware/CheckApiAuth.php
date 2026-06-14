<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('api_key') || !session('api_base_url')) {
            return redirect()->route('login')->with('error', 'Silakan login dan pastikan API Key & URL sudah diset.');
        }
        return $next($request);
    }
}
