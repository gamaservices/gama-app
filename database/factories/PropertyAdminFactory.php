<?php

namespace Database\Factories;

use App\Enums\AccountType;
use App\Enums\PropertyAdminType;
use App\Models\Address;
use App\Models\PropertyAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyAdmin>
 */
class PropertyAdminFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $address = Address::inRandomOrder()->first() ?? Address::factory()->create();

        return [
            'address_id' => $address->id,

            'name'           => fake()->name(),
            'document'       => fake()->numerify('##########'),
            'account_number' => fake()->numerify('##########'),
            'account_entity' => fake()->company(),
            'account_type'   => fake()->randomElement(AccountType::values()),
            'type'           => fake()->randomElement(PropertyAdminType::values()),
            'email1'         => fake()->safeEmail(),
            'email2'         => fake()->safeEmail(),
            'phone1'         => fake()->phoneNumber(),
            'phone2'         => fake()->phoneNumber(),
        ];
    }
}
