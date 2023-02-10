<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasLecturer;

class LecturerController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'master.lecturer.index';
        $logs['submenu_name'] = 'ทะเบียนคุมวิทยากร';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.lecturer.index');
    }

    public function create()
    {
        $logs['route_name'] = 'master.lecturer.create';
        $logs['submenu_name'] = 'เพิ่มทะเบียนคุมวิทยากร';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        return view('master.lecturer.create');
    }

    public function edit($id)
    {
        $logs['route_name'] = route('master.lecturer.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขทะเบียนคุมวิทยากร';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );
        $getResult = OoapMasLecturer::find($id);
        // dd($getResult);
        return view('master.lecturer.edit', ['datacentermaster' => $getResult]);
    }

    public function destroy($id)
    {
        $logs['route_name'] = route('master.lecturer.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบทะเบียนคุมวิทยากร';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );
        $checkResult = OoapMasLecturer::find($id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;
        OoapMasLecturer::where('lecturer_id', '=', $id)->update([
            'in_active' => $in_active
        ]);
        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
