<?php

namespace App\Filament\Resources\InsuranceResource\Pages;

use App\Filament\Resources\InsuranceResource;
use App\Filament\Resources\PropertyResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInsurance extends EditRecord
{
    use HasParentResource;

    protected static string $parentResource = PropertyResource::class;

    protected static string $resource = InsuranceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getParentResource()::getUrl('insurances.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl($this->getParentResource()::getUrl('insurances.index', [
                'parent' => $this->parent,
            ]));
    }
}
