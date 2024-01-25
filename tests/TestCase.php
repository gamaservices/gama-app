<?php

namespace Tests;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected State $state;

    protected City $city;

    protected User $user;

    protected Role $role;

    protected function setUp(): void
    {
        parent::setUp();

        $this->state = State::factory()->create();
        $this->city  = City::factory()->for($this->state)->create();
        $this->user  = User::factory()->create();

        $this->role = Role::create(['name' => 'super_admin']);
        $this->user->assignRole($this->role);

        $this->actingAs($this->user);
    }
}
