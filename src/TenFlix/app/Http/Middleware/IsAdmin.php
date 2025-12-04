<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // looks at the session/cookie guard when user is authenticated
        // also checks if the user is an admin through the db
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/');
        }
        return $next($request);
    }
}
