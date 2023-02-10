<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\OoapMasAssessmentTopic;

class SatisfactionSurveyController extends Controller
{
    public function getSatisfactionSurvey(Request $request)
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
                $button .= '<a href="/master/form/' . $data->assessment_topics_id . '/edit"><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })

            ->addColumn('del', function ($data) use ($request) {
                $button = '<button type="button" class="btn btn-pure btn-danger icon wb-trash"  onclick="change_delete(' . $data->assessment_topics_id . ')" title="ลบ"></button>';
                $button .= '<form action="/master/form/' . $data->assessment_topics_id . '" id="delete_form' . $data->assessment_topics_id . '" method="post">
                    <input type="hidden" name="_token" value="' . $request->get('token') . '">' . method_field('DELETE') . '</form>';
                return $button;
            })
            ->rawColumns(['edit', 'del'])
            ->make(true);
    }

    public function getSatisfactionSurvey1(Request $request)
    {
        $a = OoapTblAssess::select('assess_templateno')->groupBy('assess_templateno')->get();
        $b = [];
        foreach( $a as $key=>$val ){
            $c = OoapTblAssess::select('assess_id')->where('assess_templateno', '=', $val->assess_templateno)->first();
            $b[] = $c->assess_id;
        }
    $data = OoapTblAssess::select('assess_id', 'assess_templateno','created_at','created_by')
            ->where('in_active','=', false)
            ->whereIn('assess_id', $b)
            // ->groupBy('assess_templateno')
            ->orderBy('assess_id','asc');
        // dd($data->toSql());
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at_format', function ($data) {
                $a = explode("T",$data->created_at)[0];
                return $a;
            })
            ->addColumn('edit', function ($data) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href='. route('master.form.edit', ['assess_templateno' => $data->assess_templateno]) .'><i class="icon wb-pencil" aria-hidden="true" title="แก้ไข"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('copy', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $d = '' . $data->assess_templateno . 'c';
                $button .= '<a href='. route('master.form.edit', ['assess_templateno' => $d]) .'><i class="icon wb-copy" aria-hidden="true" title="คัดลอก"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('view', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $button .= '<a href='. route('master.form.view', ['assess_templateno' => $data->assess_templateno]) .'><i class="icon wb-eye" aria-hidden="true" title="ดู"></i></a>';
                $button .= '</div>';
                return $button;
            })
            ->addColumn('del', function ($data) use ($request) {
                $button = '<div class="icondemo vertical-align-middle p-2">';
                $c = '\'' . $data->assess_templateno . '\'';
                $button .= '<i style="cursor:pointer; color: red;" onclick="del(' . $c . ')" class="icon wb-trash" aria-hidden="true" title="ดู"></i>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['edit', 'copy', 'view', 'del'])
            ->make(true);
    }
}
