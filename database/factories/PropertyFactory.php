<?php

namespace Database\Factories;

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
            'customer' => 'Banco de Bogotá',
            'contract' => fake()->bothify('?-#####-?'),
            'matricula_inmobiliaria' => fake()->bothify('###-#####'),
            'codigo_catastral' => fake()->bothify('##############################'),
            'escritura' => fake()->bothify('#####'),
            'neighborhood' => fake()->word(),
            'address' => fake()->address(),
            'type' => fake()->randomElements(['rural', 'urban'])[0],
            'is_horizontal' => fake()->boolean(),
            'area' => fake()->randomFloat(2, 50, 300),
            'conservation_state' => fake()->randomElements(['good', 'normal', 'bad'])[0],
            'owner' => 'Banco de Bogotá',
            'ownership_percentage' => fake()->numberBetween(0, 100),
            'acquired_at' => fake()->date(),
        ];
    }
}
