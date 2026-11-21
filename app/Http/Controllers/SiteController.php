<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Package;
use App\Models\Service;
use App\Support\Gallery;
use Inertia\Inertia;
use Inertia\Response;

class SiteController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('site/Home', [
            'events' => Service::query()->visible('event')->get()->map->toCard(),
            'featured' => Package::query()->tents()->where('is_featured', true)->ordered()->get()->map->toCard(),
            'fromPrices' => [
                'arabian' => Package::query()->where('category', 'arabian')->min('price'),
                'block' => Package::query()->where('category', 'block')->min('price'),
            ],
            'tentCount' => Package::query()->tents()->count(),
            'gallery' => Gallery::items()->take(8)->values(),
        ]);
    }

    public function tents(): Response
    {
        return Inertia::render('site/Tents', [
            'packages' => Package::query()->tents()->ordered()->get()->map->toCard(),
            'addOns' => AddOn::query()->orderBy('sort_order')->get()->map->toRow(),
        ]);
    }

    public function equipment(): Response
    {
        return Inertia::render('site/Equipment', [
            'packages' => Package::query()->where('category', 'av')->ordered()->get()->map->toCard(),
            'extras' => Service::query()->visible('extra')->get()->map->toCard(),
        ]);
    }

    public function gallery(): Response
    {
        return Inertia::render('site/Gallery', [
            'items' => Gallery::items(),
            'tags' => Gallery::tags(),
        ]);
    }

    public function contact(): Response
    {
        return Inertia::render('site/Contact', [
            'events' => Service::query()->visible('event')->get()->map->only(['slug', 'title']),
            'packages' => Package::query()->ordered()->get()
                ->map(fn (Package $p) => [
                    'slug' => $p->slug,
                    'category' => $p->category,
                    'label' => $p->code ? "{$p->code} · {$p->name}" : $p->name,
                    'price' => $p->price,
                ]),
        ]);
    }
}
