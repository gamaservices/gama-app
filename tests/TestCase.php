<?php

namespace Tests;

use App\Models\Bank;
use App\Models\City;
use App\Models\NotaryOffice;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected State $state;

    protected City $city;

    protected NotaryOffice $notaryOffice;

    protected User $superAdmin;

    protected User $user;

    protected Bank $bank;

    protected function setUp(): void
    {
        parent::setUp();

        $this->state = State::factory()->create();
        $this->city = City::factory()->for($this->state)->create();
        $this->user = User::factory()->create();
        $this->notaryOffice = NotaryOffice::factory()->for($this->city)->create();
        $this->bank = Bank::factory()->create();

        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole(Role::create(['name' => 'super_admin']));

        $this->actingAs($this->superAdmin);
    }
}
