<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function getCourse(Request $request)
    {
        $data = OoapMasCourse::getDatas();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('coursesubgroup_name', function ($data) {
                $show = $data->coursesubgroup_name ?? 'ไม่ระบุ';
                return $show;
            })
            ->addColumn('coursetype_name', function ($data) {
                $show = $data->coursetype_name ?? 'ไม่ระบุ';
                return $show;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="/master/course/' . $data->id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $emp_province_id = auth()->user()->province_id;
                if ($data->province_id == $emp_province_id) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/course/' . $data->id . '" id="delete_form' . $data->id . '" method="post">
                            <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') ;
                $button .= '</form>';
                return $button;
                }
            })
            ->rawColumns(['coursesubgroup_name', 'coursetype_name', 'edit', 'del'])
            ->make(true);
    }
}
