<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotaryOfficeResource\Pages\CreateNotaryOffice;
use App\Filament\Resources\NotaryOfficeResource\Pages\EditNotaryOffice;
use App\Filament\Resources\NotaryOfficeResource\Pages\ListNotaryOffices;
use App\Models\NotaryOffice;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NotaryOfficeResource extends Resource
{
    protected static ?string $model = NotaryOffice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('state_id')
                    ->relationship('state', 'name')
                    ->required(),
                Select::make('city_id')
                    ->relationship('city', 'name')
                    ->required(),
                TextInput::make('number')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('state.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('city.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNotaryOffices::route('/'),
            'create' => CreateNotaryOffice::route('/create'),
            'edit' => EditNotaryOffice::route('/{record}/edit'),
        ];
    }
}
