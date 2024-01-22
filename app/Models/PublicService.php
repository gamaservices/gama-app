<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicService extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'type',
        'company',
        'is_domiciled',
    ];

    protected $casts = [
        'is_domiciled' => 'boolean',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
