<?php

namespace Database\Seeders;

use App\Models\OoapMasActtype;
use Illuminate\Database\Seeder;

class ActtypeSeeder extends Seeder
{

    public function run()
    {
        OoapMasActtype::truncate();

        OoapMasActtype::insert(
            [

                ["name" => "กิจกรรมจ้างงานเร่งด่วน", "shortname" => NULL, "job_wage_maxrate" => "300", "couse_lunch_maxrate" => "120", "couse_trainer_maxrate" => "600", "couse_material_maxrate" => "2000", "other_maxrate" => NULL],
                ["name" => "กิจกรรมทักษะฝีมือแรงงาน", "shortname" => NULL, "job_wage_maxrate" => NULL, "couse_lunch_maxrate" => "120", "couse_trainer_maxrate" => "600", "couse_material_maxrate" => "2000", "other_maxrate" => NULL],
            ]
        );
    }
}
