<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'policy_number',
        'type',
        'company',
        'start_at',
        'expired_at',
    ];

    public function casts(): array
    {
        return [
            'start_at'   => 'date',
            'expired_at' => 'date',
        ];
    }

    /**
     * @return BelongsTo<Property, Insurance>
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
