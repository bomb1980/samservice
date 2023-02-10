<?php

namespace App\Http\Controllers\api\request;

use App\Http\Controllers\Controller;
use App\Models\OoapTblReqform;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Sum_ListController extends Controller
{
    public function getSumlist(Request $request)
    {
        $data = OoapTblReqform::select(
            'ooap_mas_acttype.name as acttype_name',
            'um_mas_department.dept_name_th',
            'ooap_tbl_reqform.moo',
            'ooap_mas_amphur.amphur_name',
            'ooap_mas_tambon.tambon_name',
            'ooap_tbl_reqform.reqform_id',
            'ooap_tbl_reqform.fiscalyear_code',
            'ooap_tbl_reqform.reqform_no',
            'ooap_tbl_reqform.acttype_id',
            'ooap_tbl_reqform.actname',
            'ooap_tbl_reqform.plan_startdate',
            'ooap_tbl_reqform.plan_enddate',
            'ooap_mas_coursegroup.name as coursegroup_name',
            'ooap_mas_coursesubgroup.name as coursesubgroup_name',
            'ooap_tbl_reqform.day_qty','ooap_tbl_reqform.people_qty',
            'ooap_tbl_reqform.total_amt')
            ->leftjoin('ooap_mas_acttype','ooap_tbl_reqform.acttype_id','ooap_mas_acttype.id')
            ->leftjoin('um_mas_department','ooap_tbl_reqform.dept_id','um_mas_department.dept_id')
            ->leftjoin('ooap_mas_amphur','ooap_tbl_reqform.amphur_id','ooap_mas_amphur.amphur_id')
            ->leftjoin('ooap_mas_tambon','ooap_tbl_reqform.tambon_id','ooap_mas_tambon.tambon_id')
            ->leftjoin('ooap_mas_coursegroup','ooap_tbl_reqform.coursegroup_id','ooap_mas_coursegroup.id')
            ->leftjoin('ooap_mas_coursesubgroup','ooap_tbl_reqform.coursesubgroup_id','ooap_mas_coursesubgroup.id')
            ->leftjoin('ooap_mas_troubletype','ooap_tbl_reqform.troubletype_id','ooap_mas_troubletype.id')
            ->where([['ooap_tbl_reqform.in_active','=', 0],['ooap_tbl_reqform.status','=', 1]])
            ->orderBy('ooap_tbl_reqform.reqform_no','asc');
        return DataTables::of($data)
            ->addIndexColumn()

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
            ->rawColumns(['reqform_id','reqform_no','acttype_id','acttype_name','total_amt','edit', 'del'])
            ->make(true);
    }
}
