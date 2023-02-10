<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasLecturer;
use App\Models\OoapTblPopulation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LecturerController extends Controller
{
    public function getlecturer(Request $request)
    {
        $data = OoapMasLecturer::select(
            'ooap_mas_lecturers.*',
            'ooap_mas_lecturer_types.lecturer_types_name',
            'ooap_mas_province.province_name'
        )->where('ooap_mas_lecturers.in_active', '=', false)
            ->leftjoin('ooap_mas_province', 'ooap_mas_lecturers.province_id', 'ooap_mas_province.province_id')
            ->leftjoin('ooap_mas_lecturer_types', 'ooap_mas_lecturers.lecturer_types_id', 'ooap_mas_lecturer_types.lecturer_types_id')
            ->orderBy('ooap_mas_lecturers.lecturer_fname', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('yourname', function ($data) {

                $text = $data->lecturer_fname . ' ' . $data->lecturer_lname;

                return $text;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="/master/lecturer/' . $data->lecturer_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->lecturer_id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/lecturer/' . $data->lecturer_id . '" id="delete_form' . $data->lecturer_id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            ->rawColumns(['yourname', 'edit', 'del'])
            ->make(true);
    }

    public function getlecturer_pop(Request $request)
    {
        $data = OoapMasLecturer::select(
            'ooap_mas_lecturers.*',
            'ooap_mas_lecturer_types.lecturer_types_name',
            'ooap_mas_province.province_name'
        )->where('ooap_mas_lecturers.in_active', '=', false)
            ->leftjoin('ooap_mas_province', 'ooap_mas_lecturers.province_id', 'ooap_mas_province.province_id')
            ->leftjoin('ooap_mas_lecturer_types', 'ooap_mas_lecturers.lecturer_types_id', 'ooap_mas_lecturer_types.lecturer_types_id')
            ->orderBy('ooap_mas_lecturers.lecturer_fname', 'asc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('yourname', function ($data) {

                $text = $data->lecturer_fname . ' ' . $data->lecturer_lname;

                return $text;
            })
            ->addColumn('checkbox', function ($data) use ($request) {
                $pop_check = OoapTblPopulation::where('in_active', '=', false)
                    ->where('ooap_tbl_populations.pop_actnumber', '=', $request->act_number)
                    ->where('ooap_tbl_populations.pop_nationalid', '=', $data->lecturer_nationalid)
                    ->where('ooap_tbl_populations.pop_role', '=', 1)->first();
                $checkbox = "";
                $checkbox .= '<input type="checkbox" id="1"value="' . $data->lecturer_id . '" name="check' . $data->lecturer_id . '" class="checkSingle1"';
                if ($pop_check) {
                    $checkbox .= 'checked';
                }
                // if ($pop_check) {
                //     if ($pop_check->check_status == 1) {
                //         $checkbox .= 'checked';
                //     }
                // }
                $checkbox .= '>';
                return $checkbox;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="/master/lecturer/' . $data->lecturer_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->lecturer_id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/lecturer/' . $data->lecturer_id . '" id="delete_form' . $data->lecturer_id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            ->rawColumns(['yourname', 'edit', 'del', 'checkbox'])
            ->make(true);
    }
}
