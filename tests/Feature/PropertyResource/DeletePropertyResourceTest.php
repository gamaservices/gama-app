<?php

use App\Filament\Resources\PropertyResource\Pages\EditProperty;
use App\Models\Property;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Spatie\Activitylog\Models\Activity;

use function Pest\Livewire\livewire;

it('can delete a property', function () {
    $property = Property::factory()->create();

    livewire(EditProperty::class, [
        'record' => $property->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    expect(Activity::all()->last())
        ->description->toBe('deleted')
        ->subject_type->toBe(Property::class)
        ->subject_id->toBe($property->id)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id)
        ->and($property->refresh())
        ->deleted_at->format('Y-m-d')->toBe(today()->format('Y-m-d'));

    $this->assertAuthenticated();
});
