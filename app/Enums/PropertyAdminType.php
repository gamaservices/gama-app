<?php

namespace App\Enums;

use App\Traits\Arrayable;

enum PropertyAdminType: string
{
    use Arrayable;

    case INDIVIDUAL = 'individual';
    case CORPORATION = 'corporation';

    public function getLabel(): string
    {
        return match ($this) {
            self::INDIVIDUAL  => 'Persona Natural',
            self::CORPORATION => 'Persona Jurídica',
        };
    }
}
