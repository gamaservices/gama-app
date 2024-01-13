<?php

namespace App\Filament\Resources\PublicServiceResource\Pages;

use App\Filament\Resources\PublicServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublicService extends EditRecord
{
    protected static string $resource = PublicServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}