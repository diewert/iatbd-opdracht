<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_admin) { // Zorg ervoor dat je het admin attribuut hebt
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Je hebt geen toegang tot deze pagina.');
    }
}
