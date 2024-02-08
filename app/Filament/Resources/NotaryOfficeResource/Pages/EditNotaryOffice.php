<?php

namespace App\Filament\Resources\NotaryOfficeResource\Pages;

use App\Filament\Resources\NotaryOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Noxo\FilamentActivityLog\Extensions\LogEditRecord;

class EditNotaryOffice extends EditRecord
{
    use LogEditRecord;

    protected static string $resource = NotaryOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
