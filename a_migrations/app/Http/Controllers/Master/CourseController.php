<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasCourse;

class CourseController extends Controller
{
    function __construct() {
        $this->params['main_title'] = 'ข้อมูลหลักสูตรอบรม';

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {

        $logs['route_name'] = 'master.course.index';
        $logs['submenu_name'] = 'ข้อมูลหลักสูตรอบรม';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.course.index', $this->params);


    }


    public function create()
    {
        $logs['route_name'] = 'master.course.create';
        $logs['submenu_name'] = 'เพิ่มข้อมูลหลักสูตรอบรม';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        $this->params['sub_title'] = 'เพิ่มข้อมูลหลักสูตรอบรม';
        $this->params['icon'] = getIcon('add');

        $this->params['course_id'] = NULL;
        $this->params['datas'] = NULL;

        return view('master.course.edit', $this->params);
    }



    public function edit($id)
    {

        $logs['route_name'] = route('master.course.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขข้อมูลหลักสูตรอบรม';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        $datas = NULL;
        $this->params['sub_title'] = 'แก้ไขข้อมูลหลักสูตรอบรม';
        $this->params['icon'] = getIcon('edit');
        foreach( OoapMasCourse::getDatas($id)->get() as $kd => $vd ) {
            $datas = OoapMasCourse::find($vd->id);

            $this->params['sub_title'] = $datas->code . ' ' . $datas->name;
            $this->params['icon'] = getIcon('edit');
        }
        $this->params['course_id'] = $id;
        $this->params['datas'] = $datas;

        return view('master.course.edit', $this->params);
    }




    public function destroy($id)
    {

        $logs['route_name'] = route('master.course.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลหลักสูตรอบรม';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );

        $checkResult = OoapMasCourse::find($id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;
        // dd($in_active);
        OoapMasCourse::where('id','=', $id)->update([
            'in_active' => $in_active,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
