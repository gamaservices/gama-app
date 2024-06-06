<?php

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Models\Property;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

use function Pest\Livewire\livewire;

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
            'notary_office_id'       => $property->notary_office_id,
            'customer'               => $property->customer,
            'contract'               => $property->contract,
            'matricula_inmobiliaria' => $property->matricula_inmobiliaria,
            'codigo_catastral'       => $property->codigo_catastral,
            'escritura'              => $property->escritura,
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

    $newData = Property::factory()
        ->for($this->state)
        ->for($this->city)
        ->for($this->notaryOffice)
        ->make([
            'customer' => 'Davivienda',
            'owner'    => 'Davivienda',
        ]);

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
            'notary_office_id'       => $newData->notary_office_id,
            'customer'               => $newData->customer,
            'contract'               => $newData->contract,
            'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
            'codigo_catastral'       => $newData->codigo_catastral,
            'escritura'              => $newData->escritura,
            'neighborhood'           => $newData->neighborhood,
            'address'                => $newData->address,
            'type'                   => $property->type === 'rural' ? 'urban' : 'rural',
            'is_horizontal'          => ! $property->is_horizontal,
            'area'                   => $newData->area,
            'conservation_state'     => $property->conservation_state === 'good' ? 'bad' : 'good',
            'owner'                  => $newData->owner,
            'ownership_percentage'   => $newData->ownership_percentage,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(Activity::all()->last())
        ->description->toBe('updated')
        ->subject_type->toBe(Property::class)
        ->subject_id->toBe($property->id)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id)
        ->changes->toEqual(collect([
            'old' => [
                'state.name'             => null,
                'city.name'              => null,
                'notary_office_id'       => $property->notary_office_id,
                'customer'               => $property->customer,
                'contract'               => $property->contract,
                'matricula_inmobiliaria' => $property->matricula_inmobiliaria,
                'codigo_catastral'       => $property->codigo_catastral,
                'escritura'              => $property->escritura,
                'neighborhood'           => $property->neighborhood,
                'address'                => $property->address,
                'type'                   => $property->type,
                'is_horizontal'          => $property->is_horizontal ? 'true' : 'false',
                'area'                   => $property->area,
                'conservation_state'     => $property->conservation_state,
                'owner'                  => $property->owner,
                'ownership_percentage'   => $property->ownership_percentage,
            ],
            'attributes' => [
                'state.name'             => $newData->state->name,
                'city.name'              => $newData->city->name,
                'notary_office_id'       => $newData->notary_office_id,
                'customer'               => $newData->customer,
                'contract'               => $newData->contract,
                'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
                'codigo_catastral'       => $newData->codigo_catastral,
                'escritura'              => $newData->escritura,
                'neighborhood'           => $newData->neighborhood,
                'address'                => $newData->address,
                'type'                   => $property->type === 'rural' ? 'urban' : 'rural',
                'is_horizontal'          => ! $property->is_horizontal ? 'true' : 'false',
                'area'                   => $newData->area,
                'conservation_state'     => $property->conservation_state === 'good' ? 'bad' : 'good',
                'owner'                  => $newData->owner,
                'ownership_percentage'   => $newData->ownership_percentage,
            ],
        ]))
        ->and($property->refresh())
        ->state_id->toBe($newData->state_id)
        ->city_id->toBe($newData->city_id)
        ->notary_office_id->toBe($newData->notary_office_id)
        ->customer->toBe($newData->customer)
        ->contract->toBe($newData->contract)
        ->matricula_inmobiliaria->toBe($newData->matricula_inmobiliaria)
        ->codigo_catastral->toBe($newData->codigo_catastral)
        ->escritura->toBe($newData->escritura)
        ->neighborhood->toBe($newData->neighborhood)
        ->address->toBe($newData->address)
        ->area->toBe($newData->area)
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
