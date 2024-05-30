<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'state_id',
        'city_id',
        'notary_office_id',
        'customer',
        'contract',
        'matricula_inmobiliaria',
        'codigo_catastral',
        'escritura',
        'neighborhood',
        'address',
        'type',
        'is_horizontal',
        'area',
        'conservation_state',
        'owner',
        'ownership_percentage',
    ];

    protected function casts(): array
    {
        return [
            'disable_at'    => 'date',
            'acquired_at'   => 'date',
            'is_horizontal' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<State, Property>
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return BelongsTo<City, Property>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo<NotaryOffice, Property>
     */
    public function notaryOffice(): BelongsTo
    {
        return $this->belongsTo(NotaryOffice::class);
    }

    /**
     * @return HasMany<Insurance>
     */
    public function Insurances(): HasMany
    {
        return $this->hasMany(Insurance::class);
    }

    /**
     * @return HasMany<PublicService>
     */
    public function PublicServices(): HasMany
    {
        return $this->hasMany(PublicService::class);
    }
}
