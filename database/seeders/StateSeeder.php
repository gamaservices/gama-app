<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['name' => 'Amazonas', 'code' => '91'],
            ['name' => 'Antioquia', 'code' => '05'],
            ['name' => 'Arauca', 'code' => '81'],
            ['name' => 'Atlántico', 'code' => '08'],
            ['name' => 'Bolívar', 'code' => '13'],
            ['name' => 'Boyacá', 'code' => '15'],
            ['name' => 'Caldas', 'code' => '17'],
            ['name' => 'Caquetá', 'code' => '18'],
            ['name' => 'Casanare', 'code' => '85'],
            ['name' => 'Cauca', 'code' => '19'],
            ['name' => 'Cesar', 'code' => '20'],
            ['name' => 'Chocó', 'code' => '27'],
            ['name' => 'Córdoba', 'code' => '23'],
            ['name' => 'Cundinamarca', 'code' => '25'],
            ['name' => 'Guainía', 'code' => '94'],
            ['name' => 'Guaviare', 'code' => '95'],
            ['name' => 'Huila', 'code' => '41'],
            ['name' => 'La Guajira', 'code' => '44'],
            ['name' => 'Magdalena', 'code' => '47'],
            ['name' => 'Meta', 'code' => '50'],
            ['name' => 'Nariño', 'code' => '52'],
            ['name' => 'Norte de Santander', 'code' => '54'],
            ['name' => 'Putumayo', 'code' => '86'],
            ['name' => 'Quindío', 'code' => '63'],
            ['name' => 'Risaralda', 'code' => '66'],
            ['name' => 'San Andrés y Providencia', 'code' => '88'],
            ['name' => 'Santander', 'code' => '68'],
            ['name' => 'Sucre', 'code' => '70'],
            ['name' => 'Tolima', 'code' => '73'],
            ['name' => 'Valle del Cauca', 'code' => '76'],
            ['name' => 'Vaupés', 'code' => '97'],
            ['name' => 'Vichada', 'code' => '99'],
        ];

        State::insert($states);
    }
}
