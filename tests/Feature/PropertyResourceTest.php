<?php

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PropertyResource\Pages\CreateProperty;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Models\Property;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(PropertyResource::getUrl())->assertSuccessful();
});

it('can list properties', function () {
    $properties = Property::factory()->count(10)->create();

    livewire(ListProperties::class)
        ->assertCanSeeTableRecords($properties);
});

it('can render create page', function () {
    $this->get(PropertyResource::getUrl('create'))->assertSuccessful();
});

it('can create a property', function () {
    $newData = Property::factory()->make();

    livewire(CreateProperty::class)
        ->fillForm([
            'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Property::class, [
        'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
    ]);
});

it('can validate create input', function () {
    livewire(CreateProperty::class)
        ->fillForm([
            'matricula_inmobiliaria' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['matricula_inmobiliaria' => 'required']);
});

it('can render edit page', function () {
    $this->get(PropertyResource::getUrl('edit', [
        'record' => Property::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $property = Property::factory()->create();

    livewire(EditProperty::class, [
        'record' => $property->getRouteKey(),
    ])
        ->assertFormSet([
            'matricula_inmobiliaria' => $property->matricula_inmobiliaria,
        ]);
});

it('can save a property', function () {
    $property = Property::factory()->create();

    $newData = Property::factory()->make();

    livewire(EditProperty::class, [
        'record' => $property->getRouteKey(),
    ])
        ->fillForm([
            'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($property->refresh())
        ->matricula_inmobiliaria->toBe($newData->matricula_inmobiliaria);
});

it('can validate edit input', function () {
    $property = Property::factory()->create();

    livewire(EditProperty::class, [
        'record' => $property->getRouteKey(),
    ])
        ->fillForm([
            'matricula_inmobiliaria' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['matricula_inmobiliaria' => 'required']);
});

it('can delete a property', function () {
    $property = Property::factory()->create();

    livewire(EditProperty::class, [
        'record' => $property->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    expect($property->refresh())
        ->deleted_at->toBeInstanceOf(Carbon::class);
});
