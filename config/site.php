<?php

/*
|--------------------------------------------------------------------------
| Business details for the public site
|--------------------------------------------------------------------------
|
| Facts copied from the Creative Factory 2026 catalogue (CF_CATALOGUE_2026-ogos.pdf).
| Translatable strings are keyed by locale; everything else is shared.
|
*/

return [

    'name' => 'Creative Factory',

    'tagline' => [
        'en' => 'Event Management & Equipment Supplier',
        'ms' => 'Pengurusan Acara & Pembekal Peralatan',
    ],

    'motto' => 'Dream. Plan. Celebrate.',

    // Public staging must not be indexed until the owner's domain goes live.
    'indexable' => (bool) env('SITE_INDEXABLE', false),

    // Accounts are not part of phase 1. Closed until there is something to sign in to.
    'registration' => (bool) env('ACCOUNTS_REGISTRATION', false),

    'locales' => [
        'en' => ['label' => 'EN', 'name' => 'English', 'hreflang' => 'en-MY', 'og' => 'en_MY'],
        'ms' => ['label' => 'BM', 'name' => 'Bahasa Melayu', 'hreflang' => 'ms-MY', 'og' => 'ms_MY'],
    ],

    'default_locale' => 'en',

    // Public pages and their path per locale. The key is the route name
    // (English routes use the bare name, Malay ones are prefixed "ms.").
    'pages' => [
        'home' => ['en' => '/', 'ms' => '/ms'],
        'tents' => ['en' => '/tent-packages', 'ms' => '/ms/pakej-khemah'],
        'equipment' => ['en' => '/equipment', 'ms' => '/ms/peralatan'],
        'gallery' => ['en' => '/gallery', 'ms' => '/ms/galeri'],
        'contact' => ['en' => '/contact', 'ms' => '/ms/hubungi'],
    ],

    'contact' => [
        // Calls and WhatsApp use the same number, as printed in the catalogue.
        'phone' => '+60149576683',
        'phone_display' => '+6014-957 6683',
        'whatsapp' => '60149576683',
        'whatsapp_display' => '+6014-957 6683',
        'email' => 'creativefactoryevents@gmail.com',
        // The catalogue gives no street address. "KK" in the social handles
        // and the event photos point to Kota Kinabalu. Confirm with the owner.
        'area' => [
            'en' => 'Kota Kinabalu, Sabah',
            'ms' => 'Kota Kinabalu, Sabah',
        ],
        'social' => [
            'instagram' => ['handle' => 'creativefactorykk', 'url' => 'https://www.instagram.com/creativefactorykk'],
            'tiktok' => ['handle' => 'CreativeFactoryKK', 'url' => 'https://www.tiktok.com/@creativefactorykk'],
            // Page URL not in the catalogue: a search link until the owner confirms it.
            'facebook' => ['handle' => 'Creative Factory', 'url' => 'https://www.facebook.com/search/top?q=Creative%20Factory%20KK'],
        ],
    ],

];
