<?php

use App\Http\Controllers\SeoController;
use App\Http\Controllers\SiteController;
use App\Support\SitePages;
use Illuminate\Support\Facades\Route;

/*
| Public site: Malay at "/", English under "/en". Paths live in config/site.php.
*/
foreach (SitePages::locales() as $locale) {
    foreach (config('site.pages') as $page => $paths) {
        Route::get($paths[$locale], [SiteController::class, $page])
            ->middleware("locale:{$locale}")
            ->name(SitePages::routeName($page, $locale));
    }
}

Route::get('sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('robots.txt', [SeoController::class, 'robots'])->name('robots');

/*
| Accounts (phase 2: clients & vendors, bookings). Not linked from the site yet.
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
