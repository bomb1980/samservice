<?php

namespace Database\Seeders;

use App\Models\OoapMasCoursegroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursegroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasCoursegroup::truncate();

        DB::table('ooap_mas_coursegroup')->insert([

            ["code" => "01", "name" => "หลักสูตรการฝึกยกระดับฝีมือ", "shortname" => "...", "acttype_id" => "2"],
            ["code" => "02", "name" => "หลักสูตรการฝึกอาชีพในชนบท", "shortname" => "...", "acttype_id" => "2"],
            ["code" => "03", "name" => "หลักสูตรการฝึกอาชีพเสริม", "shortname" => "...", "acttype_id" => "2"],
            ["code" => "04", "name" => "หลักสูตรการฝึกเสริมทักษะ", "shortname" => "...", "acttype_id" => "2"],

        ]);
    }
}
