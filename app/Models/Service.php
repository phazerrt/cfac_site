<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * Event types we plan for ("event") and other services ("extra":
 * backdrop printing, photobooth, mini pelamin).
 *
 * @property int $id
 * @property string $slug
 * @property string $kind
 * @property string $icon
 * @property string|null $image
 * @property list<string>|null $gallery
 * @property string $title
 * @property string $summary
 * @property bool $is_active
 * @property int $sort_order
 */
class Service extends Model
{
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = ['title', 'summary'];

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /** @param Builder<Service> $query */
    public function scopeVisible(Builder $query, string $kind): void
    {
        $query->where('kind', $kind)->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * @return array<string, mixed>
     */
    public function toCard(): array
    {
        return [
            'slug' => $this->slug,
            'icon' => $this->icon,
            'image' => $this->image ? asset($this->image) : null,
            'gallery' => array_map(fn (string $path) => asset($path), $this->gallery ?? []),
            'title' => $this->title,
            'summary' => $this->summary,
        ];
    }
}
