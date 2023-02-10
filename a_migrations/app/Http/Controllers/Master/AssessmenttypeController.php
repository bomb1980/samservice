<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OoapMasAssessmentType;

class AssessmenttypeController extends Controller
{

    function __construct() {
        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'master.assessmenttype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทแบบประเมิน';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.assessmenttype.index');
    }

    public function create()
    {

        $logs['route_name'] = 'master.assessmenttype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทแบบประเมิน';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );
        return view('master.assessmenttype.create');
    }

    public function edit($assessment_types_id)
    {

        $logs['route_name'] = 'master.assessmenttype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทแบบประเมิน';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        return view('master.assessmenttype.edit', compact('assessment_types_id'));
    }

    public function destroy($assessment_types_id)
    {

        $logs['route_name'] = 'master.assessmenttype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทแบบประเมิน';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );

        $checkResult = OoapMasAssessmentType::find($assessment_types_id);

        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;

        OoapMasAssessmentType::where('assessment_types_id', '=', $assessment_types_id)->update([
            'in_active' => $in_active
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
