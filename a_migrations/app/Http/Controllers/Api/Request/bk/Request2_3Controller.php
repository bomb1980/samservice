<?php

namespace App\Http\Controllers\Api\Request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblReqform;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Request2_3Controller extends Controller
{
    public function getRequest2_3(Request $request)
    {
        $data = OoapTblReqform::select('ooap_mas_acttype.name as acttype_name','um_mas_department.dept_name_th','ooap_tbl_reqform.moo','ooap_mas_amphur.amphur_name','ooap_mas_tambon.tambon_name',
        'ooap_tbl_reqform.reqform_id','ooap_tbl_reqform.fiscalyear_code','ooap_tbl_reqform.reqform_no','ooap_tbl_reqform.actname',
        'ooap_tbl_reqform.req_startmonth','ooap_tbl_reqform.req_endmonth','ooap_mas_coursegroup.name as coursegroup_name','ooap_mas_coursesubgroup.name as ooap_mas_coursesubgroup_name',
        'ooap_tbl_reqform.day_qty','ooap_tbl_reqform.people_qty','ooap_tbl_reqform.total_amt')
            ->leftjoin('ooap_mas_acttype','ooap_tbl_reqform.acttype_id','ooap_mas_acttype.id')
            ->leftjoin('um_mas_department','ooap_tbl_reqform.dept_id','um_mas_department.dept_id')
            ->leftjoin('ooap_mas_amphur','ooap_tbl_reqform.amphur_id','ooap_mas_amphur.amphur_id')
            ->leftjoin('ooap_mas_tambon','ooap_tbl_reqform.tambon_id','um_mas_department.tambon_id')
            ->leftjoin('ooap_mas_coursegroup','ooap_tbl_reqform.coursegroup_id','ooap_mas_coursegroup.id')
            ->leftjoin('ooap_mas_coursesubgroup','ooap_tbl_reqform.coursesubgroup_id','ooap_mas_coursesubgroup.id')
            ->leftjoin('ooap_mas_troubletype','ooap_tbl_reqform.troubletype_id','ooap_mas_troubletype.id')
            ->where([['ooap_tbl_reqform.in_active', '=', false],['ooap_tbl_reqform.status', '=', 1]])
            ->orderBy('ooap_tbl_reqform.reqform_no','asc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('period', function ($data) {
                $text = '<div>';
                $text .= onlyMonthThai($data->req_startmonth) . ' - ' . onlyMonthThai($data->req_endmonth);
                $text .= '</div>';
                return $text;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="request2_3/' . $data->reqform_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->reqform_id . ')" title="ลบ"></button>';
                $button .= '<form action="/request/request2_3/' . $data->reqform_id .'" id="delete_form' . $data->reqform_id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            // ->rawColumns(['startdate_view','enddate_view','edit', 'del'])
            ->rawColumns(['reqform_id','reqform_no','edit', 'del'])
            ->make(true);
    }
}
