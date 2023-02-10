<?php

namespace Database\Seeders;

use App\Models\OoapMasSubmenu1;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMenu1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasSubmenu1::truncate();

        DB::table('ooap_mas_submenu1')->insert([

            ['submenu_id' => 1, 'submenu1_name' => 'หัวข้อความพึงพอใจ', 'display_order' => 1, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 1, 'submenu1_name' => 'ระดับความพึงพอใจ', 'display_order' => 2, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 2, 'submenu1_name' => 'หัวข้อความพึงพอใจ', 'display_order' => 1, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 2, 'submenu1_name' => 'ระดับความพึงพอใจ', 'display_order' => 2, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 3, 'submenu1_name' => 'หัวข้อความพึงพอใจ', 'display_order' => 1, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 3, 'submenu1_name' => 'ระดับความพึงพอใจ', 'display_order' => 2, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 4, 'submenu1_name' => 'หัวข้อความพึงพอใจ', 'display_order' => 1, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 4, 'submenu1_name' => 'ระดับความพึงพอใจ', 'display_order' => 2, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 5, 'submenu1_name' => 'หัวข้อความพึงพอใจ', 'display_order' => 1, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 5, 'submenu1_name' => 'ระดับความพึงพอใจ', 'display_order' => 2, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 6, 'submenu1_name' => 'หัวข้อความพึงพอใจ', 'display_order' => 1, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
            ['submenu_id' => 6, 'submenu1_name' => 'ระดับความพึงพอใจ', 'display_order' => 2, 'created_by' => 'Seeder', 'route_name' => 'activity.join_activity.index'],
        ]);
    }
}
