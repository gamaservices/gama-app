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
        'notary_office_id',
        'address_id',
        'contract',
        'matricula_inmobiliaria',
        'codigo_catastral',
        'escritura',
        'type',
        'is_horizontal',
        'area',
        'conservation_state',
        'bank_ownership_percentage',
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
     * @return BelongsTo<Address, Property>
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
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

    /**
     * @return BelongsTo<Bank, Property>
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
