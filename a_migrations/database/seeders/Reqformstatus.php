<?php

namespace Database\Seeders;

use App\Models\OoapMasReqformStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Reqformstatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasReqformStatus::truncate();

        DB::table('ooap_mas_reqform_status')->insert([
            ['name' => 'บันทึกร่าง', 'shortname' => 'บันทึกร่าง'],
            ['name' => 'รอพิจารณา', 'shortname' => 'รอพิจารณา'],
            ['name' => 'ผ่าน', 'shortname' => 'ผ่าน'],
            ['name' => 'ไม่ผ่าน', 'shortname' => 'ไม่ผ่าน'],
            ['name' => 'ยกเลิก', 'shortname' => 'ยกเลิก'],
        ]);
    }
}
