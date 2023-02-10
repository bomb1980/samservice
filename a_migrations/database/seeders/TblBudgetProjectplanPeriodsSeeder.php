<?php

namespace Database\Seeders;

use App\Models\OoapTblBudgetProjectplanPeriod;
use Illuminate\Database\Seeder;

class TblBudgetProjectplanPeriodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OoapTblBudgetProjectplanPeriod::truncate();

        OoapTblBudgetProjectplanPeriod::insert(
            [
                ["startperioddate" => "2022-01-01 00:00:00", "endperioddate" => "2022-04-01 00:00:00", "budgetyear" => "2566", "periodno" => "1", "budgetratio" => "33", "budgetperiod" => "14850", "budgetbalance" => "0", "budget_transferamt" => "999999", "budget_manage" => "51", "budget_summanage" => "61", "budget_project" => "71", "budget_summanageproject" => "81", "budget_sumpaymentproject" => "91"],
                ["startperioddate" => "2022-06-01 00:00:00", "endperioddate" => "2022-09-01 00:00:00", "budgetyear" => "2566", "periodno" => "2", "budgetratio" => "5", "budgetperiod" => "2250", "budgetbalance" => "0", "budget_transferamt" => "0", "budget_manage" => "100", "budget_summanage" => "62", "budget_project" => "72", "budget_summanageproject" => "82", "budget_sumpaymentproject" => "92"],
                ["startperioddate" => "2022-10-01 00:00:00", "endperioddate" => "2022-12-01 00:00:00", "budgetyear" => "2566", "periodno" => "3", "budgetratio" => "34", "budgetperiod" => "15300", "budgetbalance" => "0", "budget_transferamt" => "0", "budget_manage" => "53", "budget_summanage" => "63", "budget_project" => "73", "budget_summanageproject" => "83", "budget_sumpaymentproject" => "93"],
                ["startperioddate" => "2022-11-01 00:00:00", "endperioddate" => "2022-11-01 00:00:00", "budgetyear" => "2567", "periodno" => "99", "budgetratio" => "2", "budgetperiod" => "900", "budgetbalance" => "0", "budget_transferamt" => "0", "budget_manage" => "54", "budget_summanage" => "64", "budget_project" => "74", "budget_summanageproject" => "84", "budget_sumpaymentproject" => "94"],
                ["startperioddate" => "2023-01-01 00:00:00", "endperioddate" => "2023-02-01 00:00:00", "budgetyear" => "2566", "periodno" => "4", "budgetratio" => "3", "budgetperiod" => "1350", "budgetbalance" => "0", "budget_transferamt" => "0", "budget_manage" => "55", "budget_summanage" => "65", "budget_project" => "75", "budget_summanageproject" => "85", "budget_sumpaymentproject" => "95"],
                ["startperioddate" => "2023-01-01 00:00:00", "endperioddate" => "2023-02-01 00:00:00", "budgetyear" => "2565", "periodno" => "1", "budgetratio" => "3", "budgetperiod" => "1350", "budgetbalance" => "0", "budget_transferamt" => "0", "budget_manage" => "55", "budget_summanage" => "65", "budget_project" => "75", "budget_summanageproject" => "85", "budget_sumpaymentproject" => "95"],

            ]
        );
    }
}
