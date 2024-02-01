<?php

use App\Filament\Resources\Shield\RoleResource;
use App\Filament\Resources\Shield\RoleResource\Pages\CreateRole;
use App\Filament\Resources\Shield\RoleResource\Pages\EditRole;
use App\Filament\Resources\Shield\RoleResource\Pages\ListRoles;
use Filament\Actions\DeleteAction;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(RoleResource::getUrl())
        ->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render list page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(RoleResource::getUrl())
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can list roles', function () {
    livewire(ListRoles::class)
        ->assertCanSeeTableRecords(Role::all())
        ->assertCountTableRecords(2)
        ->assertCanRenderTableColumn('name')
        ->assertCanRenderTableColumn('guard_name')
        ->assertCanRenderTableColumn('permissions_count')
        ->assertCanRenderTableColumn('updated_at')
        ->searchTable('super_admin')
        ->assertCanSeeTableRecords(Role::where('name', 'super_admin')->get());

    $this->assertAuthenticated();
});

it('can render create page', closure: function () {
    $this->get(RoleResource::getUrl('create'))
        ->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render create page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(RoleResource::getUrl('create'))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can create a role', function () {
    livewire(CreateRole::class)
        ->assertFormExists()
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('guard_name')
        ->assertFormFieldExists('user')
        ->assertFormFieldExists('property')
        ->assertFormFieldExists('insurance')
        ->fillForm([
            'name'       => 'testing_role',
            'guard_name' => 'web',
            'property'   => ['view_any_property'],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Role::class, [
        'name'       => 'testing_role',
        'guard_name' => 'web',
    ]);

    $role       = Role::findByName('testing_role');
    $permission = Permission::findByName('view_any_property');

    $this->assertDatabaseHas('role_has_permissions', [
        'permission_id' => $permission->id,
        'role_id'       => $role->id,
    ]);
});

it('can validate create input', function () {
    $role = Role::create(['name' => 'testing-role']);

    livewire(CreateRole::class)
        ->fillForm([
            'name' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
        ])
        ->fillForm([
            'name' => $role->name,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'unique',
        ])
        ->fillForm([
            'name'       => str_repeat('a', 256),
            'guard_name' => str_repeat('a', 256),
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name'       => 'max:255',
            'guard_name' => 'max:255',
        ]);
});

it('can render edit page', function () {
    $this->get(RoleResource::getUrl('edit', [
        'record' => Role::create(['name' => 'testing-role']),
    ]))->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render edit page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(RoleResource::getUrl('edit', [
            'record' => Role::create(['name' => 'testing-role']),
        ]))->assertForbidden();

    $this->assertAuthenticated();
});

it('can retrieve data', function () {
    $role       = Role::create(['name' => 'testing_role']);
    $permission = Permission::create(['name' => 'view_any_property']);
    $role->givePermissionTo($permission);

    livewire(EditRole::class, [
        'record' => $role->getRouteKey(),
    ])

        ->assertFormSet([
            'name'       => $role->name,
            'guard_name' => $role->guard_name,
            'property'   => ['view_any_property'],
        ]);
});

it('can save a role', function () {
    $role = Role::create(['name' => 'testing_role']);

    livewire(EditRole::class, [
        'record' => $role->getRouteKey(),
    ])
        ->assertFormExists()
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('guard_name')
        ->assertFormFieldExists('user')
        ->assertFormFieldExists('property')
        ->assertFormFieldExists('insurance')
        ->fillForm([
            'name'       => 'another_testing_role',
            'guard_name' => 'web',
            'property'   => ['view_any_property'],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($role->refresh())
        ->name->toBe('another_testing_role')
        ->guard_name->toBe('web');

    $this->assertDatabaseHas('role_has_permissions', [
        'permission_id' => Permission::findByName('view_any_property')->id,
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
        ])
        ->fillForm([
            'name'       => str_repeat('a', 256),
            'guard_name' => str_repeat('a', 256),
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name'       => 'max:255',
            'guard_name' => 'max:255',
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

it('can render view page', function () {
    $this->get(RoleResource::getUrl('view', [
        'record' => Role::create(['name' => 'testing-role']),
    ]))->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render view page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(RoleResource::getUrl('view', [
            'record' => Role::create(['name' => 'testing-role']),
        ]))->assertForbidden();

    $this->assertAuthenticated();
});
