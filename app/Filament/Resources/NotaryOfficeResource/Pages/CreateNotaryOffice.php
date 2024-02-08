<?php

namespace App\Filament\Resources\NotaryOfficeResource\Pages;

use App\Filament\Resources\NotaryOfficeResource;
use Filament\Resources\Pages\CreateRecord;
use Noxo\FilamentActivityLog\Extensions\LogCreateRecord;

class CreateNotaryOffice extends CreateRecord
{
    use LogCreateRecord;

    protected static string $resource = NotaryOfficeResource::class;
}
