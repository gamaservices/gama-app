<?php

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(UserResource::getUrl())->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render list page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(UserResource::getUrl())
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can list users', function () {
    livewire(ListUsers::class)
        ->assertCanSeeTableRecords(User::all())
        ->assertCountTableRecords(2)
        ->assertCanRenderTableColumn('name')
        ->assertCanRenderTableColumn('email')
        ->assertCanRenderTableColumn('roles.name')
        ->assertCanNotRenderTableColumn('created_at')
        ->assertCanNotRenderTableColumn('updated_at');

    $this->assertAuthenticated();
});

it('can render create page', function () {
    $this->get(UserResource::getUrl('create'))->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render create page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(UserResource::getUrl('create'))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can create an user', function () {
    $newData = User::factory()->make();
    $role = Role::create(['name' => 'testing_role']);

    livewire(CreateUser::class)
        ->assertFormExists()
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('email')
        ->assertFormFieldExists('password')
        ->assertFormFieldExists('password_confirmation')
        ->assertFormFieldExists('roles')
        ->fillForm([
            'name'                  => $newData->name,
            'email'                 => $newData->email,
            'password'              => 'new_password',
            'password_confirmation' => 'new_password',
            'roles'                 => $role->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $user = User::where('name', $newData->name)->first();

    $this->assertTrue(Hash::check('new_password', $user->password));

    $this->assertDatabaseHas(User::class, [
        'name'  => $newData->name,
        'email' => $newData->email,
    ]);

    $this->assertDatabaseHas('model_has_roles', [
        'role_id'  => $role->id,
        'model_id' => $user->id,
    ]);

    expect(Activity::all()->last())
        ->description->toBe('created')
        ->subject_type->toBe(User::class)
        ->subject_id->toBe($user->id)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id)
        ->changes->toEqual(collect([
            'old'        => [],
            'attributes' => [
                'name'       => $newData->name,
                'email'      => $newData->email,
                'roles.name' => [$role->name],
            ],
        ]));

    $this->assertAuthenticated();
});

it('can validate create input', function () {
    livewire(CreateUser::class)
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
        ])
        ->fillForm([
            'name'     => str_repeat('a', 256),
            'email'    => str_repeat('a', 256),
            'password' => str_repeat('a', 256),
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name'     => 'max:255',
            'email'    => 'max:255',
            'password' => 'max:255',
        ]);

    $this->assertAuthenticated();
});

it('can render edit page', function () {
    $this->get(UserResource::getUrl('edit', [
        'record' => User::factory()->create(),
    ]))->assertSuccessful();

    $this->assertAuthenticated();
});

it('cannot render edit page when user do not have permission', function () {
    $this->actingAs($this->user)
        ->get(UserResource::getUrl('edit', [
            'record' => User::factory()->create(),
        ]))
        ->assertForbidden();

    $this->assertAuthenticated();
});

it('can retrieve data', function () {
    $user = User::factory()->create();

    livewire(EditUser::class, [
        'record' => $user->getRouteKey(),
    ])
        ->assertFormSet([
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => null,
            'password_confirmation' => null,
            'roles'                 => $user->roles->pluck('id')->toArray(),
        ]);

    $this->assertAuthenticated();
});

it('can save an user', function () {
    $role = Role::create(['name' => 'testing_role']);
    $newRole = Role::create(['name' => 'new_role']);
    $user = User::factory()->create();
    $user->syncRoles($role);
    $newData = User::factory()->make();

    livewire(EditUser::class, [
        'record' => $user->getRouteKey(),
    ])
        ->assertFormExists()
        ->assertFormFieldExists('name')
        ->assertFormFieldExists('email')
        ->assertFormFieldExists('password')
        ->assertFormFieldExists('password_confirmation')
        ->assertFormFieldExists('roles')
        ->fillForm([
            'name'                  => $newData->name,
            'email'                 => $newData->email,
            'password'              => 'new_password',
            'password_confirmation' => 'new_password',
            'roles'                 => $newRole->id,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(Activity::all()->last())
        ->description->toBe('updated')
        ->subject_type->toBe(User::class)
        ->subject_id->toBe($user->id)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id)
        ->changes->toEqual(collect([
            'old' => [
                'name'       => $user->name,
                'email'      => $user->email,
                'roles.name' => [$role->name],

            ],
            'attributes' => [
                'name'       => $newData->name,
                'email'      => $newData->email,
                'roles.name' => [$newRole->name],
            ],
        ]))
        ->and($user->refresh())
        ->name->toBe($newData->name)
        ->email->toBe($newData->email)
        ->password->not()->toBeNull()
        ->roles->first()->id->toBe($newRole->id);

    $this->assertAuthenticated();
});

it('can validate edit input', function () {
    $user = User::factory()->create();

    livewire(EditUser::class, [
        'record' => $user->getRouteKey(),
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
        ])->fillForm([
            'name'     => str_repeat('a', 256),
            'email'    => str_repeat('a', 256),
            'password' => str_repeat('a', 256),
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name'     => 'max:255',
            'email'    => 'max:255',
            'password' => 'max:255',
        ]);

    $this->assertAuthenticated();
});

it('can delete an user', function () {
    $user = User::factory()->create();

    livewire(EditUser::class, [
        'record' => $user->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($user);

    expect(Activity::all()->last())
        ->description->toBe('deleted')
        ->subject_type->toBe(User::class)
        ->subject_id->toBe($user->id)
        ->causer_type->toBe(User::class)
        ->causer_id->toBe($this->superAdmin->id);

    $this->assertAuthenticated();
});
