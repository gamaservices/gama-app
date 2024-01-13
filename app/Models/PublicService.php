<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicService extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'company',
        'is_domiciled',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
