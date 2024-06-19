<?php

namespace App\Enums;

use App\Traits\Arrayable;

enum AccountType: string
{
    use Arrayable;

    case SAVINGS = 'savings';
    case CURRENT = 'current';

    public function getLabel(): string
    {
        return match ($this) {
            self::SAVINGS => 'Ahorros',
            self::CURRENT => 'Corriente',
        };
    }
}
