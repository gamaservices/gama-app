<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->create([
                'name'  => 'Master',
                'email' => 'master@gama.services',
            ]);

        User::factory()
            ->create([
                'name'  => 'Admin',
                'email' => 'admin@gestioncorporativa.com.co',
            ]);

        $this->call([
            StateSeeder::class,
            CitySeeder::class,
            PropertySeeder::class,
        ]);
    }
}
