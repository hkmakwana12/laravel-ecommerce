<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'start_date',
        'end_date',
        'total_quantity',
        'use_per_user',
        'used_quantity',
        'max_discount_value',
        'min_cart_value',
        'max_cart_value',
        'is_for_new_user',
    ];


    protected $perPage = 10;

    protected $casts = [
        'start_date'   => 'date:Y-m-d',
        'end_date'     => 'date:Y-m-d',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function scopeSearch($query, $term)
    {
        if (! $term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('code', 'like', "%{$term}%")
                ->orWhere('type', 'like', "%{$term}%")
                ->orWhere('value', 'like', "%{$term}%")
                ->orWhere('total_quantity', 'like', "%{$term}%")
                ->orWhere('start_date', 'like', "%{$term}%")
                ->orWhere('end_date', 'like', "%{$term}%");
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        $now = now();

        return $query
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            });
    }
}
