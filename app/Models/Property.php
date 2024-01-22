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

    protected $casts = [
        'disable_at'    => 'date',
        'acquired_at'   => 'date',
        'is_horizontal' => 'boolean',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function notaryOffice(): BelongsTo
    {
        return $this->belongsTo(NotaryOffice::class);
    }

    public function Insurances(): HasMany
    {
        return $this->hasMany(Insurance::class);
    }

    public function PublicServices(): HasMany
    {
        return $this->hasMany(PublicService::class);
    }
}
