<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//ooap_tbl_fybdtransfer_model
class OoapTblFybdtransfer extends Model
{
    protected $table = 'ooap_tbl_fybdtransfer';

    protected $primaryKey = 'id';

    protected $fillable = [
        'fiscalyear_code', 'fybdperiod_id', 'transfer_date', 'transfer_amt', 'transfer_desp', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'parent_id'
    ];

    protected $dates = [
        'transfer_date', 'created_at', 'updated_at', 'deleted_at'
    ];

    static function getTotalByYears()
    {
        return OoapTblFybdtransfer::selectraw("
            ooap_tbl_fybdtransfer.fiscalyear_code,
            SUM(    ooap_tbl_fybdtransfer.transfer_amt ) as total_transfer_amt

        ")
        ->where('ooap_tbl_fybdtransfer.in_active', '=', false)
        ->groupby('ooap_tbl_fybdtransfer.fiscalyear_code');
    }



    static function getGroupDatas($id = NULL, $fiscalyear_code = NULL, $transfer_amt = NULL, $delete_budget_id = NULL)
    {
        if (!empty($delete_budget_id)) {
            $data = self::selectraw("
                ooap_tbl_fybdtransfer.id,
                ooap_tbl_fybdtransfer.fiscalyear_code,
                ooap_tbl_fybdtransfer.parent_id,
                ooap_tbl_budget_projectplan_periods.periodno,
                SUM(ooap_tbl_fybdtransfer.transfer_amt ) as total_transfer_amt,
                max(ooap_tbl_fybdtransfer.transfer_date) as max_transfer_date
            ")
                ->leftjoin('ooap_tbl_budget_projectplan_periods', 'ooap_tbl_fybdtransfer.parent_id', '=', 'ooap_tbl_budget_projectplan_periods.budget_id')
                ->where('ooap_tbl_fybdtransfer.in_active', '=', false);

            $data = $data->where('parent_id', '=', $delete_budget_id);

            if (!empty($id)) {
                $data = $data->where('id', '=', $id);
            }

            if (!empty($transfer_amt)) {
                $data = $data->where('transfer_amt', '>', 0);
            }

            $data = $data->groupby('ooap_tbl_fybdtransfer.fiscalyear_code')
                ->groupby('ooap_tbl_fybdtransfer.id')
                ->groupby('ooap_tbl_fybdtransfer.parent_id')
                ->groupby('ooap_tbl_budget_projectplan_periods.periodno');
        } else {
            $data = self::selectraw("
                ooap_tbl_fybdtransfer.fiscalyear_code,

                ooap_tbl_fybdtransfer.parent_id,


                ooap_tbl_budget_projectplan_periods.periodno,

                SUM(ooap_tbl_fybdtransfer.transfer_amt ) as total_transfer_amt,
                max(ooap_tbl_fybdtransfer.transfer_date) as max_transfer_date

            ")
                ->leftjoin('ooap_tbl_budget_projectplan_periods', 'ooap_tbl_fybdtransfer.parent_id', '=', 'ooap_tbl_budget_projectplan_periods.budget_id')
                ->where('ooap_tbl_fybdtransfer.in_active', '=', false);

            if (!empty($delete_budget_id)) {
                $data = $data->select('ooap_tbl_fybdtransfer.id')->where('parent_id', '=', $delete_budget_id)->groupby('ooap_tbl_fybdtransfer.id');
            }

            if (!empty($id)) {
                $data = $data->where('id', '=', $id);
            }

            if (!empty($fiscalyear_code)) {
                $data = $data->where('fiscalyear_code', '=', $fiscalyear_code);
            }

            if (!empty($transfer_amt)) {
                $data = $data->where('transfer_amt', '>', 0);
            }

            $data = $data->groupby('ooap_tbl_fybdtransfer.fiscalyear_code')
                ->groupby('ooap_tbl_fybdtransfer.parent_id')
                ->groupby('ooap_tbl_budget_projectplan_periods.periodno');
        }

        return $data->orderBy('ooap_tbl_fybdtransfer.fiscalyear_code', 'ASC')->orderBy('ooap_tbl_budget_projectplan_periods.periodno', 'asc');
    }

    static function getDatas($id = NULL, $fiscalyear_code = NULL, $transfer_amt = NULL, $fybdperiod_id = NULL)
    {
        $data = self::selectraw("
            ooap_tbl_fybdtransfer.*,
            ooap_tbl_budget_projectplan_periods.budgetperiod

        ")
            ->leftjoin('ooap_tbl_budget_projectplan_periods', 'ooap_tbl_fybdtransfer.parent_id', '=', 'ooap_tbl_budget_projectplan_periods.budget_id')
            ->where('ooap_tbl_fybdtransfer.in_active', '=', false);

        if (!empty($id)) {
            $data = $data->where('id', '=', $id);
        }

        if (!empty($fiscalyear_code)) {
            $data = $data->where('fiscalyear_code', '=', $fiscalyear_code);
        }


        if (!empty($fybdperiod_id)) {
            $data = $data->where('fybdperiod_id', '=', $fybdperiod_id);
        }



        if (!empty($transfer_amt)) {
            $data = $data->where('transfer_amt', '>', 0);
        }


        return $data->orderBy('fiscalyear_code', 'DESC')->orderBy('transfer_date', 'asc');
    }


    static function getSubDataTotals($parent_id = NULL, $skip_id = NULL)
    {

        $datas = self::selectraw('

            sum(ooap_tbl_fybdtransfer.transfer_amt) as total_transfer_amt,
            count( * ) as t
        ');

        if ($parent_id) {
            $datas = $datas->where('parent_id', '=', $parent_id);
        }

        if ($skip_id) {
            $datas = $datas->where('id', '!=', $skip_id);
        }

        if ($datas) {
            return $datas->first()->toArray();
        }

        return [
            't' => 0,
            'total_transfer_amt' => 0,
        ];
    }



    public $timestamps = true;
}
