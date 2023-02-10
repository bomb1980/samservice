<?php

namespace App\Http\Controllers\Api\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Request3_3Controller extends Controller
{
    public function getRequest(Request $request)
    {
        $data = OoapTblRequest::whereIn('ooap_tbl_requests.status',["2", "3", "4"])
        ->select(
            'ooap_tbl_requests.req_id',
            'ooap_tbl_requests.req_year',
            'ooap_tbl_requests.req_number',
            'ooap_tbl_employees.division_name',
            'ooap_mas_acttype.name',
            'ooap_mas_amphur.amphur_name',
            'ooap_mas_tambon.tambon_name',
            'ooap_tbl_requests.req_moo',
            'ooap_tbl_requests.req_startmonth',
            'ooap_tbl_requests.req_numofday',
            'ooap_tbl_requests.req_numofpeople',
            'ooap_tbl_requests.req_amount',
            'ooap_tbl_requests.status',
            'ooap_tbl_requests.req_acttype',
        )
        ->leftjoin('ooap_mas_acttype','ooap_tbl_requests.req_acttype','ooap_mas_acttype.id')
        ->leftjoin('ooap_mas_amphur','ooap_tbl_requests.req_district','ooap_mas_amphur.amphur_id')
        ->leftjoin('ooap_mas_tambon','ooap_tbl_requests.req_subdistrict','ooap_mas_tambon.tambon_id')
        ->leftjoin('ooap_tbl_employees','ooap_tbl_requests.req_id','ooap_tbl_employees.division_id');
            // ->orderBy('ooap_tbl_reqform.reqform_no','asc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('division', function ($data) {
                $text = $data->division_name ?? '-';
                return $text;
            })
            ->addColumn('req_amount_format', function ($data) {
                $text = number_format(($data->req_amount),2);
                return $text;
            })
            ->addColumn('req_startmonth_format', function ($data) {
                $text = formatDateThai($data->req_startmonth) ?? '-';
                return $text;
            })
            ->addColumn('status_confirm', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                    if($data->status == 1){
                        $button .= '<span class="text-primary">บันทึกแบบร่าง</span>';
                    }else if($data->status == 2){
                        $button .= '<span class="text-warning">รอพิจารณา</span>';
                    }else if($data->status == 3){
                        $button .= '<span class="text-success">ผ่านการพิจารณา</span>';
                    }else if($data->status == 4){
                        $button .= '<span class="text-danger">ไม่ผ่านการพิจารณา</span>';
                    }else if($data->status == 5){
                        $button .= '<span class="text-primary">ส่งคำขอกลับ</span>';
                    }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                if($data->status == 1){
                    if($data->acttype_id == 1){
                        $button .= '<a href="/request/request3_3/' . $data->req_acttype . '/' . $data->req_id . '/detail"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }else{
                        $button .= '<a href="/request/request3_3/' . $data->req_acttype . '/' . $data->req_id . '/detail"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                    }
                }else{
                    if($data->acttype_id == 1){
                        $button .= '<a href="/request/request3_3/' . $data->req_acttype . '/' . $data->req_id . '/detail"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }else{
                        $button .= '<a href="/request/request3_3/' . $data->req_acttype . '/' . $data->req_id . '/detail"><i class="icon wb-eye" aria-hidden="true" title="ดูข้อมูล"></i></a>';
                    }
                    // $button .= '<a href="javascript:void(0)" class="text-secondary"><i class="icon fa-eye" aria-hidden="true" title="แก้ไข"></i></a>';
                }
                $button .= '</div>';
                return $button;
            })
            // ->addColumn('del', function ($data) use ($request) {
            //     $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->req_id . ')" title="ลบ"></button>';
            //     $button .= '<form action="/request/reqform/' . $data->req_id .'" id="delete_form' . $data->req_id . '" method="post">
            //         <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
            //     return $button;
            // })
            // ->addColumn('status_show', function ($data) use ($request) {
            //     $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->req_id . ')" title="ลบ"></button>';
            //     $button .= '<form action="/request/reqform/' . $data->req_id .'" id="delete_form' . $data->req_id . '" method="post">
            //         <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
            //     return $button;
            // })
            // // ->rawColumns(['startdate_view','enddate_view','edit', 'del'])
            ->rawColumns([
                // 'status_show',
                'status_confirm',
                'edit',
                'checkbox',
                // 'del'
            ])
            ->make(true);
    }
}

