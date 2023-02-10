<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\OoapMasCoursetype;

class CoursetypeController extends Controller
{
    function __construct() {
        $this->main_title = 'ข้อมูลประเภทหลักสูตร';

        $this->middleware('auth');
        // $this->middleware('role:ROLE_SuperAdmin,ROLE_Admin');
    }

    public function index()
    {
        $logs['route_name'] = 'master.coursetype.index';
        $logs['submenu_name'] = 'ข้อมูลประเภทหลักสูตร';
        $logs['log_type'] = 'view';

        createLogTrans( $logs );

        return view('master.coursetype.index',['main_title'=>$this->main_title]);

    }

    public function edit($id)
    {
        $logs['route_name'] = route('master.coursetype.edit', ['id' => $id]);
        $logs['submenu_name'] = 'แก้ไขมูลประเภทหลักสูตร';
        $logs['log_type'] = 'edit';

        createLogTrans( $logs );

        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่ม'. $this->main_title .'';

        foreach (OoapMasCoursetype::getDatas($id)->get() as $ka => $va) {

            $icon = getIcon('edit');

            $getResult = OoapMasCoursetype::find($va->id);

            $title = $getResult->name;
        }

        return view('master.coursetype.edit', ['dataCoursetype' => $getResult, 'title' => $title, 'icon' => $icon, 'main_title'=>$this->main_title]);
    }

    public function create()
    {
        $logs['route_name'] = 'master.coursetype.create';
        $logs['submenu_name'] = 'เพิ่มข้อมูลประเภทหลักสูตร';
        $logs['log_type'] = 'add';

        createLogTrans( $logs );

        $icon = getIcon('add');
        $getResult = NULL;
        $title = 'เพิ่ม'. $this->main_title .'';

        return view('master.coursetype.create', ['dataCoursetype' => $getResult, 'title' => $title, 'icon' => $icon, 'main_title'=>$this->main_title]);
    }

    public function destroy($id)
    {
        $logs['route_name'] = route('master.coursetype.destroy', ['id' => $id]);
        $logs['submenu_name'] = 'ลบข้อมูลประเภทหลักสูตร';
        $logs['log_type'] = 'delete';

        createLogTrans( $logs );

        $checkResult = OoapMasCoursetype::find($id);
        ($checkResult->in_active == 1) ? $in_active = 0 : $in_active = 1;

        OoapMasCoursetype::where('id','=', $id)->update([
            'in_active' => $in_active,
            'deleted_by' => auth()->user()->name,
            'deleted_at' => now()
        ]);

        return redirect()->back()->with('success_del', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
