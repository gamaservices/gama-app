<?php

use App\Filament\Resources\NotaryOfficeResource;
use App\Filament\Resources\NotaryOfficeResource\Pages\CreateNotaryOffice;
use App\Filament\Resources\NotaryOfficeResource\Pages\EditNotaryOffice;
use App\Filament\Resources\NotaryOfficeResource\Pages\ListNotaryOffices;
use App\Models\NotaryOffice;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Spatie\Activitylog\Models\Activity;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(NotaryOfficeResource::getUrl())->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render list page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(NotaryOfficeResource::getUrl())
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can list notary offices', function () {
    $notaryOffices = NotaryOffice::factory()->count(10)->create();

    $this->notaryOffice->delete();

    livewire(ListNotaryOffices::class)
        ->assertCanSeeTableRecords($notaryOffices)
        ->assertCountTableRecords(10)
        ->assertCanRenderTableColumn('number')
        ->assertCanRenderTableColumn('city.name')
        ->assertCanNotRenderTableColumn('created_at')
        ->assertCanNotRenderTableColumn('updated_at')
        ->searchTable($notaryOffices->first()->number)
        ->assertCanSeeTableRecords($notaryOffices->where('number', $notaryOffices->first()->number))
        ->assertCountTableRecords($notaryOffices->where('number', $notaryOffices->first()->number)->count());

    $this->assertAuthenticated();
});

it('can render create page', function () {
    $this->get(NotaryOfficeResource::getUrl('create'))->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render create page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(NotaryOfficeResource::getUrl('create'))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can create a notary office', function () {
    $newData = NotaryOffice::factory()
        ->for($this->city)
        ->make();

    livewire(CreateNotaryOffice::class)
        ->assertFormExists()
        ->assertFormFieldExists('number')
        ->assertFormFieldExists('city_id')
        ->fillForm([
            'number'  => $newData->number,
            'city_id' => $newData->city_id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(NotaryOffice::class, [
        'number'  => $newData->number,
        'city_id' => $newData->city_id,
    ]);

    expect(Activity::all()->last())
        ->description->toBe('created')
        ->subject_type->toBe(NotaryOffice::class)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id)
        ->changes->toEqual(collect([
            'old'        => [],
            'attributes' => [
                'number'    => $newData->number,
                'city.name' => $newData->city->name,
            ],
        ]));

    $this->assertAuthenticated();
});

it('can validate create input', function () {
    livewire(CreateNotaryOffice::class)
        ->fillForm([
            'number'  => null,
            'city_id' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'number'  => 'required',
            'city_id' => 'required',
        ])
        ->fillForm([
            'number' => 0,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'number' => 'min:1',
        ]);

    $this->assertAuthenticated();
});

it('can render edit page', function () {
    $this->get(NotaryOfficeResource::getUrl('edit', [
        'record' => NotaryOffice::factory()->create(),
    ]))->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render edit page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(NotaryOfficeResource::getUrl('edit', [
            'record' => NotaryOffice::factory()->create(),
        ]))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can retrieve data', function () {
    $notaryOffice = NotaryOffice::factory()->create();

    livewire(EditNotaryOffice::class, [
        'record' => $notaryOffice->getRouteKey(),
    ])
        ->assertFormSet([
            'number'  => $notaryOffice->number,
            'city_id' => $notaryOffice->city_id,
        ]);

    $this->assertAuthenticated();
});

it('can save a notary office', function () {
    $notaryOffice = NotaryOffice::factory()
        ->for($this->city)
        ->create();

    $newData = NotaryOffice::factory()
        ->for($this->city)
        ->make();

    livewire(EditNotaryOffice::class, [
        'record' => $notaryOffice->getRouteKey(),
    ])
        ->assertFormExists()
        ->assertFormFieldExists('number')
        ->assertFormFieldExists('city_id')
        ->fillForm([
            'number'  => $newData->number,
            'city_id' => $newData->city_id,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(Activity::all()->last())
        ->description->toBe('updated')
        ->subject_type->toBe(NotaryOffice::class)
        ->subject_id->toBe($notaryOffice->id)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id)
        ->changes([
            'old' => [
                'number'  => $notaryOffice->number,
                'city.id' => $notaryOffice->city_id,
            ],
            'attributes' => [
                'number'  => $newData->number,
                'city.id' => $newData->city_id,
            ],
        ])
        ->and($notaryOffice->refresh())
        ->number->toBe($newData->number)
        ->city_id->toBe($newData->city_id);
});

it('can validate edit input', function () {
    $notaryOffice = NotaryOffice::factory()->create();

    livewire(EditNotaryOffice::class, [
        'record' => $notaryOffice->getRouteKey(),
    ])
        ->fillForm([
            'number'  => null,
            'city_id' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'number'  => 'required',
            'city_id' => 'required',
        ])
        ->fillForm([
            'number' => 0,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'number' => 'min:1',
        ]);

    $this->assertAuthenticated();
});

it('can delete a notary office', function () {
    $notaryOffice = NotaryOffice::factory()->create();

    livewire(EditNotaryOffice::class, [
        'record' => $notaryOffice->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($notaryOffice);

    expect(Activity::all()->last())
        ->description->toBe('deleted')
        ->subject_type->toBe(NotaryOffice::class)
        ->subject_id->toBe($notaryOffice->id)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id);

    $this->assertAuthenticated();
});
