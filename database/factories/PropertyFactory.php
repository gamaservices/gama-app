<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\City;
use App\Models\NotaryOffice;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer'               => 'Banco de Bogotá',
            'contract'               => fake()->bothify('?-#####-?'),
            'matricula_inmobiliaria' => fake()->bothify('###-#####'),
            'codigo_catastral'       => fake()->bothify('##############################'),
            'escritura'              => fake()->bothify('#####'),
            'neighborhood'           => fake()->word(),
            'address'                => fake()->address(),
            'type'                   => fake()->randomElements(['rural', 'urban'])[0],
            'is_horizontal'          => fake()->boolean(),
            'area'                   => fake()->randomFloat(2, 50, 300),
            'conservation_state'     => fake()->randomElements(['good', 'normal', 'bad'])[0],
            'owner'                  => 'Banco de Bogotá',
            'ownership_percentage'   => fake()->numberBetween(0, 100),
            'acquired_at'            => fake()->date(),
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Property $property) {
            $city = City::inRandomOrder()->first();

            $property->address()->save(Address::factory()->for($city)->create());
            $property->notaryOffice()->save(NotaryOffice::factory()->for($city)->create());
        });
    }
}
