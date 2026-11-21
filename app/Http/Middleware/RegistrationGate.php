<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Public sign-up stays closed until phase 2 (client & vendor accounts).
 * Fortify's registration feature stays enabled so its routes and the
 * generated Wayfinder helpers exist; this gate answers 404 while
 * ACCOUNTS_REGISTRATION is false.
 */
class RegistrationGate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('site.registration') && $request->routeIs('register', 'register.store')) {
            abort(404);
        }

        return $next($request);
    }
}
