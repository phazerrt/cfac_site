<?php

namespace App\Http\Controllers;

use App\Support\SitePages;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $xml = view('seo.sitemap', [
            'pages' => SitePages::pages(),
            'locales' => config('site.locales'),
        ])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots(): Response
    {
        $lines = config('site.indexable')
            ? ['User-agent: *', 'Disallow: /dashboard', 'Disallow: /settings', '', 'Sitemap: '.route('sitemap')]
            // Staging: keep crawlers out until the owner's domain is live.
            : ['User-agent: *', 'Disallow: /'];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
