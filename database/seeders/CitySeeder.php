<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $antioquia_id = State::where('name', 'Antioquia')->first()->id;
        $cundinamarca_id = State::where('name', 'Cundinamarca')->first()->id;
        $cities = [
            ['name' => 'Medellín', 'state_id' => $antioquia_id],
            ['name' => 'Envigado', 'state_id' => $antioquia_id],
            ['name' => 'Itagüí', 'state_id' => $antioquia_id],
            ['name' => 'Bello', 'state_id' => $antioquia_id],
            ['name' => 'Sabaneta', 'state_id' => $antioquia_id],
            ['name' => 'Rionegro', 'state_id' => $antioquia_id],
            ['name' => 'La Estrella', 'state_id' => $antioquia_id],
            ['name' => 'Girardota', 'state_id' => $antioquia_id],
            ['name' => 'Bogotá', 'state_id' => $cundinamarca_id],
            ['name' => 'Soacha', 'state_id' => $cundinamarca_id],
            ['name' => 'Chía', 'state_id' => $cundinamarca_id],
            ['name' => 'Zipaquirá', 'state_id' => $cundinamarca_id],
            ['name' => 'Funza', 'state_id' => $cundinamarca_id],
            ['name' => 'Mosquera', 'state_id' => $cundinamarca_id],
            ['name' => 'Cajicá', 'state_id' => $cundinamarca_id],
            ['name' => 'Facatativá', 'state_id' => $cundinamarca_id],
        ];

        City::insert($cities);
    }
}
