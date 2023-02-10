<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//ooap_tbl_fiscalyear_req_periods_model
class OoapTblFiscalyearReqPeriod extends Model
{
    protected $table = 'ooap_tbl_fiscalyear_req_periods';

    protected $primaryKey = 'id';

    protected $fillable = [
        'parent_id', 'req_startdate', 'req_enddate', 'status', 'in_active', 'remember_token', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];


    static function canRequest($current_date = NULL)
    {
        // $current_date = '2022-01-25';
        if (empty($current_date)) {

            $current_date = now();
        }
        $data = OoapTblFiscalyear::select('*')
            ->where('req_startdate', '<=', $current_date)
            ->where('req_enddate', '>=', $current_date)->first();

        if (!$data) {

            return 'close';
        }

        if ( auth()->user()->emp_type != 2 ) {
            return 'close';

        }

        return 'open';
    }

    static function getDatas($id = NULL, $parent_id = NULL)
    {

        $data = self::selectraw("
            ooap_tbl_fiscalyear_req_periods.*,
            ooap_tbl_fiscalyear.startdate,
            ooap_tbl_fiscalyear.enddate

        ")
            ->leftjoin('ooap_tbl_fiscalyear', 'ooap_tbl_fiscalyear_req_periods.parent_id', '=', 'ooap_tbl_fiscalyear.id')

            ->where('ooap_tbl_fiscalyear_req_periods.in_active', '=', false);

        if (!empty($id)) {
            $data = $data->where('ooap_tbl_fiscalyear_req_periods.id', '=', $id);
        }

        if (!empty($parent_id)) {
            $data = $data->where('ooap_tbl_fiscalyear_req_periods.parent_id', '=', $parent_id);
        }

        return $data;
    }

    static function getNextRequestTime($current_date = NULL)
    {

        if (empty($current_date)) {

            $current_date = now();
        }

        $data = self::select('*')->where('req_startdate', '>', $current_date)->orderby('req_startdate', 'asc')->first();

        if ($data) {

            return '<br><h2 class="text-center">ท่านสามารถยื่นเรื่องครั้งต่อไปได้ในวันที่ <span style="color: green;">' . datetimeToThaiDatetime($data->req_startdate, 'd M Y') . '<span></h2>';
        }

        return false;
    }



    static function setSubDatas($parent_id = NULL)
    {
        $sub_datas = self::selectraw("
            ooap_tbl_fiscalyear_req_periods.*,

            9999 as total_transfer_amt

        ");


        if (!empty($parent_id)) {

            $sub_datas =  $sub_datas->where('parent_id', '=', $parent_id);
        }

        $sub_datas =  $sub_datas->orderby('req_startdate', 'asc')->get()->toArray();

        foreach ($sub_datas as $ka => $va) {

            $sub_datas[$ka]['periodno'] = $ka + 1;
            $sub_datas[$ka]['req_startdate'] = datetoview($va['req_startdate']);
            $sub_datas[$ka]['req_enddate'] = datetoview($va['req_enddate']);
        }

        return $sub_datas;
    }

    static function getYearDatas()
    {
        return self::select('parent_id')->where('in_active', '=', false)->where('budget_manage', '>', 0)->groupby('parent_id');
    }

    static function getparent_idPeriodnoList($skip_id = NULL)
    {
        if (!empty($skip_id)) {

            $dd = self::selectraw("
                parent_id,
                periodno
            ")
                ->where('in_active', '=', false)
                ->whereraw("budgetperiod > NVL( (SELECT sum(transfer_amt) FROM ooap_tbl_fybdtransfer WHERE parent_id = ooap_tbl_fiscalyear_req_periods.budget_id AND id != ? ), 0)", [$skip_id])
                ->groupby('parent_id', 'periodno')
                ->orderby('parent_id', 'asc')
                ->orderby('periodno', 'asc');
        } else {

            $dd = self::selectraw("
                parent_id,
                periodno
            ")
                ->where('in_active', '=', false)
                ->whereraw("budgetperiod > NVL( (SELECT sum(transfer_amt) FROM ooap_tbl_fybdtransfer WHERE parent_id = ooap_tbl_fiscalyear_req_periods.budget_id), 0)")
                ->groupby('parent_id', 'periodno')
                ->orderby('parent_id', 'asc')
                ->orderby('periodno', 'asc');
        }

        return $dd;
    }




    static function getSubDataTotals($parent_id = NULL)
    {

        $datas = self::selectraw('

            sum(ooap_tbl_fiscalyear_req_periods.budgetratio) as total_budgetratio,
            sum(ooap_tbl_fiscalyear_req_periods.budgetperiod) as total_budgetperiod,
            count( * ) as t
        ')->where('parent_id', $parent_id)
            ->groupby('parent_id')
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



    static function getSubDataTotal($parent_id = NULL, $budget_id = NULL, $newVal = [])
    {
        $datas =  self::selectraw('

            sum(ooap_tbl_fiscalyear_req_periods.budgetratio) as total_budgetratio
        ')->where('parent_id', $parent_id);

        if (!empty($budget_id)) {

            $datas = $datas->where('ooap_tbl_fiscalyear_req_periods.budget_id', '!=', $budget_id);
        }

        if ($datas) {

            return $datas->first()->total_budgetratio + $newVal['budgetratio'];
        }

        return $newVal['budgetratio'];
    }
}
