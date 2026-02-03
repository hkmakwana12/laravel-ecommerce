<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    protected $fillable = ['attribute_id', 'value'];

    public function scopeSearch($query, $term)
    {
        if (! $term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('value', 'like', "%{$term}%");
        });
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
