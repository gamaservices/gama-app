<?php

use App\Filament\Resources\Shield\RoleResource;
use App\Filament\Resources\Shield\RoleResource\Pages\CreateRole;
use App\Filament\Resources\Shield\RoleResource\Pages\EditRole;
use App\Filament\Resources\Shield\RoleResource\Pages\ListRoles;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(RoleResource::getUrl())->assertSuccessful();
});

it('can list roles', function () {
    livewire(ListRoles::class)
        ->assertCanSeeTableRecords(Role::all());
});

it('can render create page', function () {
    $this->get(RoleResource::getUrl('create'))->assertSuccessful();
});

it('can create a role', function () {
    $newData = Role::factory()->make();

    livewire(CreateRole::class)
        ->fillForm([
            'name'                  => $newData->name,
            'email'                 => $newData->email,
            'password'              => 'new_password',
            'password_confirmation' => 'new_password',
            'roles'                 => $this->role->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $user = Role::where('name', $newData->name)->first();

    $this->assertTrue(Hash::check('new_password', $user->password));

    $this->assertDatabaseHas(Role::class, [
        'name'  => $newData->name,
        'email' => $newData->email,
    ]);

    $this->assertDatabaseHas('model_has_roles', [
        'role_id'  => $this->role->id,
        'model_id' => $user->id,
    ]);
});

it('can validate create input', function () {
    livewire(CreateRole::class)
        ->fillForm([
            'name'                  => null,
            'email'                 => null,
            'password'              => null,
            'password_confirmation' => 'other',
            'roles'                 => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name'                  => 'required',
            'email'                 => 'required',
            'password'              => 'required',
            'password_confirmation' => 'same:password',
            'roles'                 => 'required',
        ]);
});

it('can render edit page', function () {
    $this->get(RoleResource::getUrl('edit', [
        'record' => Role::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $user = Role::factory()->create();

    livewire(EditRole::class, [
        'record' => $user->getRouteKey(),
    ])
        ->assertFormSet([
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => null,
            'password_confirmation' => null,
            'roles'                 => $user->roles->pluck('id')->toArray(),
        ]);
});

it('can save an user', function () {
    $user = Role::factory()->create();

    $newData = Role::factory()->make();

    livewire(EditRole::class, [
        'record' => $user->getRouteKey(),
    ])
        ->fillForm([
            'name'                  => $newData->name,
            'email'                 => $newData->email,
            'password'              => 'new_password',
            'password_confirmation' => 'new_password',
            'roles'                 => $this->role->id,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->refresh())
        ->name->toBe($newData->name)
        ->email->toBe($newData->email)
        ->password->not()->toBeNull()
        ->roles->first()->id->toBe($this->role->id);
});

it('can validate edit input', function () {
    $Role = Role::factory()->create();

    livewire(EditRole::class, [
        'record' => $Role->getRouteKey(),
    ])
        ->fillForm([
            'name'                  => null,
            'email'                 => null,
            'password'              => null,
            'password_confirmation' => 'other',
            'roles'                 => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name'                  => 'required',
            'email'                 => 'required',
            'password'              => 'required',
            'password_confirmation' => 'same:password',
            'roles'                 => 'required',
        ]);
});

it('can delete an user', function () {
    $Role = Role::factory()->create();

    livewire(EditRole::class, [
        'record' => $Role->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($Role);
});
