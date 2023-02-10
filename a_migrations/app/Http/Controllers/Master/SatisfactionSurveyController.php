<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasAssessmentTopic;

class SatisfactionSurveyController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        return view('master.SatisfactionSurvey.index');
    }

    public function view($assess_templateno)
    {
        return view('master.SatisfactionSurvey.view', ['assess_templateno' => $assess_templateno]);
    }

    public function create()
    {
        return view('master.SatisfactionSurvey.create');
    }

    public function edit($assessment_topics_id)
    {

        return view('master.SatisfactionSurvey.edit', ['assessment_topics_id' => $assessment_topics_id]);
    }

    public function destroy($assessment_topics_id)
    {
        $logs['route_name'] = route('master.form.destroy', ['assessment_topics_id' => $assessment_topics_id]);
        $logs['submenu_name'] = 'ลบกิจกรรมจ้างงานเร่งด่วน';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );
        $checkResult = OoapMasAssessmentTopic::find($assessment_topics_id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;
        OoapMasAssessmentTopic::where('assessment_topics_id', '=', $assessment_topics_id)->update([
            'in_active' => $in_active
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
