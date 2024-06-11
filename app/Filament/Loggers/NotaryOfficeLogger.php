<?php

namespace App\Filament\Loggers;

use App\Filament\Resources\NotaryOfficeResource;
use App\Models\NotaryOffice;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class NotaryOfficeLogger extends Logger
{
    public static ?string $model = NotaryOffice::class;

    public static function getLabel(): string|Htmlable|null
    {
        return NotaryOfficeResource::getModelLabel();
    }

    public static function resource(ResourceLogger $resourceLogger): ResourceLogger
    {
        return $resourceLogger
            ->fields([
                Field::make('number')
                    ->label('Número de Notaría'),
                Field::make('city.name')
                    ->hasOne('city')
                    ->label('Ciudad'),
            ]);
    }
}
