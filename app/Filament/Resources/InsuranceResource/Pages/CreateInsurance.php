<?php

namespace App\Filament\Resources\InsuranceResource\Pages;

use App\Filament\Resources\InsuranceResource;
use App\Filament\Resources\PropertyResource;
use App\Filament\Traits\HasParentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInsurance extends CreateRecord
{
    use HasParentResource;

    protected static string $parentResource = PropertyResource::class;

    protected static string $resource = InsuranceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getParentResource()::getUrl('insurances.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($this->parent->id)) {
            $data['property_id'] = $this->parent->id;
        }

        return $data;
    }
}
