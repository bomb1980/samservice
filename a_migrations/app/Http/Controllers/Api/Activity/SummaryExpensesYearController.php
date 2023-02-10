<?php

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapTblFybdpayment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SummaryExpensesYearController extends Controller
{
    public function getExpenses(Request $request)
    {
         $data = OoapTblBudgetProjectplanPeriod::where('in_active','=', 0)->groupBy(['budgetyear','periodno'])
               ->where([['budgetyear', '=', $request->budgetyear],['periodno', '=', $request->periodno]])
                // ->where('periodno', '=', $request->periodno)
               ->select(['budgetyear','periodno'])
               ->selectRaw("SUM(budget_manage) AS budget_manage,
               SUM(budget_summanage) AS budget_summanage,
               SUM(budget_project) AS budget_project,
               SUM(budget_summanageproject) AS budget_summanageproject,
               SUM(budget_sumpaymentproject) AS budget_sumpaymentproject");
        // if ($request->budgetyear && $request->periodno) {
        //     $data = $data->where(['budgetyear', '=', $request->budgetyear],['periodno', '=', $request->periodno]);
        // }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('budget_manage', function ($data) {
                $text = number_format($data->budget_manage,2);
                // $text = $data->budgetyear;
                return $text;
            })
            ->addColumn('budget_summanage', function ($data) {
                $text = number_format($data->budget_summanage,2);
                // $text = $data->periodno;
                return $text;
            })
            ->addColumn('budget_manage_balance', function ($data) {
                $text = number_format(($data->budget_manage)-($data->budget_summanage),2);
                return $text;
            })
            ->addColumn('budget_project', function ($data) {
                $text = number_format($data->budget_project,2);
                return $text;
            })
            ->addColumn('budget_summanageproject', function ($data) {
                $text = number_format($data->budget_summanageproject,2);
                return $text;
            })
            ->addColumn('budget_sumpaymentproject', function ($data) {
                $text = number_format($data->budget_sumpaymentproject,2);
                return $text;
            })
            ->addColumn('budget_project_balance', function ($data) {
                $text = number_format(($data->budget_project)-(($data->budget_summanageproject)+($data->budget_sumpaymentproject)),2);
                return $text;
            })
            ->rawColumns([
                'budget_manage',
                'budget_summanage',
                'budget_manage_balance',
                'budget_project',
                'budget_summanageproject',
                'budget_sumpaymentproject',
                'budget_project_balance'
            ])
            ->make(true);
    }

    public function getDetailExpenses(Request $request)
    {
         $data = OoapTblFybdpayment::select('ooap_mas_divisions.division_name',
                'ooap_mas_acttype.name',
                'ooap_tbl_activities.act_shortname',
                'ooap_tbl_fybdpayment.pay_date',
                'ooap_tbl_fybdpayment.pay_amt')
                ->leftJoin('ooap_tbl_activities','ooap_tbl_fybdpayment.refer_actnumber','=','ooap_tbl_activities.act_number')
                ->leftJoin('ooap_mas_divisions','ooap_tbl_fybdpayment.division_id','=','ooap_mas_divisions.division_id')
                ->leftJoin('ooap_mas_acttype','ooap_tbl_activities.act_acttype','=','ooap_mas_acttype.id')
                ->leftJoin('ooap_tbl_budget_projectplan_periods','ooap_tbl_fybdpayment.parent_id','=','ooap_tbl_budget_projectplan_periods.budget_id')
                ->where([['ooap_tbl_fybdpayment.fiscalyear_code', '=', $request->budgetyear],['ooap_tbl_budget_projectplan_periods.periodno', '=', $request->periodno]]);
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
            ->addColumn('act_shortname', function ($data) {
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
                'act_shortname',
                'pay_date',
                'pay_amt'
            ])
            ->make(true);
    }
}
