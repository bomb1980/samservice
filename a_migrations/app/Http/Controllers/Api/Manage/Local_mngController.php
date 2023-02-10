<?php

namespace App\Http\Controllers\Api\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OoapTblBudgetProjectplanPeriod;
use App\Models\OoapMasDivision;
use App\Models\OoapTblAllocate;
use App\Models\OoapTblActivities;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\DB;

class Local_mngController extends Controller
{
    public function getRequest(Request $request)
    {
        $data = OoapMasDivision::where('ooap_mas_divisions.in_active','=', 0)
            ->where('ooap_mas_divisions.division_name', 'like', 'สำนักงานแรงงานจังหวัด%')
            ->leftJoin('ooap_tbl_activities', function($join) use($request){
                $join->on('ooap_tbl_activities.act_div', '=', 'ooap_mas_divisions.division_id');
                $join->on('ooap_tbl_activities.in_active', '=', DB::raw('0'));
                $join->on('ooap_tbl_activities.act_year', '=', DB::raw($request->year));
                $join->on('ooap_tbl_activities.act_periodno', '=', DB::raw($request->peri));
            })
            ->leftJoin('ooap_tbl_allocate', function($join) use($request){
                $join->on('ooap_tbl_allocate.division_id', '=', 'ooap_mas_divisions.division_id');
                $join->on('ooap_tbl_allocate.in_active', '=', DB::raw('0'));
                $join->on('ooap_tbl_allocate.budgetyear', '=', DB::raw($request->year));
                $join->on('ooap_tbl_allocate.periodno', '=', DB::raw($request->peri));
            })
            ->select(["ooap_tbl_allocate.count_urgent", "ooap_tbl_allocate.sum_urgent"])
            ->select(["ooap_tbl_allocate.count_training", "ooap_tbl_allocate.sum_training","ooap_tbl_allocate.allocate_urgent", "ooap_tbl_allocate.allocate_training", "ooap_tbl_allocate.allocate_manage", "ooap_mas_divisions.division_id", "ooap_mas_divisions.division_name"])
            ->groupBy([
                'ooap_mas_divisions.division_id',
                'ooap_mas_divisions.division_name',
                "ooap_tbl_allocate.count_training", "ooap_tbl_allocate.sum_training","ooap_tbl_allocate.allocate_urgent", "ooap_tbl_allocate.allocate_training", "ooap_tbl_allocate.allocate_manage", "ooap_mas_divisions.division_id", "ooap_mas_divisions.division_name"
            ])
            ->selectRaw("SUM(ooap_tbl_activities.act_amount) AS sum_amt, COUNT(ooap_tbl_activities.act_amount) as count_rec,
            SUM(CASE WHEN ooap_tbl_activities.act_acttype = '1' THEN ooap_tbl_activities.act_amount ELSE 0 end) AS sum_amt1, COUNT(CASE WHEN ooap_tbl_activities.act_acttype = '1' THEN 1 end) as count_rec1,
            SUM(CASE WHEN ooap_tbl_activities.act_acttype = '2' THEN ooap_tbl_activities.act_amount ELSE 0 end) AS sum_amt2, COUNT(CASE WHEN ooap_tbl_activities.act_acttype = '2' THEN 1 end) as count_rec2");
            // ->orderBy('division_id','asc');

        // dd($data->toSql());
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('count_urgent', function ($data) use ($request) {
                $res = $data->count_urgent;
                if($res == null){
                    $res = $data->count_rec1;
                }
                return $res;
            })
            ->addColumn('sum_urgent', function ($data) use ($request) {
                $res = $data->sum_urgent;
                if($res == null){
                    $res = $data->sum_amt1;
                }
                return $res;
            })

            ->addColumn('count_training', function ($data) use ($request) {
                $res = $data->count_training;
                if($res == null){
                    $res = $data->count_rec2;
                }
                return $res;
            })
            ->addColumn('sum_training', function ($data) use ($request) {
                $res = $data->sum_training;
                if($res == null){
                    $res = $data->sum_amt2;
                }
                return $res;
            })

            ->addColumn('count_amt', function ($data) use ($request) {
                $res = 0;
                if($data->count_urgent != null && $data->count_training != null){
                    $res = $data->count_urgent + $data->count_training;
                }else{
                    $res = $data->count_rec1 + $data->count_rec2;
                }
                return $res;
            })
            ->addColumn('sum_amt', function ($data) use ($request) {
                $res = 0;
                if($data->sum_urgent != null && $data->sum_training != null){
                    $res = $data->sum_urgent + $data->sum_training;
                }else{
                    $res = $data->sum_amt1 + $data->sum_amt2;
                }
                return $res;
            })

            ->addColumn('allocate_urgent', function ($data) {
                $id = '"allocate_urgent' . $data->division_id . '"';
                if($data->count_rec > 0){
                    $button = '<input type="number" style="text-align:right;" id=' . $id . ' oninput="setAllocateSum(' . $data->division_id . ')" class="form-control col-md-12 allocate-urgent" placeholder="0.00" value="' . $data->allocate_urgent . '">';
                }else{
                    $button = '<input type="number" style="text-align:right;" id=' . $id . ' oninput="setAllocateSum(' . $data->division_id . ')" class="form-control col-md-12 allocate-urgent" placeholder="0.00" disabled>';
                }
                return $button;
            })

            ->addColumn('allocate_training', function ($data) {
                $id = '"allocate_training' . $data->division_id . '"';
                if($data->count_rec > 0){
                    $button = '<input type="number" style="text-align:right;" id=' . $id . ' oninput="setAllocateSum(' . $data->division_id . ')" class="form-control col-md-12 allocate-training" placeholder="0.00" value="' . $data->allocate_training . '">';
                }else{
                    $button = '<input type="number" style="text-align:right;" id=' . $id . ' oninput="setAllocateSum(' . $data->division_id . ')" class="form-control col-md-12 allocate-training" placeholder="0.00" disabled>';
                }
                return $button;
            })

            ->addColumn('allocate_manage', function ($data) {
                $id = '"allocate_manage' . $data->division_id . '"';
                if($data->count_rec > 0){
                    $button = '<input type="number" style="text-align:right;" id=' . $id . ' oninput="setAllocateSum(' . $data->division_id . ')" class="form-control col-md-12 allocate-manage" placeholder="0.00" value="' . $data->allocate_manage . '">';
                }else{
                    $button = '<input type="number" style="text-align:right;" id=' . $id . ' oninput="setAllocateSum(' . $data->division_id . ')" class="form-control col-md-12 allocate-manage" placeholder="0.00" disabled>';
                }
                return $button;
            })

            ->addColumn('allocate_sum', function ($data) {
                $id = '"allocate_sum' . $data->division_id . '"';
                $sum = $data->allocate_urgent + $data->allocate_training + $data->allocate_manage;
                $button = '<div id=' . $id . ' class="allsum">' . $sum . '</div>';
                return $button;
            })

            // ->addColumn('transfer_amt_show', function ($data) {
            //     $button = number_format($data->transfer_amt, 2);
            //     return $button;
            // })
            // ->addColumn('edit', function ($data) {
            //     $button = '<div class="icondemo vertical-align-middle p-2">';
            //     $button .= '<a href="/manage/receivetransfer/' . $data->id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
            //     $button .= '</div>';
            //     return $button;
            // })
            // ->addColumn('del', function ($data) use ($request) {
            //     $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->id . ')" title="ลบ"></button>';
            //     $button .= '<form action="/master/center_master11/' . $data->id .'" id="delete_form' . $data->id . '" method="post">
            //         <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
            //     return $button;
            // })
            ->rawColumns(['allocate_urgent', 'allocate_training', 'allocate_manage', 'allocate_sum'])
            ->make(true);
    }
}
