<?php

namespace App\Filament\Loggers;

use App\Filament\Resources\PublicServiceResource;
use App\Models\PublicService;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\RelationManager;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class PublicServiceLogger extends Logger
{
    public static ?string $model = PublicService::class;

    public static function getLabel(): string|Htmlable|null
    {
        return PublicServiceResource::getModelLabel();
    }

    public static function resource(ResourceLogger $resourceLogger): ResourceLogger
    {
        return $resourceLogger
            ->fields([
                Field::make('type')
                    ->label('Tipo'),
                Field::make('company')
                    ->label('Compañía'),
                Field::make('is_domiciled')
                    ->boolean()
                    ->label('Es domiciliado'),
                Field::make('property_id')
                    ->label('ID BRP'),
            ]);
    }
}
