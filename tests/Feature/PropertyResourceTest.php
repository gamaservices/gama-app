<?php

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PropertyResource\Pages\CreateProperty;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Models\Property;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(PropertyResource::getUrl())->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render list page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(PropertyResource::getUrl())
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can list properties', function () {
    $properties = Property::factory()->count(10)->create();

    livewire(ListProperties::class)
        ->assertCanSeeTableRecords($properties)
        ->assertCountTableRecords(10)
        ->assertCanRenderTableColumn('state.name')
        ->assertCanRenderTableColumn('city.name')
        ->assertCanRenderTableColumn('notaryOffice.id')
        ->assertCanRenderTableColumn('customer')
        ->assertCanRenderTableColumn('contract')
        ->assertCanRenderTableColumn('matricula_inmobiliaria')
        ->assertCanRenderTableColumn('codigo_catastral')
        ->assertCanRenderTableColumn('escritura')
        ->assertCanRenderTableColumn('neighborhood')
        ->assertCanRenderTableColumn('address')
        ->assertCanRenderTableColumn('type')
        ->assertCanRenderTableColumn('is_horizontal')
        ->assertCanRenderTableColumn('area')
        ->assertCanRenderTableColumn('conservation_state')
        ->assertCanRenderTableColumn('owner')
        ->assertCanRenderTableColumn('ownership_percentage')
        ->assertCanRenderTableColumn('disabled_at')
        ->assertCanRenderTableColumn('acquired_at')
        ->assertCanNotRenderTableColumn('created_at')
        ->assertCanNotRenderTableColumn('updated_at');

    $this->assertAuthenticated();
});

