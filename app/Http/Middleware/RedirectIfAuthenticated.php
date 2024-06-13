<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Logging to check if middleware is being executed
        Log::info('Middleware check for authentication');

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Logging to see if the user is already authenticated
                Log::info('User is authenticated, redirecting to home');
                return redirect(RouteServiceProvider::HOME);
            }
        }

        // Logging to indicate middleware allows the request to pass through
        Log::info('User is not authenticated, proceeding with the request');
        return $next($request);
    }
}