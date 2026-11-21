<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Until the owner's domain goes live (SITE_INDEXABLE=true) every response
 * tells search engines not to index the staging site.
 */
class NoIndexStaging
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('site.indexable')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        return $response;
    }
}
