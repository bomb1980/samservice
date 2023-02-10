<?php

namespace Database\Seeders;

use App\Models\OoapTblFybdtransfer;
use Illuminate\Database\Seeder;

//ooap_tbl_fybdtransfer_seed
class TblFybdtransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapTblFybdtransfer::truncate();

        OoapTblFybdtransfer::insert([
            ["fiscalyear_code" => "2564", "fybdperiod_id" => "1", "transfer_date" => NULL, "transfer_amt" => "4545.00", "transfer_desp" => NULL, "parent_id" => "1"],
            ["fiscalyear_code" => "2564", "fybdperiod_id" => "1", "transfer_date" => NULL, "transfer_amt" => "4545.00", "transfer_desp" => NULL, "parent_id" => "2"],

        ]);
    }
}
