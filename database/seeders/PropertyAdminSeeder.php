<?php

namespace Database\Seeders;

use App\Models\PropertyAdmin;
use Illuminate\Database\Seeder;

class PropertyAdminSeeder extends Seeder
{
    public function run(): void
    {
        PropertyAdmin::factory(10)->create();
    }
}
