<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Gallery photos from config/gallery.php, localized for the current request.
 */
class Gallery
{
    /** @var list<string> */
    public const TAGS = ['tents', 'dinners', 'stage', 'events'];

    /**
     * @return Collection<int, array{src: string, w: int, h: int, tag: string, alt: string}>
     */
    public static function items(): Collection
    {
        $locale = app()->getLocale();

        return collect(config('gallery'))->map(fn (array $item) => [
            'src' => asset($item['src']),
            'w' => $item['w'],
            'h' => $item['h'],
            'tag' => $item['tag'],
            'alt' => $item['alt'][$locale] ?? $item['alt']['en'],
        ]);
    }

    /**
     * @return list<string>
     */
    public static function tags(): array
    {
        return self::TAGS;
    }
}
