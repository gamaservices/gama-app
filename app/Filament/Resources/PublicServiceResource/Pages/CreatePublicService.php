<?php

namespace App\Filament\Resources\PublicServiceResource\Pages;

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PublicServiceResource;
use App\Filament\Traits\HasParentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePublicService extends CreateRecord
{
    use HasParentResource;

    protected static string $parentResource = PropertyResource::class;

    protected static string $resource = PublicServiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getParentResource()::getUrl('public_services.index', [
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
