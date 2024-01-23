<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * @return HasMany<City>
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * @return HasMany<Property>
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
