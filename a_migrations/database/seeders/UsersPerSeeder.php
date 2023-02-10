<?php

namespace Database\Seeders;

use App\Models\OoapMasUserPer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersPerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapMasUserPer::truncate();

        DB::table('ooap_mas_user_per')->insert([
            ['user_id' => '1', 'submenu_id' => '1', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '2', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '3', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '4', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '5', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '6', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '7', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '8', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '9', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '10', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '11', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '12', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '13', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '14', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '15', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '16', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '17', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '18', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '19', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '20', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '21', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '22', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '23', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '24', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '25', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '26', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '27', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '28', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '29', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '30', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '31', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '32', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '33', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '34', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
            ['user_id' => '1', 'submenu_id' => '35', 'view_data' => '1', 'insert_data' => '1', 'update_data' => '1', 'delete_data' => '1', 'in_active' => '0', 'created_by' => 'seeder', 'updated_by' => null],
        ]);
    }
}
