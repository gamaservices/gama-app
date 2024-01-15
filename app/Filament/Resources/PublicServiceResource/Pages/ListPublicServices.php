<?php

namespace App\Filament\Resources\PublicServiceResource\Pages;

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PublicServiceResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ListPublicServices extends ListRecords
{
    use HasParentResource;

    protected static string $parentResource = PropertyResource::class;

    protected static string $resource = PublicServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->url(fn (): string => $this->getParentResource()::getUrl('public_services.create', [
                    'parent' => $this->parent,
                ])),
        ];
    }

    public function table(Table $table): Table
    {
        return parent::table($table)->pushActions([
            EditAction::make()
                ->url(fn (Model $record): string => PropertyResource::getUrl('public_services.edit', [
                    'record' => $record,
                    'parent' => $this->parent,
                ])),
            DeleteAction::make(),
        ]);
    }
}
