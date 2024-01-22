<?php

use App\Filament\Resources\InsuranceResource\Pages\CreateInsurance;
use App\Filament\Resources\InsuranceResource\Pages\EditInsurance;
use App\Filament\Resources\InsuranceResource\Pages\ListInsurances;
use App\Filament\Resources\PropertyResource;
use App\Models\Insurance;
use App\Models\Property;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $parent = Property::factory()->create();
    $this->get(PropertyResource::getUrl('insurances.index', ['parent' => $parent->id]))
        ->assertSuccessful();
});

it('can list insurances', function () {
    $parent = Property::factory()
        ->has(Insurance::factory()->count(10))
        ->create();

    livewire(ListInsurances::class, [
        'parent' => $parent,
    ])
        ->assertCanSeeTableRecords($parent->insurances);
});

it('can render create page', function () {
    $parent = Property::factory()->create();
    $this->get(PropertyResource::getUrl('insurances.create', ['parent' => $parent->id]))
        ->assertSuccessful();
});

it('can create an insurance', function () {
    $parent = Property::factory()->create();
    $newData = Insurance::factory()->make([
        'property_id' => $parent->id,
    ]);

    livewire(CreateInsurance::class, [
        'parent' => $parent,
    ])
        ->fillForm([
            'policy_number' => $newData->policy_number,
            'type' => $newData->type,
            'company' => $newData->company,
            'start_at' => $newData->start_at,
            'expired_at' => $newData->expired_at,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Insurance::class, [
        'policy_number' => $newData->policy_number,
        'type' => $newData->type,
        'company' => $newData->company,
        'start_at' => $newData->start_at,
        'expired_at' => $newData->expired_at,
        'property_id' => $newData->property_id,
    ]);
});

it('can validate create input', function () {
    $parent = Property::factory()->create();

    livewire(CreateInsurance::class, [
        'parent' => $parent,
    ])
        ->fillForm([
            'policy_number' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['policy_number' => 'required']);
});

it('can render edit page', function () {
    $parent = Property::factory()
        ->has(Insurance::factory())
        ->create();

    $this->get(PropertyResource::getUrl('insurances.edit', [
        'parent' => $parent,
        'record' => $parent->insurances->first(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $parent = Property::factory()
        ->has(Insurance::factory())
        ->create();
    $insurance = $parent->insurances->first();

    livewire(EditInsurance::class, [
        'parent' => $parent,
        'record' => $insurance->getRouteKey(),
    ])
        ->assertFormSet([
            'policy_number' => $insurance->policy_number,
            'type' => $insurance->type,
            'company' => $insurance->company,
            'start_at' => $insurance->start_at->format('Y-m-d'),
            'expired_at' => $insurance->expired_at->format('Y-m-d'),
            'property_id' => $insurance->property_id,
        ]);
});

it('can save an insurance', function () {
    $parent = Property::factory()
        ->has(Insurance::factory())
        ->create();

    $newData = Insurance::factory()
        ->make([
            'property_id' => $parent->id,
        ]);

    livewire(EditInsurance::class, [
        'parent' => $parent,
        'record' => $parent->insurances->first()->getRouteKey(),
    ])
        ->fillForm([
            'policy_number' => $newData->policy_number,
            'type' => $newData->type,
            'company' => $newData->company,
            'start_at' => $newData->start_at,
            'expired_at' => $newData->expired_at,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($parent->insurances->first()->refresh())
        ->policy_number->toBe($newData->policy_number)
        ->type->toBe($newData->type)
        ->company->toBe($newData->company)
        ->start_at->format('Y-m-d')->toBe($newData->start_at->format('Y-m-d'))
        ->expired_at->format('Y-m-d')->toBe($newData->expired_at->format('Y-m-d'))
        ->property_id->toBe($newData->property_id);
});

it('can validate edit input', function () {
    $parent = Property::factory()
        ->has(Insurance::factory())
        ->create();

    livewire(EditInsurance::class, [
        'parent' => $parent,
        'record' => $parent->insurances->first()->getRouteKey(),
    ])
        ->fillForm([
            'policy_number' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['policy_number' => 'required']);
});

it('can delete an insurance', function () {
    $parent = Property::factory()
        ->has(Insurance::factory()->count(10))
        ->create();

    $insurance = $parent->insurances->first();

    livewire(EditInsurance::class, [
        'parent' => $parent,
        'record' => $insurance->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($insurance);
});
