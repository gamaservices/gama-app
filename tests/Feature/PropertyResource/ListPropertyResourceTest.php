<?php

use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PropertyResource\Pages\ListProperties;
use App\Models\Property;

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
        ->assertCanRenderTableColumn('notaryOffice.id')
        ->assertCanRenderTableColumn('contract')
        ->assertCanRenderTableColumn('matricula_inmobiliaria')
        ->assertCanRenderTableColumn('codigo_catastral')
        ->assertCanRenderTableColumn('escritura')
        ->assertCanRenderTableColumn('type')
        ->assertCanRenderTableColumn('is_horizontal')
        ->assertCanRenderTableColumn('area')
        ->assertCanRenderTableColumn('conservation_state')
        ->assertCanRenderTableColumn('bank_ownership_percentage')
        ->assertCanRenderTableColumn('disabled_at')
        ->assertCanRenderTableColumn('acquired_at')
        ->assertCanNotRenderTableColumn('created_at')
        ->assertCanNotRenderTableColumn('updated_at');

    $this->assertAuthenticated();
});
