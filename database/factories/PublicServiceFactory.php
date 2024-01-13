<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublicService>
 */
class PublicServiceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company' => 'EPM',
            'type' => fake()->randomElements(['water', 'electricity', 'gas'])[0],
            'is_domiciled' => fake()->boolean(),
        ];
    }
}
