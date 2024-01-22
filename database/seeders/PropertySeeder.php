<?php

namespace Database\Seeders;

use App\Models\Insurance;
use App\Models\NotaryOffice;
use App\Models\Property;
use App\Models\PublicService;
use App\Models\State;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $antioquia_id    = State::where('name', 'Antioquia')->first()->id;
        $cundinamarca_id = State::where('name', 'Cundinamarca')->first()->id;

        Property::factory()->count(100)->has(Insurance::factory()->count(2))
            ->has(PublicService::factory()->count(3))
            ->for(NotaryOffice::factory()->state([
                'state_id' => $antioquia_id,
            ]))
            ->create([
                'state_id' => $antioquia_id,
            ]);

        Property::factory()->count(100)->has(Insurance::factory()->count(2))
            ->has(PublicService::factory()->count(3))
            ->for(NotaryOffice::factory()->state([
                'state_id' => $cundinamarca_id,
            ]))
            ->create([
                'state_id' => $cundinamarca_id,
            ]);
    }
}
