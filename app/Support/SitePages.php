<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * Localized public pages: route names, URLs, language alternates and the
 * data every public page shares (navigation, contact details, UI strings).
 *
 * Default-locale (English) routes use the bare page name ("tents"); other
 * locales are prefixed ("ms.tents").
 */
class SitePages
{
    /** @return list<string> */
    public static function locales(): array
    {
        return array_keys(config('site.locales'));
    }

    /** @return list<string> */
    public static function pages(): array
    {
        return array_keys(config('site.pages'));
    }

    public static function routeName(string $page, string $locale): string
    {
        return $locale === config('site.default_locale') ? $page : "{$locale}.{$page}";
    }

    public static function url(string $page, ?string $locale = null): string
    {
        return route(self::routeName($page, $locale ?? app()->getLocale()));
    }

    /**
     * The public page the request is on, or null for app/auth pages.
     */
    public static function current(Request $request): ?string
    {
        $name = $request->route()?->getName();

        if ($name === null) {
            return null;
        }

        $page = str_contains($name, '.') ? substr($name, strpos($name, '.') + 1) : $name;

        return in_array($page, self::pages(), true) && $name === self::routeName($page, app()->getLocale())
            ? $page
            : null;
    }

    /**
     * @return array<string, mixed>
     */
    public static function shared(Request $request): array
    {
        $locale = app()->getLocale();
        $current = self::current($request);
        $contact = config('site.contact');

        return [
            'key' => $current,
            'canonical' => $current ? self::url($current) : null,
            'alternates' => collect(self::locales())->mapWithKeys(fn (string $l) => [
                $l => [
                    'href' => $current ? self::url($current, $l) : self::url('home', $l),
                    'label' => config("site.locales.{$l}.label"),
                    'name' => config("site.locales.{$l}.name"),
                    'hreflang' => config("site.locales.{$l}.hreflang"),
                ],
            ])->all(),
            'ogLocale' => config("site.locales.{$locale}.og"),
            'ogImage' => asset('images/og-image.jpg'),
            'indexable' => config('site.indexable'),
            'nav' => collect(self::pages())->map(fn (string $page) => [
                'key' => $page,
                'href' => self::url($page),
            ])->all(),
            'business' => [
                'name' => config('site.name'),
                'tagline' => config("site.tagline.{$locale}"),
                'motto' => config('site.motto'),
                'phone' => $contact['phone'],
                'phoneDisplay' => $contact['phone_display'],
                'whatsapp' => $contact['whatsapp'],
                'whatsappDisplay' => $contact['whatsapp_display'],
                'email' => $contact['email'],
                'area' => $contact['area'][$locale],
                'social' => $contact['social'],
            ],
        ];
    }

    /**
     * All UI strings for the locale (lang/{locale}.json), cached per process.
     *
     * @return array<string, string>
     */
    public static function translations(string $locale): array
    {
        static $cache = [];

        return $cache[$locale] ??= File::exists($path = lang_path("{$locale}.json"))
            ? json_decode(File::get($path), true, flags: JSON_THROW_ON_ERROR)
            : [];
    }

    /**
     * schema.org data for the business (rendered as JSON-LD on public pages).
     *
     * @return array<string, mixed>
     */
    public static function structuredData(): array
    {
        $c = config('site.contact');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => config('site.name'),
            'description' => config('site.tagline.'.app()->getLocale()),
            'slogan' => config('site.motto'),
            'url' => self::url('home'),
            'logo' => asset('images/brand/logo-full.png'),
            'image' => asset('images/og-image.jpg'),
            'telephone' => $c['phone'],
            'email' => $c['email'],
            'areaServed' => $c['area']['en'],
            'sameAs' => [$c['social']['instagram']['url'], $c['social']['tiktok']['url']],
            'priceRange' => 'RM350 - RM3500',
        ];
    }
}
