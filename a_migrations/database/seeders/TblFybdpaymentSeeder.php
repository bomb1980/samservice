<?php

namespace Database\Seeders;

use App\Models\OoapTblFybdpayment;
use Illuminate\Database\Seeder;

class TblFybdpaymentSeeder extends Seeder
{
    public function run()
    {
        OoapTblFybdpayment::truncate();

        OoapTblFybdpayment::insert([
            ["parent_id" => "1", "payment_group" => "2", "division_id" => "1", "refer_actnumber" => "RF-6510-0001", "fiscalyear_code" => "2565", "pay_date" => "2022-10-18", "pay_amt" => "223322.00", "pay_manageamt" => "100.00", "pay_urgentamt" => "100.00", "pay_trainamt" => "0.00", "pay_name" => "dsdsddd", "pay_desp" => "sdsddssdsdsdsddds", "status" => "0"],
            ["parent_id" => "1", "payment_group" => "1", "division_id" => "0", "refer_actnumber" => "0", "fiscalyear_code" => "2565", "pay_date" => "2022-10-18", "pay_amt" => "223322.00", "pay_manageamt" => "200.00", "pay_urgentamt" => "0.00", "pay_trainamt" => "150.00", "pay_name" => "dsdsddd", "pay_desp" => "sdsddssdsdsdsddds", "status" => "0"],
            ["parent_id" => "1", "payment_group" => "1", "division_id" => "0", "refer_actnumber" => "0", "fiscalyear_code" => "2565", "pay_date" => "2022-10-18", "pay_amt" => "223322.00", "pay_manageamt" => "200.00", "pay_urgentamt" => "0.00", "pay_trainamt" => "200.00", "pay_name" => "dsdsddd", "pay_desp" => "sdsddssdsdsdsddds", "status" => "0"],
            ["parent_id" => "1", "payment_group" => "2", "division_id" => "4", "refer_actnumber" => "RF-6610-0001", "fiscalyear_code" => "2566", "pay_date" => "2022-10-18", "pay_amt" => "223322.00", "pay_manageamt" => "200.00", "pay_urgentamt" => "0.00", "pay_trainamt" => "200.00", "pay_name" => "dsdsddd", "pay_desp" => "sdsddssdsdsdsddds", "status" => "0"],
            ["parent_id" => "1", "payment_group" => "2", "division_id" => "5", "refer_actnumber" => "RF-6610-0002", "fiscalyear_code" => "2566", "pay_date" => "2022-10-18", "pay_amt" => "223322.00", "pay_manageamt" => "200.00", "pay_urgentamt" => "0.00", "pay_trainamt" => "200.00", "pay_name" => "dsdsddd", "pay_desp" => "sdsddssdsdsdsddds", "status" => "0"],
            ["parent_id" => "1", "payment_group" => "2", "division_id" => "6", "refer_actnumber" => "RF-6511-0001", "fiscalyear_code" => "2567", "pay_date" => "2022-10-18", "pay_amt" => "223322.00", "pay_manageamt" => "200.00", "pay_urgentamt" => "0.00", "pay_trainamt" => "200.00", "pay_name" => "dsdsddd", "pay_desp" => "sdsddssdsdsdsddds", "status" => "0"],
        ]);
    }
}
