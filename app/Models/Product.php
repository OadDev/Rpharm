<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'pack_size', 'composition', 'image_path',
        'description', 'gradient_start', 'gradient_end', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * The product's primary category, used where a single category is needed
     * (e.g. the homepage "Our Top Products" tag).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Every therapeutic area this product belongs to. Kept in sync with
     * `category_id`, whose value always matches the first selected category.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => MediaUrl::resolve($this->image_path));
    }
}
