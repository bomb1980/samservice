<?php

namespace Database\Seeders;

use App\Models\OoapMasCoursesubgroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesubgroupSeeder extends Seeder
{

    public function run()
    {
        OoapMasCoursesubgroup::truncate();

        DB::table('ooap_mas_coursesubgroup')->insert([

            ["code" => "01", "name" => "กลุ่มอาชีพช่างเครื่องกล", "shortname" => "ช่างเครื่องกล", "acttype_id" => "2", "coursegroup_id" => "1"],
            ["code" => "02", "name" => "กลุ่มอาชีพช่างไฟฟ้า", "shortname" => "ช่างไฟฟ้า", "acttype_id" => "2", "coursegroup_id" => "1"],
            ["code" => "03", "name" => "กลุ่มอาชีพช่างเครื่องทำความเย็นและเครื่องปรับอากาศ", "shortname" => "ช่างแอร์", "acttype_id" => "2", "coursegroup_id" => "1"],
            ["code" => "04", "name" => "กลุ่มอาชีพช่างอิเล็กทรอนิกส์", "shortname" => "ช่างอิเล็กฯ", "acttype_id" => "2", "coursegroup_id" => "1"],
            ["code" => "05", "name" => "กลุ่มอาชีพช่างก่อสร้าง", "shortname" => "ช่างก่อสร้าง", "acttype_id" => "2", "coursegroup_id" => "1"],
            ["code" => "06", "name" => "กลุ่มอาชีพในชนบท", "shortname" => "อาชีพในชนบท", "acttype_id" => "2", "coursegroup_id" => "2"],
            ["code" => "07", "name" => "กลุ่มอาชีพเสริม", "shortname" => "อาชีพเสริม", "acttype_id" => "2", "coursegroup_id" => "3"],
            ["code" => "08", "name" => "กลุ่มอาชีพช่างอุตสาหกรรมศิลป์", "shortname" => "ช่างอุตสาหกรรมศิลป์", "acttype_id" => "2", "coursegroup_id" => "4"],
            ["code" => "09", "name" => "กลุ่มอาชีพธุรกิจบริการ", "shortname" => "ธุรกิจบริการ", "acttype_id" => "2", "coursegroup_id" => "4"],

       ]);
    }
}
