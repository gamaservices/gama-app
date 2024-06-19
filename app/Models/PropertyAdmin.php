<?php

namespace App\Models;

use App\Enums\AccountType;
use App\Enums\PropertyAdminType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_id',
        'name',
        'document',
        'account_number',
        'account_entity',
        'account_type',
        'type',
        'email1',
        'email2',
        'phone1',
        'phone2',
    ];

    protected $casts = [
        'account_type' => AccountType::class,
        'type'         => PropertyAdminType::class,
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
