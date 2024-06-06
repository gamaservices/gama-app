<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_address',
        'neighborhood',
        'city_id',
        'building_name',
        'apartment',
        'observations',
    ];

    /**
     * @return BelongsTo<City, Address>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
