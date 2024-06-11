<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = collect(City::pluck('id'));

        return [
            'base_address'  => fake()->streetAddress(),
            'neighborhood'  => fake()->word(),
            'building_name' => fake()->word(),
            'apartment'     => fake()->buildingNumber(),
            'observations'  => json_encode(fake()->realTextBetween($minNbChars = 60, $maxNbChars = 100, $indexSize = 2)),
            'city_id'       => $cities->random(),
        ];
    }
}
