<?php

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can render list page', function () {
    $this->get(UserResource::getUrl())->assertSuccessful();
});

it('can list users', function () {
    livewire(ListUsers::class)
        ->assertCanSeeTableRecords([$this->user]);
});

it('can render create page', function () {
    $this->get(UserResource::getUrl('create'))->assertSuccessful();
});

it('can create an user', function () {
    $newData = User::factory()->make();

    livewire(CreateUser::class)
        ->fillForm([
            'name'                  => $newData->name,
            'email'                 => $newData->email,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(User::class, [
        'name'  => $newData->name,
        'email' => $newData->email,
    ]);
});

it('can validate create input', function () {
    livewire(CreateUser::class)
        ->fillForm([
            'name'     => null,
            'email'    => null,
            'password' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name'     => 'required',
            'email'    => 'required',
            'password' => 'required',
        ]);
});

it('can render edit page', function () {
    $this->get(UserResource::getUrl('edit', [
        'record' => User::factory()->create(),
    ]))->assertSuccessful();
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
        ]);
});

it('can save an user', function () {
    $user = User::factory()->create();

    $newData = User::factory()->make();

    livewire(EditUser::class, [
        'record' => $user->getRouteKey(),
    ])
        ->fillForm([
            'name'                  => $newData->name,
            'email'                 => $newData->email,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->refresh())
        ->name->toBe($newData->name)
        ->email->toBe($newData->email)
        ->password->not()->toBeNull();
});

it('can validate edit input', function () {
    $User = User::factory()->create();

    livewire(EditUser::class, [
        'record' => $User->getRouteKey(),
    ])
        ->fillForm([
            'name'     => null,
            'email'    => null,
            'password' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name'     => 'required',
            'email'    => 'required',
            'password' => 'required',
        ]);
});

it('can delete an user', function () {
    $User = User::factory()->create();

    livewire(EditUser::class, [
        'record' => $User->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($User);
});
