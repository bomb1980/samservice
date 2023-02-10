<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasAssessmentTopic;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SatisfactionformApiController extends Controller
{
    public function getSatisfactionform(Request $request)
    {
        $data = OoapMasAssessmentTopic::select(
            'ooap_mas_assessment_topics.assessment_topics_id',
            'ooap_mas_assessment_topics.assessment_topics_name',
            'ooap_mas_assessment_topics.descriptions',
            'ooap_mas_acttype.name',
            'ooap_mas_assessment_types.assessment_types_name',
            )
        ->where('ooap_mas_assessment_topics.in_active', '=', false)

        ->leftJoin('ooap_mas_acttype','ooap_mas_assessment_topics.acttype_id','ooap_mas_acttype.id')
        ->leftJoin('ooap_mas_assessment_types','ooap_mas_assessment_topics.assessment_types_id','ooap_mas_assessment_types.assessment_types_id')

        ->orderBy('ooap_mas_assessment_topics.assessment_topics_name', 'asc');


        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href="/master/satisfactionform/' . $data->assessment_topics_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->assessment_topics_id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/satisfactionform/' . $data->assessment_topics_id . '" id="delete_form' . $data->assessment_topics_id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            ->rawColumns(['edit', 'del'])
            ->make(true);
    }
}
