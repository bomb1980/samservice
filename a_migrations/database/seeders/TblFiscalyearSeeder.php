<?php

namespace Database\Seeders;

use App\Models\OoapTblFiscalyear;
use Illuminate\Database\Seeder;

class TblFiscalyearSeeder extends Seeder
{
    //ooap_tbl_fiscalyear
    public function run()
    {
        OoapTblFiscalyear::truncate();

        OoapTblFiscalyear::insert([
            ["fiscalyear_code" => "2564", "centerpayment_amt" => "0.00", "urgentpayment_amt" => "0.00", "trainingpayment_amt" => "0.00", "req_startdate" => "2021-10-06", "req_enddate" => "2022-10-31", "req_urgentamt" => "0.00", "req_skillamt" => "0.00", "req_sumreqamt" => "0.00", "req_amt" => "45000.00", "startdate" => "2023-10-01", "enddate" => "2024-09-30", "req_status" => "1", "budget_amt" => "45000.00", "transfer_amt" => "15000.00", "refund_amt" => "0.00", "regionperiod_amt" => "778.00", "regionpay_amt" => "55.00", "ostbudget_amt" => "0.00", "centerbudget_amt" => "12000.00", "regionbudget_amt" => "30000.00"],
            ["fiscalyear_code" => "2565", "centerpayment_amt" => "5.00", "urgentpayment_amt" => "5.00", "trainingpayment_amt" => "5.00", "req_startdate" => "2021-10-06", "req_enddate" => "2025-10-21", "req_urgentamt" => "38811150.00", "req_skillamt" => "38811150.00", "req_sumreqamt" => "77622300.00", "req_amt" => "44445454.00", "startdate" => "2022-10-01", "enddate" => "2023-09-30", "req_status" => "1", "budget_amt" => "99.00", "transfer_amt" => "0.00", "refund_amt" => "0.00", "regionperiod_amt" => "0.00", "regionpay_amt" => "0.00", "ostbudget_amt" => "0.00", "centerbudget_amt" => "0.00", "regionbudget_amt" => "0.00"],
            ["fiscalyear_code" => "2566", "centerpayment_amt" => "0.00", "urgentpayment_amt" => "0.00", "trainingpayment_amt" => "0.00", "req_startdate" => "2021-10-06", "req_enddate" => "2021-10-14", "req_urgentamt" => "0.00", "req_skillamt" => "0.00", "req_sumreqamt" => "0.00", "req_amt" => "0.00", "startdate" => "2024-10-01", "enddate" => "2025-09-30", "req_status" => "0", "budget_amt" => "0.00", "transfer_amt" => "0.00", "refund_amt" => "0.00", "regionperiod_amt" => "0.00", "regionpay_amt" => "0.00", "ostbudget_amt" => "0.00", "centerbudget_amt" => "0.00", "regionbudget_amt" => "0.00"],
        ]);
    }
}
