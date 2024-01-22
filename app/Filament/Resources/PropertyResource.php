<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsuranceResource\Pages\CreateInsurance;
use App\Filament\Resources\InsuranceResource\Pages\EditInsurance;
use App\Filament\Resources\InsuranceResource\Pages\ListInsurances;
use App\Filament\Resources\PropertyResource\Pages\CreateProperty;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Filament\Resources\PublicServiceResource\Pages\CreatePublicService;
use App\Filament\Resources\PublicServiceResource\Pages\EditPublicService;
use App\Filament\Resources\PublicServiceResource\Pages\ListPublicServices;
use App\Models\Property;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Route;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'matricula_inmobiliaria';

    protected static ?string $modelLabel = 'Inmueble';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('contract')
                    ->maxLength(255)
                    ->label('ID BRP'),
                TextInput::make('matricula_inmobiliaria')
                    ->required()
                    ->maxLength(255)
                    ->label('Matrícula Inmobiliaria'),
                TextInput::make('codigo_catastral')
                    ->maxLength(255)
                    ->label('Código Catastral'),
                Select::make('state_id')
                    ->relationship('state', 'name')
                    ->label('Departamento'),
                Select::make('city_id')
                    ->relationship('city', 'name')
                    ->label('Ciudad o municipio'),
                TextInput::make('neighborhood')
                    ->maxLength(255)
                    ->label('Barrio o Vereda'),
                TextInput::make('address')
                    ->maxLength(255)
                    ->label('Dirección'),
                TextInput::make('escritura')
                    ->maxLength(255)
                    ->label('No. de Escritura'),
                Select::make('notary_office_id')
                    ->relationship('notaryOffice', 'id')
                    ->label('Notaría'),
                TextInput::make('customer')
                    ->maxLength(255)
                    ->default('Banco de Bogotá')
                    ->label('Cliente'),
                Radio::make('type')
                    ->options([
                        'rural'  => 'Rural',
                        'urbano' => 'Urbano',
                    ])
                    ->label('Tipo de predio'),
                Toggle::make('is_horizontal')
                    ->inline()
                    ->label('Es Propiedad Horizontal'),
                TextInput::make('area')
                    ->numeric()
                    ->label('Área'),
                TextInput::make('conservation_state')
                    ->maxLength(255)
                    ->label('Estado de conservación'),
                TextInput::make('owner')
                    ->maxLength(255)
                    ->label('Propietario'),
                TextInput::make('ownership_percentage')
                    ->numeric()
                    ->minValue(0.1)
                    ->maxValue(100)
                    ->label('% de derechos'),
                DatePicker::make('disable_at')
                    ->label('Fecha de deshabilitación'),
                DatePicker::make('acquired_at')
                    ->label('Fecha de apertura'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('state.name')
                    ->sortable()
                    ->label('Departamento'),
                TextColumn::make('city.name')
                    ->sortable()
                    ->label('Ciudad o municipio'),
                TextColumn::make('notaryOffice.id')
                    ->numeric()
                    ->sortable()
                    ->label('Notaría'),
                TextColumn::make('customer')
                    ->searchable()
                    ->label('Cliente'),
                TextColumn::make('contract')
                    ->searchable()
                    ->label('ID BRP'),
                TextColumn::make('matricula_inmobiliaria')
                    ->searchable()
                    ->label('Matrícula Inmobiliaria'),
                TextColumn::make('codigo_catastral')
                    ->searchable()
                    ->label('Código Catastral'),
                TextColumn::make('escritura')
                    ->searchable()
                    ->label('No. de Escritura'),
                TextColumn::make('neighborhood')
                    ->searchable()
                    ->label('Barrio o Vereda'),
                TextColumn::make('address')
                    ->searchable()
                    ->label('Dirección'),
                TextColumn::make('type')
                    ->searchable()
                    ->label('Tipo de predio'),
                IconColumn::make('is_horizontal')
                    ->boolean()
                    ->label('Es Propiedad Horizontal'),
                TextColumn::make('area')
                    ->numeric()
                    ->sortable()
                    ->label('Área'),
                TextColumn::make('conservation_state')
                    ->searchable()
                    ->label('Estado de conservación'),
                TextColumn::make('owner')
                    ->searchable()
                    ->label('Propietario'),
                IconColumn::make('ownership_percentage')
                    ->boolean()
                    ->label('% de derechos'),
                TextColumn::make('disable_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de deshabilitación'),
                TextColumn::make('acquired_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de apertura'),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Creado el'),
                TextColumn::make('updated_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Actualizado el'),
                TextColumn::make('deleted_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Eliminado el'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Action::make('Seguros')
                    ->color('success')
                    ->icon('heroicon-m-academic-cap')
                    ->url(fn (Property $record): string => self::getUrl('insurances.index', [
                        'parent' => $record->id,
                    ])),
                Action::make('Servicios Públicos')
                    ->color('success')
                    ->icon('heroicon-m-academic-cap')
                    ->url(fn (Property $record): string => self::getUrl('public_services.index', [
                        'parent' => $record->id,
                    ])),
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

            'index'  => ListProperties::route('/'),
            'create' => CreateProperty::route('/create'),
            'edit'   => EditProperty::route('/{record}/edit'),

            'insurances.index'  => ListInsurances::route('/{parent}/insurances'),
            'insurances.create' => CreateInsurance::route('/{parent}/insurances/create'),
            'insurances.edit'   => EditInsurance::route('/{parent}/insurances/{record}/edit'),

            'public_services.index'  => ListPublicServices::route('/{parent}/public_services'),
            'public_services.create' => CreatePublicService::route('/{parent}/public_services/create'),
            'public_services.edit'   => EditPublicService::route('/{parent}/public_services/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getUrl(string $name = 'index', array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        $parameters['tenant'] ??= ($tenant ?? Filament::getTenant());

        $routeBaseName = static::getRouteBaseName(panel: $panel);
        $routeFullName = "{$routeBaseName}.{$name}";
        $routePath     = Route::getRoutes()->getByName($routeFullName)->uri();

        if (str($routePath)->contains('{parent}')) {
            $parameters['parent'] ??= (request()->route('parent') ?? request()->input('parent'));
        }

        return route($routeFullName, $parameters, $isAbsolute);
    }
}
