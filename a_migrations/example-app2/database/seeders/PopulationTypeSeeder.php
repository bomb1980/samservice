<?php

namespace Database\Seeders;

use App\Models\OoapMasPopulatioType;
use Illuminate\Database\Seeder;

class PopulationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasPopulatioType::truncate();

        OoapMasPopulatioType::insert([

            ["population_types_name" => "วิทยากร"],
            ["population_types_name" => "ผู้เข้าร่วม"],
            ["population_types_name" => "ผู้นำชุมชน"],
        ]);
    }
}
