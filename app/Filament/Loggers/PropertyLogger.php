<?php

namespace App\Filament\Loggers;

use App\Filament\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class PropertyLogger extends Logger
{
    public static ?string $model = Property::class;

    public static function getLabel(): string|Htmlable|null
    {
        return PropertyResource::getModelLabel();
    }

    public static function resource(ResourceLogger $resourceLogger): ResourceLogger
    {
        return $resourceLogger
            ->fields([
                Field::make('contract')
                    ->label('ID BRP'),
                Field::make('matricula_inmobiliaria')
                    ->label('Matrícula Inmobiliaria'),
                Field::make('codigo_catastral')
                    ->label('Código Catastral'),
                Field::make('escritura')
                    ->label('No. de escritura'),
                Field::make('notary_office_id')
                    ->label('Notaría'),
                Field::make('customer')
                    ->label('Cliente'),
                Field::make('type')
                    ->label('Tipo de predio'),
                Field::make('is_horizontal')
                    ->boolean()
                    ->label('Es horizontal'),
                Field::make('area')
                    ->label('Área'),
                Field::make('conservation_state')
                    ->label('Estado de conservación'),
                Field::make('owner')
                    ->label('Propietario'),
                Field::make('ownership_percentage')
                    ->label('Porcentaje de derechos'),
                Field::make('disabled_at')
                    ->date()
                    ->label('Fecha de deshabilitación'),
                Field::make('acquired_at')
                    ->date()
                    ->label('Fecha de apertura'),
            ]);
    }
}
