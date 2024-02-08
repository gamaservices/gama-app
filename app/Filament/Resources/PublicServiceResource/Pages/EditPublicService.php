<?php

namespace App\Filament\Resources\PublicServiceResource\Pages;

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PublicServiceResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Noxo\FilamentActivityLog\Extensions\LogEditRecord;

class EditPublicService extends EditRecord
{
    use HasParentResource;
    use LogEditRecord;

    protected static string $parentResource = PropertyResource::class;

    protected static string $resource = PublicServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getParentResource()::getUrl('public_services.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl($this->getParentResource()::getUrl('public_services.index', [
                'parent' => $this->parent,
            ]));
    }
}
