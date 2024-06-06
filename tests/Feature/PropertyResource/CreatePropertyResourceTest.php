<?php

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PropertyResource\Pages\CreateProperty;
use App\Models\Property;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

use function Pest\Livewire\livewire;

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
        ->for($this->notaryOffice)
        ->make();

    livewire(CreateProperty::class)
        ->assertFormExists()
        ->assertFormFieldExists('notary_office_id')
        ->assertFormFieldExists('customer')
        ->assertFormFieldExists('contract')
        ->assertFormFieldExists('matricula_inmobiliaria')
        ->assertFormFieldExists('codigo_catastral')
        ->assertFormFieldExists('escritura')
        ->assertFormFieldExists('type')
        ->assertFormFieldExists('is_horizontal')
        ->assertFormFieldExists('area')
        ->assertFormFieldExists('conservation_state')
        ->assertFormFieldExists('owner')
        ->assertFormFieldExists('ownership_percentage')
        ->assertFormFieldExists('disabled_at')
        ->assertFormFieldExists('acquired_at')
        ->fillForm([
            'address_id'             => $newData->address_id,
            'notary_office_id'       => $newData->notary_office_id,
            'customer'               => $newData->customer,
            'contract'               => $newData->contract,
            'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
            'codigo_catastral'       => $newData->codigo_catastral,
            'escritura'              => $newData->escritura,
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
        'notary_office_id'       => $newData->notary_office_id,
        'customer'               => $newData->customer,
        'contract'               => $newData->contract,
        'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
        'codigo_catastral'       => $newData->codigo_catastral,
        'escritura'              => $newData->escritura,
        'type'                   => $newData->type,
        'is_horizontal'          => $newData->is_horizontal,
        'area'                   => $newData->area,
        'conservation_state'     => $newData->conservation_state,
        'owner'                  => $newData->owner,
        'ownership_percentage'   => $newData->ownership_percentage,
    ]);

    expect(Activity::all()->last())
        ->description->toBe('created')
        ->subject_type->toBe(Property::class)
        ->subject_id->toBe(Property::all()->last()->id)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id)
        ->changes->toEqual(collect([
            'old'        => [],
            'attributes' => [
                'notary_office_id'       => $newData->notary_office_id,
                'customer'               => $newData->customer,
                'contract'               => $newData->contract,
                'matricula_inmobiliaria' => $newData->matricula_inmobiliaria,
                'codigo_catastral'       => $newData->codigo_catastral,
                'escritura'              => $newData->escritura,
                'type'                   => $newData->type,
                'is_horizontal'          => $newData->is_horizontal ? 'true' : 'false',
                'area'                   => $newData->area,
                'conservation_state'     => $newData->conservation_state,
                'owner'                  => $newData->owner,
                'ownership_percentage'   => $newData->ownership_percentage,
            ],
        ]));

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
            'conservation_state'     => str_repeat('a', 256),
            'owner'                  => str_repeat('a', 256),
        ])
        ->call('create')
        ->assertHasFormErrors([
            'contract'               => 'max:255',
            'matricula_inmobiliaria' => 'max:255',
            'codigo_catastral'       => 'max:255',
            'escritura'              => 'max:255',
            'conservation_state'     => 'max:255',
            'owner'                  => 'max:255',
        ]);

    $this->assertAuthenticated();
});
