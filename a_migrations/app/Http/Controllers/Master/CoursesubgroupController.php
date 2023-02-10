<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasCoursesubgroup;

class CoursesubgroupController extends Controller
{
    function __construct() {
        $this->main_title = 'ข้อมูลกลุ่มสาขาอาชีพ';


        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'master.coursesubgroup.index';
        $logs['submenu_name'] = 'ข้อมูลกลุ่มสาขาอาชีพ';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.coursesubgroup.index',['main_title'=>$this->main_title]);
    }


    public function create()
    {
        $logs['route_name'] = 'master.coursesubgroup.create';
        $logs['submenu_name'] = 'เพิ่มข้อมูลกลุ่มสาขาอาชีพ';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่มข้อมูลกลุ่มสาขาอาชีพ';

        return view('master.coursesubgroup.create', ['dataCoursesubgroup' => $getResult, 'title' => $title, 'icon' => $icon, 'main_title'=>$this->main_title]);

    }

    public function edit($id)
    {
        $logs['route_name'] = route('master.coursesubgroup.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขข้อมูลกลุ่มสาขาอาชีพ';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่มข้อมูลกลุ่มสาขาอาชีพ';

        foreach (OoapMasCoursesubgroup::getDatas($id)->get() as $ka => $va) {
            $icon = getIcon('edit');

            $getResult = OoapMasCoursesubgroup::find($va->id);

            $title = $getResult->name;
        }

        return view('master.coursesubgroup.edit', ['dataCoursesubgroup' => $getResult, 'title' => $title, 'icon' => $icon, 'main_title'=>$this->main_title]);

    }

    public function destroy($id)
    {
        $logs['route_name'] = route('master.coursesubgroup.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลกลุ่มสาขาอาชีพ';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );

        $checkResult = OoapMasCoursesubgroup::find($id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;
        // dd($in_active);
        OoapMasCoursesubgroup::where('id','=', $id)->update([
            'in_active' => $in_active,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
