<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages\CreateProperty;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Models\Property;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
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
                Select::make('state_id')
                    ->relationship('state', 'name')
                    ->required(),
                Select::make('city_id')
                    ->relationship('city', 'name')
                    ->required(),
                Select::make('notary_office_id')
                    ->relationship('notaryOffice', 'id')
                    ->required(),
                TextInput::make('customer')
                    ->required()
                    ->maxLength(255)
                    ->default('Banco de Bogotá'),
                TextInput::make('contract')
                    ->required()
                    ->maxLength(255),
                TextInput::make('matricula_inmobiliaria')
                    ->required()
                    ->maxLength(255),
                TextInput::make('codigo_catastral')
                    ->required()
                    ->maxLength(255),
                TextInput::make('escritura')
                    ->required()
                    ->maxLength(255),
                TextInput::make('neighborhood')
                    ->maxLength(255),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_horizontal')
                    ->required(),
                TextInput::make('area')
                    ->required()
                    ->numeric(),
                TextInput::make('conservation_state')
                    ->required()
                    ->maxLength(255),
                TextInput::make('owner')
                    ->required()
                    ->maxLength(255),
                TextInput::make('ownership_percentage')
                    ->numeric()
                    ->required()
                    ->minValue(0.1)
                    ->maxValue(100),
                DatePicker::make('disable_at'),
                DatePicker::make('acquired_at')
                    ->required(),
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
                TextColumn::make('notaryOffice.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('customer')
                    ->searchable(),
                TextColumn::make('contract')
                    ->searchable(),
                TextColumn::make('matricula_inmobiliaria')
                    ->searchable(),
                TextColumn::make('codigo_catastral')
                    ->searchable(),
                TextColumn::make('escritura')
                    ->searchable(),
                TextColumn::make('neighborhood')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                IconColumn::make('is_horizontal')
                    ->boolean(),
                TextColumn::make('area')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('conservation_state')
                    ->searchable(),
                TextColumn::make('owner')
                    ->searchable(),
                IconColumn::make('ownership_percentage')
                    ->boolean(),
                TextColumn::make('disable_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('acquired_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProperties::route('/'),
            'create' => CreateProperty::route('/create'),
            'edit' => EditProperty::route('/{record}/edit'),
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
