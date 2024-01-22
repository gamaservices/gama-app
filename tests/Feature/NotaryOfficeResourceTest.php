<?php

use App\Filament\Resources\NotaryOfficeResource;
use App\Filament\Resources\NotaryOfficeResource\Pages\CreateNotaryOffice;
use App\Filament\Resources\NotaryOfficeResource\Pages\EditNotaryOffice;
use App\Filament\Resources\NotaryOfficeResource\Pages\ListNotaryOffices;
use App\Models\NotaryOffice;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(NotaryOfficeResource::getUrl())->assertSuccessful();
});

it('can list notary offices', function () {
    $properties = NotaryOffice::factory()->count(10)->create();

    livewire(ListNotaryOffices::class)
        ->assertCanSeeTableRecords($properties);
});

it('can render create page', function () {
    $this->get(NotaryOfficeResource::getUrl('create'))->assertSuccessful();
});

it('can create a notary office', function () {
    $newData = NotaryOffice::factory()
        ->for($this->state)
        ->for($this->city)
        ->make();

    livewire(CreateNotaryOffice::class)
        ->fillForm([
            'number'   => $newData->number,
            'state_id' => $newData->state_id,
            'city_id'  => $newData->city_id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(NotaryOffice::class, [
        'number'   => $newData->number,
        'state_id' => $newData->state_id,
        'city_id'  => $newData->city_id,
    ]);
});

it('can validate create input', function () {
    livewire(CreateNotaryOffice::class)
        ->fillForm([
            'number' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['number' => 'required']);
});

it('can render edit page', function () {
    $this->get(NotaryOfficeResource::getUrl('edit', [
        'record' => NotaryOffice::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $NotaryOffice = NotaryOffice::factory()->create();

    livewire(EditNotaryOffice::class, [
        'record' => $NotaryOffice->getRouteKey(),
    ])
        ->assertFormSet([
            'number' => $NotaryOffice->number,
        ]);
});

it('can save a NotaryOffice', function () {
    $NotaryOffice = NotaryOffice::factory()
        ->for($this->state)
        ->for($this->city)
        ->create();

    $newData = NotaryOffice::factory()
        ->for($this->state)
        ->for($this->city)
        ->make();

    livewire(EditNotaryOffice::class, [
        'record' => $NotaryOffice->getRouteKey(),
    ])
        ->fillForm([
            'number'   => $newData->number,
            'state_id' => $newData->state_id,
            'city_id'  => $newData->city_id,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($NotaryOffice->refresh())
        ->number->toBe($newData->number)
        ->state_id->toBe($newData->state_id)
        ->city_id->toBe($newData->city_id);
});

it('can validate edit input', function () {
    $NotaryOffice = NotaryOffice::factory()->create();

    livewire(EditNotaryOffice::class, [
        'record' => $NotaryOffice->getRouteKey(),
    ])
        ->fillForm([
            'number' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['number' => 'required']);
});

it('can delete a NotaryOffice', function () {
    $NotaryOffice = NotaryOffice::factory()->create();

    livewire(EditNotaryOffice::class, [
        'record' => $NotaryOffice->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($NotaryOffice);
});
