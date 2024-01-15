<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicServiceResource\Pages\CreatePublicService;
use App\Filament\Resources\PublicServiceResource\Pages\EditPublicService;
use App\Filament\Resources\PublicServiceResource\Pages\ListPublicServices;
use App\Models\PublicService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PublicServiceResource extends Resource
{
    protected static ?string $model = PublicService::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('property_id')
                    ->relationship('property', 'id')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                TextInput::make('company')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_domiciled')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('property.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('company')
                    ->searchable(),
                IconColumn::make('is_domiciled')
                    ->boolean(),
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
            'index' => ListPublicServices::route('/'),
            'create' => CreatePublicService::route('/create'),
            'edit' => EditPublicService::route('/{record}/edit'),
        ];
    }
}
