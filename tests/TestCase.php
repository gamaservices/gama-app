<?php

namespace Tests;

use App\Models\City;
use App\Models\NotaryOffice;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected State $state;

    protected City $city;

    protected NotaryOffice $notaryOffice;

    protected function setUp(): void
    {
        parent::setUp();

       $this->actingAs(User::factory()->create());
    }
}