it('can render create page', function () {
    $this->get(PropertyResource::getUrl('create'))
        ->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render create page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(PropertyResource::getUrl('create'))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can create a property', function () {
    $newData = Property::factory()
        ->for($this->state)
        ->for($this->city)
        ->make();

    livewire(CreateProperty::class)
        ->assertFormExists()
        ->assertFormFieldExists('state_id')
        ->assertFormFieldExists('city_id')
        ->assertFormFieldExists('notary_office_id')
        ->assertFormFieldExists('customer')
        ->assertFormFieldExists('contract')
        ->assertFormFieldExists('matricula_inmobiliaria')
        ->assertFormFieldExists('codigo_catastral')
        ->assertFormFieldExists('escritura')
        ->assertFormFieldExists('neighborhood')
        ->assertFormFieldExists('address')
        ->assertFormFieldExists('type')
        ->assertFormFieldExists('is_horizontal')
        ->assertFormFieldExists('area')
        ->assertFormFieldExists('conservation_state')
        ->assertFormFieldExists('owner')
        ->assertFormFieldExists('ownership_percentage')
        ->assertFormFieldExists('disabled_at')
        ->assertFormFieldExists('acquired_at')
        ->fillForm([
            'state_id'               => $newData->state_id,
            'city_id'                => $newData->city_id,
            'notary_office_id'       => $newData->notaryOffice_id,
            'customer'               => $newData->customer,
            'contract'               => $newData->contract,
            'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
            'codigo_catastral'       => $newData->codigo_catastral,
            'escritura'              => $newData->escritura,
            'neighborhood'           => $newData->neighborhood,
            'address'                => $newData->address,
            'type'                   => $newData->type,
            'is_horizontal'          => $newData->is_horizontal,
            'area'                   => $newData->area,
            'conservation_state'     => $newData->conservation_state,
            'owner'                  => $newData->owner,
            'ownership_percentage'   => $newData->ownership_percentage,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Property::class, [
        'state_id'               => $newData->state_id,
        'city_id'                => $newData->city_id,
        'notary_office_id'       => $newData->notaryOffice_id,
        'customer'               => $newData->customer,
        'contract'               => $newData->contract,
        'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
        'codigo_catastral'       => $newData->codigo_catastral,
        'escritura'              => $newData->escritura,
        'neighborhood'           => $newData->neighborhood,
        'address'                => $newData->address,
        'type'                   => $newData->type,
        'is_horizontal'          => $newData->is_horizontal,
        'area'                   => $newData->area,
        'conservation_state'     => $newData->conservation_state,
        'owner'                  => $newData->owner,
        'ownership_percentage'   => $newData->ownership_percentage,
    ]);

    $this->assertAuthenticated();
});

it('can validate create input', function () {
    livewire(CreateProperty::class)
        ->fillForm([
            'matricula_inmobiliaria' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'matricula_inmobiliaria' => 'required',
        ])
        ->fillForm([
            'contract'               => str_repeat('a', 256),
            'matricula_inmobiliaria' => str_repeat('a', 256),
            'codigo_catastral'       => str_repeat('a', 256),
            'escritura'              => str_repeat('a', 256),
            'neighborhood'           => str_repeat('a', 256),
            'address'                => str_repeat('a', 256),
            'conservation_state'     => str_repeat('a', 256),
            'owner'                  => str_repeat('a', 256),
        ])
        ->call('create')
        ->assertHasFormErrors([
            'contract'               => 'max:255',
            'matricula_inmobiliaria' => 'max:255',
            'codigo_catastral'       => 'max:255',
            'escritura'              => 'max:255',
            'neighborhood'           => 'max:255',
            'address'                => 'max:255',
            'conservation_state'     => 'max:255',
            'owner'                  => 'max:255',
        ]);

    $this->assertAuthenticated();
});

it('can render edit page', function () {
    $this->get(PropertyResource::getUrl('edit', [
        'record' => Property::factory()->create(),
    ]))->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render edit page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(PropertyResource::getUrl('edit', [
            'record' => Property::factory()->create(),
        ]))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can retrieve data', function () {
    $property = Property::factory()->create();

    livewire(EditProperty::class, [
        'record' => $property->getRouteKey(),
    ])
        ->assertFormSet([
            'state_id'               => $property->state_id,
            'city_id'                => $property->city_id,
            'notary_office_id'       => $property->notary_office_id,
            'customer'               => $property->customer,
            'contract'               => $property->contract,
            'matricula_inmobiliaria' => $property->matricula_inmobiliaria,
            'codigo_catastral'       => $property->codigo_catastral,
            'escritura'              => $property->escritura,
            'neighborhood'           => $property->neighborhood,
            'address'                => $property->address,
            'type'                   => $property->type,
            'is_horizontal'          => $property->is_horizontal,
            'area'                   => $property->area,
            'conservation_state'     => $property->conservation_state,
            'owner'                  => $property->owner,
            'ownership_percentage'   => $property->ownership_percentage,
            'disabled_at'            => $property->disabled_at,
            'acquired_at'            => $property->acquired_at->format('Y-m-d'),
        ]);

    $this->assertAuthenticated();
});

it('can save a property', function () {
    $property = Property::factory()->create();

    $newData = Property::factory()->make();

    livewire(EditProperty::class, [
        'record' => $property->getRouteKey(),
    ])
        ->assertFormExists()
        ->assertFormFieldExists('state_id')
        ->assertFormFieldExists('city_id')
        ->assertFormFieldExists('notary_office_id')
        ->assertFormFieldExists('customer')
        ->assertFormFieldExists('contract')
        ->assertFormFieldExists('matricula_inmobiliaria')
        ->assertFormFieldExists('codigo_catastral')
        ->assertFormFieldExists('escritura')
        ->assertFormFieldExists('neighborhood')
        ->assertFormFieldExists('address')
        ->assertFormFieldExists('type')
        ->assertFormFieldExists('is_horizontal')
        ->assertFormFieldExists('area')
        ->assertFormFieldExists('conservation_state')
        ->assertFormFieldExists('owner')
        ->assertFormFieldExists('ownership_percentage')
        ->assertFormFieldExists('disabled_at')
        ->assertFormFieldExists('acquired_at')
        ->fillForm([
            'state_id'               => $newData->state_id,
            'city_id'                => $newData->city_id,
            'notary_office_id'       => $newData->notaryOffice_id,
            'customer'               => $newData->customer,
            'contract'               => $newData->contract,
            'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
            'codigo_catastral'       => $newData->codigo_catastral,
            'escritura'              => $newData->escritura,
            'neighborhood'           => $newData->neighborhood,
            'address'                => $newData->address,
            'type'                   => $newData->type,
            'is_horizontal'          => $newData->is_horizontal,
            'area'                   => $newData->area,
            'conservation_state'     => $newData->conservation_state,
            'owner'                  => $newData->owner,
            'ownership_percentage'   => $newData->ownership_percentage,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($property->refresh())
        ->state_id->toBe($newData->state_id)
        ->city_id->toBe($newData->city_id)
        ->notary_office_id->toBe($newData->notaryOffice_id)
        ->customer->toBe($newData->customer)
        ->contract->toBe($newData->contract)
        ->matricula_inmobiliaria->toBe($newData->matricula_inmobiliaria)
        ->codigo_catastral->toBe($newData->codigo_catastral)
        ->escritura->toBe($newData->escritura)
        ->neighborhood->toBe($newData->neighborhood)
        ->address->toBe($newData->address)
        ->type->toBe($newData->type)
        ->is_horizontal->toBe($newData->is_horizontal)
        ->area->toBe($newData->area)
        ->conservation_state->toBe($newData->conservation_state)
        ->owner->toBe($newData->owner)
        ->ownership_percentage->toBe($newData->ownership_percentage);

    $this->assertAuthenticated();
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
        ->assertHasFormErrors([
            'matricula_inmobiliaria' => 'required',
        ])
        ->fillForm([
            'contract'               => str_repeat('a', 256),
            'matricula_inmobiliaria' => str_repeat('a', 256),
            'codigo_catastral'       => str_repeat('a', 256),
            'escritura'              => str_repeat('a', 256),
            'neighborhood'           => str_repeat('a', 256),
            'address'                => str_repeat('a', 256),
            'conservation_state'     => str_repeat('a', 256),
            'owner'                  => str_repeat('a', 256),
        ])
        ->call('save')
        ->assertHasFormErrors([
            'contract'               => 'max:255',
            'matricula_inmobiliaria' => 'max:255',
            'codigo_catastral'       => 'max:255',
            'escritura'              => 'max:255',
            'neighborhood'           => 'max:255',
            'address'                => 'max:255',
            'conservation_state'     => 'max:255',
            'owner'                  => 'max:255',
        ]);

    $this->assertAuthenticated();
});

it('can delete a property', function () {
    $property = Property::factory()->create();

    livewire(EditProperty::class, [
        'record' => $property->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    expect($property->refresh())
        ->deleted_at->format('Y-m-d')->toBe(today()->format('Y-m-d'));

    $this->assertAuthenticated();
});
