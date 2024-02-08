<?php

namespace App\Filament\Loggers;

use App\Filament\Resources\InsuranceResource;
use App\Models\Insurance;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class InsuranceLogger extends Logger
{
    public static ?string $model = Insurance::class;

    public static function getLabel(): string|Htmlable|null
    {
        return InsuranceResource::getModelLabel();
    }

    public static function resource(ResourceLogger $resourceLogger): ResourceLogger
    {
        return $resourceLogger
            ->fields([
                Field::make('policy_number')
                    ->label('Número de póliza'),
                Field::make('type')
                    ->label('Tipo de póliza'),
                Field::make('company')
                    ->label('Compañía aseguradora'),
                Field::make('start_at')
                    ->date()
                    ->label('Fecha de inicio'),
                Field::make('expired_at')
                    ->date()
                    ->label('Fecha de vencimiento'),
                Field::make('property.id')
                    ->label('ID BRP'),
            ]);
    }
}
