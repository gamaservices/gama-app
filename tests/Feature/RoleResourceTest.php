<?php

use App\Filament\Resources\RoleResource;
use App\Filament\Resources\RoleResource\Pages\CreateRole;
use App\Filament\Resources\RoleResource\Pages\EditRole;
use App\Filament\Resources\RoleResource\Pages\ListRoles;
use Filament\Actions\DeleteAction;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(RoleResource::getUrl())->assertSuccessful();
});

it('can list roles', function () {
    livewire(ListRoles::class)
        ->assertCanSeeTableRecords(Role::all());
});

it('can render create page', closure: function () {
    $this->get(RoleResource::getUrl('create'))->assertSuccessful();
});

it('can create a role', function () {
    $newData = Role::create(['name' => 'testing-role']);

    livewire(CreateRole::class)
        ->fillForm([
            'name'       => $newData->name . '_role',
            'guard_name' => $newData->guard_name,
            'insurance'  => ['view_any_insurance'],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Role::class, [
        'name'       => $newData->name . '_role',
        'guard_name' => $newData->guard_name,
    ]);

    $permission = Permission::findByName('view_any_insurance');

    $this->assertDatabaseHas('role_has_permissions', [
        'permission_id' => $permission->id,
        'role_id'       => $newData->id + 1,
    ]);
});

it('can validate create input', function () {
    livewire(CreateRole::class)
        ->fillForm([
            'name' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
        ]);

    $newData = Role::create(['name' => 'testing-role']);

    livewire(CreateRole::class)
        ->fillForm([
            'name' => $newData->name,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'unique',
        ]);
});

it('can render edit page', function () {
    $this->get(RoleResource::getUrl('edit', [
        'record' => Role::create(['name' => 'testing-role']),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $role       = Role::create(['name' => 'testing-role']);
    $permission = Permission::create(['name' => 'view_any_insurance']);
    $role->givePermissionTo($permission);

    livewire(EditRole::class, [
        'record' => $role->getRouteKey(),
    ])
        ->assertFormSet([
            'name'       => $role->name,
            'guard_name' => $role->guard_name,
            'insurance'  => ['view_any_insurance'],
        ]);
});

it('can save a role', function () {
    $role = Role::create(['name' => 'testing-role-1']);

    $newData = Role::create(['name' => 'testing-role-2']);

    livewire(EditRole::class, [
        'record' => $role->getRouteKey(),
    ])
        ->fillForm([
            'name'       => $newData->name . '_role',
            'guard_name' => $newData->guard_name,
            'insurance'  => ['view_any_insurance'],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($role->refresh())
        ->name->toBe($newData->name . '_role')
        ->guard_name->toBe($newData->guard_name);

    $this->assertDatabaseHas('role_has_permissions', [
        'permission_id' => Permission::findByName('view_any_insurance')->id,
        'role_id'       => $role->id,
    ]);
});

it('can validate edit input', function () {
    $role = Role::create(['name' => 'testing-role']);

    livewire(EditRole::class, [
        'record' => $role->getRouteKey(),
    ])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name' => 'required',
        ]);
});

it('can delete a role', function () {
    $role = Role::create(['name' => 'testing-role']);

    livewire(EditRole::class, [
        'record' => $role->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($role);
});
