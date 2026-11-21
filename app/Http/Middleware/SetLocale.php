<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the locale given as a route-middleware parameter: "locale:en".
 * Public pages carry their locale in the URL (Malay at /, English at /en).
 */
class SetLocale
{
    public function handle(Request $request, Closure $next, ?string $locale = null): Response
    {
        $locales = array_keys(config('site.locales'));

        $locale = in_array($locale, $locales, true) ? $locale : config('site.default_locale');

        app()->setLocale($locale);

        return $next($request);
    }
}
