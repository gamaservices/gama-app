<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Bank;
use App\Models\City;
use App\Models\NotaryOffice;
use App\Models\Property;
use App\Models\PropertyAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $propertyAdmin = PropertyAdmin::inRandomOrder()->first();
        $bank = Bank::inRandomOrder()->first();
        $city = City::inRandomOrder()->first();
        $address = Address::factory()->for($city)->create();
        $notaryOffice = NotaryOffice::factory()->for($city)->create();

        return [
            'contract'                  => fake()->bothify('?-#####-?'),
            'matricula_inmobiliaria'    => fake()->bothify('###-#####'),
            'codigo_catastral'          => fake()->bothify('##############################'),
            'escritura'                 => fake()->bothify('#####'),
            'type'                      => fake()->randomElements(['rural', 'urban'])[0],
            'is_horizontal'             => fake()->boolean(),
            'area'                      => fake()->randomFloat(2, 50, 300),
            'conservation_state'        => fake()->randomElements(['good', 'normal', 'bad'])[0],
            'bank_ownership_percentage' => fake()->numberBetween(0, 100),
            'acquired_at'               => fake()->date(),

            'address_id'        => $address->id,
            'notary_office_id'  => $notaryOffice->id,
            'bank_id'           => $bank->id,
            'property_admin_id' => $propertyAdmin->id,
        ];
    }
}
