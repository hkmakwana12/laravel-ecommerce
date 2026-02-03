<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'long_description',
        'regular_price',
        'selling_price',
        'sku',
        'barcode',
        'is_active',
        'is_featured',
        'category_id',
        'brand_id',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'regular_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    /* public function getRouteKeyName(): string
    {
        return 'slug';
    } */

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function thumbnailURL($size = ''): string|null
    {
        return $this?->getMedia('featured-image')->first()?->getUrl($size) ?? placeholderURL();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function defaultVariant()
    {
        return $this->hasOne(ProductVariant::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeRelatedProducts($query, $limit = 8)
    {
        return
            $query->where('id', '!=', $this->id)
            ->where(function ($query) {
                return $query->where('category_id', $this->category_id)
                    ->orWhere('brand_id', $this->brand_id);
            })
            ->with('media')
            ->active()
            ->take($limit)
            ->get();
    }


    public function scopeSearch($query, $term)
    {
        if (! $term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('slug', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%")
                ->orWhere('barcode', 'like', "%{$term}%")
                ->orWhere('regular_price', 'like', "%{$term}%")
                ->orWhere('selling_price', 'like', "%{$term}%");
        });
    }
}
