<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasActtype;
use Illuminate\Http\Request;

class ActivitytypeController extends Controller
{

    function __construct() {
        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'master.activitytype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทกิจกรรม';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.activitytype.index');
    }

    public function create()
    {

        $logs['route_name'] = 'master.activitytype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทกิจกรรม';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );
        return view('master.activitytype.create');
    }

    public function edit($activity_types_id)
    {

        $logs['route_name'] = 'master.activitytype.edit';
        $logs['submenu_name'] = 'ข้อมูลประเภทกิจกรรม';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );
        return view('master.activitytype.edit', compact('activity_types_id'));
    }

    public function destroy($activity_types_id)
    {
        $logs['route_name'] = route('master.activitytype.destroy', ['activity_types_id' => $activity_types_id]);
        $logs['submenu_name'] = 'ลบข้อมูลประเภทกิจกรรม';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );

        $checkResult = OoapMasActtype::where('id', $activity_types_id)->first();

        ($checkResult->inactive == 1) ? $inactive = 0 : $inactive = 1;


        OoapMasActtype::where('id','=', $activity_types_id)->update([
            'inactive' => $inactive,
            'delete_by' => auth()->user()->name,
            'delete_date' => now()
        ]);

        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
