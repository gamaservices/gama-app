<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'first_email',
        'second_email',
        'first_phone',
        'second_phone',
    ];

    /**
     * @return HasMany<Property>
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
