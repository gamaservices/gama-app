<?php

namespace App\Filament\Resources\InsuranceResource\Pages;

use App\Filament\Resources\InsuranceResource;
use App\Filament\Resources\PropertyResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ListInsurances extends ListRecords
{
    use HasParentResource;

    protected static string $parentResource = PropertyResource::class;

    protected static string $resource = InsuranceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->url(fn (): string => $this->getParentResource()::getUrl('insurances.create', [
                    'parent' => $this->parent,
                ])),
        ];
    }

    public function table(Table $table): Table
    {
        return parent::table($table)->pushActions([
            EditAction::make()
                ->url(fn (Model $record): string => PropertyResource::getUrl('insurances.edit', [
                    'record' => $record,
                    'parent' => $this->parent,
                ])),
            DeleteAction::make(),
        ]);
    }
}
