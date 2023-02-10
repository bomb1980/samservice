<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


//ooap_tbl_budget_projectplan_periods_model
class OoapTblBudgetProjectplanPeriod extends Model
{
    protected $table = 'ooap_tbl_budget_projectplan_periods';

    protected $primaryKey = 'budget_id';

    protected $fillable = [
        'startperioddate', 'endperioddate', 'budget_transferdate', 'budgetyear', 'periodno', 'budgetratio', 'budgetperiod', 'budgetbalance', 'budget_transferamt', 'budget_manage', 'budget_summanage', 'budget_project', 'budget_summanageproject', 'budget_sumpaymentproject', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'allocate_manage'

    ];



    static function getBudgetYearPeriodnoList($skip_id = NULL)
    {
        if (!empty($skip_id)) {

            $dd = self::selectraw("
                budgetyear,
                periodno
            ")
                ->where('in_active', '=', false)
                ->whereraw("budgetperiod > NVL( (SELECT sum(transfer_amt) FROM ooap_tbl_fybdtransfer WHERE parent_id = ooap_tbl_budget_projectplan_periods.budget_id AND id != ? ), 0)", [$skip_id])
                ->groupby('budgetyear', 'periodno')
                ->orderby('budgetyear', 'asc')
                ->orderby('periodno', 'asc');
        } else {

            $dd = self::selectraw("
                budgetyear,
                periodno
            ")
                ->where('in_active', '=', false)
                ->whereraw("budgetperiod > NVL( (SELECT sum(transfer_amt) FROM ooap_tbl_fybdtransfer WHERE parent_id = ooap_tbl_budget_projectplan_periods.budget_id), 0)")
                ->groupby('budgetyear', 'periodno')
                ->orderby('budgetyear', 'asc')
                ->orderby('periodno', 'asc');
        }

        return $dd;
    }



    static function getSubDataTotals_($budgetyear = NULL, $skip_id = NULL)
    {
        //SELECT `budgetyear`, sum(budget_manage ) FROM `ooap_tbl_budget_projectplan_periods` GROUP by `budgetyear`;
        $datas = self::selectraw('

            ooap_tbl_budget_projectplan_periods.budgetyear,
            sum(ooap_tbl_budget_projectplan_periods.budget_manage) as total_budget_manage,
            sum(ooap_tbl_budget_projectplan_periods.budgetratio) as total_budgetratio,
            sum(ooap_tbl_budget_projectplan_periods.budgetperiod) as total_budgetperiod,
            count( * ) as t
        ');

        if (!empty($budgetyear)) {

            $datas = $datas->where('budgetyear', '=', $budgetyear);
        }

        if (!empty($skip_id)) {

            $datas = $datas->where('budget_id', '!=', $skip_id);
        }
        $datas = $datas->groupby('budgetyear')->first();

        if ($datas) {
            return $datas->toArray();
        }

        return [
            'budgetyear' => 0,
            't' => 0,
            'total_budget_manage' => 0,
            'total_budgetratio' => 0,
            'total_budgetperiod' => 0,
        ];
    }



    static function getDatas($id = NULL, $budgetyear = NULL, $periodno = NULL, $budget_manage = false)
    {

        $data = self::selectraw(
            "ooap_tbl_budget_projectplan_periods.*,
            (
                SELECT
                    allocate_manage + allocate_urgent + allocate_training
                FROM ooap_tbl_allocate
                WHERE budgetyear = ooap_tbl_budget_projectplan_periods.budgetyear
                AND periodno = ooap_tbl_budget_projectplan_periods.periodno
                AND division_id = ?
            ) as allocate_manage,

            'dsads' as region,
            'province' as province,
            'name' as name,
            99 as t,
            878878 as total_people_checkin",
            [auth()->user()->division_id]
        )->where('in_active', '=', false);

        if (!empty($id)) {
            $data = $data->where('budget_id', '=', $id);
        }

        if (!empty($budgetyear)) {
            $data = $data->where('budgetyear', '=', $budgetyear);
        }

        if (!empty($periodno)) {
            $data = $data->where('periodno', '=', $periodno);
        }

        if ($budget_manage == true) {
            $data = $data->where('budget_manage', '>', 0);
        }

        // $data =

        return $data
            ->orderBy('budgetyear', 'asc')
            ->orderBy('periodno', 'asc');
    }



    static function setSubDatas($budgetyear = NULL)
    {
        $sub_datas = self::selectraw("
            ooap_tbl_budget_projectplan_periods.*,

            ( SELECT SUM( transfer_amt ) FROM ooap_tbl_fybdtransfer WHERE parent_id = ooap_tbl_budget_projectplan_periods.budget_id ) as total_transfer_amt

        ");


        if (!empty($budgetyear)) {

            $sub_datas =  $sub_datas->where('budgetyear', '=', $budgetyear);

            OoapTblFiscalyear::where('fiscalyear_code', '=', $budgetyear)->update(['status' => 1]);
        }

        $sub_datas =  $sub_datas->orderby('startperioddate', 'asc')->get()->toArray();


        foreach ($sub_datas as $ka => $va) {

            self::where('budget_id', '=', $va['budget_id'])->update(['periodno' => ($ka + 1)]);
            $sub_datas[$ka]['periodno'] = $ka + 1;
            $sub_datas[$ka]['startperioddate'] = dateToMonth($va['startperioddate']);
            $sub_datas[$ka]['endperioddate'] = dateToMonth($va['endperioddate']);
            $sub_datas[$ka]['budget_transferdate'] = empty($va['budget_transferdate']) ? NULL : datetimeToDateThai($va['budget_transferdate']);


            if (!empty($budgetyear)) {

                OoapTblFiscalyear::where('fiscalyear_code', '=', $budgetyear)->update(['status' => 3]);
            }
        }

        return $sub_datas;
    }

    static function getSubDataTotals($budgetyear = NULL)
    {

        $datas = self::selectraw('

            sum(ooap_tbl_budget_projectplan_periods.budgetratio) as total_budgetratio,
            sum(ooap_tbl_budget_projectplan_periods.budgetperiod) as total_budgetperiod,
            count( * ) as t
        ')->where('budgetyear', $budgetyear)
            ->groupby('budgetyear')
            ->first();

        if ($datas) {
            return $datas->toArray();
        }

        return [
            't' => 0,
            'total_budgetratio' => 0,
            'total_budgetperiod' => 0,
        ];
    }


}
