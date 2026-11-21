{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($pages as $page)
@foreach ($locales as $locale => $meta)
    <url>
        <loc>{{ \App\Support\SitePages::url($page, $locale) }}</loc>
@foreach ($locales as $alt => $altMeta)
        <xhtml:link rel="alternate" hreflang="{{ $altMeta['hreflang'] }}" href="{{ \App\Support\SitePages::url($page, $alt) }}" />
@endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ \App\Support\SitePages::url($page, config('site.default_locale')) }}" />
        <changefreq>monthly</changefreq>
        <priority>{{ $page === 'home' ? '1.0' : '0.8' }}</priority>
    </url>
@endforeach
@endforeach
</urlset>
