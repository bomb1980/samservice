<?php

namespace Database\Seeders;

use App\Models\OoapMasBuildingtype;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasBuildingtype::truncate();

        DB::table('ooap_mas_buildingtypes')->insert([
            ["name" => "แหล่งน้ำ", "shortname" => "...", "acttype_id" => "1"],
            ["name" => "แนวกันไฟป่า", "shortname" => "...", "acttype_id" => "1"],
            ["name" => "วัด", "shortname" => "...", "acttype_id" => "1"],
            ["name" => "โรงเรียน", "shortname" => "...", "acttype_id" => "1"],
            ["name" => "มัสยิด", "shortname" => "...", "acttype_id" => "1"],
            ["name" => "อื่นๆ", "shortname" => "...", "acttype_id" => "1"],
        ]);
    }
}
