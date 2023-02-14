<?php

namespace Database\Seeders;

use App\Models\per_off_type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerOffTypeSeeder extends Seeder
{

    public function run()
    {

        per_off_type::truncate();

        if( DB::connection()->getDatabaseName() == 'bombtest2') {

            return ;
        }

        per_off_type::insert([
            ["ot_code" => "01 ", "ot_name" => "ข้าราชการพลเรือนสามัญ", "ot_active" => "1", "update_user" => "1", "update_date" => "2001-07-09 12:00:00", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "02 ", "ot_name" => "ข้าราชการพลเรือนในพระองค์", "ot_active" => "1", "update_user" => "1", "update_date" => "2003-07-30 13:48:15", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "03 ", "ot_name" => "ข้าราชการประจำต่างประเทศพิเศษ", "ot_active" => "1", "update_user" => "1", "update_date" => "2003-07-30 13:48:40", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "04 ", "ot_name" => "ข้าราชการรัฐสภา", "ot_active" => "1", "update_user" => "1", "update_date" => "2003-07-30 13:48:57", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "05 ", "ot_name" => "ข้าราชการตุลาการ", "ot_active" => "1", "update_user" => "1", "update_date" => "2003-07-30 13:49:08", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "06 ", "ot_name" => "ข้าราชการสังกัดกรุงเทพมหานคร", "ot_active" => "1", "update_user" => "1", "update_date" => "2003-07-30 13:49:37", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "07 ", "ot_name" => "ลูกจ้างประจำ", "ot_active" => "1", "update_user" => "1", "update_date" => "2003-07-30 13:50:23", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "08 ", "ot_name" => "พนักงานราชการทั่วไป", "ot_active" => "1", "update_user" => "1", "update_date" => "2007-05-11 13:22:07", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "09 ", "ot_name" => "พนักงานราชการพิเศษ", "ot_active" => "1", "update_user" => "1", "update_date" => "2007-05-11 13:22:07", "ot_seq_no" => NULL, "ot_othername" => NULL],
            ["ot_code" => "10 ", "ot_name" => "พนักงานราชการเฉพาะกิจ", "ot_active" => "1", "update_user" => "1", "update_date" => "2021-08-16 12:33:38", "ot_seq_no" => NULL, "ot_othername" => NULL],


        ]);
    }
}
