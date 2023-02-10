<?php

namespace App\Http\Controllers\api\activity;

use App\Http\Controllers\Controller;
use App\Models\OoapMasDivision;
use App\Models\OoapTblAllocate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TranMngController extends Controller
{
    public function getTran_mng(Request $request)
    {
        $data = OoapTblAllocate::select(
            'ooap_mas_divisions.division_id',
            'ooap_mas_divisions.division_name',
            'ooap_tbl_allocate.id as allocate_id',
            'ooap_tbl_allocate.budgetyear',
            'ooap_tbl_allocate.periodno',
            'ooap_tbl_allocate.allocate_manage',
            'ooap_tbl_allocate.count_training',
            'ooap_tbl_allocate.sum_training',
            'ooap_tbl_allocate.count_urgent',
            'ooap_tbl_allocate.sum_urgent',
            'ooap_tbl_allocate.allocate_urgent',
            'ooap_tbl_allocate.allocate_training',
            'ooap_tbl_allocate.allocate_manage',
        )
            ->leftJoin('ooap_mas_divisions', 'ooap_mas_divisions.division_id', 'ooap_tbl_allocate.division_id')
            ->where('ooap_mas_divisions.in_active', '=', false);

        if ($request->fiscalyear_code) {
            $data = $data->where('ooap_tbl_allocate.budgetyear', '=', $request->fiscalyear_code);
        }

        if ($request->periodno) {
            $data = $data->where('ooap_tbl_allocate.periodno', '=', $request->periodno);
        }

        if ($request->txt_search) {
            $data = $data->where(function ($query) use ($request) {
                $query->where('ooap_mas_divisions.division_name', 'LIKE', '%' . $request->txt_search . '%');
            });
        }
        // $data = OoapMasDivision::select(
        //     'ooap_mas_divisions.division_id',
        //     'ooap_mas_divisions.division_name',
        //     'ooap_tbl_allocate.id as allocate_id',
        //     'ooap_tbl_allocate.budgetyear',
        //     'ooap_tbl_allocate.periodno',
        //     'ooap_tbl_allocate.allocate_manage',
        //     'ooap_tbl_allocate.count_training',
        //     'ooap_tbl_allocate.sum_training',
        //     'ooap_tbl_allocate.count_urgent',
        //     'ooap_tbl_allocate.sum_urgent',
        //     'ooap_tbl_allocate.allocate_urgent',
        //     'ooap_tbl_allocate.allocate_training',
        //     'ooap_tbl_allocate.allocate_manage',
        // )
        //     ->where('ooap_mas_divisions.in_active', '=', false)
        //     ->where('ooap_mas_divisions.province_id', '!=', null)
        //     ->leftJoin('ooap_tbl_allocate', 'ooap_mas_divisions.division_id', 'ooap_tbl_allocate.division_id');
        // if ($request->fiscalyear_code) {
        //     $data = $data->where('ooap_tbl_allocate.budgetyear', '=', $request->fiscalyear_code);
        // }
        // if ($request->periodno) {
        //     $data = $data->where('ooap_tbl_allocate.periodno', '=', $request->periodno);
        // }

        // $data = $data->where('ooap_mas_divisions.province_id', '!=', false);
        // $data = $data->orderby('ooap_mas_divisions.division_name', 'ad');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_training', function ($data) {
                $sum_training = $data->sum_training;
                return number_format($sum_training, 2);
            })
            ->addColumn('sum_urgent', function ($data) {
                $sum_urgent = $data->sum_urgent;
                return number_format($sum_urgent, 2);
            })
            ->addColumn('count_act', function ($data) {
                $count_act = $data->count_training + $data->count_urgent;
                return $count_act;
            })
            ->addColumn('sum_act', function ($data) {
                $sum_act = $data->sum_training + $data->sum_urgent;
                return number_format($sum_act, 2);
            })
            ->addColumn('allocate_urgent', function ($data) {
                $button = $data->allocate_urgent;
                return number_format($button, 2);
            })
            ->addColumn('allocate_training', function ($data) {
                $button = $data->allocate_training;
                return number_format($button, 2);
            })
            ->addColumn('allocate_manage', function ($data) {
                $button = $data->allocate_manage;
                return number_format($button, 2);
            })
            ->addColumn('sum_allocate', function ($data) {
                $sum_allocate = $data->allocate_urgent + $data->allocate_training + $data->allocate_manage;
                $button = $sum_allocate;
                return number_format($button, 2);
            })
            ->addColumn('edit', function ($data) {
                if ($data->allocate_id) {
                    $button = '<div class="icondemo vertical-align-middle p-2">';
                    $button .= '<a href="/activity/tran_mng/allocate/' . $data->allocate_id . '/edit" class="btn btn-primary btn-md">จัดสรร</a>';
                    $button .= '</div>';
                    return $button;
                } else {
                    $button = '<div class="icondemo vertical-align-middle p-2">';
                    $button .= '<a href="/activity/tran_mng/allocate/' . $data->division_id . '" class="btn btn-primary btn-md">จัดสรร</a>';
                    $button .= '</div>';
                    return $button;
                }
            })
            ->rawColumns(['sum_training', 'sum_urgent', 'count_act', 'sum_act', 'allocate_urgent', 'allocate_training', 'allocate_manage', 'sum_allocate', 'edit', 'del'])
            ->make(true);
    }
}
