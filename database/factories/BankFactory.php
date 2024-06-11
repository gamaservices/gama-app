<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => $this->faker->company,
            'first_email'  => $this->faker->unique()->safeEmail,
            'second_email' => $this->faker->unique()->safeEmail,
            'first_phone'  => $this->faker->unique()->phoneNumber,
            'second_phone' => $this->faker->unique()->phoneNumber,
        ];
    }
}
