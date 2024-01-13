<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer',
        'contract',
        'matricula_inmobiliaria',
        'codigo_catastral',
        'escritura',
        'neighborhood',
        'address',
        'type',
        'horizontal',
        'area',
        'conservation_state',
        'owner',
        'ownership_percentage',
    ];

    protected $casts = [
        'disable_at' => 'datetime',
        'acquired_at' => 'datetime',
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
