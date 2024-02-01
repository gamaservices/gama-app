<?php

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PublicServiceResource\Pages\CreatePublicService;
use App\Filament\Resources\PublicServiceResource\Pages\EditPublicService;
use App\Filament\Resources\PublicServiceResource\Pages\ListPublicServices;
use App\Models\Property;
use App\Models\PublicService;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $parent = Property::factory()->create();
    $this->get(PropertyResource::getUrl('public_services.index', ['parent' => $parent->id]))
        ->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render list page when user do not have permission', function () {
    $parent = Property::factory()->create();
    $this->actingAs($this->user)
        ->get(PropertyResource::getUrl('public_services.index', ['parent' => $parent->id]))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can list public services', function () {
    $parent = Property::factory()
        ->has(PublicService::factory()->count(10))
        ->create();

    livewire(ListPublicServices::class, [
        'parent' => $parent,
    ])
        ->assertCanSeeTableRecords($parent->publicServices)
        ->assertCountTableRecords(10)
        ->assertCanRenderTableColumn('type')
        ->assertCanRenderTableColumn('company')
        ->assertCanRenderTableColumn('is_domiciled')
        ->assertCanRenderTableColumn('property.id')
        ->assertCanNotRenderTableColumn('created_at')
        ->assertCanNotRenderTableColumn('updated_at');

    $this->assertAuthenticated();
});

it('can render create page', function () {
    $parent = Property::factory()->create();
    $this->get(PropertyResource::getUrl('public_services.create', ['parent' => $parent->id]))
        ->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render create page when user do not have permission', function () {
    $parent = Property::factory()->create();
    $this->actingAs($this->user)
        ->get(PropertyResource::getUrl('public_services.create', ['parent' => $parent->id]))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can create a public service', function () {
    $parent  = Property::factory()->create();
    $newData = PublicService::factory()->make([
        'property_id' => $parent->id,
    ]);

    livewire(CreatePublicService::class, [
        'parent' => $parent,
    ])
        ->assertFormExists()
        ->assertFormFieldExists('type')
        ->assertFormFieldExists('company')
        ->assertFormFieldExists('is_domiciled')
        ->fillForm([
            'type'         => $newData->type,
            'company'      => $newData->company,
            'is_domiciled' => $newData->is_domiciled,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(PublicService::class, [
        'type'         => $newData->type,
        'company'      => $newData->company,
        'is_domiciled' => $newData->is_domiciled,
        'property_id'  => $newData->property_id,
    ]);

    $this->assertAuthenticated();
});

it('can validate create input', function () {
    $parent = Property::factory()->create();

    livewire(CreatePublicService::class, [
        'parent' => $parent,
    ])
        ->fillForm([
            'type'         => null,
            'company'      => null,
            'is_domiciled' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'type'         => 'required',
            'company'      => 'required',
            'is_domiciled' => 'required',
        ])
        ->fillForm([
            'type'    => str_repeat('a', 256),
            'company' => str_repeat('a', 256),
        ])
        ->call('create')
        ->assertHasFormErrors([
            'type'    => 'max:255',
            'company' => 'max:255',
        ]);

    $this->assertAuthenticated();
});

it('can render edit page', function () {
    $parent = Property::factory()
        ->has(PublicService::factory())
        ->create();

    $this->get(PropertyResource::getUrl('public_services.edit', [
        'parent' => $parent,
        'record' => $parent->publicServices->first(),
    ]))->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render edit page when user do not have permission', function () {
    $parent = Property::factory()
        ->has(PublicService::factory())
        ->create();

    $this->actingAs($this->user)
        ->get(PropertyResource::getUrl('public_services.edit', [
            'parent' => $parent,
            'record' => $parent->publicServices->first(),
        ]))->assertForbidden();

    $this->assertAuthenticated();
});

it('can retrieve data', function () {
    $parent = Property::factory()
        ->has(PublicService::factory())
        ->create();
    $publicService = $parent->publicServices->first();

    livewire(EditPublicService::class, [
        'parent' => $parent,
        'record' => $publicService->getRouteKey(),
    ])
        ->assertFormSet([
            'type'         => $publicService->type,
            'company'      => $publicService->company,
            'is_domiciled' => $publicService->is_domiciled,
            'property_id'  => $publicService->property_id,
        ]);

    $this->assertAuthenticated();
});

it('can save a public service', function () {
    $parent = Property::factory()
        ->has(PublicService::factory())
        ->create();

    $newData = PublicService::factory()
        ->make([
            'property_id' => $parent->id,
        ]);

    livewire(EditPublicService::class, [
        'parent' => $parent,
        'record' => $parent->publicServices->first()->getRouteKey(),
    ])
        ->assertFormExists()
        ->assertFormFieldExists('type')
        ->assertFormFieldExists('company')
        ->assertFormFieldExists('is_domiciled')
        ->fillForm([
            'type'         => $newData->type,
            'company'      => $newData->company,
            'is_domiciled' => $newData->is_domiciled,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($parent->publicServices->first()->refresh())
        ->type->tobe($newData->type)
        ->company->tobe($newData->company)
        ->is_domiciled->tobe($newData->is_domiciled)
        ->property_id->toBe($newData->property_id);
});

it('can validate edit input', function () {
    $parent = Property::factory()
        ->has(PublicService::factory())
        ->create();

    livewire(EditPublicService::class, [
        'parent' => $parent,
        'record' => $parent->publicServices->first()->getRouteKey(),
    ])
        ->fillForm([
            'type'         => null,
            'company'      => null,
            'is_domiciled' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'type'         => 'required',
            'company'      => 'required',
            'is_domiciled' => 'required',
        ])
        ->fillForm([
            'type'    => str_repeat('a', 256),
            'company' => str_repeat('a', 256),
        ])
        ->call('save')
        ->assertHasFormErrors([
            'type'    => 'max:255',
            'company' => 'max:255',
        ]);

    $this->assertAuthenticated();
});

it('can delete a public service', function () {
    $parent = Property::factory()
        ->has(PublicService::factory()->count(10))
        ->create();

    $publicService = $parent->publicServices->first();

    livewire(EditPublicService::class, [
        'parent' => $parent,
        'record' => $publicService->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($publicService);

    $this->assertAuthenticated();
});
