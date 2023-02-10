<?php

namespace Database\Seeders;

use App\Models\OoapTblPopulationType;
use Illuminate\Database\Seeder;
//ooap_tbl_employees_seed
class OoapMasPopulationTypesSeeder extends Seeder
{

    public function run()
    {
        OoapTblPopulationType::truncate();

        OoapTblPopulationType::insert([

            ["population_types_name" => "วิทยากร"],
            ["population_types_name" => "ผู้เข้าร่วม"],
            ["population_types_name" => "ผู้นำชุมชน"],
        ]);
    }
}
