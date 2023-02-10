<?php

namespace Database\Seeders;

use App\Models\OoapMasActivitiesType;
use Illuminate\Database\Seeder;
//ooap_mas_ocuupations_seed
class OoapMasActivitiesTypesSeeder extends Seeder
{

    public function run()
    {

        OoapMasActivitiesType::truncate();

        OoapMasActivitiesType::insert([

            ["name" => "จ้างงานเร่งด่วน", "status" => "1"],
            ["name" => "ฝึกฝีมือแรงงาน", "status" => "1"],

        ]);
    }
}
