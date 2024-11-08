<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckIfBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Controleer of de gebruiker is ingelogd en of de gebruiker is geblokkeerd
        if (Auth::check() && Auth::user()->is_blocked) {
            Auth::logout(); // Log de gebruiker uit als deze is geblokkeerd
            return redirect('/login')->with('error', 'Je account is geblokkeerd. Neem contact op met de administrator.');
        }

        return $next($request);
    }
}
