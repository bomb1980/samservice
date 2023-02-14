<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PerOrgAssSeeder::class,
            PerLevelSeeder::class,
            PerOffTypeSeeder::class,
            PerPrenameSeeder::class,
            PERPERSONALSeeder::class,
        ]);
    }
}
