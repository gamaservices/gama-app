<?php

namespace App\Filament\Loggers;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class UserLogger extends Logger
{
    public static ?string $model = User::class;

    public static function getLabel(): string|Htmlable|null
    {
        return UserResource::getModelLabel();
    }

    public static function resource(ResourceLogger $resourceLogger): ResourceLogger
    {
        return $resourceLogger
            ->fields([
                Field::make('name')
                    ->label('Nombre'),
                Field::make('email')
                    ->label('Correo Electrónico'),
                Field::make('roles.name')
                    ->label('Roles')
                    ->hasMany('roles')
                    ->badge(),
            ]);
    }
}
