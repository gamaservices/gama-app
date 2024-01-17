<?php

namespace App\Filament\Resources;

use App\Models\PublicService;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PublicServiceResource extends Resource
{
    protected static ?string $model = PublicService::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'property_id';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Servicios públicos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type')
                    ->required()
                    ->maxLength(255)
                    ->label('Tipo'),
                TextInput::make('company')
                    ->required()
                    ->maxLength(255)
                    ->label('Compañía'),
                Toggle::make('is_domiciled')
                    ->required()
                    ->label('Es domiciliado'),
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
                TextColumn::make('type')
                    ->searchable()
                    ->label('Tipo de servicio'),
                TextColumn::make('company')
                    ->searchable()
                    ->label('Compañía'),
                IconColumn::make('is_domiciled')
                    ->boolean()
                    ->label('Es domiciliado'),
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
