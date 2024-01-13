<?php

namespace App\Filament\Resources\NotaryOfficeResource\Pages;

use App\Filament\Resources\NotaryOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotaryOffices extends ListRecords
{
    protected static string $resource = NotaryOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
