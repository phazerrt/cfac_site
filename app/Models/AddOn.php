<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $price_arabian
 * @property int|null $price_block
 * @property int $sort_order
 */
class AddOn extends Model
{
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = ['name'];

    protected $guarded = ['id'];

    /**
     * Prices go out in ringgit (2.5, 6, 150).
     *
     * @return array<string, mixed>
     */
    public function toRow(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'arabian' => $this->price_arabian / 100,
            'block' => $this->price_block !== null ? $this->price_block / 100 : null,
        ];
    }
}
