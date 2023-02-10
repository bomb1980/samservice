<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasAssessmentType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssessmenttypeApiController extends Controller
{

    public function getAssessmenttype(Request $request)
    {
        $data = OoapMasAssessmentType::where('ooap_mas_assessment_types.in_active', false);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="/master/assessmenttype/' . $data->assessment_types_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->assessment_types_id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/assessmenttype/' . $data->assessment_types_id . '" id="delete_form' . $data->assessment_types_id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            ->rawColumns(['edit', 'del'])
            ->make(true);
    }
}
