<?php

namespace Database\Seeders;

use App\Models\OoapMasOcuupation;
use Illuminate\Database\Seeder;
//ooap_mas_ocuupations_seed
class OoapMasOcuupationSeeder extends Seeder
{

    public function run()
    {

        OoapMasOcuupation::truncate();

        OoapMasOcuupation::insert([

            ["name" => "นักเรียน-นักศึกษา"],
            ["name" => "แม่บ้าน"],
            ["name" => "รับจ้าง"],
            ["name" => "ข้าราชการ"],
            ["name" => "รัฐวิสาหกิจ"],
            ["name" => "พนักงานบริษัท"],

        ]);
    }
}
