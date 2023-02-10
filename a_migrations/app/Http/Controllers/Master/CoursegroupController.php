<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasCoursegroup;

class CoursegroupController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'master.coursegroup.index';
        $logs['submenu_name'] = 'ข้อมูลกลุ่มหลักสูตร';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.coursegroup.index');
    }

    public function create()
    {

        $logs['route_name'] = 'master.coursegroup.create';
        $logs['submenu_name'] = 'เพิ่มข้อมูลกลุ่มหลักสูตร';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่มข้อมูลกลุ่มหลักสูตร';

        return view('master.coursegroup.create', ['dataCoursegroup' => $getResult, 'title' => $title, 'icon' => $icon]);

    }

    public function edit($id)
    {
        $logs['route_name'] = route('master.coursegroup.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขข้อมูลกลุ่มหลักสูตร';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        $icon = getIcon('edit');
        $getResult = NULL;
        $title = 'แก้ไขข้อมูลกลุ่มหลักสูตร';

        foreach (OoapMasCoursegroup::getDatas($id)->get() as $ka => $va) {
            $icon = getIcon('edit');

            $getResult = OoapMasCoursegroup::find($va->id);

            $title = $getResult->name;
        }

        return view('master.coursegroup.edit', ['dataCoursegroup' => $getResult, 'title' => $title, 'icon' => $icon]);
    }

    public function destroy($id)
    {
        $logs['route_name'] = route('master.coursegroup.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลกลุ่มหลักสูตร';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );

        $checkResult = OoapMasCoursegroup::find($id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;
        // dd($in_active);
        OoapMasCoursegroup::where('id', '=', $id)->update([
            'in_active' => $in_active,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
