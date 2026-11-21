<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $slug
 * @property string $category
 * @property string|null $finish
 * @property string $tier
 * @property string|null $code
 * @property string $name
 * @property string|null $size
 * @property string $features
 * @property int|null $price
 * @property string|null $note
 * @property string|null $image
 * @property list<string>|null $gallery
 * @property bool $is_featured
 * @property int $sort_order
 */
class Package extends Model
{
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = ['name', 'features', 'note'];

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    /** @param Builder<Package> $query */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order');
    }

    /** @param Builder<Package> $query */
    public function scopeTents(Builder $query): void
    {
        $query->whereIn('category', ['arabian', 'block']);
    }

    /**
     * @return array<string, mixed>
     */
    public function toCard(): array
    {
        return [
            'slug' => $this->slug,
            'category' => $this->category,
            'finish' => $this->finish,
            'tier' => $this->tier,
            'code' => $this->code,
            'name' => $this->name,
            'size' => $this->size,
            'features' => array_values(array_filter(array_map('trim', explode("\n", $this->features)))),
            'price' => $this->price,
            'note' => $this->note ?: null,
            'image' => $this->image ? asset($this->image) : null,
            'gallery' => array_map(fn (string $path) => asset($path), $this->gallery ?? []),
            'featured' => $this->is_featured,
        ];
    }
}
