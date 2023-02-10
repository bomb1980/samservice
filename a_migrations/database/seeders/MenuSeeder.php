<?php

namespace Database\Seeders;

use App\Models\OoapMasMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasMenu::truncate();
        DB::table('ooap_mas_menu')->insert([
            // ['menu_id' => 1, 'menu_name' => 'จัดการข้อมูลแบบฟอร์มประเมิน', 'menu_icon' => 'site-menu-icon wb-settings', 'activepage_name' => 'estimate', 'display_order' => 1, 'created_by' => 'seeder'],
            ['menu_id' => 1, 'menu_name' => 'จัดการข้อมูลกลาง', 'menu_icon' => 'site-menu-icon wb-settings', 'activepage_name' => 'master', 'display_order' => 2, 'created_by' => 'seeder'],
            ['menu_id' => 2, 'menu_name' => 'ข้อมูลคำขอรับการจัดสรรงบประมาณ', 'menu_icon' => 'site-menu-icon wb-layout', 'activepage_name' => 'request', 'display_order' => 3, 'created_by' => 'seeder'],
            ['menu_id' => 3, 'menu_name' => 'บริหารงบประมาณ', 'menu_icon' => 'site-menu-icon wb-file', 'activepage_name' => 'manage', 'display_order' => 4, 'created_by' => 'seeder'],
            ['menu_id' => 4, 'menu_name' => 'บริหารกิจกรรม', 'menu_icon' => 'site-menu-icon wb-file', 'activepage_name' => 'activity', 'display_order' => 5, 'created_by' => 'seeder'],
            ['menu_id' => 5, 'menu_name' => 'บันทึกผลการดำเนินงาน', 'menu_icon' => 'site-menu-icon wb-file', 'activepage_name' => 'result', 'display_order' => 6, 'created_by' => 'seeder'],
            ['menu_id' => 6, 'menu_name' => 'รายงาน', 'menu_icon' => 'site-menu-icon wb-file', 'activepage_name' => 'report', 'display_order' => 7, 'created_by' => 'seeder'],
            ['menu_id' => 7, 'menu_name' => 'สิทธิ์การใช้งานระบบ', 'menu_icon' => 'site-menu-icon wb-file', 'activepage_name' => 'permission', 'display_order' => 7, 'created_by' => 'seeder'],

        ]);
    }
}
