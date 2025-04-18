<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $perPage = 10;

    /**
     * @return HasMany<State,Country>
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}
