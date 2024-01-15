<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsuranceResource\Pages\CreateInsurance;
use App\Filament\Resources\InsuranceResource\Pages\EditInsurance;
use App\Filament\Resources\InsuranceResource\Pages\ListInsurances;
use App\Models\Insurance;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InsuranceResource extends Resource
{
    protected static ?string $model = Insurance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('property_id')
                    ->relationship('property', 'id')
                    ->required(),
                TextInput::make('policy_number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                TextInput::make('company')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('start_at')
                    ->required(),
                DatePicker::make('expired_at')
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
                TextColumn::make('policy_number')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('company')
                    ->searchable(),
                TextColumn::make('start_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('expired_at')
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
            'index' => ListInsurances::route('/'),
            'create' => CreateInsurance::route('/create'),
            'edit' => EditInsurance::route('/{record}/edit'),
        ];
    }
}
