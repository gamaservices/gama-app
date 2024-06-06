<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotaryOffice>
 */
class NotaryOfficeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = collect(City::pluck('id'));

        return [
            'number'  => random_int(1, 8),
            'city_id' => $cities->random(),
        ];
    }
}
