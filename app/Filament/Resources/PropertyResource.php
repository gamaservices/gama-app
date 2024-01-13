<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('state_id')
                    ->relationship('state', 'name')
                    ->required(),
                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->required(),
                Forms\Components\Select::make('notary_office_id')
                    ->relationship('notaryOffice', 'id')
                    ->required(),
                Forms\Components\TextInput::make('customer')
                    ->required()
                    ->maxLength(255)
                    ->default('Banco de Bogotá'),
                Forms\Components\TextInput::make('contract')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('matricula_inmobiliaria')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('codigo_catastral')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('escritura')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('neighborhood')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_horizontal')
                    ->required(),
                Forms\Components\TextInput::make('area')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('conservation_state')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('owner')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('ownership_percentage')
                    ->required(),
                Forms\Components\DateTimePicker::make('disable_at'),
                Forms\Components\DateTimePicker::make('acquired_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('state.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notaryOffice.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contract')
                    ->searchable(),
                Tables\Columns\TextColumn::make('matricula_inmobiliaria')
                    ->searchable(),
                Tables\Columns\TextColumn::make('codigo_catastral')
                    ->searchable(),
                Tables\Columns\TextColumn::make('escritura')
                    ->searchable(),
                Tables\Columns\TextColumn::make('neighborhood')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_horizontal')
                    ->boolean(),
                Tables\Columns\TextColumn::make('area')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conservation_state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner')
                    ->searchable(),
                Tables\Columns\IconColumn::make('ownership_percentage')
                    ->boolean(),
                Tables\Columns\TextColumn::make('disable_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('acquired_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
