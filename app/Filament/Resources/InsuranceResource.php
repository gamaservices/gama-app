<?php

namespace App\Filament\Resources;

use App\Models\Insurance;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InsuranceResource extends Resource
{
    protected static ?string $model = Insurance::class;

    protected static ?string $modelLabel = 'Seguro';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'policy_number';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('policy_number')
                    ->required()
                    ->maxLength(255)
                    ->label('Número de póliza'),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255)
                    ->label('Tipo de póliza'),
                TextInput::make('company')
                    ->required()
                    ->maxLength(255)
                    ->label('Compañía aseguradora'),
                DatePicker::make('start_at')
                    ->required()
                    ->label('Fecha de inicio'),
                DatePicker::make('expired_at')
                    ->required()
                    ->label('Fecha de vencimiento'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('property.id')
                    ->numeric()
                    ->sortable()
                    ->label('ID BRP'),
                TextColumn::make('policy_number')
                    ->searchable()
                    ->label('Número de póliza'),
                TextColumn::make('type')
                    ->searchable()
                    ->label('Tipo de póliza'),
                TextColumn::make('company')
                    ->searchable()
                    ->label('Compañía aseguradora'),
                TextColumn::make('start_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de inicio'),
                TextColumn::make('expired_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de vencimiento'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Creado en'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Actualizado en'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
