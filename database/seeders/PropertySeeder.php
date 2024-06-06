<?php

namespace Database\Seeders;

use App\Models\Insurance;
use App\Models\Property;
use App\Models\PublicService;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        Property::factory()->count(100)
            ->has(Insurance::factory()->count(2))
            ->has(PublicService::factory()->count(3))
            ->create();

        Property::factory()->count(100)
            ->has(Insurance::factory()->count(2))
            ->has(PublicService::factory()->count(3))
            ->create();
    }
}
