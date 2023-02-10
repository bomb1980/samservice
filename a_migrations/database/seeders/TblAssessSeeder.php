<?php

namespace Database\Seeders;

use App\Models\OoapTblAssess;
use Illuminate\Database\Seeder;
//ooap_tbl_assess_seed
class TblAssessSeeder extends Seeder
{
    public function run()
    {

        OoapTblAssess::truncate();

        OoapTblAssess::insert([

            ["assess_templateno" => "221108-020542", "assess_type" => "R", "assess_hdr" => 'ด้านวิทยากร', "assess_description" => 'การใช้เวลาในการอธิบายได้เหมาะสม', "assess_group" => "P"],
            ["assess_templateno" => "221108-020542", "assess_type" => "R", "assess_hdr" => 'ด้านวิทยากร', "assess_description" => 'ความเหมาะสมของเนื้อหาที่ใช้', "assess_group" => "P"],
            ["assess_templateno" => "221108-020542", "assess_type" => "R", "assess_hdr" => 'ด้านวิทยากร', "assess_description" => 'ความน่าสนใจของการนำเสนอเนื้อหา', "assess_group" => "P"],
            ["assess_templateno" => "221108-020542", "assess_type" => "O", "assess_hdr" => NULL, "assess_description" => 'ข้อเสนอแนะ', "assess_group" => "P"],

        ]);
    }
}
