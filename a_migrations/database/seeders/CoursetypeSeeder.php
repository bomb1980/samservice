<?php

namespace Database\Seeders;

use App\Models\OoapMasCoursetype;
use Illuminate\Database\Seeder;

class CoursetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasCoursetype::truncate();

        OoapMasCoursetype::insert([

            ["code" => "001", "name" => "ประเภทรถจักรยานยนต์", "shortname" => NULL, "coursegroup_id" => "1", "coursesubgroup_id" => "1"],
            ["code" => "002", "name" => "ประเภทเครื่องยนต์หนักและเครื่องยนต์การเกษตร", "shortname" => NULL, "coursegroup_id" => "1", "coursesubgroup_id" => "1"],
            ["code" => "003", "name" => "ประเภทกลุ่มก่อสร้าง", "shortname" => NULL, "coursegroup_id" => "1", "coursesubgroup_id" => "5"],
            ["code" => "004", "name" => "ประเภทกลุ่มอะลูมิเนียม", "shortname" => NULL, "coursegroup_id" => "1", "coursesubgroup_id" => "5"],
            ["code" => "005", "name" => "ประเภทกลุ่มอาชีพอื่นๆ", "shortname" => NULL, "coursegroup_id" => "1", "coursesubgroup_id" => "5"],
        ]);
    }
}
