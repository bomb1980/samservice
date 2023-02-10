<?php

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use App\Models\OoapTblFybdpayment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SummaryExpensesController extends Controller
{
    public function getDetailExpenses(Request $request)
    {
         $data = OoapTblFybdpayment::select('ooap_mas_divisions.division_name',
                'ooap_mas_acttype.name',
                'ooap_tbl_requests.req_shortname',
                'ooap_tbl_fybdpayment.pay_date',
                'ooap_tbl_fybdpayment.pay_amt')
                ->leftJoin('ooap_tbl_requests','ooap_tbl_fybdpayment.refer_actnumber','=','ooap_tbl_requests.req_actnumber')
                ->leftJoin('ooap_mas_divisions','ooap_tbl_fybdpayment.division_id','=','ooap_mas_divisions.division_id')
                ->leftJoin('ooap_mas_acttype','ooap_tbl_requests.req_acttype','=','ooap_mas_acttype.id');
                // ->where('ooap_tbl_fybdpayment.in_active','=', 0);
                // ->where([['ooap_tbl_fybdpayment.fiscalyear_code', '=', $request->budgetyear]]);
        // if ($request->budgetyear && $request->periodno) {
        //     $data = $data->where(['budgetyear', '=', $request->budgetyear],['periodno', '=', $request->periodno]);
        // }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('division_name', function ($data) {
                $text = $data->division_name;
                // $text = $data->budgetyear;
                return $text;
            })
            ->addColumn('name', function ($data) {
                $text = $data->name;
                return $text;
            })
            ->addColumn('req_shortname', function ($data) {
                $text = $data->req_shortname;
                return $text;
            })
            ->addColumn('pay_date', function ($data) {
                $text = datetoview($data->pay_date);
                return $text;
            })
            ->addColumn('pay_amt', function ($data) {
                $text = number_format($data->pay_amt,2);
                return $text;
            })
            ->rawColumns([
                'division_name',
                'name',
                'req_shortname',
                'pay_date',
                'pay_amt'
            ])
            ->make(true);
    }
}
