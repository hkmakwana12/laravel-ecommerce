<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CartItem extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $fillable = ['cart_id', 'product_id', 'variant_id', 'quantity'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function getPriceAttribute(): float
    {
        return $this->variant?->selling_price ?? 0;
    }

    public function getTotalAttribute(): float
    {
        return ($this->price * $this->quantity);
    }

    public function taxes(): MorphMany
    {
        return $this->morphMany(Taxable::class, 'taxable');
    }
}
