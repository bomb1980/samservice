<?php

namespace Database\Seeders;

use App\Models\OoapTblAllocate;
use Illuminate\Database\Seeder;

class TblAllocateSeeder extends Seeder
{

    public function run()
    {
        OoapTblAllocate::truncate();

        OoapTblAllocate::insert([


            ["budgetyear" => "2570", "periodno" => "1", "division_id" => "58", "division_name" => "สำนักงานแรงงานจังหวัดเชียงราย", "count_urgent" => "4", "sum_urgent" => "400000", "count_training" => "4", "sum_training" => "40000", "allocate_urgent" => NULL, "allocate_training" => NULL, "allocate_manage" => "100000"],
            ["budgetyear" => "2566", "periodno" => "1", "division_id" => "58", "division_name" => "สำนักงานแรงงานจังหวัดเชียงราย", "count_urgent" => "1", "sum_urgent" => "200000", "count_training" => "1", "sum_training" => "20000", "allocate_urgent" => NULL, "allocate_training" => NULL, "allocate_manage" => "70000"],
        ]);
    }
}
