<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StateSeeder::class,
            CitySeeder::class,
            PropertySeeder::class,
        ]);

        $master = User::factory()
            ->create([
                'name'  => 'Master',
                'email' => 'master@gama.services',
            ]);

        Artisan::call('shield:super-admin --user=' . $master->id);

        User::factory()
            ->create([
                'name'  => 'Admin',
                'email' => 'admin@gestioncorporativa.com.co',
            ]);
    }
}
