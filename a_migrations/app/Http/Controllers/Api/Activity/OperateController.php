<?php

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use App\Models\OoapTblActivities;

class OperateController extends Controller
{
    public function getActform(Request $request)
    {
        $data = OoapTblActivities::select(
            'ooap_tbl_activities.act_id',
            'ooap_tbl_activities.act_number',
            'ooap_tbl_activities.act_acttype',
            'ooap_tbl_activities.act_district',
            'ooap_tbl_activities.act_subdistrict',
            'ooap_tbl_activities.act_moo',
            'ooap_tbl_activities.act_periodno',
            'ooap_tbl_activities.act_year',
            'ooap_tbl_activities.act_startmonth',
            'ooap_tbl_activities.act_endmonth',
            'ooap_tbl_activities.act_numofday',
            'ooap_tbl_activities.act_numofpeople',
            'ooap_tbl_activities.act_amount',
            'ooap_tbl_activities.status',

            'ooap_mas_acttype.name',

            'ooap_mas_amphur.amphur_name',
            'ooap_mas_tambon.tambon_name'
        )
        ->leftjoin('ooap_mas_acttype','ooap_tbl_activities.act_acttype','ooap_mas_acttype.id')
        ->leftjoin('ooap_mas_amphur','ooap_tbl_activities.act_district','ooap_mas_amphur.amphur_id')
        ->leftjoin('ooap_mas_tambon','ooap_tbl_activities.act_subdistrict','ooap_mas_tambon.tambon_id')

        ->where('ooap_tbl_activities.in_active', '=', false);

        if($request->fiscalyear_code!=''){
            $data = $data->where('ooap_tbl_activities.act_year', '=',$request->fiscalyear_code);
        }

        if($request->dept_id!=''){
            $data = $data->where('ooap_tbl_activities.act_div', '=',$request->dept_id);
        }

        if($request->acttype_id!=''){
            $data = $data->where('ooap_tbl_activities.act_acttype', '=',$request->acttype_id);
        }

        $data = $data->orderBy('ooap_tbl_activities.act_number');


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) use ($request) {
                $text="";
                if($data->status == 3 || $data->status == 4 || $data->status == 5){// view mode
                    $text .= '<input type="checkbox" id="' . $data->act_id . ' "value="'. $data->act_id .'" name="checkAll" class="checkSingle">';
                }else{
                    $text = "-";
                }
                return $text;
            })
            ->addColumn('act_amount_format', function ($data) {
                $text = number_format(($data->act_amount),2);
                return $text;
            })
            ->addColumn('act_start_To_end_format', function ($data) {
                $text = '' . formatDateThai($data->act_startmonth) . '-' . formatDateThai($data->act_endmonth) ;
                return $text;
            })
            ->addColumn('status_confirm', function ($data) use ($request) {

                $button = '<div class="icondemo vertical-align-middle p-2">';
                if($data->status == 1){
                    $button .= '<span class="text-warning">บันทึกแบบร่าง </span>';
                }else if($data->status == 2){
                    $button .= '<span class="text-success">ยืนยันความพร้อม </span>';
                }else if($data->status == 3){
                    $button .= '<span class="text-success">จัดสรรโอนเงิน </span>';
                }else if($data->status == 4){
                    $button .= '<span class="text-success">บันทึกข้อมูลปรับแผน/โครงการ </span>';
                }else if($data->status == 5){
                    $button .= '<span class="text-success">เริ่มกิจกรรม </span>';
                }else if($data->status == 6){
                    $button .= '<span class="text-danger">ปิดกิจกรรม </span>';
                }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if($data->status == 1){// edit mode
                    if($data->act_acttype == 1){ // งานเร่งด่วน
                        $button .= '<a href="' . route('operate.emer_employ.detail', ['id' => $data->act_id, 'p_id' => 1]) . '"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }else{// ทักษะฝีมือแรงงาน
                        $button .= '<a href="' . route('operate.result_train.detail', ['id' => $data->act_id, 'p_id' => 1]) . '"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }
                }else{// view mode
                    if($data->act_acttype == 1){// งานเร่งด่วน
                        $button .= '<a href="' . route('operate.emer_employ.detail', ['id' => $data->act_id, 'p_id' => 1]) . '"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }else{// ทักษะฝีมือแรงงาน
                        $button .= '<a href="' . route('operate.result_train.detail', ['id' => $data->act_id, 'p_id' => 1]) . '"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }
                    // $button .= '<a href="javascript:void(0)" class="text-secondary"><i class="icon fa-eye" aria-hidden="true" title="แก้ไข"></i></a>';
                }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('act_start', function ($data) use ($request) {
                // if ($data->status == 5) {
                    $button = '<button type="button" class="btn btn-pure btn-primary icon wb-dropright"  onclick="change_start(' . $data->act_id . ')" title="เริ่มกิจจกรรม"></button>';
                    return $button;
                // }
            })
            ->addColumn('details', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if($data->status == 1){// edit mode
                    if($data->act_acttype == 1){ // งานเร่งด่วน
                        $button .= '<a href="' . route('operate.emer_employ.detail', ['id' => $data->act_id, 'p_id' => 1]) . '"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }else{// ทักษะฝีมือแรงงาน
                        $button .= '<a href="' . route('operate.result_train.detail', ['id' => $data->act_id, 'p_id' => 1]) . '"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }
                }else{// view mode
                    if($data->act_acttype == 1){// งานเร่งด่วน
                        $button .= '<a href="' . route('operate.emer_employ.detail', ['id' => $data->act_id, 'p_id' => 1]) . '"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }else{// ทักษะฝีมือแรงงาน
                        $button .= '<a href="' . route('operate.result_train.detail', ['id' => $data->act_id, 'p_id' => 1]) . '"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }
                    // $button .= '<a href="javascript:void(0)" class="text-secondary"><i class="icon fa-eye" aria-hidden="true" title="แก้ไข"></i></a>';
                }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('act_end', function ($data) use ($request) {
                // if ($data->status == 6) {
                    $button = '<button type="button" class="btn btn-pure btn-primary icon wb-check-circle"  onclick="change_end(' . $data->act_id . ')" title="ปิดกิจจกรรม"></button>';
                    return $button;
                // }
            })
            ->rawColumns([
                'status_confirm', 'edit', 'checkbox', 'act_start','details','act_end'
            ])
            ->make(true);
    }
}
