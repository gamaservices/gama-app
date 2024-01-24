<?php

namespace Tests;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected State $state;

    protected City $city;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->state = State::factory()->create();
        $this->city  = City::factory()->for($this->state)->create();
        $this->user  = User::factory()->create();

        $this->actingAs($this->user);
    }
}
