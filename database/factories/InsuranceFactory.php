<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Insurance>
 */
class InsuranceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $property = Property::inRandomOrder()->first() ?? Property::factory()->create();

        return [
            'property_id' => $property->id,

            'policy_number' => fake()->bothify('RC-####'),
            'type'          => 'Responsabilidad Civíl',
            'company'       => 'Seguros Sura',
            'start_at'      => fake()->dateTime('-1 year')->format('Y-m-d'),
            'expired_at'    => fake()->dateTimeBetween('-9 months', '+1 year')->format('Y-m-d'),
        ];
    }
}
