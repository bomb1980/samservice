<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasAssessmentTopic;
use Illuminate\Http\Request;

class AssessmentTopicController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'master.assessment_topic.index';
        $logs['submenu_name'] = 'บริหารแบบประเมินความพึงพอใจ';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );
        return view('master.assessment_topic.index');
    }

    public function create()
    {
        $logs['route_name'] = 'master.assessment_topic.create';
        $logs['submenu_name'] = 'เพิ่มบริหารแบบประเมินความพึงพอใจ';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );
        return view('master.assessment_topic.create');
    }

    public function edit($assessment_topics_id)
    {
        $logs['route_name'] = route('master.assessment_topic.edit', ['assessment_topics_id' => $assessment_topics_id]);
        $logs['submenu_name'] = 'แก้ไขบริหารแบบประเมินความพึงพอใจ';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        return view('master.assessment_topic.edit', compact('assessment_topics_id'));
    }

    public function destroy($assessment_topics_id)
    {
        $logs['route_name'] = route('master.assessment_topic.destroy', ['assessment_topics_id' => $assessment_topics_id]);
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
