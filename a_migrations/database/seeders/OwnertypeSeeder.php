<?php

namespace Database\Seeders;

use App\Models\OoapMasCourseOwnertype;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OwnertypeSeeder extends Seeder
{

    public function run()
    {
        OoapMasCourseOwnertype::truncate();

        DB::table('ooap_mas_course_ownertype')->insert([

            ["name" => "กรมพัฒนาฝีมือแรงงาน", "shortname" => "กรมพัฒฯ"],
            ["name" => "สถาบันพัฒนาฝีมือแรงงาน", "shortname" => "สพร."],
            ["name" => "สำนักงานพัฒนาฝีมือแรงงาน", "shortname" => "สนพ."],
            ["name" => "สำนักงานแรงงานจังหวัด", "shortname" => "สรจ."],
            ["name" => "สถานศึกษา", "shortname" => "สถานศึกษา"],
            ["name" => "ปราชญ์ชาวบ้าน", "shortname" => "ปราชญ์ชาวบ้าน"],
            ["name" => "วิทยากร", "shortname" => "วิทยากร"],
        ]);
    }
}
