<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Resources\Pages\CreateRecord;
use Noxo\FilamentActivityLog\Extensions\LogCreateRecord;

class CreateProperty extends CreateRecord
{
    use LogCreateRecord;

    protected static string $resource = PropertyResource::class;
}
