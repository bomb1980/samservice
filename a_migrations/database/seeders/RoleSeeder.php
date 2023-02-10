<?php

namespace Database\Seeders;

use App\Models\OoapMasRole;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run()
    {
        OoapMasRole::truncate();

        OoapMasRole::insert(
            [
                ['role_id' => 1, 'role_level_id' => 1, 'role_name' => 'ROLE_SuperAdmin', 'role_name_th' => 'AdminIT'],
                ['role_id' => 2, 'role_level_id' => 1, 'role_name' => 'ROLE_Admin', 'role_name_th' => 'เจ้าหน้าที่จัดการข้อมูลส่วนกลาง'],
                ['role_id' => 3, 'role_level_id' => 1, 'role_name' => 'ROLE_User', 'role_name_th' => 'ผู้ใช้งานทั่วไป'],
            ]
        );
    }
}
