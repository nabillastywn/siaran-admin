<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if (Auth::check() && Auth::user()->role === 0) {
    //         return $next($request);
    //     }

    //     return redirect('/login')->withErrors(['You are not authorized to access this page.']);
    // }
}